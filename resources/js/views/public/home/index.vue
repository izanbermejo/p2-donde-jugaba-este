<template>
    <section class="banner" >
        <img
            src="/images/banner_home.webp"
            alt="banner principal"
            style="width: 100%;"
        />

        <div class="texto-banner">
            <h1 class="titulo-banner">
                Sube en el ranking o quédate en el banquillo
            </h1>

            <span class="parrafo-banner">
                Bienvenido a nuestra plataforma de fútbol, donde la pasión por el deporte rey se une con la emoción de los juegos y el espíritu competitivo. Aquí podrás desafiar tus conocimientos futbolísticos, competir contra otros jugadores y escalar posiciones en nuestro ranking global. ¿Estás listo para demostrar que eres el mejor en el campo? ¡Únete a nosotros y comienza tu aventura futbolística hoy mismo!
            </span>
        </div>
    </section>

    <section class="juegos section-home">
        <h2>Juegos</h2>
        <span class="explicacion-seccion">Pon a prueba tus conocimientos de fútbol con distintos minijuegos y mejora tus resultados.</span>
        <div class="flex flex-row flex-wrap justify-between w-full" >
            <router-link  to="/juegos/match9">
                <div class="juego-container">
                    <img src="/images/Match9.webp" alt="Imagen del juego" class="juego-imagen" />
                    <h3 class="juego-titulo">Match 9</h3>
                    <p class="juego-descripcion">
                        Juego de lógica futbolística en formato 3x3 donde deberás completar un tablero rellenando cada casilla con un jugador que cumpla simultáneamente los requisitos de su fila y su columna (nacionalidad y club en el que haya jugado). Cada combinación siempre tiene al menos un jugador válido, pero no podrás repetir jugadores dentro del mismo tablero...
                    </p>
                </div>
            </router-link>
            <router-link  to="/juegos/path4">
                <div class="juego-container">
                    <img src="/images/Path4.webp" alt="Imagen del juego" class="juego-imagen" />
                    <h3 class="juego-titulo">Path 4</h3>
                    <p class="juego-descripcion">
                        Encuentra la ruta correcta entre jugadores conectándolos a través de clubes en el menor número de pasos posible. Cada jugador te llevará a nuevas opciones, pero tendrás que elegir bien el camino para llegar al objetivo...
                    </p>
                </div>
            </router-link>
        </div>
        <router-link  to="/juegos" style="width: 25%;">
            <Button label="Ver juegos" severity="primary" class="btn-ver-juegos" />
        </router-link>
    </section>

    <section class="ranking section-home">
        <h2>Ranking</h2>
        <span class="explicacion-seccion">Consulta las mejores puntuaciones y compara tu nivel con otros jugadores.</span>
        <div class="flex flex-col items-center" style="width: 100%; height: 100%; margin-bottom: 40px; gap: 30px; ">
            <TablaRankingGlobal :rows="5"/>
            <router-link  to="/ranking" style="width: 25%;">
                <Button label="Ir al ranking" severity="primary" class="btn-ver-juegos" />
            </router-link>
        </div>
    </section>
</template>

<script setup>
import { authStore } from "@/store/auth";
import TablaRankingGlobal from "../../../components/TablaRankingGlobal.vue";
</script>

<style scoped>

h2 {
    color: #00203E;
    font-size: 60px;
    font-weight: bold;
}

.banner,
.juegos {
    max-width: 100%;
    overflow-x: hidden;
}

.banner {
    position: relative;
    width: 100%;
    margin-top: 0;
    padding-top: 0;
    height: 800px;
    overflow: hidden;
}

/* FIX línea blanca */
.banner img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

/* Degradado inferior */
.banner::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: 0;
    width: 100%;
    height: 60%;
    background: linear-gradient(
        to top,
        rgba(0, 32, 62, 0.95),
        rgba(0, 32, 62, 0.6),
        rgba(0, 32, 62, 0)
    );
    pointer-events: none;
}

/* Texto superpuesto */
.banner .texto-banner {
    position: absolute;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%);
    text-align: center;
    z-index: 2;
    max-width: 90%;
}

.banner .titulo-banner {
    color: white;
    font-size: 60px;
    font-weight: 700;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.6);
    white-space: nowrap;
}

.banner .parrafo-banner {
    color: #d8e6f4;
    font-size: 18px;
    font-weight: 500;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.6);
}

/* Secciones */
.section-home {
    padding: 0px 350px;
}

/* Juegos */

.juegos {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 50px;
    margin: 50px 0px;
    margin-bottom: 80px;
    width: 100%;
}

