<template>
    <div>
        <div class="relative flex items-center gap-3">
            <Button color="primary" size="sm" :disabled="hasNoPortfolios()" @click="handleOpenModal">
                <PlusIcon />
                Add Transaction
                <InfoPopover v-if="hasNoPortfolios()" type="info" title="No portfolios available" text="Create at least one portfolio before adding transactions." />
            </Button>
        </div>

        <Modal v-model="isModalOpen" title="Add Transaction" :show-cancel-button="true" :disabled="isSubmitting">
            <form :id="createTransactionFormId" class="space-y-4" @submit.prevent="submitCreateTransaction">
                <UserPortfolioSelect />
                <TransactionTypeSelect />
                <StockSelect />
                <Input name="amount" label="Amount" type="number" placeholder="e.g., 10" autocomplete="off" />
                <Input name="price" label="Price" type="number" placeholder="e.g., 150.50" autocomplete="off" />
                <Input name="date" label="Date" type="date" autocomplete="off" />
                <Input name="fee" label="Fee" type="number" placeholder="e.g., 5.00" autocomplete="off" />
            </form>

            <template #footer>
                <Button color="primary" size="sm" type="submit" :form="createTransactionFormId" :loading="isSubmitting" :disabled="!meta.valid || isSubmitting">
                    Save Transaction
                </Button>
            </template>
        </Modal>
    </div>
</template>

<script setup lang="ts">
import Button from '@/components/ui/Button.vue'
import PlusIcon from '@/components/ui/icons/PlusIcon.vue'
import InfoPopover from '@/components/ui/InfoPopover.vue'
import Input from '@/components/ui/inputs/Input.vue'
import StockSelect from '@/components/ui/inputs/StockSelect.vue'
import Modal from '@/components/ui/Modal.vue'
import UserPortfolioSelect from '@/components/user/portfolios/UserPortfolioSelect.vue'
import TransactionTypeSelect from '@/components/user/transactions/TransactionTypeSelect.vue'
import { useUserPortfolios } from '@/composables/useUserPortfolios'
import { createUserTransactionApi } from '@/lib/api/transaction-api'
import { minDecimalNumberRule, nonNegativeNumberRule, numberRequiredRule, stringRequiredRule } from '@/lib/validation/rules'
import { toTypedSchema } from '@vee-validate/zod'
import { useForm } from 'vee-validate'
import { ref } from 'vue'
import { useToast } from 'vue-toastification'
import { z } from 'zod'

const toast = useToast()
const { hasNoPortfolios, fetchUserPortfolios } = useUserPortfolios()

const createTransactionFormId = 'create-transaction-form'
const isModalOpen = ref(false)

const createTransactionSchema = toTypedSchema(
    z.object({
        portfolioId: numberRequiredRule(),
        transactionTypeId: z.preprocess((val) => (val === '' || val === undefined ? undefined : Number(val)), z.number().min(1, 'Transaction type is required')),
        stockSymbol: stringRequiredRule(),
        amount: minDecimalNumberRule(0.00000001),
        price: minDecimalNumberRule(0.00000001),
        date: stringRequiredRule(),
        fee: z.preprocess((val) => (val === '' || val === undefined || val === null ? 0 : Number(val)), nonNegativeNumberRule()),
    }),
)

const { handleSubmit, isSubmitting, meta, resetForm, values } = useForm({
    validationSchema: createTransactionSchema,
    initialValues: {
        portfolioId: undefined,
        transactionTypeId: undefined,
        stockSymbol: '',
        amount: undefined,
        price: undefined,
        date: new Date().toISOString().split('T')[0],
        fee: 0,
    },
})

const handleOpenModal = () => {
    if (!hasNoPortfolios()) {
        isModalOpen.value = true
    }
}

const submitCreateTransaction = handleSubmit(async (values) => {
    try {
        await createUserTransactionApi({
            portfolioId: values.portfolioId,
            transactionTypeId: values.transactionTypeId,
            stockSymbol: values.stockSymbol,
            amount: values.amount,
            price: values.price,
            date: values.date,
            fee: values.fee,
        })

        await fetchUserPortfolios()

        isModalOpen.value = false
        resetForm()
        toast.success('Transaction added successfully')
    } catch (error: any) {
        const errorMessage = 'Failed to add transaction. Please try again later.'
        toast.error(errorMessage)
        console.error(error)
    }
})
</script>
