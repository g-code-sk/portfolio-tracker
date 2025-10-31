<template>
    <ion-page>
        <ion-content class="ion-padding">
            <div class="flex min-h-screen items-center justify-center bg-gray-100">
                <div class="w-full max-w-lg text-center">
                    <!-- Logo/Brand Section -->
                    <div class="mb-8">
                        <div class="mb-6 flex justify-center">
                            <div
                                class="flex h-24 w-24 items-center justify-center rounded-full bg-gradient-to-br from-blue-500 to-purple-600 text-4xl font-bold text-white shadow-lg"
                            >
                                PT
                            </div>
                        </div>
                        <h1 class="mb-4 text-5xl font-bold text-gray-900">Portfolio Tracker</h1>
                        <p class="mb-2 text-xl text-gray-600">Track, analyze, and grow your investments</p>
                        <p class="text-gray-500">Manage your portfolio with ease and confidence</p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-12 flex flex-col gap-4 px-8">
                        <Button color="primary" size="xl" @click="goToLogin" class="w-full shadow-lg"> Sign In </Button>
                        <Button color="secondary" size="xl" @click="goToRegister" class="w-full shadow-lg"> Create Account </Button>
                    </div>

                    <!-- Features Section -->
                    <div class="mt-16 grid grid-cols-1 gap-6 px-8 md:grid-cols-3">
                        <div class="rounded-lg bg-white p-6 shadow-sm">
                            <div class="mb-3 flex justify-center">
                                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-100">
                                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"
                                        ></path>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="mb-2 font-semibold text-gray-900">Real-time Tracking</h3>
                            <p class="text-sm text-gray-600">Monitor your investments in real-time with live data</p>
                        </div>

                        <div class="rounded-lg bg-white p-6 shadow-sm">
                            <div class="mb-3 flex justify-center">
                                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-purple-100">
                                    <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                                        ></path>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="mb-2 font-semibold text-gray-900">Performance Analytics</h3>
                            <p class="text-sm text-gray-600">Detailed insights into your portfolio performance</p>
                        </div>

                        <div class="rounded-lg bg-white p-6 shadow-sm">
                            <div class="mb-3 flex justify-center">
                                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-green-100">
                                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                                        ></path>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="mb-2 font-semibold text-gray-900">Secure & Private</h3>
                            <p class="text-sm text-gray-600">Your data is encrypted and protected</p>
                        </div>
                    </div>
                </div>
            </div>
        </ion-content>
    </ion-page>
</template>

<script setup lang="ts">
import Button from '@/components/ui/Button.vue';
import { IonContent, IonPage } from '@ionic/vue';
import { useRouter } from 'vue-router';

const router = useRouter();

const goToLogin = () => {
    router.push('/login');
};

const goToRegister = () => {
    router.push('/register');
};
</script>
