import { getStoredToken, removeStoredToken } from '@/lib/auth-token'
import { isNativePlatform } from '@/lib/utils'
import axios from 'axios'

/**
 * Determine the API base URL based on environment
 */
export const getBaseURL = (): string => {
    if (isNativePlatform) {
        return 'http://localhost:80/api'
    }
    // For web development, use the Laravel backend URL
    return import.meta.env.VITE_API_URL || 'https://portfolio-tracker.test/api'
}

/**
 * Axios instance configured with base URL and headers
 */
export const api = axios.create({
    baseURL: getBaseURL(),
    headers: {
        Accept: 'application/json',
        'Content-Type': 'application/json',
    },
})

// Add token to requests if it exists
api.interceptors.request.use(
    (config) => {
        const token = getStoredToken()
        if (token) {
            config.headers.Authorization = `Bearer ${token}`
        }
        return config
    },
    (error) => {
        return Promise.reject(error)
    },
)

// Handle 401 errors (invalid/expired token)
api.interceptors.response.use(
    (response) => response,
    (error) => {
        if (error.response?.status === 401) {
            // Token is invalid or expired, remove it
            removeStoredToken()
        }
        return Promise.reject(error)
    },
)
