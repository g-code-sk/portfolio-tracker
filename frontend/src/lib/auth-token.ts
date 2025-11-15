// Token storage key
const TOKEN_STORAGE_KEY = 'auth_token';

/**
 * Get the stored authentication token
 */
export function getStoredToken(): string | null {
    if (typeof window !== 'undefined') {
        return localStorage.getItem(TOKEN_STORAGE_KEY);
    }
    return null;
}

/**
 * Store an authentication token
 */
export function setStoredToken(token: string): void {
    if (typeof window !== 'undefined') {
        localStorage.setItem(TOKEN_STORAGE_KEY, token);
    }
}

/**
 * Remove the stored authentication token
 */
export function removeStoredToken(): void {
    if (typeof window !== 'undefined') {
        localStorage.removeItem(TOKEN_STORAGE_KEY);
    }
}

