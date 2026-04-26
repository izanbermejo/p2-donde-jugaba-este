import { ref } from 'vue'
import axios from 'axios'

export default function useJuegos() {

    const juegos = ref([]);
    const juego = ref();

    const getJuegos = async () => {
        return axios.get('/api/juegos')
            .then(response => {
                juegos.value = response.data;
                return response;
            })
    }

    const getJuegoByIdJuego = async (idJuego) => {
        return axios.get(`/api/juegos/${idJuego}`)
            .then(response => {
                juego.value = response.data;
                return response;
            })
    }

    return {
        juegos,
        juego,
        getJuegos,
        getJuegoByIdJuego,
    }
}
