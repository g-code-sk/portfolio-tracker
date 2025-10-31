<template>
    <ion-page>
        <ion-content class="ion-padding">
            <div class="flex min-h-screen items-center justify-center bg-gray-100">
                <div class="w-full max-w-md">
                    <!-- Logo/Title Section -->
                    <div class="mb-8 text-center">
                        <div class="mb-4 flex justify-center">
                            <div
                                class="flex h-16 w-16 items-center justify-center rounded-full bg-gradient-to-br from-blue-500 to-purple-600 text-2xl font-bold text-white"
                            >
                                PT
                            </div>
                        </div>
                        <h1 class="mb-2 text-3xl font-bold text-gray-900">Welcome Back</h1>
                        <p class="text-gray-600">Sign in to your Portfolio Tracker account</p>
                    </div>

                    <!-- Login Form Card -->
                    <div class="rounded-lg border border-gray-200 bg-white p-8 shadow-sm">
                        <form @submit.prevent="handleLogin">
                            <!-- Email Field -->
                            <div class="mb-4">
                                <label for="email" class="mb-2 block text-sm font-medium text-gray-700">Email</label>
                                <input
                                    id="email"
                                    v-model="email"
                                    type="email"
                                    required
                                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-900 transition-colors focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                    placeholder="you@example.com"
                                />
                            </div>

                            <!-- Password Field -->
                            <div class="mb-6">
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
                            <div class="mb-6 flex items-center">
                                <input
                                    id="remember"
                                    v-model="rememberMe"
                                    type="checkbox"
                                    class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-2 focus:ring-blue-500"
                                />
                                <label for="remember" class="ml-2 text-sm text-gray-700">Remember me</label>
                            </div>

                            <!-- Submit Button -->
                            <Button type="submit" color="primary" size="lg" :loading="isLoading" class="w-full">
                                {{ isLoading ? '' : 'Sign In' }}
                            </Button>

                            <!-- Error Message -->
                            <div v-if="errorMessage" class="mt-4 rounded-lg bg-red-50 p-3 text-sm text-red-600">
                                {{ errorMessage }}
                            </div>
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
        </ion-content>
    </ion-page>
</template>

<script setup lang="ts">
import Button from '@/components/ui/Button.vue';
import { IonContent, IonPage } from '@ionic/vue';
import { ref } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();

const email = ref('');
const password = ref('');
const rememberMe = ref(false);
const isLoading = ref(false);
const errorMessage = ref('');

const handleLogin = async () => {
    try {
        isLoading.value = true;
        errorMessage.value = '';

        // TODO: Implement actual login logic here
        // Example API call:
        // const response = await loginUser({ email: email.value, password: password.value });

        // Simulate API call
        await new Promise((resolve) => setTimeout(resolve, 1500));

        // On success, redirect to dashboard
        router.push('/app/dashboard');
    } catch (error) {
        errorMessage.value = 'Invalid email or password. Please try again.';
    } finally {
        isLoading.value = false;
    }
};
</script>
