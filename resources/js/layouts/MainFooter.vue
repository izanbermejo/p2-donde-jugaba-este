<template>
    <footer class="main-footer w-full mt-auto">
        <div class="max-w-7xl mx-auto px-6 py-6 flex items-center justify-between">

            <!-- Izquierda -->
            <div class="text-sm footer-text">
                © 2024 ¿Dónde jugaba este? — Todos los derechos reservados
            </div>

            <!-- Derecha (logo) -->
            <div class="flex items-center">
                <img src="/images/logo.svg" alt="Logo" class="footer-logo" />
            </div>

        </div>
    </footer>
</template>

<style scoped>

/* Footer base */
.main-footer {
    background-color: #00203E;
    border-top: 1px solid #003262;
    box-shadow: 0 -1px 3px rgba(0, 0, 0, 0.1);
}

/* Texto */
.footer-text {
    color: white;
    font-weight: 500;
}

/* Logo */
.footer-logo {
    height: 32px;
    width: auto;
    opacity: 0.9;
    transition: all 0.2s ease;
}

</style>
