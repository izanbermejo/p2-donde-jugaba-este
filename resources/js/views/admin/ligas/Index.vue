<template>
    <div class="permissions-page">
        <Card>
            <template #title>
                <div class="flex items-center justify-between w-full">
                    <span>Gestión de Ligas</span>
                    <div class="flex items-center gap-2">
                        <Button
                            label="Actualizar"
                            icon="pi pi-refresh"
                            size="small"
                            outlined
                            severity="secondary"
                            :loading="isLoading"
                            @click="getLigas"
                        />
                        <Button
                            v-if="can('liga-create')"
                            label="Nueva Liga"
                            icon="pi pi-plus"
                            size="small"
                            severity="primary"
                            @click="openCreateDialog"
                        />
                    </div>
                </div>
            </template>

            <template #subtitle>
                Administra y gestiona las ligas del sistema. Crea, edita y elimina ligas según tus permisos.
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
                    :value="ligas || []"
                    :paginator="true"
                    :rows="10"
                    :rows-per-page-options="[10, 25, 50]"
                    data-key="id"
                    striped-rows
                    size="small"
                    :loading="isLoading"
                    filter-display="menu"
                    :filter-delay="300"
                    :global-filter-fields="['id_liga', 'nombre_liga', 'pais_liga', 'dificultad_liga']"
                >
                    <template #empty>
                        <div class="table-empty-state">
                            <i class="pi pi-inbox empty-state-icon"></i>
                            <p class="empty-state-text">No se encontraron ligas</p>
                            <p class="empty-state-subtext">Intenta ajustar los filtros de búsqueda</p>
                        </div>
                    </template>

                    <Column field="id_liga" header="ID" sortable filter class="w-[80px]">
                        <template #body="slotProps">
                            <Skeleton v-if="isLoading" width="3rem" height="1rem" />
                            <span v-else class="table-cell-id">{{ slotProps.data.id_liga }}</span>
                        </template>
                        <template #filter="{ filterModel }">
                            <InputText v-model="filterModel.value" placeholder="ID" class="w-full" />
                        </template>
                    </Column>

                    <Column field="nombre_liga" header="Nombre" sortable filter class="min-w-[200px]">
                        <template #body="slotProps">
                            <Skeleton v-if="isLoading" width="10rem" height="1rem" />
                            <span v-else class="table-cell-name">{{ slotProps.data.nombre_liga || '-' }}</span>
                        </template>
                        <template #filter="{ filterModel }">
                            <InputText v-model="filterModel.value" placeholder="Nombre" class="w-full" />
                        </template>
                    </Column>
                    
                    <Column field="pais_liga" header="Pais" sortable filter class="min-w-[200px]">
                        <template #body="slotProps">
                            <Skeleton v-if="isLoading" width="10rem" height="1rem" />
                            <span v-else class="table-cell-name">{{ slotProps.data.pais_liga || '-' }}</span>
                        </template>
                        <template #filter="{ filterModel }">
                            <InputText v-model="filterModel.value" placeholder="Nombre" class="w-full" />
                        </template>
                    </Column>

                    <Column field="dificultad_liga" header="Dificultad" sortable class="min-w-[170px]">
                        <template #body="slotProps">
                            <Skeleton v-if="isLoading" width="8rem" height="1rem" />
                            <span v-else class="text-sm table-cell-date">
                                {{ slotProps.data.dificultad_liga }}
                            </span>
                        </template>
                        <template #filter="{ filterModel }">
                            <InputText v-model="filterModel.value" placeholder="Nombre" class="w-full" />
                        </template>
                    </Column>

                    <Column header="Acciones" class="w-[150px]">
                        <template #body="slotProps">
                            <Skeleton v-if="isLoading" width="4rem" height="2rem" />
                            <div v-else class="flex gap-2">
                                <Button
                                    v-if="can('liga-edit')"
                                    v-tooltip.top="'Editar liga'"
                                    icon="pi pi-pencil"
                                    rounded
                                    text
                                    severity="secondary"
                                    size="small"
                                    @click="openEditDialog(slotProps.data)"
                                />
                                <Button
                                    v-if="can('liga-delete')"
                                    v-tooltip.top="'Eliminar liga'"
                                    icon="pi pi-trash"
                                    rounded
                                    text
                                    severity="danger"
                                    size="small"
                                    @click="confirmDeleteLiga(slotProps.data)"
                                />
                            </div>
                        </template>
                    </Column>
                </DataTable>
            </template>
        </Card>

        <Dialog
            v-model:visible="ligaDialog.open"
            modal
            :header="ligaDialog.type === 'create' ? 'Crear Liga' : 'Editar Liga'"
            :style="{ width: '400px' }"
            class="liga-dialog"
        >
            <div class="flex flex-col gap-4">
                <div v-if="ligaDialog.type === 'create'">
                    <label for="liga-id" class="dialog-label">Id de la liga</label>
                    <InputText
                        id="liga-id"
                        v-model="liga.id_liga"
                        placeholder="ID"
                        class="w-full"
                        :class="{ 'p-invalid': hasError('id_liga') }"
                    />
                    <small v-if="hasError('id_liga')" class="dialog-error">
                        {{ getError('id_liga') }}
                    </small>
                </div>
                <div>
                    <label for="liga-nombre" class="dialog-label">Nombre de la liga</label>
                    <InputText
                        id="liga-nombre"
                        v-model="liga.nombre_liga"
                        placeholder="Nombre"
                        class="w-full"
                        :class="{ 'p-invalid': hasError('nombre_liga') }"
                    />
                    <small v-if="hasError('nombre_liga')" class="dialog-error">
                        {{ getError('nombre_liga') }}
                    </small>
                </div>
                <div>
                    <label for="pais_liga" class="dialog-label">País de la liga</label>
                    <InputText
                        id="pais-liga "
                        v-model="liga.pais_liga"
                        placeholder="País"
                        class="w-full"
                        :class="{ 'p-invalid': hasError('pais_liga') }"
                    />
                    <small v-if="hasError('pais_liga')" class="dialog-error">
                        {{ getError('pais_liga') }}
                    </small>
                </div>
                <div class="flex flex-col">
                    <label for="liga-dificultad" class="dialog-label">Dificultad de la liga</label>
                    <SelectButton
                        id="liga-dificultad"
                        v-model="liga.dificultad_liga"
                        :options="dificultadOpciones"
                        optionLabel="dificultad"
                        optionValue="value"
                        :class="{ 'p-invalid': hasError('dificultad_liga') }"
                    />
                    <small v-if="hasError('dificultad_liga')" class="dialog-error">
                        {{ getError('dificultad_liga') }}
                    </small>
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
                    v-if="ligaDialog.type === 'create'"
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
import useLigas from "@/composables/ligas";
import { useAbility } from '@casl/vue';
import {FilterMatchMode, FilterOperator} from "@primevue/core/api";

