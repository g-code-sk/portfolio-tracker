<template>
    <div>
        <div class="flex gap-3">
            <Button color="primary" size="sm" @click="isModalOpen = true"> Add Portfolio </Button>
        </div>

        <Modal v-model="isModalOpen" title="Create Portfolio" :show-cancel-button="true" :disabled="isSubmitting">
            <form :id="createPortfolioFormId" class="space-y-4" @submit.prevent="submitCreatePortfolio">
                <Input name="name" label="Portfolio Name" placeholder="e.g., Retirement Fund" autocomplete="off" />
                <CurrencySelect name="currencyId" />
            </form>

            <template #footer>
                <Button color="primary" size="sm" type="submit" :form="createPortfolioFormId" :loading="isSubmitting" :disabled="!meta.valid || isSubmitting">
                    Save Portfolio
                </Button>
            </template>
        </Modal>
    </div>
</template>

<script setup lang="ts">
import Button from '@/components/ui/Button.vue'
import CurrencySelect from '@/components/ui/inputs/CurrencySelect.vue'
import Input from '@/components/ui/inputs/Input.vue'
import Modal from '@/components/ui/Modal.vue'
import { stringRequiredRule } from '@/lib/validation/rules'
import { toTypedSchema } from '@vee-validate/zod'
import { useForm } from 'vee-validate'
import { ref } from 'vue'
import { z } from 'zod'

import { useUserPortfolios } from '@/composables/useUserPortfolios'
import { createUserPortfolioApi } from '@/lib/api/portfolio-api'
import { useToast } from 'vue-toastification'

const { refreshUserPortfolios: refreshPortfolios } = useUserPortfolios()
const toast = useToast()

const createPortfolioFormId = 'create-portfolio-form'
const isModalOpen = ref(false)

const createPortfolioSchema = toTypedSchema(
    z.object({
        name: stringRequiredRule().max(80, 'Keep the name under 80 characters'),
        currencyId: z.number().min(1, 'Base currency is required'),
    }),
)

const { handleSubmit, isSubmitting, meta, resetForm } = useForm({
    validationSchema: createPortfolioSchema,
    initialValues: {
        name: '',
        currencyId: undefined,
    },
})

const submitCreatePortfolio = handleSubmit(async (values) => {
    try {
        await createUserPortfolioApi({
            name: values.name,
            currency_id: values.currencyId,
        })

        await refreshPortfolios()

        isModalOpen.value = false
        resetForm()
        toast.success('Portfolio created successfully')
    } catch (error) {
        toast.error('Failed to create portfolio. Please try again.')
        console.error(error)
    }
})
</script>
