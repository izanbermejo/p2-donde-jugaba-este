import { ref } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'
import * as yup from 'yup'
import { useValidation } from './useValidation'
import { useToast } from './useToast'
import dayjs from 'dayjs'

export default function useClubes() {
    const { errors, validate, clearErrors, hasError, getError } = useValidation()
    const router = useRouter()
    const toast = useToast()

    const isLoading = ref(false)
    const clubes = ref([])
    const initialClub = {
        id_club: 0,
        slug_club: '',
        nombre_club: '',
        logo_url: new Date(),
        pais_club: '',
        id_liga_club: '',
        dificultad_club: '',
    }
    const club = ref({ ...initialClub })
    const validationErrors = errors


    const clubSchema = yup.object({
        id_club: yup.number().required('El id es obligatorio').min(1, 'Mínimo 1 caracter').max(99999999, 'Máximo 8 dígitos').moreThan(0, 'El Id debe ser mayor que 0'),
        slug_club: yup.string().trim().required('El slug del club es obligatorio'),
        nombre_club: yup.string().trim().required('El nombre del club es obligatorio'),
        logo_url: yup.string().trim(),
        pais_club: yup.string().trim().required('Es obligatorio indicar un país para el club'),
        id_pais_club: yup.string().trim().required('Es obligatorio indicar un id del pais para el club'),
        dificultad_club: yup.string().trim().required('Es obligatorio indicar la dificultad del club'),
    })

    const getClubes = async () => {
        return axios.get('/api/clubes')
        .then(response => {
                clubes.value = response.data;
                return response;
            })
    }

    const getClub = async (id) => {
        return axios.get(`/api/clubes/${id}`)
            .then(response => {
                club.value = response.data.data;
                return response;
            })
    }

    const createClub = async () => {
        if (isLoading.value) return;

        isLoading.value = true
        clearErrors()

        club.value.slug_club = formatearSlugNombreClub(club.value.nombre_club)

        const clubParaEnviar = {
            ...club.value,
            // pais_club: club.value.pais_club.id_pais, // aquí solo el ID
            // fecha_nacimiento_jugador: dayjs(jugador.value.fecha_nacimiento_jugador).format('YYYY-MM-DD')
        };

        const { isValid } = validate(clubSchema, clubParaEnviar)
        if (!isValid) {
            isLoading.value = false
            return
        }

        const serializedClub = serializeClub(clubParaEnviar)

        return axios.post('/api/clubes', serializedClub, {
            headers: {
                "content-type": "multipart/form-data"
            }
        })
            .then(response => {
                router.push({ name: 'clubes.index' })
                toast.crud.created('Club')
                return response.data
            })
            .catch(error => {
                if (error.response?.data) {
                    validationErrors.value = error.response.data.errors
                }
            })
            .finally(() => isLoading.value = false)
    }

    const resetClub = () => {
        club.value = { ...initialClub }
        clearErrors()
    }

    const setClub = (data = {}) => {
        club.value = {
            id_club: data.id_club ?? 0,
            slug_club: data.slug_club ?? '',
            nombre_club: data.nombre_club ?? '',
            logo_url: data.logo.url ?? '',
            pais_club: darta.pais ?? '',
            id_liga_club: data.id_liga_club ?? '',
            dificultad_club: data.dificultad_club ?? '',
        }
        clearErrors()
    }

    const updateClub = async () => {
        if (isLoading.value) return;

        isLoading.value = true
        clearErrors()

        const clubParaEnviar = {
            ...club.value,
            // pais_jugador: jugador.value.pais_jugador.id_pais, // aquí solo el ID
            // fecha_nacimiento_jugador: dayjs(jugador.value.fecha_nacimiento_jugador).format('YYYY-MM-DD')
        };

        const { isValid } = validate(clubSchema, clubParaEnviar)
        if (!isValid) {
            isLoading.value = false
            return
        }

        return axios.put('/api/clubes/' + club.value.id_club, clubParaEnviar)
            .then(response => {
                router.push({ name: 'clubes.index' })
                toast.crud.updated('Club')
                return response.data.data;
            })
            .catch(error => {
                if (error.response?.data) {
                    validationErrors.value = error.response.data.errors
                }
            })
            .finally(() => isLoading.value = false)
    }

    const upsertClubRecord = (clubRecord) => {
        if (!clubRecord?.id_club) return
        clubes.value = [
            clubRecord,
            ...clubes.value.filter(item => item.id_club !== clubRecord.id_club)
        ]
    }

    const deleteClub = async (id) => {
        axios.delete('/api/clubes/' + id)
            .then(response => {
                getClubes()
                toast.crud.deleted('Club')
            })
            .catch(error => {
                toast.error('Error', 'No se pudo eliminar el club')
            })
    }

    const serializeClub = (data) => {
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

    const formatearSlugNombreClub = (nombre) => {
    return nombre
        .toLowerCase()
        .normalize("NFD")                // separa acentos
        .replace(/[\u0300-\u036f]/g, "") // elimina acentos
        .replace(/\s+/g, "-");           // espacios → guiones
}

    return {
        clubes,
        club,
        getClubes,
        getClub,
        createClub,
        updateClub,
        upsertClubRecord,
        deleteClub,
        resetClub,
        setClub,
        hasError,
        getError,
        validationErrors,
        isLoading,
    }
}
