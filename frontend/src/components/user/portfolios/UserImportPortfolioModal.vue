<template>
    <div>
        <div class="flex gap-3">
            <Button color="primary" size="sm" @click="isModalOpen = true"> Import </Button>
        </div>

        <Modal v-model="isModalOpen" title="Import Portfolio" :show-cancel-button="true" :disabled="isSubmitting">
            <form :id="importPortfolioFormId" class="space-y-4" @submit.prevent="submitImportPortfolio">
                <UserPortfolioSelect name="portfolioId" />
                <Select name="type" label="Broker Type" :options="brokerTypeOptions" placeholder="Select your broker" />
                <FileInput name="file" label="Import File" accept=".csv,.xlsx,.xls" hint="Select a CSV or Excel file to import" />
            </form>

            <template #footer>
                <Button color="primary" size="sm" type="submit" :form="importPortfolioFormId" :loading="isSubmitting" :disabled="!meta.valid || isSubmitting">
                    Import Data
                </Button>
            </template>
        </Modal>
    </div>
</template>

<script setup lang="ts">
import Button from '@/components/ui/Button.vue'
import FileInput from '@/components/ui/inputs/FileInput.vue'
import Select from '@/components/ui/inputs/Select.vue'
import UserPortfolioSelect from '@/components/user/portfolios/UserPortfolioSelect.vue'
import Modal from '@/components/ui/Modal.vue'
import type { SelectOption } from '@/lib/types/generic-types'
import { toTypedSchema } from '@vee-validate/zod'
import { useForm } from 'vee-validate'
import { ref } from 'vue'
import { useToast } from 'vue-toastification'
import { z } from 'zod'

const toast = useToast()

const importPortfolioFormId = 'import-portfolio-form'
const isModalOpen = ref(false)

const brokerTypeOptions: SelectOption[] = [
    { label: 'Trading 212', value: 'trading_212' },
    { label: 'Interactive Brokers', value: 'interactive_brokers' },
]

const importPortfolioSchema = toTypedSchema(
    z.object({
        portfolioId: z.number().min(1, 'Portfolio is required'),
        type: z.string().min(1, 'Broker type is required'),
        file: z.instanceof(File, { message: 'File is required' }),
    }),
)

const { handleSubmit, isSubmitting, meta, resetForm } = useForm({
    validationSchema: importPortfolioSchema,
    initialValues: {
        portfolioId: undefined,
        type: '',
        file: undefined,
    },
})

const submitImportPortfolio = handleSubmit(async (values) => {
    try {
        // TODO: Implement the API call to import portfolio data
        // Example:
        // await importPortfolioApi({
        //     portfolio_id: values.portfolioId,
        //     type: values.type,
        //     file: values.file,
        // })

        console.log('Import values:', values)

        isModalOpen.value = false
        resetForm()
        toast.success('Portfolio data imported successfully')
    } catch (error) {
        toast.error('Failed to import portfolio data. Please try again.')
        console.error(error)
    }
})
</script>
