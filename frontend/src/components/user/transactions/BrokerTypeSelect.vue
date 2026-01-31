<template>
    <Select v-bind="$attrs" :name="name" :label="label" :options="types" :disabled="isLoading || disabled" :placeholder="placeholder" :hint="hint" />
</template>

<script setup lang="ts">
import Select from '@/components/ui/inputs/Select.vue'
import { fetchBrokerTypesInputApi } from '@/lib/api/broker-type-api'
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
        name: 'brokerTypeId',
        label: 'Broker Type',
        placeholder: 'Select your broker',
        disabled: false,
    },
)

const toast = useToast()
const types = ref<SelectOption[]>([])
const isLoading = ref(false)

onMounted(async () => {
    isLoading.value = true
    try {
        types.value = await fetchBrokerTypesInputApi()
    } catch {
        toast.error('Failed to load broker types.')
    } finally {
        isLoading.value = false
    }
})
</script>
