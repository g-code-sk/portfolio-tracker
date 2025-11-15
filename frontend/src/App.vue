<template>
    <ion-app theme="light">
        <ion-router-outlet></ion-router-outlet>
    </ion-app>
</template>

<script setup lang="ts">
import { IonApp, IonRouterOutlet } from '@ionic/vue';
</script>

<style>
/* Override Ionic's default text colors */
ion-page {
    --color: #111827;
    color: #111827;
}

ion-content {
    --color: #111827;
    color: #111827;
}
</style>

<style scoped></style>
