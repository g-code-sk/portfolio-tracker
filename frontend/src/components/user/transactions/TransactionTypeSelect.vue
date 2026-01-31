<template>
    <Select v-bind="$attrs" :name="name" :label="label" :options="transactionTypes" :disabled="isLoading || disabled" :placeholder="placeholder" :hint="hint" />
</template>

<script setup lang="ts">
import Select from '@/components/ui/inputs/Select.vue'
import { fetchTransactionTypesInputApi } from '@/lib/api/transaction-type-api'
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
        name: 'transactionTypeId',
        label: 'Transaction Type',
        placeholder: 'Select transaction type',
        disabled: false,
    },
)

const toast = useToast()
const transactionTypes = ref<SelectOption[]>([])
const isLoading = ref(false)

onMounted(async () => {
    isLoading.value = true
    try {
        transactionTypes.value = await fetchTransactionTypesInputApi()
    } catch {
        toast.error('Failed to load transaction types.')
    } finally {
        isLoading.value = false
    }
})
</script>
