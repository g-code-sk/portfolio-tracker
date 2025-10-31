<template>
    <ion-app theme="light">
        <ion-router-outlet :animation="fadeAnimation"></ion-router-outlet>
    </ion-app>
</template>

<script setup lang="ts">
import { IonApp, IonRouterOutlet, createAnimation } from '@ionic/vue';
import { onMounted, ref } from 'vue';
import { getTest } from './lib/api';

// Fade animation for page transitions
const fadeAnimation = (baseEl: HTMLElement, opts?: any) => {
    const rootAnimation = createAnimation().duration(250).easing('ease-in-out');

    const enteringAnimation = createAnimation().addElement(opts.enteringEl).fromTo('opacity', '0', '1');

    const leavingAnimation = createAnimation().addElement(opts.leavingEl).fromTo('opacity', '1', '0');

    rootAnimation.addAnimation([enteringAnimation, leavingAnimation]);

    return rootAnimation;
};

const apiStatus = ref('');
const apiMessage = ref('');

onMounted(async () => {
    try {
        const data = await getTest();
        apiStatus.value = data.status ?? 'ok';
        apiMessage.value = data.message ?? '';
    } catch (e) {
        apiStatus.value = 'error';
        apiMessage.value = 'Failed to reach /api/test';
    }
});
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
