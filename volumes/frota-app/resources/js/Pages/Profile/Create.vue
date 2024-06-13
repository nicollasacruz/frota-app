<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm} from '@inertiajs/vue3';
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SelectInput from "@/Components/SelectInput.vue";
import { watch } from "vue";
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';


defineProps<{
    // mustVerifyEmail?: boolean;
    // status?: string;
}>();

const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
    phone: "",
    IBAN: "",
    NIF: "",
    profitPercentage: 100,
    hasCar: true,
    rentValue: 0,
});

watch(() => form.wasSuccessful, (newValue) => {
    console.log('entrou no watch');
    if (newValue) {
        console.log('entrou');
        toast.success("Criado com sucesso!");
    }
});
</script>

<template>
    <Head title="Criar Usuário"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Criar Usuário</h2>
        </template>

        <section class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <header>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Informações do Usuário</h2>

                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Criando um motorista para frota.
                    </p>
                </header>

                <form @submit.prevent="form.post(route('usuarios.store'))" class="mt-6 space-y-6">
                    <div>
                        <InputLabel for="name" value="Name"/>

                        <TextInput
                            id="name"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.name"
                            required
                            autofocus
                            autocomplete="name"
                        />

                        <InputError class="mt-2" :message="form.errors.name"/>
                    </div>

                    <div>
                        <InputLabel for="email" value="Email"/>

                        <TextInput
                            id="email"
                            type="email"
                            class="mt-1 block w-full"
                            v-model="form.email"
                            required
                            autocomplete="username"
                        />

                        <InputError class="mt-2" :message="form.errors.email"/>
                    </div>

                    <div>
                        <InputLabel for="password" value="Senha"/>

                        <TextInput
                            id="password"
                            type="password"
                            class="mt-1 block w-full"
                            v-model="form.password"
                            required
                            autocomplete="new-password"
                        />

                        <InputError class="mt-2" :message="form.errors.password"/>
                    </div>

                    <div>
                        <InputLabel for="password_confirmation" value="Confirmação de Senha"/>

                        <TextInput
                            id="password_confirmation"
                            type="password"
                            class="mt-1 block w-full"
                            v-model="form.password_confirmation"
                            required
                            autocomplete="new-password"
                        />

                        <InputError class="mt-2" :message="form.errors.password_confirmation"/>
                    </div>

                    <div>
                        <InputLabel for="phone" value="Telefone"/>

                        <TextInput
                            id="phone"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.phone"
                            pattern="[0-9]{9}"
                            required
                            autocomplete="phone"
                        />

                        <InputError class="mt-2" :message="form.errors.phone"/>
                    </div>

                    <div>
                        <InputLabel for="IBAN" value="IBAN"/>

                        <TextInput
                            id="IBAN"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.IBAN"
                            required
                            autocomplete="IBAN"
                        />

                        <InputError class="mt-2" :message="form.errors.IBAN"/>
                    </div>

                    <div>
                        <InputLabel for="NIF" value="NIF"/>

                        <TextInput
                            id="NIF"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.NIF"
                            pattern="[0-9]{9}"
                            required
                            autocomplete="NIF"
                        />

                        <InputError class="mt-2" :message="form.errors.NIF"/>
                    </div>

                    <div>
                        <InputLabel for="profitPercentage" value="Porcentagem de Lucro"/>

                        <TextInput
                            id="profitPercentage"
                            type="number"
                            class="mt-1 block w-full"
                            v-model="form.profitPercentage"
                            required
                            autocomplete="profitPercentage"
                        />

                        <InputError class="mt-2" :message="form.errors.profitPercentage"/>
                    </div>

                    <div>
                        <InputLabel for="hasCar" value="Tem Carro"/>

                        <SelectInput
                            id="hasCar"
                            class="mt-1"
                            v-model="form.hasCar"
                            autocomplete="hasCar"
                            :data="[{id: true, name: 'Sim'}, {id: false, name: 'Não'}]"
                        />

                        <InputError class="mt-2" :message="form.errors.hasCar"/>
                    </div>

                    <div v-show="!form.hasCar">
                        <InputLabel for="rentValue" value="Valor de Aluguel"/>

                        <TextInput
                            id="rentValue"
                            type="number"
                            class="mt-1 block w-full"
                            v-model="form.rentValue"
                            required
                            autocomplete="rentValue"
                        />

                        <InputError class="mt-2" :message="form.errors.rentValue"/>
                    </div>

                    <div class="flex items-center gap-4">
                        <PrimaryButton>Criar</PrimaryButton>

                        <Transition
                            enter-active-class="transition ease-in-out"
                            enter-from-class="opacity-0"
                            leave-active-class="transition ease-in-out"
                            leave-to-class="opacity-0"
                        >
                            <p v-if="form.recentlySuccessful" class="text-sm text-gray-600 dark:text-gray-400">
                                Salvo.</p>
                        </Transition>
                    </div>
                </form>
            </div>
        </section>
    </AuthenticatedLayout>
</template>
