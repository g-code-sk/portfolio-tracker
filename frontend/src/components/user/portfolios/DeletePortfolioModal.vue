<template>
    <div>
        <Button color="danger" size="sm" @click="showModal = true">
            <TrashIcon />
            Delete Portfolio
        </Button>

        <Modal v-model="showModal" title="Delete Portfolio" :disabled="isDeleting" :close-on-backdrop="!isDeleting" show-cancel-button>
            <div class="space-y-4">
                <p class="text-sm text-gray-600">
                    Are you sure you want to delete this portfolio? This action will permanently delete the portfolio and all associated transactions.
                </p>
                <Alert type="error">This action cannot be undone.</Alert>
            </div>

            <template #footer>
                <Button color="danger" size="sm" :loading="isDeleting" @click="handleDelete">
                    <TrashIcon />
                    Delete Portfolio
                </Button>
            </template>
        </Modal>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useToast } from 'vue-toastification'

import Alert from '@/components/ui/Alert.vue'
import Button from '@/components/ui/Button.vue'
import TrashIcon from '@/components/ui/icons/TrashIcon.vue'
import Modal from '@/components/ui/Modal.vue'
import { useUserPortfolios } from '@/composables/useUserPortfolios'
import { deleteUserPortfolioApi } from '@/lib/api/portfolio-api'

const { fetchUserPortfolios } = useUserPortfolios()

const props = defineProps<{
    portfolioId: number
}>()

const router = useRouter()
const toast = useToast()

const showModal = ref(false)
const isDeleting = ref(false)

const handleDelete = async () => {
    try {
        isDeleting.value = true

        await deleteUserPortfolioApi(props.portfolioId)
        await fetchUserPortfolios(true)

        toast.success('Portfolio deleted successfully')
        showModal.value = false

        // Redirect to portfolios list
        await router.push('/portfolios')
    } catch (error) {
        toast.error('Unable to delete portfolio. Please try again.')
        console.error('Error deleting portfolio:', error)
    } finally {
        isDeleting.value = false
    }
}
</script>
