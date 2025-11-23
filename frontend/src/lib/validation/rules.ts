import z from 'zod'

export function stringRequiredRule(message = 'This field is required') {
    return z.string().min(1, message)
}

export function positiveNumberRule(message = 'Must be greater than 0') {
    return z.coerce.number().positive(message)
}

export function minDecimalNumberRule(min: number, message?: string) {
    return z.coerce.number().min(min, message || `Must be at least ${min}`)
}

export function numberRequiredRule(message = 'This field is required') {
    return z.number().min(1, message)
}

export function nonNegativeNumberRule(message = 'Must be 0 or greater') {
    return z.coerce.number().min(0, message)
}
