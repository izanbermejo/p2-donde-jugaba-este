import { ref } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'
import * as yup from 'yup'
import { useValidation } from './useValidation'
import { useToast } from './useToast'

export default function useLigas() {
    const { errors, validate, clearErrors, hasError, getError } = useValidation()
    const router = useRouter()
    const toast = useToast()

    const isLoading = ref(false)
    const ligas = ref([])
    const initialLiga = {
        id_liga: '',
        nombre_liga: '',
        pais_liga: '',
        dificultad_liga: '0',
    }
    const liga = ref({ ...initialLiga})
    const validationErrors = errors


    const ligaSchema = yup.object({
        id_liga: yup.string().trim().required('El id es obligatorio').min(2, 'Mínimo 2 caracteres').max(6, 'Máximo 6 caracteres').lowercase(),
        nombre_liga: yup.string().trim().required('El nombre es obligatorio'),
        pais_liga: yup.string().trim().required('El pais es obligatorio'),
        dificultad_liga: yup.number().required('Es obligatorio indicar una dificultad para la liga').min(0).max(3),
    })

    const getLigas = async () => {
        return axios.get('/api/ligas')
            .then(response => {
                ligas.value = response.data;
                return response;
            })
    }

    const getLiga = async (id) => {
        return axios.get(`/api/ligas/${id}`)
            .then(response => {
                liga.value = response.data.data;
                return response;
            })
    }

    const createLiga = async () => {
        if (isLoading.value) return;

        isLoading.value = true
        clearErrors()

        const { isValid } = validate(ligaSchema, liga.value)
        if (!isValid) {
            isLoading.value = false
            return
        }

        const serializedLiga = serializeLiga(liga.value)

        return axios.post('/api/ligas', serializedLiga, {
            headers: {
                "content-type": "multipart/form-data"
            }
        })
            .then(response => {
                router.push({ name: 'ligas.index' })
                toast.crud.created('Liga')
                return response.data
            })
            .catch(error => {
                if (error.response?.data) {
                    validationErrors.value = error.response.data.errors
                }
            })
            .finally(() => isLoading.value = false)
    }

    const resetLiga = () => {
        liga.value = { ...initialLiga }
        clearErrors()
    }

    const setLiga = (data = {}) => {
        liga.value = {
            id_liga: data.id_liga ?? null,
            nombre_liga: data.nombre_liga ?? '',
            pais_liga: data.pais_liga ?? '',
            dificultad_liga: data.dificultad_liga ?? 0,
        }
        clearErrors()
    }

    const updateLiga = async () => {
        if (isLoading.value) return;

        isLoading.value = true
        clearErrors()

        const { isValid } = validate(ligaSchema, liga.value)
        if (!isValid) {
            isLoading.value = false
            return
        }

        return axios.put('/api/ligas/' + liga.value.id_liga, liga.value)
            .then(response => {
                router.push({ name: 'ligas.index' })
                toast.crud.updated('Liga')
                return response.data.data;
            })
            .catch(error => {
                if (error.response?.data) {
                    validationErrors.value = error.response.data.errors
                }
            })
            .finally(() => isLoading.value = false)
    }

    const upsertLigaRecord = (ligaRecord) => {
        if (!ligaRecord?.id_liga) return
        ligas.value = [
            ligaRecord,
            ...ligas.value.filter(item => item.id_liga !== ligaRecord.id_liga)
        ]
    }

    const deleteLiga = async (id) => {
        axios.delete('/api/ligas/' + id)
            .then(response => {
                getLigas()
                toast.crud.deleted('Liga')
            })
            .catch(error => {
                toast.error('Error', 'No se pudo eliminar el liga')
            })
    }

    const serializeLiga = (data) => {
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

    return {
        ligas,
        liga,
        getLigas,
        getLiga,
        createLiga,
        updateLiga,
        upsertLigaRecord,
        deleteLiga,
        resetLiga,
        setLiga,
        hasError,
        getError,
        validationErrors,
        isLoading,
    }
}
