<template>
    <Navbar />

    <section class="info-juego">
        <h2>{{ juego?.nombre_juego }}</h2>

        <div class="info-content">
            <div class="ranking">
                <TablaRankingJuego :idJuego="props.idJuego"/>
            </div>

            <div class="content">
                <router-link :to="`/juegos/${juego?.slug_juego}`">
                    <Button label="JUGAR" severity="primary" class="btn-jugar"/>
                </router-link>

                <div class="descripcion">
                    <p>{{ juego?.descripcion_juego }}</p>
                </div>
            </div>
        </div>
    </section>

    <Footer />
</template>

<script setup>

import { onMounted } from 'vue'
import Navbar from '../../layouts/LandingNavbar.vue'
import Footer from '../../layouts/MainFooter.vue'
import useJuegos from "@/composables/juegos"
import { useRoute } from 'vue-router'
import TablaRankingJuego from '../../components/TablaRankingJuego.vue'

const route = useRoute()
const { juego, getJuegoByIdJuego } = useJuegos()

const props = defineProps({
    idJuego: [String, Number],
    slugJuego: String
})

// Carga la información del juego al montar el componente
onMounted(async () => {
    await getJuegoByIdJuego(props.idJuego)
})

</script>

<style scoped>

/* Título principal del juego */
h2 {
    color: #00203E;
    font-size: 60px;
    font-weight: bold;
}

html, body {
    height: 100%;
}

/* Contenedor principal */
.info-juego {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 50px;
    margin: 50px 0px;
    width: 100%;
    padding: 0px 350px;
    min-height: calc(75vh);
}

/* Layout principal */
.info-content {
    display: flex;
    flex-direction: row;
    gap: 50px;
    width: 100%;
    margin-bottom: 50px;
}

/* Columna derecha */
.content {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    width: 45%;
    gap: 10%;
}

/* Descripción */
.descripcion {
    width: 100%;
    padding: 25px;
    border-radius: 16px;
    font-size: 16px;
    color: #00203E;
    background-color: #d8e6f4;
    box-shadow: 0px 8px 20px rgba(0,0,0,0.3);
}

/* Ranking */
.ranking {
    width: 55%;
    font-size: 16px;
    color: #00203E;
}

/* Botón jugar */
.btn-jugar {
    font-size: 20px;
    padding: 12px 24px;
    border-radius: 16px;
    background-color: #1DB954;
    color: #00203E;
    font-weight: 800;
    width: 100%;
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
        gap: 25px;
        min-height: auto;
    }

    .info-content {
        flex-direction: column;
        gap: 25px;
        margin-bottom: 20px;
    }

    .ranking,
    .content {
        width: 100%;
    }

    .content {
        gap: 25px;
        align-items: center;
    }

    .descripcion {
        width: 100%;
        font-size: 14px;
        padding: 20px;
    }

    .btn-jugar {
        width: 100%;
        font-size: 18px;
        padding: 10px 16px;
    }
}

</style>
