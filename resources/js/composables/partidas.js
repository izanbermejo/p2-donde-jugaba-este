import { ref } from 'vue'
import axios from 'axios'

export default function usePartidas() {

    const iniciarPartida = async (idUsuario, idJuego, idDificultad) => {
        return await axios.post('/api/partida/iniciar', {
            id_usuario: idUsuario,
            id_juego: idJuego,
            id_dificultad: idDificultad
        })
    }

    const iniciarPartidaPath4 = async (idUsuario, idJuego, idDificultad) => {
        return await axios.post('/api/path4/iniciar', {
            id_usuario: idUsuario,
            id_juego: idJuego,
            id_dificultad: idDificultad
        })
    }

    const jugarPartida = async (idPartida, fila, columna, idJugador) => {
        return await axios.post('/api/partida/jugar', {
            id_partida: idPartida,
            fila: fila,
            columna: columna,
            id_jugador: idJugador
        })
    }

    const jugarPartidaPath4 = async (idPartida, idJugador) => {
        return await axios.post('/api/path4/jugar', {
            id_partida: idPartida,
            id_jugador: idJugador
        })
    }

    const rendirse = async (idPartida) => {
        return await axios.post('/api/partida/rendirse', {
            id_partida: idPartida
        })
    }

    return {
        iniciarPartida,
        jugarPartida,
        rendirse,
        jugarPartidaPath4,
        iniciarPartidaPath4
    }
}
