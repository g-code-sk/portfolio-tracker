<template>
    <AuthLayout>
        <div class="p-8">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="mb-2 text-3xl font-bold text-gray-900">Portfolios</h1>
                </div>
                <UserAddPortfolioModal />
            </div>

            <div class="mt-8">
                <UserPortfolioList v-if="portfolios.length || isLoading" :portfolios="portfolios" :is-loading="isLoading" />
                <div v-else class="rounded-xl border border-dashed border-gray-200 bg-white p-8 text-center">
                    <p class="text-lg font-semibold text-gray-900">No portfolios yet</p>
                    <p class="mt-2 text-sm text-gray-500">Create your first portfolio to start tracking assets.</p>
                </div>
            </div>
        </div>
    </AuthLayout>
</template>

<script setup lang="ts">
import UserAddPortfolioModal from '@/components/user/portfolios/UserAddPortfolioModal.vue'
import UserPortfolioList from '@/components/user/portfolios/UserPortfolioList.vue'
import { useUserPortfolios } from '@/composables/useUserPortfolios'
import AuthLayout from '@/layouts/AuthLayout.vue'
import { onMounted } from 'vue'

const { portfolios, isLoading, fetchUserPortfolios } = useUserPortfolios()

onMounted(() => {
    fetchUserPortfolios()
})
</script>

<style scoped></style>
