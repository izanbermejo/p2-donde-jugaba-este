<template>
    <Navbar />

    <div class="user-panel-container">

        <!-- Título -->
        <h1 class="user-panel-title">Panel de usuario</h1>

        <div class="panel-user">

            <!-- Avatar -->
            <div class="panel-card avatar-card">
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

            <!-- Datos -->
            <div class="panel-card data-card">
                <Card>
                    <template #title>Datos Personales</template>

                    <template #content>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            <div class="field">
                                <label class="font-bold block mb-2">Nombre *</label>
                                <InputText v-model="user.name" class="w-full" />
                                <small class="p-error">{{ getError('name') }}</small>
                            </div>

                            <div class="field">
                                <label class="font-bold block mb-2">Email</label>
                                <InputText v-model="user.email" class="w-full" disabled />
                            </div>

                            <div class="field">
                                <label class="font-bold block mb-2">Primer Apellido</label>
                                <InputText v-model="user.surname1" class="w-full" />
                                <small class="p-error">{{ getError('surname1') }}</small>
                            </div>

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
    </div>

    <Footer />
</template>

<script setup>
import { onMounted } from "vue";
import useUsers from "@/composables/users";
import { authStore } from "@/store/auth";

const auth = authStore();

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

<style scoped>
.user-panel-container {
    max-width: 1400px;
    margin: 50px auto;
    padding: 0 40px;

    display: flex;
    flex-direction: column;
    gap: 50px;
}

.user-panel-title {
    color: #00203E;
    font-size: 60px;
    font-weight: bold;
    text-align: center;
    margin: 0;
}

/* layout principal */
.panel-user {
    display: flex;
    gap: 4%;
    width: 100%;
    align-items: flex-start;
}

/* tarjetas */
.avatar-card {
    flex: 1;
    min-width: 280px;
}

.data-card {
    flex: 2;
    min-width: 320px;
}

/* responsive real */
@media (max-width: 1024px) {
    .panel-user {
        flex-direction: column;
        gap: 20px;
    }

    .avatar-card,
    .data-card {
        width: 100%;
    }
}

@media (max-width: 430px) {
    .user-panel-container {
        padding: 0 20px;
        gap: 20px;
    }

    .user-panel-title {
        font-size: 36px;
    }
    .user-panel-container {
        margin: 20px auto;
    }
}
</style>