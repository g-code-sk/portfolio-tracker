<template>
    <AuthLayout>
        <div class="p-8">
            <div v-if="isLoading" class="flex items-center justify-center py-12">
                <div class="border-t-primary-600 h-8 w-8 animate-spin rounded-full border-4 border-gray-200"></div>
            </div>
            <div v-else-if="portfolio" class="space-y-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ portfolio.name }}</h1>
                </div>

                <EmptyState title="No transactions or positions" description="You don't have any transactions or positions in this portfolio yet." />
            </div>
        </div>
    </AuthLayout>
</template>

<script setup lang="ts">
import { onMounted, ref } from 'vue'
import { useRoute } from 'vue-router'
import { useToast } from 'vue-toastification'

import EmptyState from '@/components/ui/EmptyList.vue'
import AuthLayout from '@/layouts/AuthLayout.vue'
import type { UserPortfolioResource } from '@/lib/types/portfolio-types'

const route = useRoute()
const toast = useToast()

const portfolio = ref<UserPortfolioResource | null>(null)
const isLoading = ref(false)

onMounted(async () => {
    const portfolioId = Number(route.params.id)
})
</script>

<style scoped></style>
