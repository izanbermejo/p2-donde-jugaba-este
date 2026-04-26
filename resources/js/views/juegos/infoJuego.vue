<template>
    <Navbar />

    <section class="info-juego">
        <h2>{{ juego?.nombre_juego }}</h2>
        <div class="flex flex-row justify-between" style="width: 100%; gap: 10%;">
            <div class="descripcion">
                <p>{{ juego?.descripcion_juego }}</p>
            </div>
            <div class="ranking">
                <TablaRankingJuego :idJuego="props.idJuego"/>
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
