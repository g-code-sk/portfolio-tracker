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
                        <h1 class="mb-2 text-3xl font-bold text-gray-900">Create Account</h1>
                        <p class="text-gray-600">Start tracking your portfolio today</p>
                    </div>

                    <!-- Register Form Card -->
                    <div class="rounded-lg border border-gray-200 bg-white p-8 shadow-sm">
                        <form @submit.prevent="handleRegister">
                            <!-- Name Field -->
                            <div class="mb-4">
                                <label for="name" class="mb-2 block text-sm font-medium text-gray-700">Full Name</label>
                                <input
                                    id="name"
                                    v-model="name"
                                    type="text"
                                    required
                                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-900 transition-colors focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                    placeholder="John Doe"
                                />
                            </div>

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
                            <div class="mb-4">
                                <label for="password" class="mb-2 block text-sm font-medium text-gray-700">Password</label>
                                <input
                                    id="password"
                                    v-model="password"
                                    type="password"
                                    required
                                    minlength="8"
                                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-900 transition-colors focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                    placeholder="••••••••"
                                />
                                <p class="mt-1 text-xs text-gray-500">Must be at least 8 characters</p>
                            </div>

                            <!-- Confirm Password Field -->
                            <div class="mb-6">
                                <label for="confirmPassword" class="mb-2 block text-sm font-medium text-gray-700">Confirm Password</label>
                                <input
                                    id="confirmPassword"
                                    v-model="confirmPassword"
                                    type="password"
                                    required
                                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-gray-900 transition-colors focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                    placeholder="••••••••"
                                />
                            </div>

                            <!-- Terms and Conditions -->
                            <div class="mb-6 flex items-start">
                                <input
                                    id="terms"
                                    v-model="acceptTerms"
                                    type="checkbox"
                                    required
                                    class="mt-1 h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-2 focus:ring-blue-500"
                                />
                                <label for="terms" class="ml-2 text-sm text-gray-700">
                                    I agree to the
                                    <a href="#" class="font-medium text-blue-600 transition-colors hover:text-blue-700">Terms and Conditions</a>
                                    and
                                    <a href="#" class="font-medium text-blue-600 transition-colors hover:text-blue-700">Privacy Policy</a>
                                </label>
                            </div>

                            <!-- Submit Button -->
                            <Button type="submit" color="primary" size="lg" :loading="isLoading" class="w-full">
                                {{ isLoading ? '' : 'Create Account' }}
                            </Button>

                            <!-- Error Message -->
                            <div v-if="errorMessage" class="mt-4 rounded-lg bg-red-50 p-3 text-sm text-red-600">
                                {{ errorMessage }}
                            </div>

                            <!-- Success Message -->
                            <div v-if="successMessage" class="mt-4 rounded-lg bg-green-50 p-3 text-sm text-green-600">
                                {{ successMessage }}
                            </div>
                        </form>
                    </div>

                    <!-- Sign In Link -->
                    <div class="mt-6 text-center text-sm text-gray-600">
                        Already have an account?
                        <router-link to="/login" class="font-medium text-blue-600 transition-colors hover:text-blue-700">Sign in</router-link>
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

const name = ref('');
const email = ref('');
const password = ref('');
const confirmPassword = ref('');
const acceptTerms = ref(false);
const isLoading = ref(false);
const errorMessage = ref('');
const successMessage = ref('');

const handleRegister = async () => {
    try {
        isLoading.value = true;
        errorMessage.value = '';
        successMessage.value = '';

        // Validate passwords match
        if (password.value !== confirmPassword.value) {
            errorMessage.value = 'Passwords do not match.';
            isLoading.value = false;
            return;
        }

        // Validate password strength
        if (password.value.length < 8) {
            errorMessage.value = 'Password must be at least 8 characters long.';
            isLoading.value = false;
            return;
        }

        // TODO: Implement actual registration logic here
        // Example API call:
        // const response = await registerUser({
        //     name: name.value,
        //     email: email.value,
        //     password: password.value,
        // });

        // Simulate API call
        await new Promise((resolve) => setTimeout(resolve, 1500));

        // On success
        successMessage.value = 'Account created successfully! Redirecting...';

        // Redirect to login or dashboard after a short delay
        setTimeout(() => {
            router.push('/login');
        }, 2000);
    } catch (error) {
        errorMessage.value = 'Failed to create account. Please try again.';
    } finally {
        isLoading.value = false;
    }
};
</script>
