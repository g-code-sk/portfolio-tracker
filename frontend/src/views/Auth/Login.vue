<template>
    <NonAuthLayout>
        <div class="flex min-h-screen items-center justify-center bg-gray-100">
            <div class="w-full max-w-md">
                <!-- Logo/Title Section -->
                <div class="mb-8 text-center">
                    <div class="mb-4 flex justify-center">
                        <Logo />
                    </div>
                    <h1 class="mb-2 text-3xl font-bold text-gray-900">Welcome Back</h1>
                    <p class="text-gray-600">Sign in to your Portfolio Tracker account</p>
                </div>

                <!-- Login Form Card -->
                <div class="rounded-lg border border-gray-200 bg-white p-8 shadow-sm">
                    <form @submit.prevent="handleLogin">
                        <!-- Email Field -->
                        <Input id="email" v-model="email" type="email" label="Email" placeholder="you@example.com" required />

                        <!-- Password Field -->
                        <div class="mb-4">
                            <div class="mb-2 flex items-center justify-between">
                                <label for="password" class="text-sm font-medium text-gray-700">Password</label>
                                <a href="#" class="text-sm font-medium text-blue-600 transition-colors hover:text-blue-700">Forgot password?</a>
                            </div>
                            <input
                                id="password"
                                v-model="password"
                                type="password"
                                required
                                class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-900 transition-colors focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                placeholder="••••••••"
                            />
                        </div>

                        <!-- Remember Me -->
                        <Checkbox id="remember" v-model="rememberMe" label="Remember me" />

                        <!-- Submit Button -->
                        <Button type="submit" color="primary" size="lg" :loading="isLoading" class="w-full">
                            {{ isLoading ? '' : 'Sign In' }}
                        </Button>
                    </form>
                </div>

                <!-- Sign Up Link -->
                <div class="mt-6 text-center text-sm text-gray-600">
                    Don't have an account?
                    <router-link to="/register" class="font-medium text-blue-600 transition-colors hover:text-blue-700">Sign up</router-link>
                </div>

                <!-- Back to Home Link -->
                <div class="mt-4 text-center text-sm text-gray-600">
                    <router-link to="/" class="font-medium text-gray-700 transition-colors hover:text-gray-900">← Back to Home</router-link>
                </div>
            </div>
        </div>
    </NonAuthLayout>
</template>

<script setup lang="ts">
import Button from '@/components/ui/Button.vue';
import Checkbox from '@/components/ui/Checkbox.vue';
import Input from '@/components/ui/Input.vue';
import Logo from '@/components/ui/Logo.vue';
import { useAuth } from '@/composables/useAuth';
import NonAuthLayout from '@/layouts/NonAuthLayout.vue';
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { useToast } from 'vue-toastification';

const router = useRouter();
const { login, isLoading } = useAuth();
const toast = useToast();

const email = ref('');
const password = ref('');
const rememberMe = ref(false);

const handleLogin = async () => {
    try {
        const result = await login({
            email: email.value,
            password: password.value,
            remember: rememberMe.value,
        });

        if (result.success) {
            toast.success('Welcome back! Redirecting...');
            // On success, redirect to dashboard
            setTimeout(() => {
                router.push('/app/dashboard');
            }, 500);
        } else {
            toast.error(result.error || 'Invalid email or password. Please try again.');
        }
    } catch (error) {
        toast.error('An unexpected error occurred. Please try again.');
    }
};
</script>
