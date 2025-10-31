<template>
    <ion-page>
        <ion-content class="ion-padding">
            <div class="p-8">
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <h1 class="mb-2 text-3xl font-bold text-gray-900">Portfolios</h1>
                    </div>
                    <div class="flex gap-3">
                        <Button color="primary" size="sm" @click="handleAddPortfolio"> Add Portfolio </Button>
                    </div>
                </div>

                <!-- Portfolio List will go here -->
                <div class="mt-8">
                    <p class="text-gray-600">Manage your investment portfolios here.</p>
                    <p class="text-gray-500">No portfolios yet. Create your first one!</p>
                </div>
            </div>
        </ion-content>
    </ion-page>
</template>

<script setup lang="ts">
import Button from '@/components/ui/Button.vue';
import { IonContent, IonPage } from '@ionic/vue';

const handleAddPortfolio = () => {
    console.log('Add portfolio clicked');
    // TODO: Open modal or navigate to create portfolio page
};
</script>

<style scoped></style>
