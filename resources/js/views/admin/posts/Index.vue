<template>

    <div class="w-full space-y-4">
        <div class="flex items-center justify-between">
        <div>
            <h2 class="text-lg font-semibold">Gestión de Posts</h2>
            <p class="text-sm text-gray-600">Lista simple de posts</p>
        </div>
        <div class="flex gap-2">
            <button class="px-3 py-2 text-sm border rounded hover:bg-gray-50 bg-white">
            Actualizar'
            </button>
        </div>
        </div>

        <div class="overflow-x-auto border rounded bg-white shadow-sm">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-700 font-medium border-b">
            <tr>
                <th class="px-4 py-3 w-16">ID</th>
                <th class="px-4 py-3">Título</th>
                <th class="px-4 py-3">Categorías</th>
                <th class="px-4 py-3 w-64">Contenido</th>
                <th class="px-4 py-3 whitespace-nowrap">Creado</th>
                <th class="px-4 py-3 text-right">Acciones</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 text-gray-500"></td>

                <td class="px-4 py-3 font-medium text-gray-900"></td>
                <td class="px-4 py-3">

                </td>
                <td class="px-4 py-3 text-gray-600">
                <div class="line-clamp-2"></div>
                </td>
                <td class="px-4 py-3 whitespace-nowrap text-gray-500"></td>
                <td class="px-4 py-3 text-right space-x-2">
                <button class="text-blue-600 hover:text-blue-800 font-medium">
                    Editar
                </button>
                <button class="text-red-600 hover:text-red-800 font-medium" >
                    Eliminar
                </button>
                </td>
            </tr>
            </tbody>
        </table>
        </div>
    </div>

</template>


<script setup lang="js">
import axios from 'axios';
import { onMounted, ref } from 'vue';
import useUtils from "@/composables/utils"
import usePosts from '../../../composables/posts';

const { posts, getPosts } = usePosts();
const { formatDate } = useUtils();

// onMounted(() => {
//     axios.get('/api/posts').then(response => {
//         posts.value = response.data.data;
//         console.log(response)
//     })
// });

onMounted(() => {
    getPosts()
    .then(response => {
        console.log('estoy en la vista')
    })
})

</script>


<style scoped>



</style>
