<template>
  <div class="board">

    <!-- FILA 1 -->
    <div class="row">
      <div class="cell empty"></div>

      <div
        v-for="pais in paises"
        :key="'pais-' + pais"
        class="cell header"
      >
        {{ getPaisNombre(pais) }}
      </div>
    </div>

    <!-- FILAS CLUBES -->
    <div
      v-for="(club, fila) in clubes"
      :key="'club-row-' + fila"
      class="row"
    >
      <!-- columna izquierda -->
      <div class="cell header">
        {{ getClubNombre(club) }}
      </div>

      <!-- celdas jugables -->
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

/* ======================
   ESTADO
====================== */
const partida = ref(null)

const paises = ref([])
const clubes = ref([])
const paisesMap = ref({})
const clubesMap = ref({})
const id_partida = ref(null)

const showModal = ref(false)
const jugadoresModal = ref([])
const filaSeleccionada = ref(null)
const columnaSeleccionada = ref(null)

/* ======================
   INICIO PARTIDA
====================== */
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

  // cargar clubes
  const clubesRes = await axios.get('/api/clubes')
  clubesMap.value = Object.fromEntries(
    clubesRes.data.map(c => [c.id_club, c.nombre_club])
  )
  
if (!res.data.ok) {
  alert(res.data.message)
  return
}

partida.value = res.data.partida
id_partida.value = res.data.partida.id_partida

  paises.value = partida.value.estado.paises
  clubes.value = partida.value.estado.clubes
})

/* ======================
   TABLERO
====================== */
function getJugador(fila, columna) {
  const key = `${fila}-${columna}`
  const jugador = partida.value?.estado?.tablero?.[key]

  return jugador?.nombre_jugador ?? ''
}

/* ======================
   CLICK CELDA
====================== */
async function clickCelda(fila, columna) {
  try {
    // guardamos coordenadas
    filaSeleccionada.value = fila
    columnaSeleccionada.value = columna

    // abrimos modal directamente
    showModal.value = true

  } catch (e) {
    console.error(e)
  }
}

/* ======================
   SELECCION JUGADOR
====================== */
async function selectJugador(jugador) {
  try {
    const res = await axios.post('/api/partida/jugar', {
      id_partida: id_partida.value,
      fila: filaSeleccionada.value,
      columna: columnaSeleccionada.value,
      id_jugador: jugador.id_jugador
    })

    // ❌ ERROR → no pintar
    if (!res.data.ok) {
      alert(res.data.message)
      return
    }

    // 🟢 OK → pintar
    partida.value.estado.tablero[
      `${filaSeleccionada.value}-${columnaSeleccionada.value}`
    ] = res.data.jugador

    showModal.value = false

    axios.post('/api/partida/jugar', data)
    .then(res => {
      
      if (res.data.victoria) {
        alert("🎉 ¡VICTORIA!\nPuntuación: " + res.data.puntuacion_final)
      }

    })

  } catch (e) {
    console.error(e)
  }
}



function rendirse() {
  axios.post('/api/partida/rendirse', {
    id_partida: partida.value.id_partida
  }).then(res => {
    alert('Te has rendido. Puntuación: ' + res.data.puntuacion)
    // aquí puedes redirigir o cerrar juego
  })
}

function comprobarFinPartida() {
  const tablero = partida.value?.estado?.tablero || {}

  if (Object.keys(tablero).length === 9) {
    finalizarPartida()
  }
}

/* ======================
   HELPERS (TEMP)
====================== */
function getPaisNombre(id) {
  return paisesMap.value[id] || id
}

function getClubNombre(id) {
  return clubesMap.value[id] || id
}
</script>

<style>
.board {
  display: inline-block;
}

.row {
  display: flex;
}

.cell {
  width: 90px;
  height: 90px;
  border: 1px solid #ccc;
  display: flex;
  align-items: center;
  justify-content: center;
}

.header {
  background: #f5f5f5;
  font-weight: bold;
}

.empty {
  background: transparent;
  border: none;
}

.playable {
  cursor: pointer;
}

.playable:hover {
  background: #e0f7fa;
}
</style>