<template>
    <div class="permissions-page">
        <Card>
            <template #title>
                <div class="flex items-center justify-between w-full">
                    <span>Gestión de Posiciones</span>
                    <div class="flex items-center gap-2">
                        <Button label="Actualizar" icon="pi pi-refresh" size="small" outlined severity="secondary"
                            :loading="isLoading" @click="getPosiciones" />
                        <Button v-if="can('posicion-create')" label="Nueva Posicion" icon="pi pi-plus" size="small"
                            severity="primary" @click="openCreateDialog" />
                    </div>
                </div>
            </template>

            <template #subtitle>
                Administra y gestiona las posiciones del sistema. Crea, edita y elimina posiciones según tus permisos.
            </template>

            <template #content>
                <div v-if="isLoading" class="table-loading-skeleton space-y-3">
                    <div v-for="row in skeletonRows" :key="row" class="flex gap-3 items-center">
                        <Skeleton width="60px" height="1.25rem" />
                        <Skeleton width="200px" height="1.25rem" />
                        <Skeleton width="140px" height="1.25rem" />
                        <div class="flex gap-2 ml-auto">
                            <Skeleton width="2.5rem" height="2.5rem" shape="circle" />
                            <Skeleton width="2.5rem" height="2.5rem" shape="circle" />
                        </div>
                    </div>
                </div>
                <DataTable v-else v-model:filters="filters" :value="posiciones || []" :paginator="true" :rows="10"
                    :rows-per-page-options="[10, 25, 50]" data-key="id" striped-rows size="small" :loading="isLoading"
                    filter-display="menu" :filter-delay="300"
                    :global-filter-fields="['id_posicion', 'rol', 'posicion']"> <template #empty>
                        <div class="table-empty-state"> <i class="pi pi-inbox empty-state-icon"></i>
                            <p class="empty-state-text">No se encontraron posiciones</p>
                            <p class="empty-state-subtext">Intenta ajustar los filtros de búsqueda</p>
                        </div>
                    </template>
                    <Column field="id_posicion" header="ID" sortable filter class="w-[80px]"> <template
                            #body="slotProps">
                            <Skeleton v-if="isLoading" width="3rem" height="1rem" /> <span v-else
                                class="table-cell-id">{{ slotProps.data.id_posicion }}</span>
                        </template>
                        <template #filter="{ filterModel }">
                            <InputText v-model="filterModel.value" placeholder="ID" class="w-full" />
                        </template>
                    </Column>



                    <Column field="rol" header="Rol"  sortable filter class="min-w-[200px]" :showFilterMatchModes="false"
                        :showFilterOperator="false" >
                        <template #body="slotProps">
                           
                            <Skeleton v-if="isLoading" width="10rem" height="1rem" />
                            <span v-else class="table-cell-name">
                                                
                                {{ slotProps.data.rol || '-' }}
                            </span>
                        </template>

                        <template #filter="{ filterModel, filterCallback }">
                            <MultiSelect v-model="filterModel.value" @change="filterCallback()" :options="roles"
                                placeholder="Seleccionar rol" class="w-full" display="chip" />
                        </template>
                    </Column>




                    <Column field="posicion" header="Posicion" sortable class="min-w-[170px]"> <template
                            #body="slotProps">
                            <Skeleton v-if="isLoading" width="8rem" height="1rem" /> <span v-else
                                class="text-sm table-cell-date"> {{ slotProps.data.posicion }} </span>
                        </template>
                        <template #filter="{ filterModel }">
                            <InputText v-model="filterModel.value" placeholder="Nombre" class="w-full" />
                        </template>
                    </Column>
                    <Column header="Acciones" class="w-[150px]"> <template #body="slotProps">
                            <Skeleton v-if="isLoading" width="4rem" height="2rem" />
                            <div v-else class="flex gap-2"> <Button v-if="can('posicion-edit')"
                                    v-tooltip.top="'Editar posición'" icon="pi pi-pencil" rounded text
                                    severity="secondary" size="small" @click="openEditDialog(slotProps.data)" /> <Button
                                    v-if="can('posicion-delete')" v-tooltip.top="'Eliminar posición'" icon="pi pi-trash"
                                    rounded text severity="danger" size="small"
                                    @click="confirmDeletePosicion(slotProps.data)" /> </div>
                        </template>
                    </Column>
                </DataTable>
            </template>
        </Card>

        <Dialog v-model:visible="posicionDialog.open" modal
            :header="posicionDialog.type === 'create' ? 'Crear Posición' : 'Editar Posición'"
            :style="{ width: '400px' }" class="posicion-dialog">
            <div class="flex flex-col gap-4">
                <div v-if="posicionDialog.type === 'create'">
                    <label for="posicion-id" class="dialog-label">Id de la posición</label>
                    <InputText id="posicion-id" v-model="posicion.id_posicion" placeholder="ID" class="w-full"
                        :class="{ 'p-invalid': hasError('id_posicion') }" />
                    <small v-if="hasError('id_posicion')" class="dialog-error">
                        {{ getError('id_posicion') }}
                    </small>
                </div>
                <div>
                    <label for="rol" class="dialog-label">Rol de la posición</label>
                    <SelectButton id="rol" v-model="posicion.rol" :options="rolOpciones" optionLabel="rol"
                        optionValue="value" :class="{ 'p-invalid': hasError('rol') }" />
                    <small v-if="hasError('rol')" class="dialog-error">
                        {{ getError('rol') }}
                    </small>
                </div>
                <div class="flex flex-col">
                    <label for="posicion" class="dialog-label">Posición</label>
                    <InputText id="posicion" v-model="posicion.posicion" placeholder="Posicion" class="w-full"
                        :class="{ 'p-invalid': hasError('posicion') }" />
                    <small v-if="hasError('posicion')" class="dialog-error">
                        {{ getError('posicion') }}
                    </small>
                </div>
            </div>
            <template #footer>
                <Button label="Cancelar" severity="secondary" @click="closeDialog" :disabled="isSubmitting" />
                <Button v-if="posicionDialog.type === 'create'" label="Crear" @click="submitCreate"
                    :loading="isSubmitting" :disabled="isSubmitting" />
                <Button v-else label="Guardar" @click="submitUpdate" :loading="isSubmitting" :disabled="isSubmitting" />
            </template>
        </Dialog>
    </div>
