<template>
    <UserPortfolioListSkeleton v-if="isLoading" />
    <div v-else class="grid gap-4">
        <div
            v-for="portfolio in portfolios"
            :key="portfolio.id"
            class="hover:border-primary-200 rounded-xl border border-gray-200 bg-white p-5 shadow-sm transition hover:shadow-md"
        >
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-lg font-semibold text-gray-900">{{ portfolio.name }}</p>
                    <p class="text-sm text-gray-500">{{ portfolio.baseCurrency }} • {{ portfolio.assetCount }} assets</p>
                </div>
                <div class="text-right">
                    <p class="text-xl font-bold text-gray-900">
                        {{ formatCurrency(portfolio.totalValue, portfolio.baseCurrency) }}
                    </p>
                    <p class="text-sm font-semibold" :class="portfolio.changePct >= 0 ? 'text-emerald-600' : 'text-rose-600'">
                        {{ portfolio.changePct >= 0 ? '+' : '' }}{{ portfolio.changePct.toFixed(2) }}%
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'

import UserPortfolioListSkeleton from '@/components/user/portfolios/UserPortfolioListSkeleton.vue'
import type { UserPortfolioResource } from '@/lib/types/portfolio-types'

const props = withDefaults(
    defineProps<{
        portfolios: UserPortfolioResource[]
        isLoading?: boolean
    }>(),
    {
        isLoading: false,
    },
)

const formatCurrency = (value: number, currency: string) =>
    new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency,
        maximumFractionDigits: 0,
    }).format(value)

const portfolios = computed(() => props.portfolios)
</script>
