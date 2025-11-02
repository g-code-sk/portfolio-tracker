import { login as apiLogin, logout as apiLogout, register as apiRegister, getCurrentUser } from '@/lib/api/auth';
import { getStoredToken } from '@/lib/auth-token';
import type { LoginData, RegisterData, User } from '@/lib/types/auth';
import { computed, ref } from 'vue';
import { useRouter } from 'vue-router';

const user = ref<User | null>(null);
const isLoading = ref(false);
const isInitialized = ref(false);

export function useAuth() {
    const router = useRouter();

    const isAuthenticated = computed(() => user.value !== null);

    const initAuth = async () => {
        if (isInitialized.value) return;

        // Check if token exists first
        const token = getStoredToken();
        if (!token) {
            isInitialized.value = true;
            return;
        }

        isLoading.value = true;
        try {
            const currentUser = await getCurrentUser();
            user.value = currentUser;
        } catch (error) {
            user.value = null;
        } finally {
            isLoading.value = false;
            isInitialized.value = true;
        }
    };

    const login = async (credentials: LoginData) => {
        isLoading.value = true;
        try {
            const response = await apiLogin(credentials);
            user.value = response.user;
            return { success: true, user: response.user };
        } catch (error: any) {
            const message = error.response?.data?.message || 'Login failed. Please try again.';
            return { success: false, error: message };
        } finally {
            isLoading.value = false;
        }
    };

    const register = async (data: RegisterData) => {
        isLoading.value = true;
        try {
            const response = await apiRegister(data);
            user.value = response.user;
            return { success: true, user: response.user };
        } catch (error: any) {
            const message = error.response?.data?.message || 'Registration failed. Please try again.';
            const errors = error.response?.data?.errors || {};
            return { success: false, error: message, errors };
        } finally {
            isLoading.value = false;
        }
    };

    const logout = async () => {
        isLoading.value = true;
        try {
            await apiLogout();
            user.value = null;
            router.push('/login');
            return { success: true };
        } catch (error: any) {
            const message = error.response?.data?.message || 'Logout failed. Please try again.';
            return { success: false, error: message };
        } finally {
            isLoading.value = false;
        }
    };

    return {
        user,
        isAuthenticated,
        isLoading,
        isInitialized,
        login,
        register,
        logout,
        initAuth,
    };
}
