<template>
    <div>
        <div class="relative flex items-center gap-3">
            <Button color="primary" size="sm" :disabled="hasNoPortfolios" @click="handleOpenModal"> Add Transaction </Button>
            <InfoPopover v-if="hasNoPortfolios" type="info" title="No portfolios available" text="Create at least one portfolio before adding transactions." />
        </div>

        <Modal v-model="isModalOpen" title="Add Transaction" :show-cancel-button="true" :disabled="isSubmitting">
            <form :id="createTransactionFormId" class="space-y-4" @submit.prevent="submitCreateTransaction">
                <UserPortfolioSelect name="portfolioId" />
                <StockSelect name="stockId" />
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
import InfoPopover from '@/components/ui/InfoPopover.vue'
import Input from '@/components/ui/inputs/Input.vue'
import StockSelect from '@/components/ui/inputs/StockSelect.vue'
import Modal from '@/components/ui/Modal.vue'
import UserPortfolioSelect from '@/components/user/portfolios/UserPortfolioSelect.vue'
import { useUserPortfolios } from '@/composables/useUserPortfolios'
import { stringRequiredRule } from '@/lib/validation/rules'
import { toTypedSchema } from '@vee-validate/zod'
import { useForm } from 'vee-validate'
import { computed, onMounted, ref } from 'vue'
import { useToast } from 'vue-toastification'
import { z } from 'zod'

const toast = useToast()
const { portfolios, fetchUserPortfolios } = useUserPortfolios()

const hasNoPortfolios = computed(() => portfolios.value.length === 0)

onMounted(async () => {
    await fetchUserPortfolios()
})

const createTransactionFormId = 'create-transaction-form'
const isModalOpen = ref(false)

const createTransactionSchema = toTypedSchema(
    z.object({
        portfolioId: z.coerce.number().min(1, 'Portfolio is required'),
        stockId: stringRequiredRule('Stock is required'),
        amount: z.coerce.number().min(0.01, 'Amount must be greater than 0'),
        price: z.coerce.number().min(0.01, 'Price must be greater than 0'),
        date: stringRequiredRule('Date is required'),
        fee: z.preprocess((val) => (val === '' || val === undefined || val === null ? 0 : Number(val)), z.number().min(0, 'Fee must be 0 or greater')),
    }),
)

const { handleSubmit, isSubmitting, meta, resetForm } = useForm({
    validationSchema: createTransactionSchema,
    initialValues: {
        portfolioId: undefined,
        stockId: '',
        amount: undefined,
        price: undefined,
        date: '',
        fee: 0,
    },
})

const handleOpenModal = () => {
    if (!hasNoPortfolios.value) {
        isModalOpen.value = true
    }
}

const submitCreateTransaction = handleSubmit(async (values) => {
    try {
        // TODO: Implement API call when backend is ready
        console.log('Transaction data:', values)

        isModalOpen.value = false
        resetForm()
        toast.success('Transaction added successfully')
    } catch (error) {
        toast.error('Failed to add transaction. Please try again.')
        console.error(error)
    }
})
</script>
