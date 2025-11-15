import { Capacitor } from '@capacitor/core';

const isNative = Capacitor.getPlatform() !== 'web';

export const isNativePlatform = isNative;

/**
 * Get device name for token identification
 */
export function getDeviceName(): string {
    if (isNativePlatform) {
        return 'Mobile App';
    }

    const ua = navigator.userAgent;
    if (ua.includes('Chrome')) return 'Chrome Browser';
    if (ua.includes('Firefox')) return 'Firefox Browser';
    if (ua.includes('Safari')) return 'Safari Browser';
    if (ua.includes('Edge')) return 'Edge Browser';

    return 'Web Browser';
}
