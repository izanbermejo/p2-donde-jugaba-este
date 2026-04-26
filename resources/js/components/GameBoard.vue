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

  <!-- Modal de selección de jugador -->
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

// Estado de la partida actual
const partida = ref(null)

// Listas de países y clubes del tablero
const paises = ref([])
const clubes = ref([])

// Mapas para traducir IDs a nombres
const paisesMap = ref({})
const clubesMap = ref({})

// ID de la partida activa
const id_partida = ref(null)

// Control del modal de selección de jugador
const showModal = ref(false)
const filaSeleccionada = ref(null)
const columnaSeleccionada = ref(null)

// Estado del toast de notificaciones
const toast = ref({
  visible: false,
  message: '',
  type: 'info'
})

// Muestra un mensaje temporal en pantalla
function showToast(message, type = 'info') {
  toast.value.message = message
  toast.value.type = type
  toast.value.visible = true

  setTimeout(() => {
    toast.value.visible = false
  }, 2500)
}

onMounted(async () => {
  const res = await axios.post('/api/partida/iniciar', {
    id_usuario: 1,
    id_juego: 1,
    id_dificultad: 1
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

// Obtiene el jugador colocado en una celda del tablero
function getJugador(fila, columna) {
  const key = `${fila}-${columna}`
  const jugador = partida.value?.estado?.tablero?.[key]
  return jugador?.nombre_jugador ?? ''
}

// Abre el modal para seleccionar jugador en una celda
function clickCelda(fila, columna) {
  filaSeleccionada.value = fila
  columnaSeleccionada.value = columna
  showModal.value = true
}

// Envía la jugada seleccionada al backend
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

// Abandona la partida actual
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

// Traduce ID de país a nombre
function getPaisNombre(id) {
  return paisesMap.value[id] || id
}

// Traduce ID de club a nombre
function getClubNombre(id) {
  return clubesMap.value[id] || id
}
</script>

<style scoped>

/* Layout principal del juego */
.game-wrapper {
  display: flex;
  flex-direction: column;
  align-items: center;
  width: 100%;
}

/* Tablero principal */
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

/* Cabeceras superiores del tablero */
.top-header {
  background: #00203E;
  color: #ffffff;
  font-weight: 700;
}

/* Cabeceras laterales del tablero */
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

/* Notificaciones toast */
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
