<template>
    <header class="fixed top-0 right-0 left-0 z-50 border-b border-gray-200 bg-white shadow-sm">
        <div class="flex items-center justify-between px-6 py-4">
            <div class="flex items-center space-x-4">
                <h1 class="text-2xl font-bold text-gray-900">Portfolio Tracker</h1>
            </div>
            <div class="flex items-center space-x-4">
                <span v-if="user" class="text-sm text-gray-600">{{ user.name }}</span>
                <button class="rounded-lg bg-transparent px-4 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-100 hover:text-gray-900">
                    Settings
                </button>
                <button
                    @click="handleLogout"
                    class="rounded-lg bg-transparent px-4 py-2 text-sm font-medium text-red-600 transition-colors hover:bg-red-50 hover:text-red-700"
                >
                    Logout
                </button>
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-blue-500 to-purple-600 font-semibold text-white">
                    {{ userInitial }}
                </div>
            </div>
        </div>
    </header>
</template>

<script setup lang="ts">
import { useAuth } from '@/composables/useAuth'
import { computed } from 'vue'
import { useRouter } from 'vue-router'
import { useToast } from 'vue-toastification'

const { user, logout } = useAuth()
const toast = useToast()
const router = useRouter()

const userInitial = computed(() => {
    return user.value?.name?.charAt(0).toUpperCase() || 'U'
})

const handleLogout = async () => {
    const result = await logout()

    if (result.success) {
        toast.success(result.message)
        router.push('/login')
        return
    }

    toast.error(result.message)
}
</script>
