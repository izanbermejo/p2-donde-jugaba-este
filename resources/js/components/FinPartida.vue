<template>
  <div class="page-container">

    <Navbar />

    <main class="result-wrapper">

      <div class="status-section">
        <h1 v-if="victoria" class="title win">¡VICTORIA!</h1>
        <h1 v-else class="title lose">TE HAS RENDIDO</h1>
      </div>

      <div class="score-card">
        <h2>Puntuación final</h2>
        <span class="score">{{ puntuacion }}</span>
      </div>

      <!-- DETALLES -->
      <div class="details-card">
        <div class="detail">
          <span class="label">Tiempo de partida</span>
          <span class="value">{{ segundos }}s</span>
        </div>

        <div class="detail">
          <span class="label">Estado</span>
          <span class="value">{{ victoria ? 'Completado' : 'Abandonado' }}</span>
        </div>
      </div>

      <div class="actions">
        <Button label="Volver a jugar" icon="pi pi-refresh" @click="replay" />
        <Button label="Ir al inicio" severity="secondary" @click="home" />
      </div>

    </main>

    <Footer />

  </div>
</template>

<script setup>
import { useRouter, useRoute } from 'vue-router'
import Navbar from '@/layouts/LandingNavbar.vue'
import Footer from '@/layouts/MainFooter.vue'

const router = useRouter()
const route = useRoute()

const victoria = route.query.victoria === '1'
const puntuacion = route.query.puntuacion || 0
const segundos = route.query.segundos || 0

function replay() {
  router.push({
    name: 'SeleccionDificultad',
    query: { idJuego: route.query.idJuego }
  })
}

function home() {
  router.push('/')
}
</script>

<style scoped>
.page-container {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}

.result-wrapper {
  flex: 1;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: 30px;
  padding: 60px 20px;
}

.title {
  font-size: 70px;
  font-weight: 900;
  margin: 0;
  text-align: center;
}

.win {
  color: #1DB954;
}

.lose {
  color: #e74c3c;
}

.score-card {
  text-align: center;
  background: #f4f7fb;
  padding: 30px 60px;
  border-radius: 16px;
  box-shadow: 0px 6px 20px rgba(0,0,0,0.15);
}

.score-card h2 {
  margin: 0;
  font-size: 20px;
  color: #2a4761;
}

.score {
  font-size: 60px;
  font-weight: 900;
  color: #00203E;
  display: block;
  margin-top: 10px;
}

/* DETALLES */
.details-card {
  display: flex;
  gap: 40px;
  flex-wrap: wrap;
  justify-content: center;
}

.detail {
  background: white;
  padding: 20px 30px;
  border-radius: 12px;
  box-shadow: 0px 4px 15px rgba(0,0,0,0.1);
  text-align: center;
  min-width: 180px;
}

.label {
  display: block;
  font-size: 14px;
  color: #2a4761;
}

.value {
  font-size: 22px;
  font-weight: bold;
  color: #00203E;
  margin-top: 5px;
  display: block;
}

.actions {
  display: flex;
  gap: 20px;
  flex-wrap: wrap;
  justify-content: center;
  margin-top: 10px;
}

@media (max-width: 430px) {
  .title {
    font-size: 40px;
  }

  .score {
    font-size: 40px;
  }

  .score-card {
    padding: 20px 30px;
  }

  .details-card {
    flex-direction: column;
    gap: 15px;
  }
}
</style>