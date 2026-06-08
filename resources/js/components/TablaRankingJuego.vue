<template>
    <DataTable
        v-model:filters="filters"
        :value="datosTabla || []"
        :paginator="true"
        :rows="10"
        striped-rows
        style="width: 100%;"
    >
        <template #empty>
            <div class="table-empty-state">
                <i class="pi pi-trophy empty-state-icon"></i>
                <p class="empty-state-text">No hayn registros en el ranking</p>
                <p class="empty-state-subtext">Juega una partida y se el primero en aparecer</p>
            </div>
        </template>

        <Column header="Posición" style="width: 10%">
            <template #body="slotProps">
                {{ slotProps.index + 1 }}
            </template>
        </Column>

        <Column field="nombre" header="Nombre del Jugador" style="width: 50%">
            <template #body="slotProps">
                <span class="table-cell-name">{{ slotProps.data.name || '-' }}</span>
            </template>
        </Column>

        <Column field="fecha" header="Fecha" style="width: 20%">
            <template #body="slotProps">
                {{ formatDate(slotProps.data.fecha) }}
            </template>
        </Column>

        <Column field="puntuacion" header="Puntuación" style="width: 20%">
            <template #body="slotProps">
                <span class="table-cell-name">{{ slotProps.data.puntuacion || '-' }}</span>
            </template>
        </Column>

    </DataTable>
</template>

<script setup>

import { computed, onMounted, watch } from 'vue';
import useRanking from "@/composables/ranking";

const {ranking, getRankingByIdJuego} = useRanking();

const props = defineProps({
    idJuego: String,
    filtro: {
        type: String,
        default: ''
    }
})

onMounted( async () => {
    await getRankingByIdJuego(props.idJuego);
});

watch(() => props.idJuego, async (newId) => {
    await getRankingByIdJuego(newId);
});

const datosTabla = computed(() => {
    if (!ranking.value) return [];

    return ranking.value.filter(j => {
        if (!props.filtro) return true;

        return (j.name || '')
            .toLowerCase()
            .includes(props.filtro.toLowerCase());
    });
});

const formatDate = (dateString) => {
    if (!dateString) return '-';
    const date = new Date(dateString);
    return date.toLocaleDateString('es-ES', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
};

</script>
