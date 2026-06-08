<template>
  <div class="game-wrapper">

    <!-- PROGRESO (4 CASILLAS) -->
    <div class="path">

      <div
        v-for="(club, index) in clubsVisibles"
        :key="index"
        class="path-cell"
      >
        {{ club ? getClubNombre(club) : "?" }}
      </div>

    </div>

    <!-- INPUT DE BÚSQUEDA -->
    <div class="search-box">
      <input
        v-model="search"
        @input="onInput"
        placeholder="Escribe un jugador..."
        class="input"
      />

      <div v-if="loading">Buscando...</div>

      <div v-if="resultados.length">
        <div
          v-for="jugador in resultados"
          :key="jugador.id_jugador"
          class="result"
          @click="selectJugador(jugador)"
        >
          {{ jugador.nombre_jugador }}
        </div>
      </div>
      <button @click="abandonarPartida" class="btn-red">
        Rendirse
      </button>

      <div v-if="toast.visible" :class="['toast', toast.type]">
        {{ toast.message }}
      </div>
    </div>

    <div v-if="toast.visible" :class="['toast', toast.type]">
      {{ toast.message }}
    </div>

  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { authStore } from '@/store/auth'
import useClubes from '../composables/clubes'
import useJugadores from '../composables/jugadores'
import usePartidas from '../composables/partidas'

const auth = authStore()
const router = useRouter()
const route = useRoute()
const {clubes, getClubes} = useClubes();
const {getJugadorByNombre} = useJugadores();
const { iniciarPartidaPath4, jugarPartidaPath4, rendirse } = usePartidas();

const partida = ref(null)
const id_partida = ref(null)

const clubsVisibles = ref([])

const search = ref('')
const resultados = ref([])
const loading = ref(false)

const toast = ref({ visible:false, message:'', type:'info' })

const clubesMap = ref({})

function showToast(message, type='info'){
  toast.value = { visible:true, message, type }
  setTimeout(()=> toast.value.visible=false, 2000)
}

onMounted(async () => {

  const res = await iniciarPartidaPath4(
    auth.user.id,
    route.query.idJuego,
    route.query.idDificultad
  )

  partida.value = res.data.partida
  id_partida.value = res.data.partida.id_partida

  // clubes visibles (1 real + 3 ocultos)
  clubsVisibles.value = res.data.partida.estado.clubes.map((c, i) =>
    i === 0 ? c : null
  )

  await getClubes();
  clubesMap.value = Object.fromEntries(
    clubes.value.map(c => [c.id_club, c.nombre_club])
  )
})

function getClubNombre(id){
  return clubesMap.value[id] || id
}

/* ==========
   BUSCADOR
   ========== */

let debounce = null

function onInput(){
  clearTimeout(debounce)

  debounce = setTimeout(async () => {

    if(search.value.length < 2){
      resultados.value = []
      return
    }

    loading.value = true

    const res = await getJugadorByNombre(search.value)

    resultados.value = res.data
    loading.value = false

  }, 300)
}

/* =====================
   SELECCIONAR JUGADOR
   ===================== */

async function selectJugador(jugador){

  try {

    const res = await jugarPartidaPath4(id_partida.value, jugador.id_jugador)

    const data = res.data.original ?? res.data

    if (data.victoria === true) {
      showToast("🎉 ¡VICTORIA!", "success")

      setTimeout(() => {
        router.push({
          name: 'FinPartida',
          query: {
            resultado: 'victoria',
            puntuacion: data.puntuacion_final ?? 0,
            idJuego: route.query.idJuego
          }
        })
      }, 100)

      return
    }

    if (data.correcto === true) {
      showToast("✔ Correcto", "success")
    } else {
      showToast("❌ Incorrecto", "error")

      const index = clubsVisibles.value.findIndex(c => c === null)
      if (index !== -1 && data.revelar_club) {
        clubsVisibles.value[index] = data.revelar_club
      }
      if (
        data.victoria === false &&
        data.clubes_revelados > 4
      ) {

        showToast("💀 DERROTA", "error")

        setTimeout(() => {
          router.push({
            name: 'FinPartida',
            query: {
              resultado: 'derrota',
              puntuacion: 0,
              idJuego: route.query.idJuego
            }
          })
        }, 1000)

        return
      }
    }

    search.value = ''
    resultados.value = []

  } catch (e) {
    console.error(e)
    showToast("Error al jugar", "error")
  }
}

async function abandonarPartida() {

  try {

    const res = await rendirse(id_partida.value)

    showToast(
      'Te has rendido. Puntuación: ' + res.data.puntuacion,
      'info'
    )

    setTimeout(() => {
      router.push({
        name: 'FinPartida',
        query: {
          resultado: 'rendido',
          puntuacion: res.data.puntuacion,
          idJuego: route.query.idJuego
        }
      })
    }, 1200)

  } catch (e) {
    console.error(e)
    showToast("Error al rendirse", "error")
  }
}

</script>

<style scoped>
.game-wrapper{
  display:flex;
  flex-direction:column;
  align-items:center;
  gap:30px;
}

.path{
  display:flex;
  gap:20px;
}

.path-cell{
  width:120px;
  height:120px;
  display:flex;
  align-items:center;
  justify-content:center;
  font-size:24px;
  background:#00203E;
  color:white;
  border-radius:10px;
}

.input{
  padding:10px;
  width:300px;
}

.result{
  padding:6px;
  cursor:pointer;
}

.result:hover{
  background:#eee;
}

.toast{
  position:fixed;
  top:20px;
  right:20px;
  padding:10px;
  color:white;
  border-radius:8px;
}

.success{ background:green }
.error{ background:red }
.info{ background:blue }

.btn-red{
  margin-top: 10px;
  padding: 12px 22px;
  border: none;
  border-radius: 12px;
  background: #ef4444;
  color: white;
  font-weight: 600;
  cursor: pointer;
}

.btn-red:hover{
  opacity: 0.9;
}
</style>
