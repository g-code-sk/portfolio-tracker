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
                    <form @submit.prevent="onSubmit">
                        <Input name="name" label="Full Name" placeholder="John Doe" autocomplete="name" />

                        <Input name="email" type="email" label="Email" placeholder="you@example.com" autocomplete="email" />

                        <Input name="password" type="password" label="Password" placeholder="••••••••" hint="Must be at least 8 characters" autocomplete="new-password" />

                        <Input name="confirmPassword" type="password" label="Confirm Password" placeholder="••••••••" autocomplete="new-password" />

                        <Checkbox name="acceptTerms" label="I agree to the Terms and Conditions and Privacy Policy">
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
import Button from '@/components/ui/Button.vue'
import Checkbox from '@/components/ui/Checkbox.vue'
import Input from '@/components/ui/inputs/Input.vue'
import Logo from '@/components/ui/Logo.vue'
import { useAuth } from '@/composables/useAuth'
import NonAuthLayout from '@/layouts/NonAuthLayout.vue'
import { emailRule, passwordRule } from '@/lib/validation/auth-rules'
import { stringRequiredRule } from '@/lib/validation/rules'
import { toTypedSchema } from '@vee-validate/zod'
import { useForm } from 'vee-validate'
import { useRouter } from 'vue-router'
import { useToast } from 'vue-toastification'
import { z } from 'zod'

const router = useRouter()
const { register, isLoading } = useAuth()
const toast = useToast()

const registerSchema = toTypedSchema(
    z
        .object({
            name: stringRequiredRule(),
            email: emailRule(),
            password: passwordRule(),
            confirmPassword: passwordRule(8, 'Please confirm your password.'),
            acceptTerms: z.boolean().refine((value) => value === true, 'You must accept the Terms and Conditions.'),
        })
        .refine((data) => data.password === data.confirmPassword, {
            message: 'Passwords do not match.',
            path: ['confirmPassword'],
        }),
)

const { handleSubmit, values } = useForm({
    validationSchema: registerSchema,
    initialValues: {
        name: '',
        email: '',
        password: '',
        confirmPassword: '',
        acceptTerms: false,
    },
})

const onSubmit = handleSubmit(async (values) => {
    const result = await register({
        name: values.name,
        email: values.email,
        password: values.password,
        password_confirmation: values.confirmPassword,
    })

    if (result.success) {
        toast.success('Account created successfully!')
        router.push('/dashboard')
        return
    }

    toast.error(result.message)
})
</script>
