<template>
    <Teleport to="body">
        <Transition
            enter-active-class="duration-200 ease-out"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="duration-200 ease-in"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
            @enter="onEnter"
            @leave="onLeave"
        >
            <div v-if="modelValue" class="fixed inset-0 z-50 flex items-center justify-center">
                <div
                    class="absolute inset-0 bg-gray-900/60 transition-[backdrop-filter] duration-1000 ease-out"
                    :style="{ backdropFilter: `blur(${backdropBlur}px)` }"
                    @click="handleBackdropClick"
                ></div>
                <div class="relative z-10 w-full max-w-lg rounded-2xl bg-white shadow-2xl ring-1 ring-black/5" role="dialog" aria-modal="true">
                    <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
                        <div class="text-lg font-semibold text-gray-900">{{ title }}</div>

                        <button
                            type="button"
                            class="focus-visible:outline-primary-500 flex items-center justify-center rounded-full p-2 text-gray-400 transition hover:bg-gray-100 hover:text-gray-700 focus-visible:outline-2 focus-visible:outline-offset-2"
                            aria-label="Close modal"
                            @click="close"
                        >
                            <span class="sr-only">Close</span>
                            <IonIcon :icon="closeOutline" class="h-5 w-5" />
                        </button>
                    </div>

                    <div class="px-6 py-5">
                        <fieldset :disabled="disabled" class="border-none p-0">
                            <slot />
                        </fieldset>
                    </div>

                    <div class="border-t border-gray-100 px-6 py-4">
                        <div class="flex items-center justify-end gap-2">
                            <Button v-if="showCancelButton" color="secondary" size="sm" :disabled="disabled" @click="close">Cancel</Button>
                            <Button v-if="showCloseButton" color="secondary" size="sm" :disabled="disabled" @click="close">Close</Button>
                            <slot name="footer" />
                        </div>
                    </div>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>

<script setup lang="ts">
import Button from '@/components/ui/Button.vue'
import { IonIcon } from '@ionic/vue'
import { closeOutline } from 'ionicons/icons'
import { onBeforeUnmount, ref, watch } from 'vue'

const modelValue = defineModel<boolean>({
    default: false,
})

const props = withDefaults(
    defineProps<{
        title: string
        closeOnBackdrop?: boolean
        showCancelButton?: boolean
        showCloseButton?: boolean
        disabled?: boolean
    }>(),
    {
        closeOnBackdrop: true,
        showCancelButton: false,
        showCloseButton: false,
        disabled: false,
    },
)

const emit = defineEmits<{
    close: []
}>()

const backdropBlur = ref(0)

const onEnter = (el: Element) => {
    backdropBlur.value = 0
    // Use double requestAnimationFrame to ensure the element is rendered with blur(0) before transitioning
    requestAnimationFrame(() => {
        requestAnimationFrame(() => {
            backdropBlur.value = 2
        })
    })
}

const onLeave = () => {
    backdropBlur.value = 0
}

const close = () => {
    modelValue.value = false
    emit('close')
}

const handleBackdropClick = () => {
    if (props.closeOnBackdrop) {
        close()
    }
}

const handleKeydown = (event: KeyboardEvent) => {
    if (event.key === 'Escape' && modelValue.value) {
        close()
    }
}

const manageEscapeListener = (shouldListen: boolean) => {
    if (shouldListen) {
        window.addEventListener('keydown', handleKeydown)
    } else {
        window.removeEventListener('keydown', handleKeydown)
    }
}

watch(
    () => modelValue.value,
    (isOpen) => {
        manageEscapeListener(isOpen)
    },
    { immediate: true },
)

onBeforeUnmount(() => {
    manageEscapeListener(false)
})
</script>
