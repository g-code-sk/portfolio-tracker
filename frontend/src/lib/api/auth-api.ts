import { getStoredToken, removeStoredToken, setStoredToken } from '@/lib/auth-token';
import { api } from '@/lib/client';
import type { AuthResponse, LoginData, RegisterData, User } from '@/lib/types/auth-types';
import { getDeviceName } from '@/lib/utils';

/**
 * Register a new user
 */
export async function register(data: RegisterData): Promise<AuthResponse> {
    const response = await api.post<AuthResponse>('/register', {
        ...data,
        device_name: getDeviceName(),
    });

    // Store the token
    setStoredToken(response.data.token);

    return response.data;
}

/**
 * Login an existing user
 */
export async function login(data: LoginData): Promise<AuthResponse> {
    const response = await api.post<AuthResponse>('/login', {
        ...data,
        device_name: getDeviceName(),
    });

    // Store the token
    setStoredToken(response.data.token);

    return response.data;
}

/**
 * Logout the current user
 */
export async function logout(): Promise<{ message: string }> {
    const response = await api.post<{ message: string }>('/logout');

    // Remove the token
    removeStoredToken();

    return response.data;
}

/**
 * Logout from all devices
 */
export async function logoutAll(): Promise<{ message: string }> {
    const response = await api.post<{ message: string }>('/logout-all');

    // Remove the token
    removeStoredToken();

    return response.data;
}

/**
 * Get the current authenticated user
 */
export async function getCurrentUser(): Promise<User | null> {
    try {
        const token = getStoredToken();
        if (!token) {
            return null;
        }

        const response = await api.get<{ user: User }>('/user');
        return response.data.user;
    } catch (error) {
        return null;
    }
}
