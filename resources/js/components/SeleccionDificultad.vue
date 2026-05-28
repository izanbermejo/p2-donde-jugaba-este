<template>
  <div class="page-container">
    <Navbar />

    <main class="dificultad-wrapper">

      <div class="title-section">
        <h2>Selecciona dificultad</h2>
        <p>Elige el nivel con el que quieres jugar</p>
      </div>

      <div class="difficulty-grid">

        <button class="difficulty-card facil" @click="seleccionar(1)">
          <h3>Fácil</h3>
        </button>

        <button class="difficulty-card medio" @click="seleccionar(2)">
          <h3>Media</h3>
        </button>

        <button class="difficulty-card dificil" @click="seleccionar(3)">
          <h3>Difícil</h3>
        </button>

      </div>

    </main>
  </div>
  <Footer />
</template>

<script setup>
import { useRouter, useRoute } from 'vue-router'
import { authStore } from '@/store/auth'

const auth = authStore()

const router = useRouter()
const route = useRoute()

function seleccionar(dificultad) {
  router.push({
    path: `/juegos/match9`,
    query: {
      idJuego: route.query.idJuego,
      idDificultad: dificultad,
    }
  })
}
</script>

<style scoped>
.page-container {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}

/* CENTRADO GENERAL */
.dificultad-wrapper {
  flex: 1;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: flex-start;
  padding: 60px 20px;
  gap: 40px;
}

/* TITULO */
.title-section {
  text-align: center;
}

h2 {
  font-size: 60px;
  font-weight: bold;
  color: #00203E;
  margin: 0;
}

.title-section p {
  margin-top: 10px;
  font-size: 18px;
  color: #2a4761;
}

/* GRID BOTONES */
.difficulty-grid {
  display: flex;
  gap: 30px;
  flex-wrap: wrap;
  justify-content: center;
  width: 100%;
  max-width: 1000px;
}

/* TARJETAS */
.difficulty-card {
  width: 260px;
  padding: 30px;
  border-radius: 16px;
  border: none;
  cursor: pointer;
  text-align: center;
  transition: all 0.25s ease;
  box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.15);
}

.difficulty-card h3 {
  font-size: 28px;
  margin-bottom: 10px;
  color: #00203E;
}

.difficulty-card span {
  font-size: 14px;
  color: #2a4761;
}

.facil {
  background: #d8f5dd;
}

.medio {
  background: #fff3cd;
}

.dificil {
  background: #ffd6d6;
}

.difficulty-card:hover {
  transform: translateY(-8px);
  box-shadow: 0px 10px 25px rgba(0, 0, 0, 0.25);
}

/* RESPONSIVE */
@media (max-width: 430px) {
  h2 {
    font-size: 36px;
  }

  .difficulty-card {
    width: 100%;
  }

  .dificultad-wrapper {
    padding: 30px 15px;
    gap: 25px;
  }
}
</style>