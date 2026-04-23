<template>
    <div class="permissions-page">
        <Card>
            <template #title>
                <div class="flex items-center justify-between w-full">
                    <span>Gestión de Jugadores</span>
                    <div class="flex items-center gap-2">
                        <Button
                            label="Actualizar"
                            icon="pi pi-refresh"
                            size="small"
                            outlined
                            severity="secondary"
                            :loading="isLoading"
                            @click="test"
                        />
                        <Button
                            v-if="can('jugador-create')"
                            label="Nuevo Jugador"
                            icon="pi pi-plus"
                            size="small"
                            severity="primary"
                            @click="openCreateDialog"
                        />
                    </div>
                </div>
            </template>

            <template #subtitle>
                Administra y gestiona los jugadores del sistema. Crea, edita y elimina jugadores según tus permisos.
            </template>

            <template #content>
                <div v-if="isLoading" class="table-loading-skeleton space-y-3">
                    <div
                        v-for="row in skeletonRows"
                        :key="row"
                        class="flex gap-3 items-center"
                    >
                        <Skeleton width="60px" height="1.25rem" />
                        <Skeleton width="200px" height="1.25rem" />
                        <Skeleton width="140px" height="1.25rem" />
                        <div class="flex gap-2 ml-auto">
                            <Skeleton width="2.5rem" height="2.5rem" shape="circle" />
                            <Skeleton width="2.5rem" height="2.5rem" shape="circle" />
                        </div>
                    </div>
                </div>

                <DataTable
                    v-else
                    v-model:filters="filters"
                    :value="jugadores || []"
                    :first="currentPage * 10"
                    :paginator="true"
                    :rows="10"
                    :total-records="totalRecords"
                    :lazy="true"
                    data-key="id"
                    striped-rows
                    size="small"
                    :loading="isLoading"
                    filter-display="menu"
                    :filter-delay="300"
                    :global-filter-fields="['id_jugador', 'nombre_jugador', 'dificultad_jugador']"
                    @page="onPageChange"
                >
                    <template #empty>
                        <div class="table-empty-state">
                            <i class="pi pi-inbox empty-state-icon"></i>
                            <p class="empty-state-text">No se encontraron jugadores</p>
                            <p class="empty-state-subtext">Intenta ajustar los filtros de búsqueda</p>
                        </div>
                    </template>

                    <Column field="id_jugador" header="ID" sortable filter class="w-20">
                        <template #body="slotProps">
                            <Skeleton v-if="isLoading" width="3rem" height="1rem" />
                            <span v-else class="table-cell-id">{{ slotProps.data.id_jugador }}</span>
                        </template>
                        <template #filter="{ filterModel }">
                            <InputText v-model="filterModel.value" placeholder="ID" class="w-full" />
                        </template>
                    </Column>

                    <Column field="nombre_jugador" header="Nombre" sortable filter class="min-w-50">
                        <template #body="slotProps">
                            <Skeleton v-if="isLoading" width="10rem" height="1rem" />
                            <span v-else class="table-cell-name">{{ slotProps.data.nombre_jugador || '-' }}</span>
                        </template>
                        <template #filter="{ filterModel }">
                            <InputText v-model="filterModel.value" placeholder="Nombre" class="w-full" />
                        </template>
                    </Column>

                    <Column field="fecha_nacimiento_jugador" header="Fecha de nacimiento" sortable class="min-w-50">
                        <template #body="slotProps">
                            <Skeleton v-if="isLoading" width="10rem" height="1rem" />
                            <span v-else class="table-cell-name">{{ slotProps.data.fecha_nacimiento_jugador || '-' }}</span>
                        </template>
                    </Column>

                    <Column field="pais_jugador" header="Nacionalidad" sortable filter filterField="pais.nombre_pais" class="min-w-37.5" :showFilterMatchModes="false">
                        <template #body="slotProps">
                            <Skeleton v-if="isLoading" width="10rem" height="1rem" />
                            <span v-else class="table-cell-name">{{ slotProps.data.pais.nombre_pais || '-' }}</span>
                        </template>
                        <template #filter="{ filterModel }">
                            <InputText v-model="filterModel.value" placeholder="Nacionalidad" class="w-full" />
                        </template>
                    </Column>

                    <Column field="posicion_jugador" header="Posición" sortable filter class="min-w-37.5">
                        <template #body="slotProps">
                            <Skeleton v-if="isLoading" width="10rem" height="1rem" />
                            <span v-else class="table-cell-name">{{ slotProps.data.posicion_jugador || '-' }}</span>
                        </template>
                        <template #filter="{ filterModel }">
                            <InputText v-model="filterModel.value" placeholder="Posición" class="w-full" />
                        </template>
                    </Column>

                    <Column field="club_actual_jugador" header="Club actual" sortable filter class="min-w-50">
                        <template #body="slotProps">
                            <Skeleton v-if="isLoading" width="10rem" height="1rem" />
                            <span v-else class="table-cell-name">{{ slotProps.data.club_actual_jugador || '-' }}</span>
                        </template>
                        <template #filter="{ filterModel }">
                            <InputText v-model="filterModel.value" placeholder="Club actual" class="w-full" />
                        </template>
                    </Column>

                    <Column header="Acciones" class="w-37.5">
                        <template #body="slotProps">
                            <Skeleton v-if="isLoading" width="4rem" height="2rem" />
                            <div v-else class="flex gap-2">
                                <Button
                                    v-if="can('jugador-edit')"
                                    v-tooltip.top="'Editar jugador'"
                                    icon="pi pi-pencil"
                                    rounded
                                    text
                                    severity="secondary"
                                    size="small"
                                    @click="openEditDialog(slotProps.data)"
                                />
                                <Button
                                    v-if="can('jugador-delete')"
                                    v-tooltip.top="'Eliminar jugador'"
                                    icon="pi pi-trash"
                                    rounded
                                    text
                                    severity="danger"
                                    size="small"
                                    @click="confirmDeleteJugador(slotProps.data)"
                                />
                            </div>
                        </template>
                    </Column>
                </DataTable>
            </template>
        </Card>

        <Dialog
            v-model:visible="jugadorDialog.open"
            modal
            :header="jugadorDialog.type === 'create' ? 'Crear Jugador' : 'Editar Jugador'"
            :style="{ width: '900px', height: '650px' }"
            class="jugador-dialog"
        >
            <div class="flex flex-row gap-4 h-full" >
                <div class="flex flex-col gap-4 h-full" style="width: 50%;">
                    <Panel class="col-span-1 h-full">
                        <template #header>
                            <b>Imagen del Jugador</b>
                        </template>
                        <div class="user-profile">
                            <div class="user-avatar">
                                <FileUpload
                                    name="picture"
                                    url="/api/users/updateimg"
                                    @before-upload="onBeforeUpload"
                                    @upload="onTemplatedUpload($event)"
                                    accept="image/*"
                                    :maxFileSize="1500000"
                                    @select="onSelectedFiles"
                                    pt:content:class="fu-content"
                                    pt:buttonbar:class="fu-header"
                                    pt:root:class="fu"
                                    class="fu"
                                    style="max-height: 100%;"
                                >
                                    <template #header="{ chooseCallback, uploadCallback, clearCallback, files, uploadedFiles }">
                                        <div class="flex flex-wrap justify-content-between align-items-center flex-1 gap-2">
                                            <div class="flex gap-2">
                                                <Button @click="chooseCallback()" icon="pi pi-images" rounded outlined></Button>
                                                <Button @click="uploadEvent(uploadCallback, uploadedFiles)" icon="pi pi-cloud-upload" rounded outlined severity="success" :disabled="!files || files.length === 0"></Button>
                                                <Button @click="clearCallback()" icon="pi pi-times" rounded outlined severity="danger" :disabled="!files || files.length === 0"></Button>
                                            </div>
                                        </div>
                                    </template>

                                    <template #content="{ files, uploadedFiles, removeUploadedFileCallback, removeFileCallback }" style="height: 300px">
                                        <img v-if=" files.length > 0" v-for="(file, index) of files" :key="file.name + file.type + file.size" role="presentation" :alt="file.name" :src="file.objectURL" class="object-cover w-full aspect-square rounded-tl-2 rounded-tr-2" style="height: 300px"/>
                                        <div v-else style="height: 300px">
                                            <img v-if="uploadedFiles.length > 0" :key="uploadedFiles[uploadedFiles.length-1].name + uploadedFiles[uploadedFiles.length-1].type + uploadedFiles[uploadedFiles.length-1].size" role="presentation" :alt="uploadedFiles[uploadedFiles.length-1].name" :src="uploadedFiles[uploadedFiles.length-1].objectURL" class="object-cover w-full aspect-square rounded-tl-2 rounded-tr-2"/>
                                        </div>
                                    </template>

                                    <template #empty>
                                        <!-- <img v-if="user.avatar" :src=user.avatar alt="Avatar" class="object-cover w-full aspect-square rounded-tl-2 rounded-tr-2">
                                        <img v-if="!user.avatar" src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Avatar Default" class="object-cover w-full aspect-square rounded-tl-2 rounded-tr-2"> -->
                                    </template>
                                </FileUpload>
                            </div>

                        </div>
                    </Panel>
                </div>
                <div class="flex flex-col gap-4" style="width: 50%;">
                    <div v-if="jugadorDialog.type === 'create'">
                        <label for="jugador-id" class="dialog-label">Id del jugador</label>
                        <InputText
                            id="jugador-id"
                            v-model="jugador.id_jugador"
                            placeholder="ID"
                            class="w-full"
                            :class="{ 'p-invalid': hasError('id_jugador') }"
                        />
                        <small v-if="hasError('id_jugador')" class="dialog-error">
                            {{ getError('id_jugador') }}
                        </small>
                    </div>
                    <div>
                        <label for="jugador-nombre" class="dialog-label">Nombre del jugador</label>
                        <InputText
                            id="jugador-nombre"
                            v-model="jugador.nombre_jugador"
                            placeholder="Nombre"
                            class="w-full"
                            :class="{ 'p-invalid': hasError('nombre_jugador') }"
                        />
                        <small v-if="hasError('nombre_jugador')" class="dialog-error">
                            {{ getError('nombre_jugador') }}
                        </small>
                    </div>
                    <div class="flex flex-col">
                        <label for="jugador-fecha" class="dialog-label">Fecha de nacimiento</label>
                        <DatePicker
                            id="jugador-fecha"
                            v-model="jugador.fecha_nacimiento_jugador"
                            :options="dificultadOpciones"
                            optionLabel="dificultad"
                            optionValue="value"
                            :class="{ 'p-invalid': hasError('fecha_nacimiento_jugador') }"
                            class="w-full"
                            showIcon fluid iconDisplay="input"
                        />
                        <small v-if="hasError('fecha_nacimiento_jugador')" class="dialog-error">
                            {{ getError('fecha_nacimiento_jugador') }}
                        </small>
                    </div>
                    <div class="flex flex-col">
                        <label for="jugador-pais" class="dialog-label">Nacionalidad</label>
                        <Select v-model="jugador.pais_jugador" :options="countryStore.countries" filter filterBy="nombre_pais" optionLabel="nombre_pais" placeholder="Selecciona la nacionalidad" class="w-full">
                            <!-- Lo valida como false al insertar jugador porque devuelve el objeto de pais en vez de el id -->
                            <template #value="slotProps">
                                <div v-if="slotProps.value" class="flex items-center">
                                    <div>{{ slotProps.value.nombre_pais }}</div>
                                </div>
                                <span v-else>
                                    {{ slotProps.placeholder }}
                                </span>
                            </template>
                            <template #option="slotProps">
                                <div class="flex items-center">
                                    <div>{{ slotProps.option.nombre_pais }}</div>
                                </div>
                            </template>
                        </Select>
                        <small v-if="hasError('pais_jugador')" class="dialog-error">
                            {{ getError('pais_jugador') }}
                        </small>
                    </div>
                    <div>
                        <label for="jugador-posicion" class="dialog-label">Posición del jugador</label>
                        <InputText
                            id="jugador-posicion"
                            v-model="jugador.posicion_jugador"
                            placeholder="Posicion"
                            class="w-full"
                            :class="{ 'p-invalid': hasError('posicion_jugador') }"
                        />
                        <small v-if="hasError('posicion_jugador')" class="dialog-error">
                            {{ getError('posicion_jugador') }}
                        </small>
                    </div>
                    <div>
                        <label for="jugador-club-actual" class="dialog-label">Club actual del jugador</label>
                        <InputText
                            id="jugador-club-actual"
                            v-model="jugador.club_actual_jugador"
                            placeholder="Club actual"
                            class="w-full"
                            :class="{ 'p-invalid': hasError('club_actual_jugador') }"
                        />
                        <small v-if="hasError('club_actual_jugador')" class="dialog-error">
                            {{ getError('club_actual_jugador') }}
                        </small>
                    </div>
                </div>
            </div>
            <template #footer>
                <Button
                    label="Cancelar"
                    severity="secondary"
                    @click="closeDialog"
                    :disabled="isSubmitting"
                />
                <Button
                    v-if="jugadorDialog.type === 'create'"
                    label="Crear"
                    @click="submitCreate"
                    :loading="isSubmitting"
                    :disabled="isSubmitting"
                />
                <Button
                    v-else
                    label="Guardar"
                    @click="submitUpdate"
                    :loading="isSubmitting"
                    :disabled="isSubmitting"
                />
            </template>
        </Dialog>
    </div>
