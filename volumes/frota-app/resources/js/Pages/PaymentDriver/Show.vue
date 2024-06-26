<script setup lang="ts">
// @ts-nocheck

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link, useForm} from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import SelectInput from "@/Components/SelectInput.vue";
import { ref, watch } from "vue";
import InputError from "@/Components/InputError.vue";
import Checkbox from "@/Components/Checkbox.vue";

const props = defineProps<{
    payment: { id: number; date: string; valueWeekUber: number; valueWeekBolt: number; user_id: string; paymentMethod: string; car_id: number; slotValue: number; viaVerdeValue: number; frotaCardValue: number; refund_iva_amount: number; totalValue: number; instantPayment: boolean; user: { id: number; name: string; email: string; }; car: { id: number; license_plate: string; brand: string; model: string; year: number; }};
}>();

props.payment.date = props.payment.date.split('T')[0];

const form = useForm({
    date: props.payment.date,
    valueWeekUber: props.payment.valueWeekUber,
    valueWeekBolt: props.payment.valueWeekBolt,
    paymentMethod: props.payment.paymentMethod,
    car: props.payment.car,
    slotValue: props.payment.slotValue,
    viaVerdeValue: props.payment.viaVerdeValue,
    frotaCardValue: props.payment.frotaCardValue,
    refund_iva_amount: props.payment.refund_iva_amount ?? '0',
    totalValue: props.payment.totalValue ?? '0',
    instantPayment: props.payment.instantPayment,
    user: props.payment.user,
});

const paymentMethods = [
    {id: 'IBAN', name: 'IBAN'},
    {id: 'MONEY', name: 'Dinheiro'},
    {id: 'MB-WAY', name: 'Mb-Way'},
];

</script>

<template>
    <Head title="Criar Usuário"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Visualizar Pagamento</h2>
        </template>
        <section class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <header>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Visualização de Pagamento</h2>

                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Visualizando pagamento para um motorista da frota.
                    </p>
                </header>

                <form class="mt-6 space-y-6">
                    <div id="valueForm">
                        <InputLabel for="valueWeekUber" value="Valor Uber"/>

                        <TextInput
                            id="valueWeekUber"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.valueWeekUber"
                            required
                            autofocus
                            disabled
                            autocomplete="valueWeekUber"
                        />
                    </div>

                    <div id="valueForm">
                        <InputLabel for="valueWeekBolt" value="Valor Bolt"/>

                        <TextInput
                            id="valueWeekBolt"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.valueWeekBolt"
                            required
                            autofocus
                            disabled
                            autocomplete="valueWeekBolt"
                        />
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
                            disabled
                            autocomplete="slotValue"
                        />
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
                            disabled
                            autocomplete="viaVerdeValue"
                        />
                    </div>

                    <div>
                        <InputLabel for="frotaCardValue" value="Valor do Cartao da Frota"/>

                        <TextInput
                            id="frotaCardValue"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.frotaCardValue"
                            required
                            autofocus
                            disabled
                            autocomplete="frotaCardValue"
                        />
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
                            disabled
                            autocomplete="date"
                        />
                    </div>

                    <div id="driverForm">
                        <InputLabel for="user_id" value="Motorista"/>

                        <TextInput
                            id="user_id"
                            class="mt-1 block w-full"
                            v-model="form.user.name"
                            autofocus
                            disabled
                        />
                    </div>

                    <div v-if="!form.car?.id" id="carForm">
                        <InputLabel for="car_id" value="Carro"/>

                        <TextInput
                            id="car"
                            class="mt-1 block w-full"
                            v-model="form.car"
                            disabled
                        />
                    </div>

                    <div>
                        <InputLabel for="paymentMethod" value="Método de Pagamento"/>

                        <TextInput
                            id="paymentMethod"
                            class="mt-1 block w-full"
                            v-model="form.paymentMethod"
                            :data="paymentMethods"
                            disabled
                        />
                    </div>

                    <div id="imediateForm">
                        <InputLabel for="instantPayment" value="Pagamento Imediato"/>

                        <Checkbox
                            id="instantPayment"
                            class="mt-1 block"
                            :checked="form.instantPayment"
                            disabled
                        />

                    </div>

                    <div class="flex items-center gap-4">
                        <Link
                            :href="route('pagamentos.index')"
                            class="text-white font-semibold bg-black px-4 py-2 rounded-md hover:bg-gray-800 transition-colors duration-200"
                        > Voltar </Link>

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
