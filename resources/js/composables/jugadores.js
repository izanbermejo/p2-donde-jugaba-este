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
    const totalRecords = ref(0)

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

    // Esquema de validación de jugador usando yup
    const jugadorSchema = yup.object({
        id_jugador: yup.number().required('El id es obligatorio').min(1, 'Mínimo 1 caracter').max(11, 'Máximo 11 caracteres').moreThan(0, 'El Id debe ser mayor que 0'),
        slug_jugador: yup.string().trim().required('El slug del jugador es obligatorio'),
        nombre_jugador: yup.string().trim().required('El nombre del jugador es obligatorio'),
        fecha_nacimiento_jugador: yup.date().max(new Date(),'No puedes escoger una fecha en el futuro').required('Es obligatorio indicar una fecha de nacimiento para el jugador'),
        pais_jugador: yup.string().trim().required('Es obligatorio indicar un país para el jugador'),
        posicion_jugador: yup.string().trim().required('Es obligatorio indicar una posición para el jugador'),
        club_actual_jugador: yup.string().trim().required('Es obligatorio indicar el club actual del jugador o si está retirado (retired)'),
    })

    // Obtiene jugadores paginados desde la API
    const getJugadores = async (page = 1, rows = 10) => {
        try {
            isLoading.value = true

            const response = await axios.get('/api/jugadores', {
                params: {
                    page: page,
                    rows: rows
                }
            })

            jugadores.value = [...response.data.data]
            totalRecords.value = response.data.total

        } catch (error) {
            console.error(error)
        } finally {
            isLoading.value = false
        }
    }

    // Obtiene un jugador por ID
    const getJugador = async (id) => {
        return axios.get(`/api/jugadores/${id}`)
            .then(response => {
                jugador.value = response.data.data
                return response
            })
    }

    // Crea un nuevo jugador
    const createJugador = async () => {
        if (isLoading.value) return

        isLoading.value = true
        clearErrors()

        // Genera slug a partir del nombre del jugador
        jugador.value.slug_jugador = formatearSlugNombreJugador(jugador.value.nombre_jugador)

        const jugadorParaEnviar = {
            ...jugador.value,
            pais_jugador: jugador.value.pais_jugador.id_pais,
            fecha_nacimiento_jugador: dayjs(jugador.value.fecha_nacimiento_jugador).format('YYYY-MM-DD')
        }

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

    // Resetea el objeto jugador al estado inicial
    const resetJugador = () => {
        jugador.value = { ...initialJugador }
        clearErrors()
    }

    // Establece los datos de un jugador en el estado
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

    // Actualiza un jugador existente
    const updateJugador = async () => {
        if (isLoading.value) return

        isLoading.value = true
        clearErrors()

        const jugadorParaEnviar = {
            ...jugador.value,
            pais_jugador: jugador.value.pais_jugador.id_pais,
            fecha_nacimiento_jugador: dayjs(jugador.value.fecha_nacimiento_jugador).format('YYYY-MM-DD')
        }

        const { isValid } = validate(jugadorSchema, jugadorParaEnviar)
        if (!isValid) {
            isLoading.value = false
            return
        }

        return axios.put('/api/jugadores/' + jugador.value.id_jugador, jugadorParaEnviar)
            .then(response => {
                router.push({ name: 'jugadores.index' })
                toast.crud.updated('Jugador')
                return response.data.data
            })
            .catch(error => {
                if (error.response?.data) {
                    validationErrors.value = error.response.data.errors
                }
            })
            .finally(() => isLoading.value = false)
    }

    // Inserta o actualiza un jugador en la lista local evitando duplicados
    const upsertJugadorRecord = (jugadorRecord) => {
        if (!jugadorRecord?.id_jugador) return
        jugadores.value = [
            jugadorRecord,
            ...jugadores.value.filter(item => item.id_jugador !== jugadorRecord.id_jugador)
        ]
    }

    // Elimina un jugador por ID y recarga la lista
    const deleteJugador = async (id, currentPage = 1, rowsPerPage = 10) => {
        axios.delete('/api/jugadores/' + id)
            .then(response => {
                getJugadores(currentPage, rowsPerPage)
                toast.crud.deleted('Jugador')
            })
            .catch(error => {
                toast.error('Error', 'No se pudo eliminar el jugador')
            })
    }

    // Convierte un objeto en FormData para enviar al backend
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

    // Convierte el nombre del jugador en un slug URL-friendly
    const formatearSlugNombreJugador = (nombre) => {
        return nombre
            .toLowerCase()
            .normalize("NFD")
            .replace(/[\u0300-\u036f]/g, "")
            .replace(/\s+/g, "-")
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
        totalRecords,
    }
}
