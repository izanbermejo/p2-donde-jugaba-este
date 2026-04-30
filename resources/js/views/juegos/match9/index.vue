<template>
    <div class="page-container">
        <Navbar />

        <main class="content">
            <h2>Match 9</h2>

            <div class="game-wrapper">
                <GameBoard />
            </div>
        </main>

        <Footer />
    </div>
</template>

<script setup>
import GameBoard from '@/components/GameBoard.vue'
import Navbar from '@/layouts/LandingNavbar.vue'
import Footer from '@/layouts/MainFooter.vue'
</script>

<style scoped>
h2 {
    color: #00203E;
    font-size: 60px;
    font-weight: bold;
}

.page-container {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

/* CENTRADO GLOBAL */
.content {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center; /* centra horizontal */
    justify-content: flex-start;
    text-align: center;
    padding-top: 30px;
}

/* TÍTULO */
.title {
    font-size: 32px;
    font-weight: 800;
    color: #111827;
    margin-bottom: 25px;
    letter-spacing: 1px;
}

/* CONTENEDOR DEL JUEGO */
.game-wrapper {
    display: flex;
    justify-content: center;
    width: 100%;
}
</style>
