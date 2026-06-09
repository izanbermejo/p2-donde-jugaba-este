<template>
    <DataTable
        v-model:filters="filters"
        :value="datosTabla || []"
        :paginator="true"
        :rows="props.rows"
        striped-rows
        style="width: 100%;"
    >
        <template #empty>
            <div class="table-empty-state">
                <i class="pi pi-trophy empty-state-icon"></i>
                <p class="empty-state-text">No hay registros en el ranking</p>
                <p class="empty-state-subtext">Juega una partida y se el primero en aparecer</p>
            </div>
        </template>

        <Column header="Posición" style="width: 10%">
            <template #body="slotProps">
                {{ slotProps.index + 1 }}
            </template>
        </Column>

        <Column field="nombre" header="Nombre del Jugador" style="width: 70%">
            <template #body="slotProps">
                <span class="table-cell-name">{{ slotProps.data.name || '-' }}</span>
            </template>
        </Column>

        <Column field="puntuacion" header="Puntuación" style="width: 20%">
            <template #body="slotProps">
                <span class="table-cell-name">{{ slotProps.data.total_puntuacion || '-' }}</span>
            </template>
        </Column>

    </DataTable>
</template>

<script setup>

import { computed, onMounted } from 'vue';
import useRanking from "@/composables/ranking";

const props = defineProps({
    rows: {
        type: Number,
        default: 10
    },
    filtro: {
        type: String,
        default: ''
    }
});

const { ranking, getRankingGlobal } = useRanking();

const datosTabla = computed(() => {
    if (!ranking.value) return [];

    return ranking.value.filter(j => {
        if (!props.filtro) return true;

        return (j.name || '')
            .toLowerCase()
            .includes(props.filtro.toLowerCase());
    });
});

onMounted(async () => {
    await getRankingGlobal();
});

</script>
