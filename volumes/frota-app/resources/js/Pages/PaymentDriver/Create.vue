<script setup lang="ts">
// @ts-nocheck

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, useForm} from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import SelectInput from "@/Components/SelectInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { ref, watch } from "vue";
import Checkbox from "@/Components/Checkbox.vue";

const props = defineProps<{
    drivers: { id: number; name: string, hasCar: boolean }[];
    cars: { id: number; brand: string; model: string; license_plate: string; }[];
}>();

const form = useForm({
    date: new Date().toISOString().split('T')[0],
    valueWeekUber: '0',
    valueWeekBolt: '0',
    user_id: "",
    paymentMethod: "IBAN",
    car_id: null,
    slotValue: '0',
    viaVerdeValue: '0',
    frotaCardValue: '0',
    instantPayment: false,
});

const paymentMethods = [
    {id: 'IBAN', name: 'IBAN'},
    {id: 'MONEY', name: 'Dinheiro'},
    {id: 'MB-WAY', name: 'Mb-Way'},
];

const carsSelect = [
];
props.cars.forEach((car: any) => {
    carsSelect.push({id: car.id, name: car.model + ' - ' + car.license_plate});
});

function validateCurrency(event: Event) {
    const input = event.target as HTMLInputElement;
    let value = input.valueWeekUber;

    // Allow only digits and comma
    value = value.replace(/[^0-9,]/g, '');

    // Ensure there's only one comma
    const parts = value.split(',');
    if (parts.length > 2) {
        value = parts[0] + ',' + parts.slice(1).join('');
    }

    // Ensure only two digits after the comma
    if (parts[1]?.length > 2) {
        value = parts[0] + ',' + parts[1].slice(0, 2);
    }

    input.value = value;
    form.valueWeekUber = value;
}

function validateCurrencyBolt(event: Event) {
    const input = event.target as HTMLInputElement;
    let value = input.valueWeekBolt;

    // Allow only digits and comma
    value = value.replace(/[^0-9,]/g, '');

    // Ensure there's only one comma
    const parts = value.split(',');
    if (parts.length > 2) {
        value = parts[0] + ',' + parts.slice(1).join('');
    }

    // Ensure only two digits after the comma
    if (parts[1]?.length > 2) {
        value = parts[0] + ',' + parts[1].slice(0, 2);
    }

    input.value = value;
    form.valueWeekBolt = value;
}

function validateCurrencySlot(event: Event) {
    const input = event.target as HTMLInputElement;
    let value = input.value;

    // Allow only digits and comma
    value = value.replace(/[^0-9,]/g, '');

    // Ensure there's only one comma
    const parts = value.split(',');
    if (parts.length > 2) {
        value = parts[0] + ',' + parts.slice(1).join('');
    }

    // Ensure only two digits after the comma
    if (parts[1]?.length > 2) {
        value = parts[0] + ',' + parts[1].slice(0, 2);
    }

    input.value = value;
    form.slotValue = value;
}

function validateCurrencyViaVerde(event: Event) {
    const input = event.target as HTMLInputElement;
    let value = input.value;

    // Allow only digits and comma
    value = value.replace(/[^0-9,]/g, '');

    // Ensure there's only one comma
    const parts = value.split(',');
    if (parts.length > 2) {
        value = parts[0] + ',' + parts.slice(1).join('');
    }

    // Ensure only two digits after the comma
    if (parts[1]?.length > 2) {
        value = parts[0] + ',' + parts[1].slice(0, 2);
    }

    input.value = value;
    form.viaVerdeValue = value;
}

function validateCurrencyPortagem(event: Event) {
    const input = event.target as HTMLInputElement;
    let value = input.value;

    // Allow only digits and comma
    value = value.replace(/[^0-9,]/g, '');

    // Ensure there's only one comma
    const parts = value.split(',');
    if (parts.length > 2) {
        value = parts[0] + ',' + parts.slice(1).join('');
    }

    // Ensure only two digits after the comma
    if (parts[1]?.length > 2) {
        value = parts[0] + ',' + parts[1].slice(0, 2);
    }

    input.value = value;
    form.viaVerdeValue = value;
}

function validateCurrencyfrotaCardValue(event: Event) {
    const input = event.target as HTMLInputElement;
    let value = input.value;

    // Allow only digits and comma
    value = value.replace(/[^0-9,]/g, '');

    // Ensure there's only one comma
    const parts = value.split(',');
    if (parts.length > 2) {
        value = parts[0] + ',' + parts.slice(1).join('');
    }

    // Ensure only two digits after the comma
    if (parts[1]?.length > 2) {
        value = parts[0] + ',' + parts[1].slice(0, 2);
    }

    input.value = value;
    form.frotaCardValue = value;
}

watch(() => form.wasSuccessful, (newValue) => {
    if (newValue) {
        form.valueWeekUber = parseFloat(form.valueWeekUber.replace(',', '.')).toFixed(2);
        form.valueWeekBolt = parseFloat(form.valueWeekBolt.replace(',', '.')).toFixed(2);
        form.slotValue = parseFloat(form.slotValue.replace(',', '.')).toFixed(2);
        form.viaVerdeValue = parseFloat(form.viaVerdeValue.replace(',', '.')).toFixed(2);
    }
});

