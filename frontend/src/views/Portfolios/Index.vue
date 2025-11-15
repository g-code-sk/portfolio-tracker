<template>
    <AuthLayout>
        <div class="p-8">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="mb-2 text-3xl font-bold text-gray-900">Portfolios</h1>
                </div>
                <div class="flex gap-3">
                    <Button color="primary" size="sm" @click="isAddPortfolioModalOpen = true"> Add Portfolio </Button>
                </div>
            </div>

            <!-- Portfolio List will go here -->
            <div class="mt-8">
                <p class="text-gray-600">Manage your investment portfolios here.</p>
                <p class="text-gray-500">No portfolios yet. Create your first one!</p>
            </div>
        </div>

        <Modal v-model="isAddPortfolioModalOpen" title="Create Portfolio" :show-cancel-button="true" :disabled="isSubmitting">
            <form :id="createPortfolioFormId" class="space-y-4" @submit.prevent="submitCreatePortfolio">
                <Input name="name" label="Portfolio Name" placeholder="e.g., Retirement Fund" autocomplete="off" />
                <Select name="currency" label="Base Currency" :options="currencyOptions" />
            </form>

            <template #footer>
                <Button color="primary" size="sm" type="submit" :form="createPortfolioFormId" :loading="isSubmitting" :disabled="!meta.valid || isSubmitting">
                    Save Portfolio
                </Button>
            </template>
        </Modal>
    </AuthLayout>
</template>

<script setup lang="ts">
import Button from '@/components/ui/Button.vue'
import Input from '@/components/ui/Input.vue'
import Modal from '@/components/ui/Modal.vue'
import Select, { SelectOption } from '@/components/ui/Select.vue'
import AuthLayout from '@/layouts/AuthLayout.vue'
import { stringRequiredRule } from '@/lib/validation/rules'
import { toTypedSchema } from '@vee-validate/zod'
import { useForm } from 'vee-validate'
import { ref } from 'vue'
import { z } from 'zod'

const createPortfolioFormId = 'create-portfolio-form'

const createPortfolioSchema = toTypedSchema(
    z.object({
        name: stringRequiredRule().max(80, 'Keep the name under 80 characters'),
        currency: z
            .string({ required_error: 'Base currency is required' })
            .transform((value) => value.trim().toUpperCase())
            .refine((value) => ['USD', 'EUR'].includes(value), 'Currency must be USD or EUR (for now)'),
    }),
)

const { handleSubmit, isSubmitting, meta, resetForm } = useForm({
    validationSchema: createPortfolioSchema,
    initialValues: {
        name: '',
        currency: 'USD',
    },
})

const isAddPortfolioModalOpen = ref(false)

const currencyOptions: SelectOption[] = [
    { label: 'US Dollar (USD)', value: 'USD' },
    { label: 'Euro (EUR)', value: 'EUR' },
]

const submitCreatePortfolio = handleSubmit(async (values) => {
    console.log('create portfolio payload', values)
    isAddPortfolioModalOpen.value = false
})
</script>

<style scoped></style>
