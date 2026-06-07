<template>
    <div class="page-container">
        <Navbar />

        <main class="content">
            <div class="title-section">
                <h2>Path 4</h2>
            </div>

            <div class="game-section">
                <GameBoardPath4 />
            </div>
        </main>

        <Footer />
    </div>
</template>

<script setup>
import GameBoardPath4 from '@/components/GameBoardPath4.vue'
import Navbar from '@/layouts/LandingNavbar.vue'
import Footer from '@/layouts/MainFooter.vue'
</script>

<style scoped>
.page-container {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

.content {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding-top: 40px;
    padding-bottom: 60px;
}

.title-section {
    width: 100%;
    display: flex;
    justify-content: center;
    margin-bottom: 40px;
}

h2 {
    color: #00203E;
    font-size: 60px;
    font-weight: bold;
    margin: 0;
    text-align: center;
}

.game-section {
    width: 100%;
    display: flex;
    justify-content: center;
}

.game-wrapper {
    display: flex;
    justify-content: center;
    width: 100%;
}

@media (max-width: 430px) {
    h2 {
        font-size: 36px;
    }

    .title-section {
        margin-bottom: 20px;
    }

    .content {
        padding-top: 20px;
    }
}
</style>