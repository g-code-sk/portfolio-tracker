<template>
    <Select v-bind="$attrs" :name="name" :label="label" :options="brokers" :disabled="isLoading || disabled" :placeholder="placeholder" :hint="hint" />
</template>

<script setup lang="ts">
import Select from '@/components/ui/inputs/Select.vue'
import { fetchBrokersInputApi } from '@/lib/api/broker-api'
import type { SelectOption } from '@/lib/types/generic-types'
import { onMounted, ref } from 'vue'
import { useToast } from 'vue-toastification'

const props = withDefaults(
    defineProps<{
        name?: string
        label?: string
        placeholder?: string
        hint?: string
        disabled?: boolean
    }>(),
    {
        name: 'brokerId',
        label: 'Broker',
        placeholder: 'Select your broker',
        disabled: false,
    },
)

const toast = useToast()
const brokers = ref<SelectOption[]>([])
const isLoading = ref(false)

onMounted(async () => {
    isLoading.value = true
    try {
        brokers.value = await fetchBrokersInputApi()
    } catch {
        toast.error('Failed to load brokers.')
    } finally {
        isLoading.value = false
    }
})
</script>
