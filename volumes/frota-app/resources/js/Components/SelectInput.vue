<script setup lang="ts">
import { onMounted, ref, defineProps, defineExpose } from 'vue';

interface Item {
    id: string | number;
    name: string;
}

// Define os tipos das propriedades
const props = defineProps<{
    data: Item[];
}>();

const model = ref<string | number | null>(null); // Define o tipo para o v-model
const input = ref<HTMLInputElement | null>(null);

onMounted(() => {
    if (input.value?.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({
    focus: () => {
        input.value?.focus();
    }
});
</script>

<template>
    <select
        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
        v-model="model"
        ref="input"
    >
        <option value="" selected>Selecione</option>
        <option v-for="item in data" :key="item.id" :value="item.id">{{ item.name }}</option>
    </select>
</template>
