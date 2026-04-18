<template>
    <div class="permissions-page">
        <Card>
            <template #title>
                <div class="flex items-center justify-between w-full">
                    <span>Gestión de Clubes</span>
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
                            v-if="can('club-create')"
                            label="Nuevo Club"
                            icon="pi pi-plus"
                            size="small"
                            severity="primary"
                            @click="openCreateDialog"
                        />
                    </div>
                </div>
            </template>

            <template #subtitle>
                Administra y gestiona los clubes del sistema. Crea, edita y elimina clubes según tus permisos.
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
                    :value="clubes || []"
                    :paginator="true"
                    :rows="10"
                    :rows-per-page-options="[10, 25, 50]"
                    data-key="id"
                    striped-rows
                    size="small"
                    :loading="isLoading"
                    filter-display="menu"
                    :filter-delay="300"
                    :global-filter-fields="['id_club', 'nombre_club', 'dificultad_club']"
                >
                    <template #empty>
                        <div class="table-empty-state">
                            <i class="pi pi-inbox empty-state-icon"></i>
                            <p class="empty-state-text">No se encontraron clubes</p>
                            <p class="empty-state-subtext">Intenta ajustar los filtros de búsqueda</p>
                        </div>
                    </template>

                    <Column field="id_club" header="ID" sortable filter class="w-20">
                        <template #body="slotProps">
                            <Skeleton v-if="isLoading" width="3rem" height="1rem" />
                            <span v-else class="table-cell-id">{{ slotProps.data.id_club }}</span>
                        </template>
                        <template #filter="{ filterModel }">
                            <InputText v-model="filterModel.value" placeholder="ID" class="w-full" />
                        </template>
                    </Column>

                    <Column field="nombre_club" header="Nombre" sortable filter class="min-w-50">
                        <template #body="slotProps">
                            <Skeleton v-if="isLoading" width="10rem" height="1rem" />
                            <span v-else class="table-cell-name">{{ slotProps.data.nombre_club || '-' }}</span>
                        </template>
                        <template #filter="{ filterModel }">
                            <InputText v-model="filterModel.value" placeholder="Nombre" class="w-full" />
                        </template>
                    </Column>
                    
                    <Column field="pais_club" header="Pais" sortable filter class="min-w-37.5">
                        <template #body="slotProps">
                            <Skeleton v-if="isLoading" width="10rem" height="1rem" />
                            <span v-else class="table-cell-name">{{ slotProps.data.pais_club || '-' }}</span>
                        </template>
                        <template #filter="{ filterModel }">
                            <InputText v-model="filterModel.value" placeholder="Pais" class="w-full" />
                        </template>
                    </Column>
                    
                    <Column field="id_liga_club" header="Liga" sortable filter filterField="liga.nombre_liga" class="min-w-37.5" :showFilterMatchModes="false">
                        <template #body="slotProps">
                            <Skeleton v-if="isLoading" width="10rem" height="1rem" />
                            <span v-else class="table-cell-name">{{ slotProps.data.liga?.nombre_liga || '-' }}</span>
                        </template>
                        <template #filter="{ filterModel }">
                            <InputText v-model="filterModel.value" placeholder="Nombre liga" class="w-full" />
                        </template>
                    </Column>

                    <Column field="dificultad_club" header="Dificultad" sortable filter class="min-w-50">
                        <template #body="slotProps">
                            <Skeleton v-if="isLoading" width="10rem" height="1rem" />
                            <span v-else class="table-cell-name">{{ slotProps.data.dificultad_club || '-' }}</span>
                        </template>
                        <template #filter="{ filterModel }">
                            <InputText v-model="filterModel.value" placeholder="Dificultad" class="w-full" />
                        </template>
                    </Column>

                    <Column header="Acciones" class="w-37.5">
                        <template #body="slotProps">
                            <Skeleton v-if="isLoading" width="4rem" height="2rem" />
                            <div v-else class="flex gap-2">
                                <Button
                                    v-if="can('club-edit')"
                                    v-tooltip.top="'Editar club'"
                                    icon="pi pi-pencil"
                                    rounded
                                    text
                                    severity="secondary"
                                    size="small"
                                    @click="openEditDialog(slotProps.data)"
                                />
                                <Button
                                    v-if="can('club-delete')"
                                    v-tooltip.top="'Eliminar club'"
                                    icon="pi pi-trash"
                                    rounded
                                    text
                                    severity="danger"
                                    size="small"
                                    @click="confirmDeleteClub(slotProps.data)"
                                />
                            </div>
                        </template>
                    </Column>
                </DataTable>
            </template>
        </Card>

        <Dialog
            v-model:visible="clubDialog.open"
            modal
            :header="clubDialog.type === 'create' ? 'Crear Club' : 'Editar Club'"
            :style="{ width: '900px', height: '650px' }"
            class="club-dialog"
        >
            <div class="flex flex-row gap-4 h-full" >
                <div class="flex flex-col gap-4 h-full" style="width: 50%;">
                    <Panel class="col-span-1 h-full">
                        <template #header>
                            <b>Imagen del Club</b>
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
                    <div v-if="clubDialog.type === 'create'">
                        <label for="club-id" class="dialog-label">Id del club</label>
                        <InputText
                            id="club-id"
                            v-model="club.id_club"
                            placeholder="ID"
                            class="w-full"
                            :class="{ 'p-invalid': hasError('id_club') }"
                        />
                        <small v-if="hasError('id_club')" class="dialog-error">
                            {{ getError('id_club') }}
                        </small>
                    </div>
                    <div>
                        <label for="club-nombre" class="dialog-label">Nombre del club</label>
                        <InputText
                            id="club-nombre"
                            v-model="club.nombre_club"
                            placeholder="Nombre"
                            class="w-full"
                            :class="{ 'p-invalid': hasError('nombre_club') }"
                        />
                        <small v-if="hasError('nombre_club')" class="dialog-error">
                            {{ getError('nombre_club') }}
                        </small>
                    
                    </div>
                    <div class="flex flex-col">
                        <label for="club-pais" class="dialog-label">Pais</label>
                        <InputText
                            id="club-pais"
                            v-model="club.pais_club"
                            :key="club.id_club"
                            placeholder="Pais"
                            class="w-full"
                            :class="{ 'p-invalid': hasError('pais_club') }"
                        />
                        <small v-if="hasError('pais_club')" class="dialog-error">
                            {{ getError('pais_club') }}
                        </small>
                    </div>
                    <div>
                        <label for="club-liga" class="dialog-label">Liga</label>
                        <Select
                        id="club-liga" 
                        v-model="club.id_liga_club" 
                        :options="ligas" 
                        optionLabel="nombre_liga"
                        optionValue="id_liga"
                        filter 
                        filterBy="nombre_liga"  
                        placeholder="Selecciona la liga" 
                        class="w-full">
                            <!-- Lo valida como false al insertar club porque devuelve el objeto de liga en vez de el id -->
                            <template #value="slotProps">
                                <div v-if="slotProps.value" class="flex items-center">
                                    <div>{{ ligas.find(l => l.id_liga === slotProps.value)?.nombre_liga || '-' }}</div>
                                </div>
                                <span v-else>
                                    {{ slotProps.placeholder }}
                                </span>
                            </template>
                            <template #option="slotProps">
                                <div class="flex items-center">
                                    <div>{{ slotProps.option.nombre_liga }}</div>
                                </div>
                            </template>
                        </Select>
                        <small v-if="hasError('id_liga_club')" class="dialog-error">
                            {{ getError('id_liga_club') }}
                        </small>
                    </div>
                    <div>
                        <label for="club-dificultad" class="dialog-label">Dificultad del club</label>
                        <InputText
                            id="club-dificultad"
                            v-model="club.dificultad_club"
                            placeholder="Dificultad club"
                            class="w-full"
                            :class="{ 'p-invalid': hasError('dificultad_club') }"
                        />
                        <small v-if="hasError('dificultad_club')" class="dialog-error">
                            {{ getError('dificultad_club') }}
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
                    v-if="clubDialog.type === 'create'"
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
import useClubes from "@/composables/clubes";
import useLigas from "@/composables/ligas";
import { useAbility } from '@casl/vue';
import {FilterMatchMode, FilterOperator} from "@primevue/core/api";
import { usePrimeVue } from 'primevue/config';

