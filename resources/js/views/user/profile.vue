<template>
    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">

        <!-- Avatar Section -->
        <div class="col-span-1 md:col-span-4 lg:col-span-3">
            <Card>
                <template #title>Avatar</template>
                <template #content>
                    <div class="flex flex-col items-center">

                        <FileUpload
                            name="picture"
                            url="/api/users/updateimg"
                            @before-upload="onBeforeUpload"
                            @upload="onTemplatedUpload($event)"
                            accept="image/*"
                            :maxFileSize="1500000"
                            @select="onSelectedFiles"
                            mode="basic"
                            :auto="true"
                            chooseLabel="Cambiar Avatar"
                            class="w-full"
                        />

                        <div class="mt-4 w-full flex justify-center">
                            <Avatar
                                :image="user.avatar || 'https://bootdey.com/img/Content/avatar/avatar7.png'"
                                class="w-32 h-32"
                                size="xlarge"
                                shape="circle"
                            />
                        </div>

                    </div>
                </template>
            </Card>
        </div>

        <!-- Datos personales -->
        <div class="col-span-1 md:col-span-8 lg:col-span-9">
            <Card>
                <template #title>Datos Personales</template>

                <template #content>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <!-- Nombre (OBLIGATORIO) -->
                        <div class="field">
                            <label class="font-bold block mb-2">Nombre *</label>
                            <InputText v-model="user.name" class="w-full" />
                            <small class="p-error">{{ getError('name') }}</small>
                        </div>

                        <!-- Email (NO EDITABLE) -->
                        <div class="field">
                            <label class="font-bold block mb-2">Email</label>
                            <InputText v-model="user.email" class="w-full" disabled />
                        </div>

                        <!-- Apellido 1 (OPCIONAL) -->
                        <div class="field">
                            <label class="font-bold block mb-2">Primer Apellido</label>
                            <InputText v-model="user.surname1" class="w-full" />
                            <small class="p-error">{{ getError('surname1') }}</small>
                        </div>

                        <!-- Apellido 2 (OPCIONAL) -->
                        <div class="field">
                            <label class="font-bold block mb-2">Segundo Apellido</label>
                            <InputText v-model="user.surname2" class="w-full" />
                            <small class="p-error">{{ getError('surname2') }}</small>
                        </div>

                    </div>

                    <div class="mt-6 flex justify-end">
                        <Button
                            label="Guardar cambios"
                            icon="pi pi-save"
                            :loading="isLoading"
                            @click="saveProfile"
                        />
                    </div>

                </template>
            </Card>
        </div>

    </div>
</template>

<script setup>
import { onMounted } from "vue";
import { usePrimeVue } from 'primevue/config';
import useUsers from "@/composables/users";
import { authStore } from "@/store/auth";

const auth = authStore();
const $primevue = usePrimeVue();

const {
    getUser,
    user,
    updateUser,
    isLoading,
    getError
} = useUsers();

onMounted(() => {
    getUser(auth.user.id)
})

const saveProfile = async () => {
    await updateUser();
}


const onBeforeUpload = (event) => {
    event.formData.append('id', user.value.id)
};

const onTemplatedUpload = () => {
    getUser(auth.user.id);
};

const onSelectedFiles = () => {};
</script>
