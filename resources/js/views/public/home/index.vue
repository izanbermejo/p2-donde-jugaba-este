<template>
    <section class="banner" >
        <img
            src="/images/banner_home.webp"
            alt="banner principal"
            style="width: 100%;"
        />

        <h1 class="titulo-banner">
            Sube en el ranking o quédate en el banquillo
        </h1>
    </section>

    <section class="juegos">
        <h2>Juegos</h2>
        <div class="flex flex-row justify-between" style="width: 100%;">
            <router-link  to="/juegos/match9">
                <div class="juego-container">
                    <img src="/images/Match9.webp" alt="Imagen del juego" class="juego-imagen" />
                    <h3 class="juego-titulo">Match 9</h3>
                </div>
            </router-link>
            <router-link  to="/juegos/path4">
                <div class="juego-container">
                    <img src="/images/Path4.webp" alt="Imagen del juego" class="juego-imagen" />
                    <h3 class="juego-titulo">Path 4</h3>
                </div>
            </router-link>
        </div>
        <router-link  to="/juegos" style="width: 100%;">
            <Button label="Ver juegos" severity="primary" class="btn-ver-juegos" />
        </router-link>
    </section>

    <Divider />

    <section class="ranking">
        <h2>Ranking</h2>
        <div class="flex flex-col" style="width: 100%; height: 100%; margin-bottom: 40px; gap: 30px; justify-content: space-between;">
            <TablaRankingGlobal />
            <router-link  to="/ranking" style="width: 100%;">
                <Button label="Ir al ranking" severity="primary" class="btn-ver-juegos" />
            </router-link>
        </div>
    </section>
</template>

<script setup>
import { authStore } from "@/store/auth";
import TablaRankingGlobal from "../../../components/TablaRankingGlobal.vue";
</script>

<style scoped>

h2 {
    color: #00203E;
    font-size: 60px;
    font-weight: bold;
}

.banner {
    position: relative;
    width: 100%;
}

/* Degradado inferior */
.banner::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: 0;
    width: 100%;
    height: 60%;
    background: linear-gradient(
        to top,
        rgba(0, 32, 62, 0.95),
        rgba(0, 32, 62, 0.6),
        rgba(0, 32, 62, 0)
    );
    pointer-events: none;
}

/* Texto superpuesto */
.banner .titulo-banner {
    position: absolute;
    bottom: 50px;
    left: 50%;
    transform: translateX(-50%);
    color: white;
    font-size: 48px;
    font-weight: 700;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.6);
    z-index: 2;
    text-align: center;
    white-space: nowrap;
}

/* Responsive */
@media (max-width: 768px) {
    .banner .titulo-banner {
        font-size: 20px;
    }
}

/* Juegos */

.juegos {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 50px;
    margin: 50px 0px;
    padding: 0px 200px;
    margin-bottom: 80px;
}

.juego-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    background-color: #d8e6f4;
    padding: 40px;
    padding-bottom: 0px;
    border-radius: 12px;
    transition: transform 0.2s ease, box-shadow 0.2s ease
}

.juego-container:hover {
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
    margin-top: 22px;
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

/* ranking */
.ranking {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 50px;
    margin: 50px 0px;
    padding: 0px 200px;
    height: 700px;
}

</style>
