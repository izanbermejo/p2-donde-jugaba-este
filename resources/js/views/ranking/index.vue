<template>
    <Navbar />

    <section class="ranking">
        <h2>Ranking</h2>
        <div class="flex flex-row justify-between flex-wrap" style="width: 70%;">
            <DataTable
                    v-model:filters="filters"
                    :value="ranking || []"
                    :paginator="true"
                    :rows="10"
                    :rows-per-page-options="[10, 25, 50]"
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
        </div>
    </section>

    <Footer />
</template>

<script setup>

import { onMounted } from 'vue';
import Navbar from '../../layouts/LandingNavbar.vue';
import Footer from '../../layouts/MainFooter.vue';
import useRanking from "@/composables/ranking";

const {ranking, getRankingGlobal} = useRanking();

onMounted( async () => {
    await getRankingGlobal();
});

</script>

<style scoped>

h2 {
    color: #00203E;
    font-size: 60px;
    font-weight: bold;
}

html, body {
    height: 100%;
}

.ranking {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 50px;
    margin: 50px 0px;
    padding: 0px 200px;
    min-height: calc(75vh);
}

.juego-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    background-color: #d8e6f4;
    padding: 40px;
    padding-bottom: 0px;
    margin-bottom: 40px;
    border-radius: 12px;
    transition: transform 0.2s ease, box-shadow 0.2s ease
}

.btn-jugar:hover, .btn-info:hover {
    transform: translateY(-5px);
    box-shadow: 0px 8px 20px rgba(0,0,0,0.3);
}

.juego-imagen {
    width: 400px;
    height: 400px;
    border-radius: 8px;
    box-shadow: 0px 4px 15px 4px rgba(0,0,0,0.23)
;
}

.juego-titulo {
    margin-bottom: 22px;
    font-size: 34px;
    font-weight: 600;
    color: #00203E;
}

.btn-ver-juegos {
    font-size: 28px;
    padding: 12px 24px;
    border-radius: 16px;
    background-color: #1DB954;
    color: #00203E;
    font-weight: 800;
    width: 100%;
    margin-top: 20px;
}

.btns-juego {
    width: 80%;
    display: flex;
    gap: 20px;
    flex-direction: row;
    margin: 20px;
    justify-content: center;
}

.btn-jugar {
    font-size: 20px;
    padding: 12px 24px;
    border-radius: 16px;
    background-color: #1DB954;
    color: #00203E;
    font-weight: 800;
    width: 200px;
}

.btn-info {
    font-size: 20px;
    padding: 12px 24px;
    border-radius: 16px;
    background-color: #1DB954;
    color: #00203E;
    font-weight: 800;
}

</style>