</template>

<script setup>
import { ref, reactive, computed, onMounted, inject, watch } from "vue";
import useJugadores from "@/composables/jugadores";
import usePaises from "@/composables/paises";
import { useAbility } from '@casl/vue';
import {FilterMatchMode, FilterOperator} from "@primevue/core/api";
import { usePrimeVue } from 'primevue/config';
import { useCountryStore } from "@/store/paises";

const FILTERS_STORAGE_KEY = 'admin_permissions_table_filters';
const {jugadores, jugador, getJugadores, createJugador, updateJugador, deleteJugador, resetJugador, setJugador, hasError, getError, upsertJugadorRecord, isLoading, totalRecords} = useJugadores();
const { can } = useAbility();
const $primevue = usePrimeVue();
const countryStore = useCountryStore();
const currentPage = ref(0);

const swal = inject('$swal');
const canUseBrowserStorage = typeof window !== 'undefined';

console.log('DEBUG - Store inicial:', {
    countries: countryStore.countries,
    isArray: Array.isArray(countryStore.countries),
    type: typeof countryStore.countries,
    value: countryStore.countries
});

watch(() => countryStore.countries, (newVal, oldVal) => {
    console.log('DEBUG - countries cambiaron:', {
        nuevo: newVal,
        esArray: Array.isArray(newVal),
        longitud: newVal?.length,
        tipo: typeof newVal
    });
}, { deep: true, immediate: true });

