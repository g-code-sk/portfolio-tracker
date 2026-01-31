<template>
    <div>
        <div class="flex gap-3">
            <Button color="primary" size="sm" :disabled="hasNoPortfolios()" @click="isModalOpen = true">
                <UploadIcon :size="4" />
                Import Transactions
                <InfoPopover v-if="hasNoPortfolios()" type="info" title="No portfolios available" text="Create at least one portfolio before importing transactions." />
            </Button>
        </div>

        <Modal v-model="isModalOpen" title="Import Transactions" :show-cancel-button="true" :disabled="isSubmitting">
            <form :id="importPortfolioFormId" class="space-y-4" @submit.prevent="submitImportTransactions">
                <UserPortfolioSelect />
                <BrokerSelect />
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
import InfoPopover from '@/components/ui/InfoPopover.vue'
import Modal from '@/components/ui/Modal.vue'
import UploadIcon from '@/components/ui/icons/UploadIcon.vue'
import FileInput from '@/components/ui/inputs/FileInput.vue'
import UserPortfolioSelect from '@/components/user/portfolios/UserPortfolioSelect.vue'
import BrokerSelect from '@/components/user/transactions/BrokerSelect.vue'
import { useUserPortfolios } from '@/composables/useUserPortfolios'
import { importUserTransactionsApi } from '@/lib/api/transaction-api'
import { toTypedSchema } from '@vee-validate/zod'
import { useForm } from 'vee-validate'
import { ref } from 'vue'
import { useToast } from 'vue-toastification'
import { z } from 'zod'

const toast = useToast()

const importPortfolioFormId = 'import-portfolio-form'
const isModalOpen = ref(false)

const { hasNoPortfolios } = useUserPortfolios()

const importPortfolioSchema = toTypedSchema(
    z.object({
        portfolioId: z.number().min(1, 'Portfolio is required'),
        transactionTypeId: z.preprocess((val) => (val === '' || val === undefined ? undefined : Number(val)), z.number().min(1, 'Transaction type is required')),
        brokerId: z.preprocess((val) => (val === '' || val === undefined ? undefined : Number(val)), z.number().min(1, 'Broker is required')),
        file: z.instanceof(File, { message: 'File is required' }),
    }),
)

const { handleSubmit, isSubmitting, meta, resetForm } = useForm({
    validationSchema: importPortfolioSchema,
    initialValues: {
        portfolioId: undefined,
        brokerId: undefined,
        file: undefined,
    },
})

const submitImportTransactions = handleSubmit(async (values) => {
    try {
        const result = await importUserTransactionsApi({
            portfolioId: values.portfolioId,
            brokerId: values.brokerId,
            file: values.file,
        })

        isModalOpen.value = false
        resetForm()
        toast.success(`File parsed successfully! Found ${result.rowCount} rows. Check console for details.`)
    } catch (error) {
        toast.error('Failed to import transactions. Please try again.')
        console.error(error)
    }
})
</script>
