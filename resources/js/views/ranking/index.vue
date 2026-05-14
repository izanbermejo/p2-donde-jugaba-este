<template>
    <div class="page-wrapper">
        <Navbar />

        <section class="ranking">
            <h2>Ranking</h2>
            <span class="explicacion-pagina">Consulta la clasificación de los jugadores en los distintos minijuegos y compara tus resultados con los de otros usuarios. Aquí se reflejan las mejores puntuaciones y el progreso de cada participante. Supera tus marcas, escala posiciones y demuestra tu nivel en cada reto.</span>
            <div class="flex flex-row justify-between flex-wrap" style="width: 70%;">
                <TablaRankingGlobal />
            </div>
        </section>

        <Footer />
    </div>
</template>

<script setup>

import { onMounted } from 'vue';
import Navbar from '../../layouts/LandingNavbar.vue';
import Footer from '../../layouts/MainFooter.vue';
import useRanking from "@/composables/ranking";
import TablaRankingGlobal from '../../components/TablaRankingGlobal.vue';

const {ranking, getRankingGlobal} = useRanking();

onMounted( async () => {
    await getRankingGlobal();
});

</script>

<style scoped>

.page-wrapper {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

h2 {
    color: #00203E;
    font-size: 60px;
    font-weight: bold;
}

.ranking {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 50px;
    margin: 50px 0px;
    padding: 0px 200px;
    flex: 1;
}

.explicacion-pagina {
    font-size: 18px;
    color: #2a4761;
    text-align: center;
    max-width: 800px;
    margin-bottom: 20px;
}

/* responsive */

@media (max-width: 430px) {

    h2 {
        font-size: 34px;
        text-align: center;
    }

    .ranking {
        padding: 0px 15px;
        margin: 30px 0px;
        gap: 25px;
    }

    .ranking > div {
        width: 100% !important;
        justify-content: center;
    }
}

</style>
