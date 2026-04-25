import { ref } from 'vue'
import axios from 'axios'

export default function useRanking() {

    const ranking = ref([])

    const getRankingGlobal = async () => {
        return axios.get('/api/ranking')
            .then(response => {
                ranking.value = response.data;
                return response;
            })
    }

    const getRankingByIdJuego = async (idJuego) => {
        return axios.get(`/api/ranking/${idJuego}`)
            .then(response => {
                ranking.value = response.data;
                return response;
            })
    }

    return {
        ranking,
        getRankingGlobal,
        getRankingByIdJuego,
    }
}