</template>

<script setup>
import { ref, reactive, computed, onMounted, inject, watch } from "vue";
import usePosiciones from "@/composables/posiciones";
import { useAbility } from '@casl/vue';
import { FilterMatchMode, FilterOperator, FilterService } from "@primevue/core/api";

const FILTERS_STORAGE_KEY = 'admin_permissions_table_filters';
const { posiciones, posicion, getPosiciones, createPosicion, updatePosicion, deletePosicion, resetPosicion, setPosicion, hasError, getError, upsertPosicionRecord, isLoading } = usePosiciones();
const { can } = useAbility();

const swal = inject('$swal');
const canUseBrowserStorage = typeof window !== 'undefined';

const FILTER_MATCH_OR = 'FILTER_MATCH_OR';

const ROL_MATCH_OR = (value, filter) => {
    if (!filter || filter.length === 0) return true;
    if (!value) return false;

    return filter.some(f => f === value);
};

const rolOpciones = ref([
    { rol: 'Portero', value: 'Portero' },
    { rol: 'Defensa', value: 'Defensa' },
    { rol: 'Mediocampo', value: 'Mediocampo' },
    { rol: 'Ataque', value: 'Ataque' }
]);

const roles = [
    "Portero",
    "Defensa",
    "Mediocampo",
    "Ataque"
]

const filters = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
    id_posicion: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
    rol: {  value: null, matchMode: FILTER_MATCH_OR },
    posicion: { operator: FilterOperator.AND, constraints: [{ value: null, matchMode: FilterMatchMode.CONTAINS }] },
});

const posicionDialog = reactive({
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
            id_posicion: { ...filters.value.id_posicion, ...parsed.id_posicion },
            rol: { ...filters.value.rol, ...parsed.rol },
            posicion: { ...filters.value.posicion, ...parsed.posicion }
        };
    } catch (error) {
        console.warn('No se pudieron restaurar los filtros de posiciones', error);
    }
};

watch(filters, (newFilters) => {
    saveFiltersToStorage(newFilters);
}, { deep: true });

const openCreateDialog = () => {
    resetPosicion();
    posicionDialog.type = 'create';
    posicionDialog.open = true;
};

const openEditDialog = (currentPosicion) => {
    setPosicion(currentPosicion);
    posicionDialog.type = 'edit';
    posicionDialog.open = true;
};

const closeDialog = () => {
    posicionDialog.open = false;
    resetPosicion();
};

const submitCreate = () => {
    if (isSubmitting.value) return;

    createPosicion()
        .then(createdPosicion => {
            if (createdPosicion) {
                upsertPosicionRecord(createdPosicion);
                closeDialog();
            }
        });
};

const submitUpdate = () => {
    if (isSubmitting.value) return;

    updatePosicion()
        .then(updatedPosicion => {
            if (updatedPosicion) {
                upsertPosicionRecord(updatedPosicion);
                closeDialog();
            }
        });
};

const performDelete = (id) => {
    deletePosicion(id);
};

const confirmDeletePosicion = (currentPosicion) => {
    if (!swal) {
        performDelete(currentPosicion.id_posicion);
        return;
    }

    swal({
        icon: 'warning',
        title: '¿Eliminar posición?',
        text: `La posición "${currentPosicion.posicion}" se eliminará de forma permanente.`,
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#ef4444'
    }).then((result) => {
        if (result.isConfirmed) {
            performDelete(currentPosicion.id_posicion);
        }
    });
};

onMounted(() => {
    restoreFiltersFromStorage();
    getPosiciones();
    FilterService.register('FILTER_MATCH_OR',ROL_MATCH_OR);
});
</script>
