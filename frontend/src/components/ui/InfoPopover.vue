<template>
    <div>
        <button :id="triggerId" type="button" :class="buttonClasses" @click="togglePopover">
            <IonIcon :icon="iconForType" class="h-5 w-5" />
        </button>

        <IonPopover :is-open="isPopoverOpen" :event="popoverEvent" :trigger="triggerId" trigger-action="click" @didDismiss="isPopoverOpen = false">
            <IonContent class="ion-padding">
                <div class="space-y-1">
                    <div class="font-semibold text-gray-900">{{ title }}</div>
                    <div class="text-sm text-gray-600">{{ text }}</div>
                </div>
            </IonContent>
        </IonPopover>
    </div>
</template>

<script setup lang="ts">
import { IonContent, IonIcon, IonPopover } from '@ionic/vue'
import { alertCircle, informationCircle, warning } from 'ionicons/icons'
import { computed, ref, useId } from 'vue'

interface Props {
    type: 'info' | 'error' | 'warning'
    title: string
    text: string
    maxWidth?: string
}

const props = withDefaults(defineProps<Props>(), {
    maxWidth: '20rem',
})

const triggerId = useId()
const isPopoverOpen = ref(false)
const popoverEvent = ref<Event | null>(null)

const iconForType = computed(() => {
    const iconMap = {
        info: informationCircle,
        error: alertCircle,
        warning: warning,
    }
    return iconMap[props.type]
})

const buttonClasses = computed(() => {
    const baseClasses = 'flex h-6 w-6 items-center justify-center bg-transparent transition-colors'
    const colorClasses = {
        info: 'text-blue-400 hover:text-blue-600',
        error: 'text-red-400 hover:text-red-600',
        warning: 'text-yellow-400 hover:text-yellow-600',
    }
    return `${baseClasses} ${colorClasses[props.type]}`
})

const togglePopover = (event: Event) => {
    event.stopPropagation()
    popoverEvent.value = event
    isPopoverOpen.value = !isPopoverOpen.value
}
</script>

<style scoped>
ion-popover {
    --width: auto;
    --max-width: v-bind('props.maxWidth');
}
</style>
