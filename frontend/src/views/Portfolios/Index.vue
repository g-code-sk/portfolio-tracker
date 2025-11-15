<template>
    <AuthLayout>
        <div class="p-8">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="mb-2 text-3xl font-bold text-gray-900">Portfolios</h1>
                </div>
                <AddPortfolioModal />
            </div>

            <div class="mt-8">
                <PortfolioListSkeleton v-if="isLoading" />
                <template v-else>
                    <PortfolioList v-if="portfolios.length" :portfolios="portfolios" />
                    <div v-else class="rounded-xl border border-dashed border-gray-200 bg-white p-8 text-center">
                        <p class="text-lg font-semibold text-gray-900">No portfolios yet</p>
                        <p class="mt-2 text-sm text-gray-500">Create your first portfolio to start tracking assets.</p>
                    </div>
                </template>
            </div>
        </div>
    </AuthLayout>
</template>

<script setup lang="ts">
import AddPortfolioModal from '@/components/user/portfolios/AddPortfolioModal.vue'
import PortfolioList from '@/components/user/portfolios/PortfolioList.vue'
import PortfolioListSkeleton from '@/components/user/portfolios/PortfolioListSkeleton.vue'
import { useUserPortfolios } from '@/composables/useUserPortfolios'
import AuthLayout from '@/layouts/AuthLayout.vue'
import { onMounted } from 'vue'

const { portfolios, isLoading, fetchPortfolios } = useUserPortfolios()

onMounted(() => {
    fetchPortfolios()
})
</script>

<style scoped></style>
