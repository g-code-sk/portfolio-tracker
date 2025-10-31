import { Capacitor } from '@capacitor/core';
import axios from 'axios';

const isNative = Capacitor.getPlatform() !== 'web';

export const api = axios.create({
    baseURL: isNative ? '/api' : '', // To be replaced with the actual API URL
    withCredentials: true,
});

export async function getTest() {
    const { data } = await api.get('/test');
    return data;
}