const FILTERS_STORAGE_KEY = 'admin_permissions_table_filters';
const {clubes, club, getClubes, createClub, updateClub, deleteClub, resetClub, setClub, hasError, getError, upsertClubRecord, isLoading} = useClubes();
const {ligas, getLigas} = useLigas();
const { can } = useAbility();
const $primevue = usePrimeVue();

const swal = inject('$swal');
const canUseBrowserStorage = typeof window !== 'undefined';

const dificultadOpciones = ref([
    { dificultad: '0', value: '0' },
    { dificultad: '1', value: '1' },
    { dificultad: '2', value: '2' },
    { dificultad: '3', value: '3' }
]);

const filters = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
    id_club: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
    nombre_club: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
    pais_club: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
    'liga.nombre_liga': { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
    dificultad_club: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
});

const clubDialog = reactive({
    open: false,
    type: 'create'
});

const test = () => {
    getClubes()
}

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
            id_club: { ...filters.value.id_club, ...parsed.id_club },
            nombre_club: { ...filters.value.nombre_club, ...parsed.nombre_club },
            pais_club: { ...filters.value.pais_club, ...parsed.pais_club },
            'liga.nombre_liga': { ...filters.value.id_liga_club, ...parsed.id_liga_club },
            dificultad_club: { ...filters.value.dificultad_club, ...parsed.dificultad_club },
        };
    } catch (error) {
        console.warn('No se pudieron restaurar los filtros de permisos', error);
    }
};

