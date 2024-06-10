<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, router, useForm, Link} from '@inertiajs/vue3';
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { defineProps } from 'vue'
import { watch } from "vue";
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import SelectInput from "@/Components/SelectInput.vue";

const props = defineProps({
    driver: Object
});

const form = useForm({
    name: props.driver.name,
    email: props.driver.email,
    phone: props.driver.phone,
    IBAN: props.driver.IBAN,
    NIF: props.driver.NIF,
    profitPercentage: props.driver.profitPercentage,
    hasCar: !!props.driver.hasCar,
    rentValue: props.driver.rentValue,
});

const returnToDriverList = () => {
    window.location;
}

</script>

<template>
    <Head title="Editar Motorista"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Exibir Motorista</h2>
        </template>

        <section class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <header>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Informações do Motorista</h2>

                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Mostrando um motorista para frota.
                    </p>
                </header>

                <form class="mt-6 space-y-6">
                    <div id="nameForm">
                        <InputLabel for="name" value="Name"/>

                        <TextInput
                            id="name"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.name"
                            required
                            autofocus
                            autocomplete="name"
                            disabled
                        />
                    </div>

                    <div id="emailForm">
                        <InputLabel for="email" value="Email"/>

                        <TextInput
                            id="email"
                            type="email"
                            class="mt-1 block w-full"
                            v-model="form.email"
                            required
                            autocomplete="username"
                            disabled
                        />
                    </div>

                    <div>
                        <InputLabel for="phone" value="Telefone"/>

                        <TextInput
                            id="phone"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.phone"
                            required
                            autocomplete="phone"
                            disabled
                        />
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
                            disabled
                        />
                    </div>

                    <div>
                        <InputLabel for="NIF" value="NIF"/>

                        <TextInput
                            id="NIF"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.NIF"
                            required
                            autocomplete="NIF"
                            disabled
                        />

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
                            disabled
                        />
                    </div>

                    <div>
                        <InputLabel for="hasCar" value="Tem Carro"/>

                        <SelectInput
                            id="hasCar"
                            class="mt-1"
                            v-model="form.hasCar"
                            autocomplete="hasCar"
                            :data="[{id: true, name: 'Sim'}, {id: false, name: 'Não'}]"
                            disabled
                        />
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
                            disabled
                        />
                    </div>

                    <div class="flex items-center gap-4">
                        <Link
                        :href="route('usuarios.index')"
                        class="text-white font-semibold bg-black px-4 py-2 rounded-md hover:bg-gray-800 transition-colors duration-200"
                        > Voltar </Link>
                    </div>
                </form>
            </div>
        </section>
    </AuthenticatedLayout>
</template>