.juego-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    background-color: #d8e6f4;
    padding: 40px;
    border-radius: 12px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    max-width: 480px;
}

.juego-container:hover {
    transform: translateY(-5px);
    box-shadow: 0px 8px 20px rgba(0,0,0,0.3);
}

.juego-imagen {
    width: 400px;
    height: 400px;
    object-fit: cover;
    object-position: center;
    border-radius: 8px;
    box-shadow: 0px 4px 15px 4px rgba(0,0,0,0.23)
;
}

.juego-titulo {
    margin-top: 22px;
    margin-bottom: 22px;
    font-size: 34px;
    font-weight: 600;
    color: #00203E;
}

.juego-descripcion {
    font-size: 16px;
    color: #2a4761;
    text-align: center;
    line-height: 1.3;

    display: -webkit-box;
    line-clamp: 3;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.btn-ver-juegos {
    font-size: 28px;
    padding: 12px 24px;
    border-radius: 16px;
    background-color: #1DB954;
    color: #00203E;
    font-weight: 800;
    width: 100%;
    margin-top: 20px;
}

/* ranking */
.ranking {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 50px;
    /* margin: 50px 0px; */
    padding-top: 50px;
    padding-bottom: 710px;
    height: 700px;
    width: 100%;
    background-color: #d8e6f4;
    position: relative;
    overflow: hidden;
}

.ranking :deep(.p-row-even),
.ranking :deep(.p-datatable-header-cell),
.ranking :deep(.p-datatable-empty-message),
.ranking :deep(.p-paginator) {
    background-color: #d8e6f4 !important;
}


.ranking :deep(.p-datatable-paginator-bottom) {
    border-top: 1px solid #a8c6e4 !important;
}

.ranking :deep(.p-datatable-header-cell) {
    border-bottom: 1px solid #a8c6e4 !important;
}

.ranking::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image: url("/images/confeti.webp");
    background-repeat: repeat;
    background-size: 280px;
    opacity: 0.15;
    pointer-events: none;
    z-index: 0;
    mix-blend-mode: multiply;
}

.ranking > * {
    position: relative;
    z-index: 1;
}

.explicacion-seccion {
    font-size: 18px;
    color: #2a4761;
    text-align: center;
    max-width: 800px;
}

/* responsive */

@media (max-width: 430px) {

    h2 {
        font-size: 34px;
        text-align: center;
    }

    /* ===================== */
    /* HEADER / BANNER */
    /* ===================== */

    .banner {
        height: 720px;
    }

    .banner img {
        height: 100%;
        object-fit: cover;
    }

    .banner::after {
        height: 100%;
    }

    .banner .titulo-banner {
        font-size: 36px;
        white-space: normal;
        padding: 0;
        width: 100%;
        text-align: center;
    }

    .banner .texto-banner {
        left: 0;
        transform: none;
        width: 100%;
        max-width: 100%;
        padding: 0 15px; /* mismo margen que el resto de la web */
        text-align: center;
    }

    .banner .parrafo-banner {
        margin-top: 15px;
        font-size: 14px;
        line-height: 1.3;

        display: -webkit-box;
        line-clamp: 3;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* ===================== */
    /* MÁRGENES GENERALES */
    /* ===================== */

    .section-home {
        padding: 0px 15px;
    }

    /* ===================== */
    /* JUEGOS */
    /* ===================== */

    .juegos {
        padding: 0px 15px;
        gap: 25px;
        margin: 30px 0px;
    }

    /* cards full width */
    .juego-container {
        width: 100%;
        max-width: 100%;
        padding: 20px;
    }

    /* imagen un poco más grande y fluida */
    .juego-imagen {
        width: 100%;
        height: 320px;
        object-fit: cover;
        object-position: center;
    }

    .juego-titulo {
        font-size: 22px;
        text-align: center;
    }

    .juego-descripcion {
        font-size: 14px;
    }

    /* columnas en móvil */
    .flex.flex-row.flex-wrap {
        flex-direction: column !important;
        align-items: center;
        gap: 20px;
    }

    /* botón juegos */
    .btn-ver-juegos {
        font-size: 18px;
        padding: 10px 16px;
        width: 100%;
    }

    .juegos a,
    .ranking a {
        width: 100% !important;
    }

    /* ===================== */
    /* RANKING */
    /* ===================== */

    .ranking {
        padding: 0px 15px;
        height: auto;
        gap: 25px;
    }

    .explicacion-seccion {
        font-size: 14px;
        padding: 0 10px;
    }
}

</style>
