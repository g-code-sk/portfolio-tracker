<template>
    <AuthLayout>
        <div class="p-8">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="mb-2 text-3xl font-bold text-gray-900">Portfolios</h1>
                </div>
                <div class="flex gap-3">
                    <UserAddTransactionModal />
                    <UserAddPortfolioModal />
                </div>
            </div>

            <div class="mt-8">
                <UserPortfolioList v-if="portfolios.length || isLoading" :portfolios="portfolios" :is-loading="isLoading" />
                <EmptyList v-else title="No portfolios yet" description="Create your first portfolio to start tracking assets." />
            </div>
        </div>
    </AuthLayout>
</template>

<script setup lang="ts">
import EmptyList from '@/components/ui/EmptyList.vue'
import UserAddPortfolioModal from '@/components/user/portfolios/UserAddPortfolioModal.vue'
import UserPortfolioList from '@/components/user/portfolios/UserPortfolioList.vue'
import UserAddTransactionModal from '@/components/user/transactions/UserAddTransactionModal.vue'
import { useUserPortfolios } from '@/composables/useUserPortfolios'
import AuthLayout from '@/layouts/AuthLayout.vue'
import { onMounted } from 'vue'

const { portfolios, isLoading, fetchUserPortfolios } = useUserPortfolios()

onMounted(() => {
    fetchUserPortfolios()
})
</script>

<style scoped></style>
