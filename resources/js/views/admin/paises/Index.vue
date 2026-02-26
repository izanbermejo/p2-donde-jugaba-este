<template>
    <div class="permissions-page">
        <Card>
            <template #title>
                <div class="flex items-center justify-between w-full">
                    <span>Gestión de Paises</span>
                    <div class="flex items-center gap-2">
                        <Button
                            label="Actualizar"
                            icon="pi pi-refresh"
                            size="small"
                            outlined
                            severity="secondary"
                            :loading="isLoading"
                            @click="getPaises"
                        />
                        <Button
                            v-if="can('pais-create')"
                            label="Nuevo País"
                            icon="pi pi-plus"
                            size="small"
                            severity="primary"
                            @click="openCreateDialog"
                        />
                    </div>
                </div>
            </template>

            <template #subtitle>
                Administra y gestiona los paises del sistema. Crea, edita y elimina paises según tus permisos.
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
                    :value="paises || []"
                    :paginator="true"
                    :rows="10"
                    :rows-per-page-options="[10, 25, 50]"
                    data-key="id"
                    striped-rows
                    size="small"
                    :loading="isLoading"
                    filter-display="menu"
                    :filter-delay="300"
                    :global-filter-fields="['id_pais', 'nombre_pais', 'dificultad_pais']"
                >
                    <template #empty>
                        <div class="table-empty-state">
                            <i class="pi pi-inbox empty-state-icon"></i>
                            <p class="empty-state-text">No se encontraron paises</p>
                            <p class="empty-state-subtext">Intenta ajustar los filtros de búsqueda</p>
                        </div>
                    </template>

                    <Column field="id_pais" header="ID" sortable filter class="w-[80px]">
                        <template #body="slotProps">
                            <Skeleton v-if="isLoading" width="3rem" height="1rem" />
                            <span v-else class="table-cell-id">{{ slotProps.data.id_pais }}</span>
                        </template>
                        <template #filter="{ filterModel }">
                            <InputText v-model="filterModel.value" placeholder="ID" class="w-full" />
                        </template>
                    </Column>

                    <Column field="nombre_pais" header="Nombre" sortable filter class="min-w-[200px]">
                        <template #body="slotProps">
                            <Skeleton v-if="isLoading" width="10rem" height="1rem" />
                            <span v-else class="table-cell-name">{{ slotProps.data.nombre_pais || '-' }}</span>
                        </template>
                        <template #filter="{ filterModel }">
                            <InputText v-model="filterModel.value" placeholder="Nombre" class="w-full" />
                        </template>
                    </Column>

                    <Column field="dificultad_pais" header="Dificultad" sortable class="min-w-[170px]">
                        <template #body="slotProps">
                            <Skeleton v-if="isLoading" width="8rem" height="1rem" />
                            <span v-else class="text-sm table-cell-date">
                                {{ slotProps.data.dificultad_pais }}
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
                                    v-if="can('pais-edit')"
                                    v-tooltip.top="'Editar país'"
                                    icon="pi pi-pencil"
                                    rounded
                                    text
                                    severity="secondary"
                                    size="small"
                                    @click="openEditDialog(slotProps.data)"
                                />
                                <Button
                                    v-if="can('pais-delete')"
                                    v-tooltip.top="'Eliminar país'"
                                    icon="pi pi-trash"
                                    rounded
                                    text
                                    severity="danger"
                                    size="small"
                                    @click="confirmDeletePais(slotProps.data)"
                                />
                            </div>
                        </template>
                    </Column>
                </DataTable>
            </template>
        </Card>

        <Dialog
            v-model:visible="paisDialog.open"
            modal
            :header="paisDialog.type === 'create' ? 'Crear País' : 'Editar País'"
            :style="{ width: '400px' }"
            class="pais-dialog"
        >
            <div class="flex flex-col gap-4">
                <div v-if="paisDialog.type === 'create'">
                    <label for="pais-id" class="dialog-label">Id del país</label>
                    <InputText
                        id="pais-id"
                        v-model="pais.id_pais"
                        placeholder="ID"
                        class="w-full"
                        :class="{ 'p-invalid': hasError('id_pais') }"
                    />
                    <small v-if="hasError('id_pais')" class="dialog-error">
                        {{ getError('id_pais') }}
                    </small>
                </div>
                <div>
                    <label for="pais-nombre" class="dialog-label">Nombre del país</label>
                    <InputText
                        id="pais-nombre"
                        v-model="pais.nombre_pais"
                        placeholder="Nombre"
                        class="w-full"
                        :class="{ 'p-invalid': hasError('nombre_pais') }"
                    />
                    <small v-if="hasError('nombre_pais')" class="dialog-error">
                        {{ getError('nombre_pais') }}
                    </small>
                </div>
                <div class="flex flex-col">
                    <label for="pais-dificultad" class="dialog-label">Dificultad del país</label>
                    <SelectButton
                        id="pais-dificultad"
                        v-model="pais.dificultad_pais"
                        :options="dificultadOpciones"
                        optionLabel="dificultad"
                        optionValue="value"
                        :class="{ 'p-invalid': hasError('dificultad_pais') }"
                    />
                    <small v-if="hasError('dificultad_pais')" class="dialog-error">
                        {{ getError('dificultad_pais') }}
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
                    v-if="paisDialog.type === 'create'"
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
import usePaises from "@/composables/paises";
import { useAbility } from '@casl/vue';
import {FilterMatchMode, FilterOperator} from "@primevue/core/api";

const FILTERS_STORAGE_KEY = 'admin_permissions_table_filters';
const {paises, pais, getPaises, createPais, updatePais, deletePais, resetPais, setPais, hasError, getError, upsertPaisRecord, isLoading} = usePaises();
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
    id_pais: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
    nombre_pais: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
    dificultad_pais: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
});

const paisDialog = reactive({
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
            id_pais: { ...filters.value.id_pais, ...parsed.id_pais },
            nombre_pais: { ...filters.value.nombre_pais, ...parsed.nombre_pais },
            dificultad_pais: { ...filters.value.dificultad_pais, ...parsed.dificultad_pais }
        };
    } catch (error) {
        console.warn('No se pudieron restaurar los filtros de permisos', error);
    }
};

watch(filters, (newFilters) => {
    saveFiltersToStorage(newFilters);
}, { deep: true });

const openCreateDialog = () => {
    resetPais();
    paisDialog.type = 'create';
    paisDialog.open = true;
};

const openEditDialog = (currentPais) => {
    setPais(currentPais);
    paisDialog.type = 'edit';
    paisDialog.open = true;
};

const closeDialog = () => {
    paisDialog.open = false;
    resetPais();
};

const submitCreate = () => {
    if (isSubmitting.value) return;

    createPais()
        .then(createdPais => {
            if (createdPais) {
                upsertPaisRecord(createdPais);
                closeDialog();
            }
        });
};

const submitUpdate = () => {
    if (isSubmitting.value) return;

    updatePais()
        .then(updatedPais => {
            if (updatedPais) {
                upsertPaisRecord(updatedPais);
                closeDialog();
            }
        });
};

const performDelete = (id) => {
    deletePais(id);
};

const confirmDeletePais = (currentPais) => {
    if (!swal) {
        performDelete(currentPais.id_pais);
        return;
    }

    swal({
        icon: 'warning',
        title: '¿Eliminar país?',
        text: `El país "${currentPais.nombre_pais}" se eliminará de forma permanente.`,
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#ef4444'
    }).then((result) => {
        if (result.isConfirmed) {
            performDelete(currentPais.id_pais);
        }
    });
};

onMounted(() => {
    restoreFiltersFromStorage();
    getPaises();
});
</script>
