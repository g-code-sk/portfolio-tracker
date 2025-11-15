import { login as apiLogin, logout as apiLogout, register as apiRegister, getCurrentUser } from '@/lib/api/auth-api'
import { getStoredToken } from '@/lib/auth-token'
import type { AuthActionResponse, LoginData as LoginPayloadData, LogoutActionResult, RegisterData as RegisterPayloadData, User } from '@/lib/types/auth-types'
import { computed, ref } from 'vue'
import { useRouter } from 'vue-router'

const user = ref<User | null>(null)
const isLoading = ref(false)
const isInitialized = ref(false)

export function useAuth() {
    const router = useRouter()

    const isAuthenticated = computed(() => user.value !== null)

    const initAuth = async (): Promise<void> => {
        if (isInitialized.value) return

        // Check if token exists first
        const token = getStoredToken()

        if (!token) {
            isInitialized.value = true
            return
        }

        isLoading.value = true

        try {
            const currentUser = await getCurrentUser()
            user.value = currentUser
        } catch (error) {
            user.value = null
        } finally {
            isLoading.value = false
            isInitialized.value = true
        }
    }

    const login = async (credentials: LoginPayloadData): Promise<AuthActionResponse> => {
        isLoading.value = true

        try {
            const response = await apiLogin(credentials)
            user.value = response.user

            return {
                success: true,
                user: response.user,
                message: null,
                errors: null,
            }
        } catch (error: any) {
            const message = error.response?.data?.message || 'Login failed. Please try again.'
            const errors = (error.response?.data?.errors as Record<string, string[]> | undefined) ?? null

            return {
                success: false,
                user: null,
                message: message,
                errors,
            }
        } finally {
            isLoading.value = false
        }
    }

    const register = async (data: RegisterPayloadData): Promise<AuthActionResponse> => {
        isLoading.value = true

        try {
            const response = await apiRegister(data)
            user.value = response.user

            return {
                success: true,
                user: response.user,
                message: null,
                errors: null,
            }
        } catch (error: any) {
            const message = error.response?.data?.message || 'Registration failed. Please try again.'
            const errors = (error.response?.data?.errors as Record<string, string[]> | undefined) ?? null

            return {
                success: false,
                user: null,
                message: message,
                errors,
            }
        } finally {
            isLoading.value = false
        }
    }

    const logout = async (): Promise<LogoutActionResult> => {
        isLoading.value = true

        try {
            await apiLogout()
            user.value = null

            return {
                success: true,
                message: 'Logged out successfully',
            }
        } catch (error: any) {
            return {
                success: false,
                message: error.response?.data?.message || 'Logout failed. Please try again.',
            }
        } finally {
            isLoading.value = false
        }
    }

    return {
        user,
        isAuthenticated,
        isLoading,
        isInitialized,
        login,
        register,
        logout,
        initAuth,
    }
}
