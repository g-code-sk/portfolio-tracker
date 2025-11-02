<template>
    <NonAuthLayout>
        <div class="flex min-h-screen items-center justify-center bg-gray-100">
            <div class="w-full max-w-md">
                <!-- Logo/Title Section -->
                <div class="mb-8 text-center">
                    <div class="mb-4 flex justify-center">
                        <Logo />
                    </div>
                    <h1 class="mb-2 text-3xl font-bold text-gray-900">Create Account</h1>
                    <p class="text-gray-600">Start tracking your portfolio today</p>
                </div>

                <div class="rounded-lg border border-gray-200 bg-white p-8 shadow-sm">
                    <form @submit.prevent="handleRegister">
                        <Input id="name" v-model="name" type="text" label="Full Name" placeholder="John Doe" required />
                        <Input id="email" v-model="email" type="email" label="Email" placeholder="you@example.com" required />

                        <Input
                            id="password"
                            v-model="password"
                            type="password"
                            label="Password"
                            placeholder="••••••••"
                            required
                            :minlength="8"
                            hint="Must be at least 8 characters"
                        />

                        <Input id="confirmPassword" v-model="confirmPassword" type="password" label="Confirm Password" placeholder="••••••••" required />

                        <Checkbox id="terms" v-model="acceptTerms" required label="I agree to the Terms and Conditions and Privacy Policy">
                            I agree to the
                            <a href="#" class="font-medium text-blue-600 transition-colors hover:text-blue-700">Terms and Conditions</a>
                            and
                            <a href="#" class="font-medium text-blue-600 transition-colors hover:text-blue-700">Privacy Policy</a>
                        </Checkbox>

                        <Button type="submit" color="primary" size="lg" :loading="isLoading" class="w-full">
                            {{ isLoading ? '' : 'Create Account' }}
                        </Button>
                    </form>
                </div>

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
const { register, isLoading } = useAuth();
const toast = useToast();

const name = ref('');
const email = ref('');
const password = ref('');
const confirmPassword = ref('');
const acceptTerms = ref(false);

const handleRegister = async () => {
    try {
        // Validate passwords match
        if (password.value !== confirmPassword.value) {
            toast.error('Passwords do not match.');
            return;
        }

        // Validate password strength
        if (password.value.length < 8) {
            toast.error('Password must be at least 8 characters long.');
            return;
        }

        const result = await register({
            name: name.value,
            email: email.value,
            password: password.value,
            password_confirmation: confirmPassword.value,
        });

        if (result.success) {
            // On success
            toast.success('Account created successfully! Redirecting...');

            // Redirect to dashboard after a short delay
            setTimeout(() => {
                router.push('/app/dashboard');
            }, 1500);
        } else {
            // Handle validation errors
            if (result.errors) {
                const errors = result.errors as Record<string, string[]>;
                const firstError = Object.values(errors)[0]?.[0];
                toast.error(firstError || result.error || 'Failed to create account. Please try again.');
            } else {
                toast.error(result.error || 'Failed to create account. Please try again.');
            }
        }
    } catch (error) {
        toast.error('An unexpected error occurred. Please try again.');
    }
};
</script>
