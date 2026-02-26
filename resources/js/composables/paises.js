import { ref } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'
import * as yup from 'yup'
import { useValidation } from './useValidation'
import { useToast } from './useToast'

export default function usePaises() {
    const { errors, validate, clearErrors, hasError, getError } = useValidation()
    const router = useRouter()
    const toast = useToast()

    const isLoading = ref(false)
    const paises = ref([])
    const initialPais = {
        id_pais: '',
        nombre_pais: '',
        dificultad_pais: '0',
    }
    const pais = ref({ ...initialPais })
    const validationErrors = errors


    const paisSchema = yup.object({
        id_pais: yup.string().trim().required('El id es obligatorio').min(2, 'Mínimo 2 caracteres').max(6, 'Máximo 6 caracteres').lowercase(),
        nombre_pais: yup.string().trim().required('El nombre es obligatorio'),
        dificultad_pais: yup.number().required('Es obligatorio indicar una dificultad para el país').min(0).max(3),
    })

    const getPaises = async () => {
        return axios.get('/api/paises')
            .then(response => {
                paises.value = response.data;
                return response;
            })
    }

    const getPais = async (id) => {
        return axios.get(`/api/paises/${id}`)
            .then(response => {
                pais.value = response.data.data;
                return response;
            })
    }

    const createPais = async () => {
        if (isLoading.value) return;

        isLoading.value = true
        clearErrors()

        const { isValid } = validate(paisSchema, pais.value)
        if (!isValid) {
            isLoading.value = false
            return
        }

        const serializedPais = serializePais(pais.value)

        return axios.post('/api/paises', serializedPais, {
            headers: {
                "content-type": "multipart/form-data"
            }
        })
            .then(response => {
                router.push({ name: 'paises.index' })
                toast.crud.created('Pais')
                return response.data
            })
            .catch(error => {
                if (error.response?.data) {
                    validationErrors.value = error.response.data.errors
                }
            })
            .finally(() => isLoading.value = false)
    }

    const resetPais = () => {
        pais.value = { ...initialPais }
        clearErrors()
    }

    const setPais = (data = {}) => {
        pais.value = {
            id_pais: data.id_pais ?? null,
            nombre_pais: data.nombre_pais ?? '',
            dificultad_pais: data.dificultad_pais ?? 0,
        }
        clearErrors()
    }

    const updatePais = async () => {
        if (isLoading.value) return;

        isLoading.value = true
        clearErrors()

        const { isValid } = validate(paisSchema, pais.value)
        if (!isValid) {
            isLoading.value = false
            return
        }

        return axios.put('/api/paises/' + pais.value.id_pais, pais.value)
            .then(response => {
                router.push({ name: 'paises.index' })
                toast.crud.updated('Pais')
                return response.data.data;
            })
            .catch(error => {
                if (error.response?.data) {
                    validationErrors.value = error.response.data.errors
                }
            })
            .finally(() => isLoading.value = false)
    }

    const upsertPaisRecord = (paisRecord) => {
        if (!paisRecord?.id_pais) return
        paises.value = [
            paisRecord,
            ...paises.value.filter(item => item.id_pais !== paisRecord.id_pais)
        ]
    }

    const deletePais = async (id) => {
        axios.delete('/api/paises/' + id)
            .then(response => {
                getPaises()
                toast.crud.deleted('Pais')
            })
            .catch(error => {
                toast.error('Error', 'No se pudo eliminar el pais')
            })
    }

    const serializePais = (data) => {
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
        paises,
        pais,
        getPaises,
        getPais,
        createPais,
        updatePais,
        upsertPaisRecord,
        deletePais,
        resetPais,
        setPais,
        hasError,
        getError,
        validationErrors,
        isLoading,
    }
}
