<template>
    <div
        class="fixed w-full z-50 border-b border-gray-200 dark:border-gray-800 transition-all duration-300"
        style="background-color: #00203E;">
        <nav class="container mx-auto px-6 py-4 flex items-center justify-between">
            <!-- Logo -->
            <router-link v-if="!isDesktop" to="/" class="flex items-center gap-2">
                <img src="/images/logo.svg" alt="logo" class="h-10 w-auto"/>
            </router-link>

            <!-- Mobile Menu Button -->
            <button
                v-if="!isDesktop"
                @click="visibleMobileMenu = true"
                class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                <i class="pi pi-bars text-2xl" style="color: white;"></i>
            </button>

            <!-- Desktop Menu -->
            <div v-if="isDesktop" class="flex items-center" style="width: 100%; justify-content: space-between;">
                <router-link  to="/" class="flex items-center gap-2">
                    <img src="/images/logo.svg" alt="logo" class="h-10 w-auto"/>
                </router-link>
                <div class="flex gap-20">
                    <router-link
                        v-for="link in navLinks"
                        :key="link.route"
                        :to="link.route"
                        class="font-medium transition-colors nav-link"
                        style="font-size: 24px;"
                    >
                        {{ link.label }}
                    </router-link>

                </div>

                <!-- Actions -->
                <div class="flex items-center gap-3 pl-6 ">

                    <template v-if="!authStore().user?.name">
                        <router-link to="/login">
                            <Button label="Login" text size="small" />
                        </router-link>
                        <router-link to="/register">
                            <Button label="Registro" severity="primary" size="small" />
                        </router-link>
                    </template>

                    <div v-else>
                        <button
                            type="button"
                            @click="toggle"
                            class="flex items-center gap-2 px-3 py-2 rounded-lg  transition-colors header-user-button">
                            <Avatar :image="authStore().user.avatar" :label="authStore().user.name[0]" shape="circle" size="small" />
                            <span class="text-sm font-medium hidden xl:inline user-name">{{ authStore().user?.name }}</span>
                            <i class="pi pi-chevron-down text-xs" style="color: white;"></i>
                        </button>
                        <Menu ref="menu" :model="items" popup class="header-dropdown" />
                    </div>
                </div>
            </div>
        </nav>

        <!-- Mobile Menu -->
        <div v-if="visibleMobileMenu" class="fixed inset-0 z-50 lg:hidden">
            <!-- Backdrop -->
            <div class="absolute inset-0 bg-black/50" @click="visibleMobileMenu = false"></div>

            <!-- Panel -->
            <div
                class="absolute right-0 top-0 h-full w-full sm:w-80 shadow-2xl"
                :class="'bg-white text-gray-900'"
                @click.stop>
                <!-- Header -->
                <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-800">
                    <div class="flex items-center gap-2">
                        <img src="/images/logo.svg" alt="logo" class="h-8"/>
                        <span class="font-bold text-lg">Menu</span>
                    </div>
                    <button
                        @click="visibleMobileMenu = false"
                        class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                        <i class="pi pi-times text-xl"></i>
                    </button>
                </div>

                <!-- Content -->
                <div class="flex flex-col gap-4 p-4 h-[calc(100%-5rem)] overflow-y-auto">
                    <!-- Nav Links -->
                    <div class="flex flex-col gap-1">
                        <router-link
                            v-for="link in navLinks"
                            :key="link.route"
                            :to="link.route"
                            @click="visibleMobileMenu = false"
                            class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                            <i :class="link.icon"></i>
                            <span>{{ link.label }}</span>
                        </router-link>
                    </div>

                    <div class="border-t border-gray-200 dark:border-gray-800"></div>

                    <!-- Auth -->
                    <div class="flex flex-col gap-3">
                        <template v-if="!authStore().user?.name">
                            <router-link to="/login" @click="visibleMobileMenu = false">
                                <Button label="Iniciar Sesión" outlined class="w-full" />
                            </router-link>
                            <router-link to="/register" @click="visibleMobileMenu = false">
                                <Button label="Registrarse" class="w-full" />
                            </router-link>
                        </template>
                        <template v-else>
                            <div class="p-3 rounded-lg bg-gray-50 dark:bg-gray-800">
                                <div class="font-medium">{{ authStore().user.name }}</div>
                                <div class="text-xs text-gray-500">{{ authStore().user.email }}</div>
                            </div>
                            <Button label="Ir al Dashboard" icon="pi pi-th-large" outlined @click="navigateToDashboard" />
                            <Button label="Cerrar Sesión" icon="pi pi-power-off" severity="danger" text @click="handleLogout" />
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Spacer -->
    <div class="h-20"></div>
</template>

<script setup>
import { useLayout } from "@/composables/layout.js";
import useAuth from "@/composables/auth";
import { authStore } from "../store/auth";
import { ref, computed, onBeforeMount, onMounted, onUnmounted } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();
const menu = ref();
const visibleMobileMenu = ref(false);
const isScrolled = ref(false);
const isDesktop = ref(window.innerWidth >= 992);

const { logout } = useAuth();
const { setDefaultMode } = useLayout();

const navLinks = [
    { label: 'Inicio', route: '/', icon: 'pi pi-home' },
    { label: 'Juegos', route: '/juegos', icon: 'pi pi-play' },
    { label: 'Ranking', route: '/ranking', icon: 'pi pi-list' }
];

const items = computed(() => [
    {
        items: [
            { label: 'Perfil', icon: 'pi pi-user', command: () => router.push('/perfil') },
            {
                label: 'Panel Admin',
                icon: 'pi pi-cog',
                visible: authStore().user?.roles?.some(r => r.name.includes('admin')) || false,
                command: () => router.push('/admin')
            },
            { separator: true },
            {
                label: 'Cerrar sesión',
                icon: 'pi pi-power-off',
                class: 'text-red-500',
                command: () => {
                    handleLogout()
                }
            }
        ]
    }
]);

const toggle = (event) => {
    menu.value.toggle(event);
};

const navigateToDashboard = () => {
    visibleMobileMenu.value = false;
    router.push('/app');
}

const handleLogout = () => {
    visibleMobileMenu.value = false;
    logout();
}

const handleScroll = () => {
    isScrolled.value = window.scrollY > 20;
}

const handleResize = () => {
    isDesktop.value = window.innerWidth >= 992;
}

onMounted(() => {
    window.addEventListener('scroll', handleScroll);
    window.addEventListener('resize', handleResize);
});

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
    window.removeEventListener('resize', handleResize);
});

onBeforeMount(() => {
    setDefaultMode()
})
</script>

<style scoped>

.nav-link {
    color: white;
}

.nav-link:hover {
    color: #54db83;
}

.nav-link:active {
    color: #1DB954;
}

.header-user-button {
    border: none;
    background-color: transparent;
    cursor: pointer;
}

.header-user-button:hover {
    background-color: #002b53;
    border-radius: 0.5rem;
}

.header-user-button:hover .user-name {
    color: #54db83;
}

.user-name {
    color: white;
    font-weight: 600;
    letter-spacing: -0.01em;
}


</style>
