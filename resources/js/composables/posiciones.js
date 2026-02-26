import { ref } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'
import * as yup from 'yup'
import { useValidation } from './useValidation'
import { useToast } from './useToast'

export default function usePosiciones() {
    const { errors, validate, clearErrors, hasError, getError } = useValidation()
    const router = useRouter()
    const toast = useToast()

    const isLoading = ref(false)
    const posiciones = ref([])
    const initialPosicion = {
        id_posicion: '',
        rol: '',
        posicion: '',
    }
    const posicion = ref({ ...initialPosicion })
    const validationErrors = errors


    const posicionSchema = yup.object({
        id_posicion: yup.string().trim().required('El id es obligatorio').min(2, 'Mínimo 2 caracteres').max(3, 'Máximo 3 caracteres').uppercase(),
        rol: yup.string().trim().required('El rol es obligatorio').oneOf(['Portero', 'Defensa', 'Mediocampo', 'Ataque'], 'El rol debe ser Portero, Defensa, MedioCampo o Ataque'),
        posicion: yup.string().trim().required('La posicion es obligatoria').min(0),
    })

    const getPosiciones = async () => {
        return axios.get('/api/posiciones')
            .then(response => {
                posiciones.value = response.data;
                return response;
            })
    }

    const getPosicion = async (id) => {
        return axios.get(`/api/posiciones/${id}`)
            .then(response => {
                posicion.value = response.data.data;
                return response;
            })
    }

    const createPosicion = async () => {
        if (isLoading.value) return;

        isLoading.value = true
        clearErrors()

        const { isValid } = validate(posicionSchema, posicion.value)
        if (!isValid) {
            isLoading.value = false
            return
        }

        const serializedPosicion = serializePosicion(posicion.value)

        return axios.post('/api/posiciones', serializedPosicion, {
            headers: {
                "content-type": "multipart/form-data"
            }
        })
            .then(response => {
                router.push({ name: 'posiciones.index' })
                toast.crud.created('Posicion')
                return response.data
            })
            .catch(error => {
                if (error.response?.data) {
                    validationErrors.value = error.response.data.errors
                }
            })
            .finally(() => isLoading.value = false)
    }

    const resetPosicion = () => {
        posicion.value = { ...initialPosicion }
        clearErrors()
    }

    const setPosicion = (data = {}) => {
        posicion.value = {
            id_posicion: data.id_posicion ?? null,
            rol: data.rol ?? '',
            posicion: data.posicion ?? '',
        }
        clearErrors()
    }

    const updatePosicion = async () => {
        if (isLoading.value) return;

        isLoading.value = true
        clearErrors()

        const { isValid } = validate(posicionSchema, posicion.value)
        if (!isValid) {
            isLoading.value = false
            return
        }

        return axios.put('/api/posiciones/' + posicion.value.id_posicion, posicion.value)
            .then(response => {
                router.push({ name: 'posiciones.index' })
                toast.crud.updated('Posicion')
                return response.data.data;
            })
            .catch(error => {
                if (error.response?.data) {
                    validationErrors.value = error.response.data.errors
                }
            })
            .finally(() => isLoading.value = false)
    }

    const upsertPosicionRecord = (posicionRecord) => {
        if (!posicionRecord?.id_posicion) return
        posicion.value = [
            posicionRecord,
            ...posiciones.value.filter(item => item.id_posicion !== posicionRecord.id_posicion)
        ]
    }

    const deletePosicion = async (id) => {
        axios.delete('/api/posiciones/' + id)
            .then(response => {
                getPosiciones()
                toast.crud.deleted('Posicion')
            })
            .catch(error => {
                toast.error('Error', 'No se pudo eliminar la posicion')
            })
    }

    const serializePosicion = (data) => {
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
        posiciones,
        posicion,
        getPosiciones,
        getPosiciones,
        createPosicion,
        updatePosicion,
        upsertPosicionRecord,
        deletePosicion,
        resetPosicion,
        setPosicion,
        hasError,
        getError,
        validationErrors,
        isLoading,
    }
}