const FILTERS_STORAGE_KEY = 'admin_permissions_table_filters';
const {ligas, liga, getLigas, createLiga, updateLiga, deleteLiga, resetLiga, setLiga, hasError, getError, upsertLigaRecord, isLoading} = useLigas();
const { can } = useAbility();

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
    id_liga: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
    nombre_liga: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
    pais_liga: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
    dificultad_liga: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
});

const ligaDialog = reactive({
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
            id_liga: { ...filters.value.id_liga, ...parsed.id_liga },
            nombre_liga: { ...filters.value.nombre_liga, ...parsed.nombre_liga },
            pais_liga: { ...filters.value.pais_liga, ...parsed.pais_liga },
            dificultad_liga: { ...filters.value.dificultad_liga, ...parsed.dificultad_liga }
        };
    } catch (error) {
        console.warn('No se pudieron restaurar los filtros de permisos', error);
    }
};

watch(filters, (newFilters) => {
    saveFiltersToStorage(newFilters);
}, { deep: true });

const openCreateDialog = () => {
    resetLiga();
    ligaDialog.type = 'create';
    ligaDialog.open = true;
};

const openEditDialog = (currentLiga) => {
    setLiga(currentLiga);
    ligaDialog.type = 'edit';
    ligaDialog.open = true;
};

const closeDialog = () => {
    ligaDialog.open = false;
    resetLiga();
};

const submitCreate = () => {
    if (isSubmitting.value) return;

    createLiga()
        .then(createdLiga => {
            if (createdLiga) {
                upsertLigaRecord(createdLiga);
                closeDialog();
            }
        });
};

const submitUpdate = () => {
    if (isSubmitting.value) return;

    updateLiga()
        .then(updatedLiga => {
            if (updatedLiga) {
                upsertLigaRecord(updatedLiga);
                closeDialog();
            }
        });
};

const performDelete = (id) => {
    deleteLiga(id);
};

const confirmDeleteLiga = (currentLiga) => {
    if (!swal) {
        performDelete(currentLiga.id_liga);
        return;
    }

    swal({
        icon: 'warning',
        title: '¿Eliminar liga?',
        text: `La liga "${currentLiga.nombre_liga}" se eliminará de forma permanente.`,
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#ef4444'
    }).then((result) => {
        if (result.isConfirmed) {
            performDelete(currentLiga.id_liga);
        }
    });
};

onMounted(() => {
    restoreFiltersFromStorage();
    getLigas();
});
</script>
