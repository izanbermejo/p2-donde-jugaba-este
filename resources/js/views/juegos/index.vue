<template>
    <Navbar />

    <section class="juegos">
        <h2>Juegos</h2>
        <div class="flex flex-row justify-between flex-wrap" style="width: 100%;">
            <div v-for="juego in juegos" :key="juego.id" class="juego-container">
                <h3 class="juego-titulo">{{ juego.name }}</h3>
                <img :src="juego.image" alt="Imagen del juego" class="juego-imagen" />
                <div class="btns-juego">
                    <router-link :to="juego.route">
                        <Button label="JUGAR" severity="primary" class="btn-jugar" />
                    </router-link>
                    <router-link :to="juego.routeInfo">
                        <Button icon="pi pi-info" severity="primary" class="btn-info" />
                    </router-link>

                </div>
                </div>
        </div>
    </section>

    <Footer />
</template>

<script setup>

const juegos = [
    {
        id: 'match9',
        name: 'Match 9',
        image: '/images/Match9.webp',
        route: '/juegos/match9',
        routeInfo: '/juegos/match9/info'
    },
    {
        id: 'path4',
        name: 'Path 4',
        image: '/images/Path4.webp',
        route: '/juegos/path4',
        routeInfo: '/juegos/path4/info'
    },
];

import Navbar from '../../layouts/LandingNavbar.vue'
import Footer from '../../layouts/MainFooter.vue'


</script>

<style scoped>

h2 {
    color: #00203E;
    font-size: 60px;
    font-weight: bold;
}

.juegos {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 50px;
    margin: 50px 0px;
    padding: 0px 200px;
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