const hasCar = ref(true);

watch(() => form.user_id, (newValue) => {
    const driver = props.drivers.find(driver => driver.id == newValue);
    if (driver) {
        hasCar.value = driver.hasCar;
    }
});

watch([() => form.valueWeekUber, () => form.date, () => form.user_id, () => form.paymentMethod], () => {
    if (form.valueWeekUber && form.date && form.user_id && form.paymentMethod) {
        form.wasSuccessful = true;
        console.log('entrou no sucesso');
    }
})

</script>

<template>
    <Head title="Criar Usuário"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Criar Pagamento</h2>
        </template>
        <section class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <header>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Criação de Pagamentos de
                        motorista</h2>

                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Criando um pagamento para um motorista da frota.
                    </p>
                </header>

                <form @submit.prevent="form.post(route('pagamentos.store'))" class="mt-6 space-y-6">
                    <div id="valueForm">
                        <InputLabel for="valueWeekUber" value="Valor Uber"/>

                        <TextInput
                            id="valueWeekUber"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.valueWeekUber"
                            required
                            autofocus
                            @input="validateCurrency"
                            autocomplete="valueWeekUber"
                        />

                        <InputError class="mt-2" :message="form.errors.valueWeekUber"/>
                    </div>

                    <div id="valueForm">
                        <InputLabel for="valueWeekBolt" value="Valor Bolt"/>

                        <TextInput
                            id="valueWeekUber"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.valueWeekBolt"
                            required
                            autofocus
                            @input="validateCurrencyBolt"
                            autocomplete="valueWeekUber"
                        />

                        <InputError class="mt-2" :message="form.errors.valueWeekBolt"/>
                    </div>

                    <div>
                        <InputLabel for="slotValue" value="Valor do Slot"/>

                        <TextInput
                            id="slotValue"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.slotValue"
                            required
                            autofocus
                            @input="validateCurrencySlot"
                            autocomplete="slotValue"
                        />

                        <InputError class="mt-2" :message="form.errors.slotValue"/>
                    </div>

                    <div>
                        <InputLabel for="viaVerdeValue" value="Valor do Via Verde"/>

                        <TextInput
                            id="viaVerdeValue"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.viaVerdeValue"
                            required
                            autofocus
                            @input="validateCurrencyViaVerde"
                            autocomplete="viaVerdeValue"
                        />

                        <InputError class="mt-2" :message="form.errors.viaVerdeValue"/>
                    </div>

                    <div>
                        <InputLabel for="frotaCardValue" value="Valor do Cartão da Frota"/>

                        <TextInput
                            id="frotaCardValue"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.frotaCardValue"
                            required
                            autofocus
                            @input="validateCurrencyfrotaCardValue"
                            autocomplete="frotaCardValue"
                        />

                        <InputError class="mt-2" :message="form.errors.frotaCardValue"/>
                    </div>

                    <div id="dateForm">
                        <InputLabel for="date" value="Data"/>

                        <TextInput
                            id="date"
                            type="date"
                            class="mt-1 block w-full"
                            v-model="form.date"
                            required
                            autofocus
                            autocomplete="date"
                        />

                        <InputError class="mt-2" :message="form.errors.date"/>
                    </div>

                    <div id="driverForm">
                        <InputLabel for="user_id" value="Motorista"/>

                        <SelectInput
                            id="user_id"
                            class="mt-1 block w-full"
                            v-model="form.user_id"
                            :data="drivers"
                            required
                            autofocus
                            autocomplete="user_id"
                        />

                        <InputError class="mt-2" :message="form.errors.user_id"/>
                    </div>

                    <div v-if="!hasCar" id="carForm">
                        <InputLabel for="car_id" value="Carro"/>

                        <SelectInput
                            id="car_id"
                            class="mt-1 block w-full"
                            v-model="form.car_id"
                            :data="carsSelect"
                            required
                            autofocus
                            autocomplete="car_id"
                        />

                        <InputError class="mt-2" :message="form.errors.car_id"/>
                    </div>

                    <div>
                        <InputLabel for="paymentMethod" value="Método de Pagamento"/>

                        <SelectInput
                            id="paymentMethod"
                            class="mt-1 block w-full"
                            v-model="form.paymentMethod"
                            :data="paymentMethods"
                            required
                            autofocus
                            autocomplete="paymentMethod"
                        />

                        <InputError class="mt-2" :message="form.errors.paymentMethod"/>
                    </div>

                    <div id="imediateForm">
                        <InputLabel for="instantPayment" value="Pagamento Imediato"/>

                        <Checkbox
                            id="instantPayment"
                            class="mt-1 block"
                            :checked="form.instantPayment"
                        />

                        <InputError class="mt-2" :message="form.errors.instantPayment"/>
                    </div>

                    <div class="flex items-center gap-4">
                        <PrimaryButton
                            class="mt-4"
                            type="submit"
                        >Criar
                        </PrimaryButton>

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

<style scoped>

</style>
