<template>
    <div class="dashboard-container">
        <!-- Page Header Card -->
        <Card class="page-header-card">
            <template #content>
                <div class="page-header-content">
                    <div class="page-header-info">
                        <h1 class="page-title">
                            <i class="pi pi-home page-title-icon"></i>
                            Dashboard
                        </h1>
                        <p class="page-description">
                            Bienvenido al panel de administración. Desde aquí puedes gestionar usuarios, jugadores, clubes y más.
                        </p>
                    </div>
                </div>
            </template>
        </Card>

        <!-- Stats Cards -->
        <div class="dashboard-stats-grid">
            <Card class="dashboard-stat-card">
                <template #content>
                    <div class="stat-card-content">
                        <div class="stat-card-icon stat-icon-primary">
                            <i class="pi pi-users"></i>
                        </div>
                        <div class="stat-card-info">
                            <p class="stat-card-label">Usuarios</p>
                            <p class="stat-card-value">{{ stats.users || 0 }}</p>
                        </div>
                    </div>
                </template>
            </Card>

            <Card class="dashboard-stat-card">
                <template #content>
                    <div class="stat-card-content">
                        <div class="stat-card-icon stat-icon-success">
                            <i class="pi pi-users"></i>
                        </div>
                        <div class="stat-card-info">
                            <p class="stat-card-label">Jugadores</p>
                            <p class="stat-card-value">{{ stats.jugadores || 0 }}</p>
                        </div>
                    </div>
                </template>
            </Card>

            <Card class="dashboard-stat-card">
                <template #content>
                    <div class="stat-card-content">
                        <div class="stat-card-icon stat-icon-danger">
                            <i class="pi pi-shield"></i>
                        </div>
                        <div class="stat-card-info">
                            <p class="stat-card-label">Clubes</p>
                            <p class="stat-card-value">{{ stats.clubes || 0 }}</p>
                        </div>
                    </div>
                </template>
            </Card>

            <Card class="dashboard-stat-card">
                <template #content>
                    <div class="stat-card-content">
                        <div class="stat-card-icon stat-icon-info">
                            <i class="pi pi-globe"></i>
                        </div>
                        <div class="stat-card-info">
                            <p class="stat-card-label">Paises</p>
                            <p class="stat-card-value">{{ stats.paises || 0 }}</p>
                        </div>
                    </div>
                </template>
            </Card>

            <Card class="dashboard-stat-card">
                <template #content>
                    <div class="stat-card-content">
                        <div class="stat-card-icon stat-icon-warning">
                            <i class="pi pi-flag"></i>
                        </div>
                        <div class="stat-card-info">
                            <p class="stat-card-label">Ligas</p>
                            <p class="stat-card-value">{{ stats.ligas || 0 }}</p>
                        </div>
                    </div>
                </template>
            </Card>

            <Card class="dashboard-stat-card">
                <template #content>
                    <div class="stat-card-content">
                        <div class="stat-card-icon stat-icon-secondary">
                            <i class="pi pi-bullseye"></i>
                        </div>
                        <div class="stat-card-info">
                            <p class="stat-card-label">Posiciones</p>
                            <p class="stat-card-value">{{ stats.posiciones || 0 }}</p>
                        </div>
                    </div>
                </template>
            </Card>
        </div>

        <!-- Quick Actions Card -->
        <Card class="dashboard-actions-card">
            <template #content>
                <div class="dashboard-actions-content">
                    <h2 class="dashboard-actions-title">
                        <i class="pi pi-bolt"></i>
                        Acciones Rápidas
                    </h2>
                    <div class="dashboard-actions-grid">
                        <router-link
                            to="/admin/users"
                            class="dashboard-action-item"
                        >
                            <div class="dashboard-action-icon stat-icon-primary">
                                <i class="pi pi-users"></i>
                            </div>
                            <div class="dashboard-action-info">
                                <p class="dashboard-action-title">Gestionar Usuarios</p>
                                <p class="dashboard-action-description">Ver y editar usuarios</p>
                            </div>
                            <i class="pi pi-chevron-right dashboard-action-arrow"></i>
                        </router-link>

                        <router-link
                            to="/admin/jugadores"
                            class="dashboard-action-item"
                        >
                            <div class="dashboard-action-icon stat-icon-success">
                                <i class="pi pi-users"></i>
                            </div>
                            <div class="dashboard-action-info">
                                <p class="dashboard-action-title">Gestionar Jugadores</p>
                                <p class="dashboard-action-description">Ver y editar jugadores</p>
                            </div>
                            <i class="pi pi-chevron-right dashboard-action-arrow"></i>
                        </router-link>

                        <router-link
                            to="/admin/clubes"
                            class="dashboard-action-item"
                        >
                            <div class="dashboard-action-icon stat-icon-danger">
                                <i class="pi pi-shield"></i>
                            </div>
                            <div class="dashboard-action-info">
                                <p class="dashboard-action-title">Gestionar Clubes</p>
                                <p class="dashboard-action-description">Ver y editar clubes</p>
                            </div>
                            <i class="pi pi-chevron-right dashboard-action-arrow"></i>
                        </router-link>

                        <router-link
                            to="/admin/paises"
                            class="dashboard-action-item"
                        >
                                <div class="dashboard-action-icon" style="background-color: purple;">
                                <i class="pi pi-globe"></i>
                            </div>
                            <div class="dashboard-action-info">
                                <p class="dashboard-action-title">Gestionar Países</p>
                                <p class="dashboard-action-description">Ver y editar países</p>
                            </div>
                            <i class="pi pi-chevron-right dashboard-action-arrow"></i>
                        </router-link>

                        <router-link
                            to="/admin/ligas"
                            class="dashboard-action-item"
                        >
                            <div class="dashboard-action-icon stat-icon-warning">
                                <i class="pi pi-flag"></i>
                            </div>
                            <div class="dashboard-action-info">
                                <p class="dashboard-action-title">Gestionar Ligas</p>
                                <p class="dashboard-action-description">Ver y editar ligas</p>
                            </div>
                            <i class="pi pi-chevron-right dashboard-action-arrow"></i>
                        </router-link>

                        <router-link
                            to="/admin/posiciones"
                            class="dashboard-action-item"
                        >
                                <div class="dashboard-action-icon" style="background-color: purple;">
                                <i class="pi pi-bullseye"></i>
                            </div>
                            <div class="dashboard-action-info">
                                <p class="dashboard-action-title">Gestionar Posiciones</p>
                                <p class="dashboard-action-description">Ver y editar posiciones</p>
                            </div>
                            <i class="pi pi-chevron-right dashboard-action-arrow"></i>
                        </router-link>
                    </div>
                </div>
            </template>
        </Card>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import useUsers from "../../composables/users";
