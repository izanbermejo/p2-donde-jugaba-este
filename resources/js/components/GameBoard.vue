<template>
  <div class="game-wrapper">

    <div class="board">

      <div class="row">
        <div class="cell empty"></div>

        <div
          v-for="pais in paises"
          :key="'pais-' + pais"
          class="cell header top-header"
        >
          {{ getPaisNombre(pais) }}
        </div>
      </div>

      <div
        v-for="(club, fila) in clubes"
        :key="'club-row-' + fila"
        class="row"
      >
        <div class="cell header side-header">
          {{ getClubNombre(club) }}
        </div>

        <div
          v-for="(pais, columna) in paises"
          :key="fila + '-' + columna"
          class="cell playable"
          @click="clickCelda(fila + 1, columna + 1)"
        >
          {{ getJugador(fila + 1, columna + 1) }}
        </div>
      </div>

    </div>

    <button @click="rendirse" class="btn-red">
      Rendirse
    </button>

    <div v-if="toast.visible" :class="['toast', toast.type]">
      {{ toast.message }}
    </div>

  </div>

  <!-- MODAL -->
  <PlayerModal
    v-if="showModal"
    @select="selectJugador"
    @close="showModal = false"
  />
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import PlayerModal from './PlayerModal.vue'
import { useRoute } from 'vue-router'
import { authStore } from '@/store/auth'

const auth = authStore()

const route = useRoute()

const partida = ref(null)

const paises = ref([])
const clubes = ref([])
const paisesMap = ref({})
const clubesMap = ref({})
const id_partida = ref(null)

const showModal = ref(false)
const filaSeleccionada = ref(null)
const columnaSeleccionada = ref(null)

const toast = ref({
  visible: false,
  message: '',
  type: 'info'
})

function showToast(message, type = 'info') {
  toast.value.message = message
  toast.value.type = type
  toast.value.visible = true

  setTimeout(() => {
    toast.value.visible = false
  }, 2500)
}

onMounted(async () => {
  if (!auth.authenticated || !auth.user?.id) {
  showToast('Usuario no autenticado', 'error')
  return
}
  const res = await axios.post('/api/partida/iniciar', {
    id_usuario: auth.user.id,
    id_juego: route.query.idJuego,
    id_dificultad: route.query.idDificultad
  })

  const paisesRes = await axios.get('/api/paises')
  paisesMap.value = Object.fromEntries(
    paisesRes.data.map(p => [p.id_pais, p.nombre_pais])
  )

  const clubesRes = await axios.get('/api/clubes')
  clubesMap.value = Object.fromEntries(
    clubesRes.data.map(c => [c.id_club, c.nombre_club])
  )

  if (!res.data.ok) {
    showToast(res.data.message, 'error')
    return
  }

  partida.value = res.data.partida
  id_partida.value = res.data.partida.id_partida

  paises.value = partida.value.estado.paises
  clubes.value = partida.value.estado.clubes
})

function getJugador(fila, columna) {
  const key = `${fila}-${columna}`
  const jugador = partida.value?.estado?.tablero?.[key]
  return jugador?.nombre_jugador ?? ''
}

function clickCelda(fila, columna) {
  filaSeleccionada.value = fila
  columnaSeleccionada.value = columna
  showModal.value = true
}

async function selectJugador(jugador) {
  try {
    const res = await axios.post('/api/partida/jugar', {
      id_partida: id_partida.value,
      fila: filaSeleccionada.value,
      columna: columnaSeleccionada.value,
      id_jugador: jugador.id_jugador
    })

    if (!res.data.ok) {
      showToast(res.data.message, 'error')
      return
    }

    partida.value.estado.tablero[
      `${filaSeleccionada.value}-${columnaSeleccionada.value}`
    ] = res.data.jugador

    showModal.value = false

    if (res.data.victoria) {
      showToast(
        "🎉 ¡VICTORIA! Puntuación: " + res.data.puntuacion_final,
        'success'
      )
    }

  } catch (e) {
    showToast("Error al jugar la partida", 'error')
  }
}

function rendirse() {
  axios.post('/api/partida/rendirse', {
    id_partida: partida.value.id_partida
  }).then(res => {
    showToast(
      'Te has rendido. Puntuación: ' + res.data.puntuacion,
      'info'
    )
  })
}

function getPaisNombre(id) {
  return paisesMap.value[id] || id
}

function getClubNombre(id) {
  return clubesMap.value[id] || id
}
</script>

<style scoped>

.game-wrapper {
  display: flex;
  flex-direction: column;
  align-items: center;
  width: 100%;
}

.board {
  display: inline-block;
}

.row {
  display: flex;
}

.cell {
  width: 110px;
  height: 110px;
  border: 1px solid #dbe4f0;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 14px;
  transition: all 0.2s ease;
  background: #ffffff;
}

.top-header {
  background: #00203E;
  color: #ffffff;
  font-weight: 700;
}

.side-header {
  background: #1DB954;
  color: #ffffff;
  font-weight: 700;
}

.empty {
  background: transparent;
  border: none;
}

.playable {
  cursor: pointer;
  font-weight: 500;
}

.playable:hover {
  background: #e6f4ea;
  border-color: #22c55e;
  transform: scale(1.03);
}

.btn-red {
  margin-top: 25px;
  padding: 12px 22px;
  border: none;
  border-radius: 12px;
  background: #ef4444;
  color: white;
  font-weight: 600;
  cursor: pointer;
}

.toast {
  position: fixed;
  top: 20px;
  right: 20px;
  padding: 14px 18px;
  border-radius: 12px;
  color: white;
  font-weight: 600;
  z-index: 9999;
  box-shadow: 0 8px 20px rgba(0,0,0,0.2);
}

.success {
  background: #22c55e;
}

.error {
  background: #ef4444;
}

.info {
  background: #3b82f6;
}

/* responsive */
@media (max-width: 430px) {

  .game-wrapper {
    padding: 10px;
  }

  .board {
    transform: scale(0.9);
    transform-origin: top center;
  }

}

</style>
