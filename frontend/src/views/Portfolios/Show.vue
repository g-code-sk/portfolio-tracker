<template>
    <AuthLayout :breadcrumb-items="breadcrumbItems" :loading="isLoading">
        <div>
            <div v-if="isLoading" class="flex items-center justify-center py-12">
                <div class="border-t-primary-600 h-8 w-8 animate-spin rounded-full border-4 border-gray-200"></div>
            </div>
            <div v-else-if="portfolio" class="space-y-4">
                <div class="flex justify-end">
                    <Button color="danger" size="sm" class="inline-flex items-center gap-2">
                        <TrashIcon size="sm" />
                        Delete Portfolio
                    </Button>
                </div>

                <div v-if="transactions.length > 0" class="rounded-xl border border-gray-200 bg-white shadow-sm">
                    <div class="border-b border-gray-200 px-6 py-4">
                        <h2 class="text-lg font-semibold text-gray-900">Transactions</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-500 uppercase">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium tracking-wider text-gray-500 uppercase">Security</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium tracking-wider text-gray-500 uppercase">Amount</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium tracking-wider text-gray-500 uppercase">Price</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium tracking-wider text-gray-500 uppercase">Total</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium tracking-wider text-gray-500 uppercase">Fee</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                <tr v-for="transaction in transactions" :key="transaction.id" class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm whitespace-nowrap text-gray-900">
                                        {{ transaction.formattedDate }}
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <div>
                                            <div class="font-medium text-gray-900">{{ transaction.security.displaySymbol || transaction.security.symbol }}</div>
                                            <div class="text-gray-500">{{ transaction.security.description }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm whitespace-nowrap text-gray-900">
                                        {{ transaction.formattedAmount }}
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm whitespace-nowrap text-gray-900">
                                        {{ transaction.formattedPrice }}
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm font-medium whitespace-nowrap text-gray-900">
                                        {{ transaction.formattedTotal }}
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm whitespace-nowrap text-gray-500">
                                        {{ transaction.formattedFee }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <EmptyState v-else title="No transactions or positions" description="You don't have any transactions or positions in this portfolio yet." />
            </div>
        </div>
    </AuthLayout>
</template>

<script setup lang="ts">
import { computed, onMounted, ref } from 'vue'
import { useRoute } from 'vue-router'
import { useToast } from 'vue-toastification'

import Button from '@/components/ui/Button.vue'
import EmptyState from '@/components/ui/EmptyList.vue'
import TrashIcon from '@/components/ui/icons/TrashIcon.vue'
import AuthLayout from '@/layouts/AuthLayout.vue'
import { fetchUserPortfolioApi } from '@/lib/api/portfolio-api'
import { fetchUserPortfolioTransactionsApi } from '@/lib/api/transaction-api'
import type { UserPortfolioResource } from '@/lib/types/portfolio-types'
import type { UserTransactionResource } from '@/lib/types/transaction-types'

const route = useRoute()
const toast = useToast()

const portfolio = ref<UserPortfolioResource | null>(null)
const transactions = ref<UserTransactionResource[]>([])
const breadcrumbItems = computed(() => [{ label: 'Portfolios', to: '/portfolios' }, { label: portfolio.value?.name ?? null }])

const isLoading = ref(false)

onMounted(async () => {
    const portfolioId = Number(route.params.id)

    try {
        isLoading.value = true

        // Fetch portfolio and transactions in parallel
        const [portfolioData, transactionsData] = await Promise.all([fetchUserPortfolioApi(portfolioId), fetchUserPortfolioTransactionsApi(portfolioId)])

        portfolio.value = portfolioData
        transactions.value = transactionsData
    } catch (error) {
        toast.error('Unable to load portfolio data. Please try again.')
        console.error('Error fetching portfolio data:', error)
    } finally {
        isLoading.value = false
    }
})
</script>

<style scoped></style>
