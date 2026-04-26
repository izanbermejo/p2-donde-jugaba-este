<template>
    <DataTable
        v-model:filters="filters"
        :value="ranking || []"
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

import { onMounted } from 'vue';
import useRanking from "@/composables/ranking";

const {ranking, getRankingGlobal} = useRanking();

onMounted( async () => {
    await getRankingGlobal();
});

</script>
