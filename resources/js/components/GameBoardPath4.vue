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
    </div>

    <div v-if="toast.visible" :class="['toast', toast.type]">
      {{ toast.message }}
    </div>

  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useRoute, useRouter } from 'vue-router'
import { authStore } from '@/store/auth'

const auth = authStore()
const router = useRouter()
const route = useRoute()

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

  const res = await axios.post('/api/path4/iniciar', {
    id_usuario: auth.user.id,
    id_juego: route.query.idJuego,
    id_dificultad: route.query.idDificultad
  })

  partida.value = res.data.partida
  id_partida.value = res.data.partida.id_partida

  // clubes visibles (1 real + 3 ocultos)
  clubsVisibles.value = res.data.partida.estado.clubes.map((c, i) =>
    i === 0 ? c : null
  )

  const clubesRes = await axios.get('/api/clubes')
  clubesMap.value = Object.fromEntries(
    clubesRes.data.map(c => [c.id_club, c.nombre_club])
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

    const res = await axios.get('/api/jugadores/search', {
      params: { search: search.value }
    })

    resultados.value = res.data
    loading.value = false

  }, 300)
}

/* =====================
   SELECCIONAR JUGADOR
   ===================== */

async function selectJugador(jugador){

  try {

    const res = await axios.post('/api/path4/jugar', {
      id_partida: id_partida.value,
      id_jugador: jugador.id_jugador
    })

    console.log("RAW:", res)
    console.log("DATA:", res.data)

    const data = res.data.original ?? res.data

    if (data.victoria === true) {
      showToast("🎉 ¡VICTORIA!", "success")

      setTimeout(() => {
        router.push({
          name: 'FinPartida',
          query: {
            victoria: 1,
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
    }

    search.value = ''
    resultados.value = []

  } catch (e) {
    console.error(e)
    showToast("Error al jugar", "error")
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
</style>