<template>
    <ion-page>
        <ion-content>
            <div class="flex min-h-screen">
                <!-- Top Navbar -->
                <Header />

                <!-- Left Sidebar -->
                <Sidebar />

                <!-- Main Content Area -->
                <main class="relative z-10 ml-64 min-h-[calc(100vh-72px)] flex-1 bg-gray-100 pt-[80px]">
                    <div class="mt-3">
                        <div v-if="breadcrumbItems" class="mx-3 mb-3">
                            <Breadcrumb :items="breadcrumbItems" />
                        </div>
                        <!-- <div class="mx-3 rounded-lg border border-gray-200 p-3"> -->
                        <div class="mx-3 p-3">
                            <slot />
                        </div>
                    </div>
                </main>
            </div>
        </ion-content>
    </ion-page>
</template>

<script setup lang="ts">
import Header from '@/components/navigation/Header.vue'
import Sidebar from '@/components/navigation/Sidebar.vue'
import Breadcrumb from '@/components/ui/Breadcrumb.vue'
import type { BreadcrumbItem } from '@/lib/types/generic-types'
import { IonContent, IonPage } from '@ionic/vue'

interface Props {
    breadcrumbItems?: BreadcrumbItem[]
}

defineProps<Props>()
</script>