const dificultadOpciones = ref([
    { dificultad: '0', value: '0' },
    { dificultad: '1', value: '1' },
    { dificultad: '2', value: '2' },
    { dificultad: '3', value: '3' }
]);

const filters = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
    id_jugador: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
    nombre_jugador: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
    'pais.nombre_pais': { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
    posicion_jugador: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
    club_actual_jugador: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
});

const jugadorDialog = reactive({
    open: false,
    type: 'create'
});

const isSubmitting = computed(() => isLoading.value);
const skeletonRows = Array.from({ length: 5 }, (_, index) => index);

const saveFiltersToStorage = (currentFilters) => {
    if (!canUseBrowserStorage) return;
    try {
        window.localStorage.setItem(FILTERS_STORAGE_KEY, JSON.stringify(currentFilters));
    } catch (error) {
        console.warn('No se pudieron guardar los filtros de permisos', error);
    }
};

const restoreFiltersFromStorage = () => {
    if (!canUseBrowserStorage) return;
    try {
        const stored = window.localStorage.getItem(FILTERS_STORAGE_KEY);
        if (!stored) return;
        const parsed = JSON.parse(stored);
        filters.value = {
            global: { ...filters.value.global, ...parsed.global },
            id_jugador: { ...filters.value.id_jugador, ...parsed.id_jugador },
            nombre_jugador: { ...filters.value.nombre_jugador, ...parsed.nombre_jugador },
            'pais.nombre_pais': { ...filters.value.pais_jugador, ...parsed.pais_jugador },
            posicion_jugador: { ...filters.value.posicion_jugador, ...parsed.posicion_jugador },
            club_actual_jugador: { ...filters.value.club_actual_jugador, ...parsed.club_actual_jugador },
        };
    } catch (error) {
        console.warn('No se pudieron restaurar los filtros de permisos', error);
    }
};

