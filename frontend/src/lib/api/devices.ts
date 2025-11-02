import { api } from '@/lib/client';
import type { Device } from '@/lib/types/device';

/**
 * Get all devices for the current user
 */
export async function getDevices(): Promise<Device[]> {
    const response = await api.get<{ devices: Device[] }>('/devices');
    return response.data.devices;
}

/**
 * Revoke access for a specific device
 */
export async function revokeDevice(deviceId: number): Promise<void> {
    await api.delete(`/devices/${deviceId}`);
}
