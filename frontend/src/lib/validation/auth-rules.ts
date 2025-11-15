import { z } from 'zod'

export function emailRule(message = 'Enter a valid email address.') {
    return z.string().email(message)
}

export function passwordRule(minLength = 8, message = 'Password must be at least 8 characters long.') {
    return z.string().min(minLength, message)
}
