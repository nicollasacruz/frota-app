<script setup lang="ts">

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const props = defineProps<{
    payments: { id: number; paymentStatus: string; user: object; platform: string; valueWeek: number; taxValue: number; rentValue: number; SlotValue: number; viaVerdeValue: number; refund_iva_amount: number; totalValue: number }[];
}>();
console.log(props.payments);
const formatMoney = (value) => {
  return value.toLocaleString('pt-PT', { style: 'currency', currency: 'EUR' });
}
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Lista de Pagamentos</h2>
        </template>

        <section class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <header>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Listar pagamentos dos motoristas da frota</h2>
                </header>
                <div class="overflow-x-auto">
                    <table class="table">
                        <!-- head -->
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Plataforma</th>
                            <th>Valor da Semana</th>
                            <th>Valor do IVA</th>
                            <th>Valor do Aluguel</th>
                            <th>Valor do IVA a reembolsar</th>
                            <th>Valor do Slot</th>
                            <th>Valor da Via Verde</th>
                            <th>Valor Total</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr v-for="payment in props.payments">
                            <th>{{ payment.id }}</th>
                            <th>{{ payment.user.name }}</th>
                            <th>{{ payment.platform === 'uber' ? 'Uber' : 'Bolt'}}</th>
                            <th>{{ formatMoney(payment.valueWeek) }}</th>
                            <th>{{ formatMoney(payment.taxValue) }}</th>
                            <th>{{ payment.rentValue ? formatMoney(payment.rentValue) : '0,00 €' }}</th>
                            <th>{{ payment.refund_iva_amount ? formatMoney(payment.refund_iva_amount) : '0,00 €' }}</th>
                            <th>{{ payment.SlotValue ? formatMoney(payment.SlotValue) : '0,00 €' }}</th>
                            <th>{{ payment.viaVerdeValue ? formatMoney(payment.viaVerdeValue) : '0,00 €' }}</th>
                            <th>{{ payment.totalValue ? formatMoney(payment.totalValue) : '0,00 €' }}</th>
                            <th>{{ payment.paymentStatus === 'paid' ? 'Pago' : 'Por Pagar' }}</th>
                            <th class="flex">
                                <a :href="route('pagamentos.show', {payment: payment.id})" class="text-indigo-600 hover:text-indigo-900">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 24 24"><path fill="currentColor" d="M12 9a3 3 0 0 1 3 3a3 3 0 0 1-3 3a3 3 0 0 1-3-3a3 3 0 0 1 3-3m0-4.5c5 0 9.27 3.11 11 7.5c-1.73 4.39-6 7.5-11 7.5S2.73 16.39 1 12c1.73-4.39 6-7.5 11-7.5M3.18 12a9.821 9.821 0 0 0 17.64 0a9.821 9.821 0 0 0-17.64 0"/></svg>
                                </a>
                                <a :href="route('pagamentos.edit', {payment: payment.id})" class="text-indigo-600 hover:text-indigo-900">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 24 24"><path fill="currentColor" d="M4 21a1 1 0 0 0 .24 0l4-1a1 1 0 0 0 .47-.26L21 7.41a2 2 0 0 0 0-2.82L19.42 3a2 2 0 0 0-2.83 0L4.3 15.29a1.06 1.06 0 0 0-.27.47l-1 4A1 1 0 0 0 3.76 21A1 1 0 0 0 4 21M18 4.41L19.59 6L18 7.59L16.42 6zM5.91 16.51L15 7.41L16.59 9l-9.1 9.1l-2.11.52z"/></svg>
                                </a>
                                <a :href="route('pagamentos.destroy', {payment: payment.id})" class="text-red-600 hover:text-red-900">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 24 24">
                                        <path fill="currentColor" d="M19 4h-3.5l-1-1h-5l-1 1H5v2h14M6 19a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V7H6z" />
                                    </svg>
                                </a>
                            </th>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </AuthenticatedLayout>

</template>

<style scoped>

</style>
