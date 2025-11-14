// Auth types
export interface RegisterData {
    name: string;
    email: string;
    password: string;
    password_confirmation: string;
}

export interface LoginData {
    email: string;
    password: string;
    remember?: boolean;
}

export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
}

export interface AuthResponse {
    message: string;
    user: User;
    token: string;
}

export interface AuthActionResponse {
    success: boolean;
    user: User | null;
    error: string | null;
    errors: Record<string, string[]> | null;
}

export interface LogoutActionResult {
    success: boolean;
    error: string | null;
}
