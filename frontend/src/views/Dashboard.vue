<template>
    <ion-page>
        <ion-content class="ion-padding">
            <div class="p-8">
                <h1 class="mb-4 text-3xl font-bold text-gray-900">Dashboard</h1>
                <p class="mb-8 text-gray-600">Welcome to your portfolio tracker dashboard.</p>

                <!-- Button Examples -->
                <div class="space-y-8">
                    <!-- Colors -->
                    <div>
                        <h2 class="mb-4 text-xl font-semibold text-gray-900">Button Colors</h2>
                        <div class="flex flex-wrap gap-3">
                            <Button color="primary">Primary</Button>
                            <Button color="secondary">Secondary</Button>
                            <Button color="success">Success</Button>
                            <Button color="danger">Danger</Button>
                            <Button color="warning">Warning</Button>
                            <Button color="info">Info</Button>
                        </div>
                    </div>

                    <!-- Sizes -->
                    <div>
                        <h2 class="mb-4 text-xl font-semibold text-gray-900">Button Sizes</h2>
                        <div class="flex flex-wrap items-center gap-3">
                            <Button size="sm">Small</Button>
                            <Button size="md">Medium</Button>
                            <Button size="lg">Large</Button>
                            <Button size="xl">Extra Large</Button>
                        </div>
                    </div>

                    <!-- States -->
                    <div>
                        <h2 class="mb-4 text-xl font-semibold text-gray-900">Button States</h2>
                        <div class="flex flex-wrap gap-3">
                            <Button color="primary">Normal</Button>
                            <Button color="primary" :disabled="true">Disabled</Button>
                            <Button color="primary" :loading="isLoading" @click="simulateLoading">
                                {{ isLoading ? '' : 'Click to Load' }}
                            </Button>
                        </div>
                    </div>

                    <!-- Loading Examples -->
                    <div>
                        <h2 class="mb-4 text-xl font-semibold text-gray-900">Loading States</h2>
                        <div class="flex flex-wrap gap-3">
                            <Button color="primary" :loading="true" size="sm">Small Loading</Button>
                            <Button color="success" :loading="true" size="md">Medium Loading</Button>
                            <Button color="danger" :loading="true" size="lg">Large Loading</Button>
                        </div>
                    </div>
                </div>
            </div>
        </ion-content>
    </ion-page>
</template>

<script setup lang="ts">
import Button from '@/components/ui/Button.vue';
import { IonContent, IonPage } from '@ionic/vue';
import { ref } from 'vue';

const isLoading = ref(false);

const simulateLoading = () => {
    isLoading.value = true;
    setTimeout(() => {
        isLoading.value = false;
    }, 2000);
};
</script>
