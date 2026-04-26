<template>
    <Navbar />

    <section class="info-juego">
        <h2>{{ juego?.nombre_juego }}</h2>

        <div class="content">
            <div class="ranking">
                <TablaRankingJuego :idJuego="props.idJuego"/>
            </div>

            <div class="descripcion">
                <p>{{ juego?.descripcion_juego }}</p>
            </div>
        </div>

        <router-link :to="`/juegos/${juego?.slug_juego}`">
            <Button label="JUGAR" severity="primary" class="btn-jugar" style="width: 500px;"/>
        </router-link>
    </section>

    <Footer />
</template>

<script setup>

import { onMounted, ref } from 'vue';
import Navbar from '../../layouts/LandingNavbar.vue';
import Footer from '../../layouts/MainFooter.vue';
import useJuegos from "@/composables/juegos";
import { useRoute } from 'vue-router';
import TablaRankingJuego from '../../components/TablaRankingJuego.vue';

const route = useRoute()
const {juego, getJuegoByIdJuego} = useJuegos();

const props = defineProps({
    idJuego: [String, Number],
    slugJuego: String
})

onMounted( async () => {
    await getJuegoByIdJuego(props.idJuego);
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

.info-juego {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 50px;
    margin: 50px 0px;
    padding: 0px 200px;
    min-height: calc(75vh);
}

/* nuevo wrapper */
.content {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    width: 100%;
    gap: 10%;
}

.descripcion {
    width: 35%;
    padding: 25px;
    border-radius: 16px;
    font-size: 16px;
    color: #00203E;
    background-color: #d8e6f4;
    box-shadow: 0px 8px 20px rgba(0,0,0,0.3);
}

.ranking {
    width: 55%;
    font-size: 16px;
    color: #00203E;
}

/* botón */
.btn-jugar {
    font-size: 20px;
    padding: 12px 24px;
    border-radius: 16px;
    background-color: #1DB954;
    color: #00203E;
    font-weight: 800;
    width: 200px;
}

/* ===================== */
/* RESPONSIVE 430x932    */
/* ===================== */
@media (max-width: 430px) {

    h2 {
        font-size: 34px;
        text-align: center;
    }

    .info-juego {
        padding: 0px 15px;
        margin: 30px 0px;
        gap: 35px;
        min-height: auto;
    }

    /* orden móvil: ranking arriba */
    .content {
        flex-direction: column;
        gap: 30px;
    }

    .ranking {
        width: 100%;
    }

    .descripcion {
        width: 100%;
        font-size: 14px;
    }

    /* más espacio con el botón */
    .btn-jugar {
        width: 100%;
        max-width: 320px;
        margin-top: 25px;
    }
}

</style>