watch(filters, (newFilters) => {
    saveFiltersToStorage(newFilters);
}, { deep: true });

const openCreateDialog = () => {
    console.log('DEBUG - Abriendo modal CREATE:', {
        countries: countryStore.countries,
        esArray: Array.isArray(countryStore.countries),
        longitud: countryStore.countries?.length
    });
    resetJugador();
    jugadorDialog.type = 'create';
    jugadorDialog.open = true;
};

const openEditDialog = async (currentJugador) => {
    console.log('DEBUG - Abriendo modal CREATE:', {
        countries: countryStore.countries,
        esArray: Array.isArray(countryStore.countries),
        longitud: countryStore.countries?.length
    });
    await setJugador(currentJugador);
    jugadorDialog.type = 'edit';
    jugadorDialog.open = true;
};

const closeDialog = () => {
    jugadorDialog.open = false;
    resetJugador();
};

const submitCreate = () => {
    if (isSubmitting.value) return;

    createJugador()
        .then(createdJugador => {
            if (createdJugador) {
                const paisObj = countryStore.countries.find(p => p.id_pais === createdJugador.pais_jugador);
                createdJugador.pais = paisObj || { id_pais: createdJugador.pais_jugador, nombre_pais: '-' };
                upsertJugadorRecord(createdJugador);
                closeDialog();
            }
        });
};

