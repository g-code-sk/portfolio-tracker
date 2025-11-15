import z from 'zod'

export function stringRequiredRule(message = 'This field is required') {
    return z.string().min(1, message)
}