watch(filters, (newFilters) => {
    saveFiltersToStorage(newFilters);
}, { deep: true });

const openCreateDialog = () => {
    cargaLigas()
    resetClub();
    clubDialog.type = 'create';
    clubDialog.open = true;
};

const openEditDialog = (currentClub) => {
    cargaLigas()
    setClub(currentClub);
    clubDialog.type = 'edit';
    clubDialog.open = true;
};

const cargaLigas = async () => {
    const response = await getLigas();
    ligas.value = response.data;
}

const closeDialog = () => {
    clubDialog.open = false;
    resetClub();
};

const submitCreate = () => {
    console.log("1. ENTRA")
    console.log(isSubmitting.value);
    if (isSubmitting.value) return;

    createClub()
        .then(createdClub => {
            if (createdClub) {
                const ligaObj = ligas.value.find(p => p.id_liga === createdClub.id_liga_club);
                createdClub.liga = ligaObj || { id_liga: createdClub.id_liga_club, nombre_liga: '-' };
                upsertClubRecord(createdClub);
                closeDialog();
            }
        });
};

const submitUpdate = () => {
    if (isSubmitting.value) return;

    updateClub()
    .then(updatedClub => {
            if (updatedClub) {
                const ligaObj = ligas.value.find(p => p.id_liga === updatedClub.id_liga_club);
                updatedClub.liga = ligaObj || { id_liga: updatedClub.id_liga_club, nombre_liga: '-' };
                upsertClubRecord(updatedClub);
                closeDialog();
            }
        });
};

const performDelete = (id) => {
    deleteClub(id);
};

const confirmDeleteClub = (currentClub) => {
    if (!swal) {
        performDelete(currentClub.id_club);
        return;
    }

    swal({
        icon: 'warning',
        title: '¿Eliminar club?',
        text: `El club "${currentClub.nombre_club}" se eliminará de forma permanente.`,
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#ef4444'
    }).then((result) => {
        if (result.isConfirmed) {
            performDelete(currentClub.id_club);
        }
    });
};

onMounted(() => {
    restoreFiltersFromStorage();
    getClubes();
});

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
