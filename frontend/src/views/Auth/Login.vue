<template>
    <NonAuthLayout>
        <div class="flex min-h-screen items-center justify-center bg-gray-100">
            <div class="w-full max-w-md">
                <div class="mb-8 text-center">
                    <div class="mb-4 flex justify-center">
                        <Logo />
                    </div>
                    <h1 class="mb-2 text-3xl font-bold text-gray-900">Welcome Back</h1>
                    <p class="text-gray-600">Sign in to your Portfolio Tracker account</p>
                </div>

                <div class="rounded-lg border border-gray-200 bg-white p-8 shadow-sm">
                    <form @submit.prevent="handleLogin">
                        <Input name="email" type="email" label="Email" placeholder="you@example.com" autocomplete="email" />

                        <div class="mb-4">
                            <div class="mb-2 flex items-center justify-between">
                                <label for="password" class="text-sm font-medium text-gray-700">Password</label>
                                <a href="#" class="text-sm font-medium text-blue-600 transition-colors hover:text-blue-700">Forgot password?</a>
                            </div>
                            <Input name="password" type="password" placeholder="••••••••" autocomplete="current-password" />
                        </div>

                        <!-- <Checkbox name="remember" label="Remember me" /> -->

                        <Button type="submit" color="primary" size="lg" :loading="isLoading" class="w-full">
                            {{ isLoading ? '' : 'Sign In' }}
                        </Button>
                    </form>
                </div>

                <div class="mt-6 text-center text-sm text-gray-600">
                    Don't have an account?
                    <router-link to="/register" class="font-medium text-blue-600 transition-colors hover:text-blue-700">Sign up</router-link>
                </div>

                <div class="mt-4 text-center text-sm text-gray-600">
                    <router-link to="/" class="font-medium text-gray-700 transition-colors hover:text-gray-900">← Back to Home</router-link>
                </div>
            </div>
        </div>
    </NonAuthLayout>
</template>

<script setup lang="ts">
import Button from '@/components/ui/Button.vue'
import Input from '@/components/ui/inputs/Input.vue'
import Logo from '@/components/ui/Logo.vue'
import { useAuth } from '@/composables/useAuth'
import NonAuthLayout from '@/layouts/NonAuthLayout.vue'
import { emailRule, passwordRule } from '@/lib/validation/auth-rules'
import { toTypedSchema } from '@vee-validate/zod'
import { useForm } from 'vee-validate'
import { useRouter } from 'vue-router'
import { useToast } from 'vue-toastification'
import { z } from 'zod'

const router = useRouter()
const { login, isLoading } = useAuth()
const toast = useToast()

const loginSchema = toTypedSchema(
    z.object({
        email: emailRule(),
        password: passwordRule(),
        // remember: z.boolean().optional().default(false),
    }),
)

const { handleSubmit } = useForm({
    validationSchema: loginSchema,
    initialValues: {
        email: '',
        password: '',
        // remember: false,
    },
})

const handleLogin = handleSubmit(async (values) => {
    const result = await login({
        email: values.email,
        password: values.password,
        // remember: values.remember,
    })

    if (result.success) {
        toast.success('Welcome back! Redirecting...')
        router.push('/dashboard')
        return
    }

    toast.error(result.message)
})
</script>
