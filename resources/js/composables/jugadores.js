import { ref } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'
import * as yup from 'yup'
import { useValidation } from './useValidation'
import { useToast } from './useToast'
import dayjs from 'dayjs'

export default function useJugadores() {
    const { errors, validate, clearErrors, hasError, getError } = useValidation()
    const router = useRouter()
    const toast = useToast()

    const isLoading = ref(false)
    const jugadores = ref([])
    const initialJugador = {
        id_jugador: 0,
        slug_jugador: '',
        nombre_jugador: '',
        fecha_nacimiento_jugador: new Date(),
        pais_jugador: '',
        posicion_jugador: '',
        club_actual_jugador: '',
        clubes: [],
    }
    const jugador = ref({ ...initialJugador })
    const validationErrors = errors


    const jugadorSchema = yup.object({
        id_jugador: yup.number().required('El id es obligatorio').min(1, 'Mínimo 1 caracter').max(11, 'Máximo 11 caracteres').moreThan(0, 'El Id debe ser mayor que 0'),
        slug_jugador: yup.string().trim().required('El slug del jugador es obligatorio'),
        nombre_jugador: yup.string().trim().required('El nombre del jugador es obligatorio'),
        fecha_nacimiento_jugador: yup.date().max(new Date(),'No puedes escoger una fecha en el futuro').required('Es obligatorio indicar una fecha de nacimiento para el jugador'),
        pais_jugador: yup.string().trim().required('Es obligatorio indicar un país para el jugador'),
        posicion_jugador: yup.string().trim().required('Es obligatorio indicar una posición para el jugador'),
        club_actual_jugador: yup.string().trim().required('Es obligatorio indicar el club actual del jugador o si está retirado (retired)'),
    })

    const getJugadores = async () => {
        return axios.get('/api/jugadores')
        .then(response => {
                jugadores.value = response.data;
                return response;
            })
    }

    const getJugador = async (id) => {
        return axios.get(`/api/jugadores/${id}`)
            .then(response => {
                jugador.value = response.data.data;
                return response;
            })
    }

    const createJugador = async () => {
        if (isLoading.value) return;

        isLoading.value = true
        clearErrors()

        jugador.value.slug_jugador = formatearSlugNombreJugador(jugador.value.nombre_jugador)

        const jugadorParaEnviar = {
            ...jugador.value,
            pais_jugador: jugador.value.pais_jugador.id_pais, // aquí solo el ID
            fecha_nacimiento_jugador: dayjs(jugador.value.fecha_nacimiento_jugador).format('YYYY-MM-DD')
        };

        const { isValid } = validate(jugadorSchema, jugadorParaEnviar)
        if (!isValid) {
            isLoading.value = false
            return
        }

        const serializedJugador = serializeJugador(jugadorParaEnviar)

        return axios.post('/api/jugadores', serializedJugador, {
            headers: {
                "content-type": "multipart/form-data"
            }
        })
            .then(response => {
                router.push({ name: 'jugadores.index' })
                toast.crud.created('Jugador')
                return response.data
            })
            .catch(error => {
                if (error.response?.data) {
                    validationErrors.value = error.response.data.errors
                }
            })
            .finally(() => isLoading.value = false)
    }

    const resetJugador = () => {
        jugador.value = { ...initialJugador }
        clearErrors()
    }

    const setJugador = (data = {}) => {
        jugador.value = {
            id_jugador: data.id_jugador ?? 0,
            slug_jugador: data.slug_jugador ?? '',
            nombre_jugador: data.nombre_jugador ?? '',
            fecha_nacimiento_jugador: data.fecha_nacimiento_jugador
            ? new Date(data.fecha_nacimiento_jugador)
            : null,
            pais_jugador: data.pais ?? '',
            posicion_jugador: data.posicion_jugador ?? '',
            club_actual_jugador: data.club_actual_jugador ?? '',
        }
        clearErrors()
    }

    const updateJugador = async () => {
        if (isLoading.value) return;

        isLoading.value = true
        clearErrors()

        const jugadorParaEnviar = {
            ...jugador.value,
            pais_jugador: jugador.value.pais_jugador.id_pais, // aquí solo el ID
            fecha_nacimiento_jugador: dayjs(jugador.value.fecha_nacimiento_jugador).format('YYYY-MM-DD')
        };

        const { isValid } = validate(jugadorSchema, jugadorParaEnviar)
        if (!isValid) {
            isLoading.value = false
            return
        }

        return axios.put('/api/jugadores/' + jugador.value.id_jugador, jugadorParaEnviar)
            .then(response => {
                router.push({ name: 'jugadores.index' })
                toast.crud.updated('Jugador')
                return response.data.data;
            })
            .catch(error => {
                if (error.response?.data) {
                    validationErrors.value = error.response.data.errors
                }
            })
            .finally(() => isLoading.value = false)
    }

    const upsertJugadorRecord = (jugadorRecord) => {
        if (!jugadorRecord?.id_jugador) return
        jugadores.value = [
            jugadorRecord,
            ...jugadores.value.filter(item => item.id_jugador !== jugadorRecord.id_jugador)
        ]
    }

    const deleteJugador = async (id) => {
        axios.delete('/api/jugadores/' + id)
            .then(response => {
                getJugadores()
                toast.crud.deleted('Jugador')
            })
            .catch(error => {
                toast.error('Error', 'No se pudo eliminar el jugador')
            })
    }

    const serializeJugador = (data) => {
        const form = new FormData()
        Object.entries(data).forEach(([key, value]) => {
            if (value === undefined || value === null) return
            if (Array.isArray(value)) {
                value.forEach(item => form.append(`${key}[]`, item))
            } else {
                form.append(key, value)
            }
        })
        return form
    }

    const formatearSlugNombreJugador = (nombre) => {
    return nombre
        .toLowerCase()
        .normalize("NFD")                // separa acentos
        .replace(/[\u0300-\u036f]/g, "") // elimina acentos
        .replace(/\s+/g, "-");           // espacios → guiones
}

    return {
        jugadores,
        jugador,
        getJugadores,
        getJugador,
        createJugador,
        updateJugador,
        upsertJugadorRecord,
        deleteJugador,
        resetJugador,
        setJugador,
        hasError,
        getError,
        validationErrors,
        isLoading,
    }
}
