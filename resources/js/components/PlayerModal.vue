<template>
  <div class="modal-backdrop">
    <div class="modal-content">

      <h3>Escribe el jugador</h3>

      <input
        v-model="search"
        @input="onInput"
        @keydown.down.prevent="moveDown"
        @keydown.up.prevent="moveUp"
        @keydown.enter.prevent="selectActive"
        placeholder="Ej: Messi"
        class="input"
        autofocus
      />

      <div v-if="loading" class="loading">Buscando...</div>

      <div v-if="resultados.length" class="results">
        <div
          v-for="(jugador, index) in resultados"
          :key="jugador.id_jugador"
          class="player"
          :class="{ active: index === selectedIndex }"
          @click="seleccionar(jugador)"
        >
          {{ jugador.nombre_jugador }}
        </div>
      </div>

      <div v-if="!loading && search.length > 1 && resultados.length === 0">
        No hay resultados
      </div>

      <button @click="$emit('close')">Cerrar</button>

    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'

const emit = defineEmits(['select', 'close'])

const search = ref('')
const resultados = ref([])
const loading = ref(false)
const selectedIndex = ref(-1)

let debounceTimer = null

/* ======================
   INPUT + DEBOUNCE
====================== */
function onInput() {
  clearTimeout(debounceTimer)

  debounceTimer = setTimeout(async () => {
    if (search.value.length < 2) {
      resultados.value = []
      return
    }

    loading.value = true

    try {
      const res = await axios.get('/api/jugadores/search', {
        params: { search: search.value }
      })

      resultados.value = res.data
      selectedIndex.value = 0

    } catch (e) {
      console.error(e)
    }

    loading.value = false
  }, 300)
}

/* ======================
   NAVEGACIÓN TECLADO
====================== */
function moveDown() {
  if (selectedIndex.value < resultados.value.length - 1) {
    selectedIndex.value++
  }
}

function moveUp() {
  if (selectedIndex.value > 0) {
    selectedIndex.value--
  }
}

function selectActive() {
  if (resultados.value[selectedIndex.value]) {
    seleccionar(resultados.value[selectedIndex.value])
  }
}

/* ======================
   SELECCIONAR
====================== */
function seleccionar(jugador) {
  emit('select', jugador)
}
</script>

<style>
.modal-backdrop {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,0.5);

  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-content {
  background: white;
  padding: 20px;
  width: 320px;
  border-radius: 10px;
}

.input {
  width: 100%;
  padding: 8px;
  margin-bottom: 10px;
}

.loading {
  font-size: 12px;
  color: #888;
}

.results {
  max-height: 200px;
  overflow-y: auto;
  border: 1px solid #ddd;
}

.player {
  padding: 8px;
  cursor: pointer;
}

.player:hover,
.player.active {
  background: #e0f7fa;
}
</style>