import useJugadores from "../../composables/jugadores";
import useClubes from "../../composables/clubes";
import usePaises from "../../composables/paises";
import useLigas from "../../composables/ligas";
import usePosiciones from "../../composables/posiciones";

const stats = ref({
    users: 0,
    jugadores: 0,
    clubes: 0,
    paises: 0,
    ligas: 0,
    posiciones: 0
});

const { users, getUsers } = useUsers();
const { totalRecords, getJugadores } = useJugadores();
const { clubes, getClubes } = useClubes();
const { paises, getPaises } = usePaises();
const { ligas, getLigas } = useLigas();
const { posiciones, getPosiciones } = usePosiciones();


const loadStats = async () => {
    try {
        await Promise.all([
            getUsers(),
            getJugadores(),
            getClubes(),
            getPaises(),
            getLigas(),
            getPosiciones()
        ]);

        stats.value = {
            users: users.value?.total || users.value?.data?.length || 0,
            jugadores: totalRecords.value || 0,
            clubes:  clubes.value?.length || 0,
            paises: paises.value?.length || 0,
            ligas: ligas.value?.length || 0,
            posiciones: posiciones.value?.length || 0
        };
    } catch (error) {
        console.error('Error loading stats:', error);
    }
};

onMounted(() => {
    loadStats();
});
</script>

<style scoped>
.dashboard-container {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.dashboard-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.dashboard-stat-card {
    border-radius: 0.75rem;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
    border: 1px solid rgba(0, 0, 0, 0.05);
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}

.dashboard-stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

.dashboard-actions-card {
    border-radius: 0.75rem;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.dashboard-actions-content {
    padding: 0.5rem;
}

.dashboard-actions-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1.25rem;
    font-weight: 700;
    line-height: 1.75rem;
    letter-spacing: -0.02em;
    margin-bottom: 1.5rem;
}

.dashboard-actions-title i {
    font-size: 1.5rem;
    opacity: 0.9;
}

.dashboard-actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1rem;
}

.dashboard-action-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    border-radius: 0.75rem;
    border: 1px solid rgba(0, 0, 0, 0.08);
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    text-decoration: none;
    cursor: pointer;
}

.dashboard-action-item:hover {
    transform: translateX(4px);
    box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.1);
    border-color: rgba(0, 0, 0, 0.12);
}

.dashboard-action-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 2.5rem;
    height: 2.5rem;
    border-radius: 0.5rem;
    font-size: 1.25rem;
    flex-shrink: 0;
    color: white;
    box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.1);
}

.dashboard-action-info {
    flex: 1;
    min-width: 0;
}

.dashboard-action-title {
    font-size: 1rem;
    font-weight: 600;
    line-height: 1.5rem;
    margin-bottom: 0.25rem;
    letter-spacing: -0.01em;
}

.dashboard-action-description {
    font-size: 0.875rem;
    opacity: 0.7;
    line-height: 1.25rem;
}

.dashboard-action-arrow {
    font-size: 1.25rem;
    opacity: 0.5;
    transition: all 0.2s ease-in-out;
    flex-shrink: 0;
}

.dashboard-action-item:hover .dashboard-action-arrow {
    opacity: 1;
    transform: translateX(4px);
}

@media (max-width: 640px) {
    .dashboard-stats-grid {
        grid-template-columns: 1fr;
    }

    .dashboard-actions-grid {
        grid-template-columns: 1fr;
    }
}
</style>