const submitUpdate = () => {
    if (isSubmitting.value) return;

    updateJugador()
    .then(updatedJugador => {
            if (updatedJugador) {
                const paisObj = countryStore.countries.find(p => p.id_pais === updatedJugador.pais_jugador);
                updatedJugador.pais = paisObj || { id_pais: updatedJugador.pais_jugador, nombre_pais: '-' };
                upsertJugadorRecord(updatedJugador);
                closeDialog();
            }
        });
};

const performDelete = (id) => {
    deleteJugador(id);
};

const confirmDeleteJugador = (currentJugador) => {
    if (!swal) {
        const currentPage = Math.ceil(jugadores.value.length > 0 ? 1 : 1);
        deleteJugador(currentJugador.id_jugador, currentPage, 10);
        return;
    }

    swal({
        icon: 'warning',
        title: '¿Eliminar jugador?',
        text: `El jugador "${currentJugador.nombre_jugador}" se eliminará de forma permanente.`,
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#ef4444'
    }).then((result) => {
        if (result.isConfirmed) {
            const currentPage = Math.ceil(jugadores.value.length > 0 ? 1 : 1);
            deleteJugador(currentJugador.id_jugador, currentPage, 10);
        }
    });
};

onMounted(() => {
    countryStore.fetchCountries();
    restoreFiltersFromStorage();
    getJugadores(1, 10);
});

let isChangingPage = false;

const onPageChange = async (event) => {
    if (isChangingPage) return;
    isChangingPage = true;

    currentPage.value = event.page;

    await getJugadores(event.page + 1, event.rows);

    setTimeout(() => {
        isChangingPage = false;
    }, 100);
};

//subir imagen
const totalSize = ref(0);
const totalSizePercent = ref(0);
const files = ref([]);

const onBeforeUpload = (event) => {
    event.formData.append('id', user.value.id)
};

const onSelectedFiles = (event) => {
    files.value = event.files;
    if (event.files.length > 1) {
        event.files = event.files.splice(0, event.files.length - 1);
    }
    files.value.forEach((file) => {
        totalSize.value += parseInt(formatSize(file.size));
    });
};

const uploadEvent = async (callback, uploadedFiles) => {
    totalSizePercent.value = totalSize.value / 10;
    await callback();
};

const onTemplatedUpload = (event) => {
    // Reload user to get new avatar
    getUser(user.value.id);
};

const formatSize = (bytes) => {
    const k = 1024;
    const dm = 3;
    const sizes = $primevue.config.locale.fileSizeTypes;

    if (bytes === 0) {
        return `0 ${sizes[0]}`;
    }

    const i = Math.floor(Math.log(bytes) / Math.log(k));
    const formattedSize = parseFloat((bytes / Math.pow(k, i)).toFixed(dm));

    return `${formattedSize} ${sizes[i]}`;
};

</script>

<style scoped>

.fu-content {
    padding: 0px !important;
    border: 0px !important;
    border-radius: 6px;
}

.fu-header {
    border: 0px !important;
    border-radius: 6px;
}

.fu {
    display: flex;
    flex-direction: column-reverse;
    border-radius: 6px;
    border: 1px solid #e2e8f0;
}

</style>
