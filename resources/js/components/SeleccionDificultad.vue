<template>
  <div class="dificultad-wrapper">
    <h2>Selecciona dificultad</h2>

    <button @click="seleccionar(1)">Fácil</button>
    <button @click="seleccionar(2)">Media</button>
    <button @click="seleccionar(3)">Difícil</button>
  </div>
</template>

<script setup>
import { useRouter, useRoute } from 'vue-router'
import { authStore } from '@/store/auth'

const auth = authStore()

const router = useRouter()
const route = useRoute()


function seleccionar(dificultad) {
  router.push({
  path: `/juegos/match9`, // o dinámico
  query: {
    idJuego: route.query.idJuego,
    idDificultad: dificultad,
  }
})
}
</script>