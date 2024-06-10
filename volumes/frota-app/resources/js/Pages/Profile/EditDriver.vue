<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
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

</script>

<template>
    <Head title="Editar Motorista"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Editar Motorista</h2>
        </template>

        <section class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <header>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Informações do Motorista</h2>

                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Editando um motorista para frota.
                    </p>
                </header>

                <form @submit.prevent="form.post(route('usuarios.update'))" class="mt-6 space-y-6">
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
                        />

                        <InputError class="mt-2" :message="form.errors.name"/>
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
                        />

                        <InputError class="mt-2" :message="form.errors.email"/>
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
                        <PrimaryButton>Salvar</PrimaryButton>

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
