<script setup>
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'

import EncadrantSidebar from '@/Components/Encadrant/EncadrantSidebar.vue'
import DashboardHeader from '@/Components/Encadrant/DashboardHeader.vue'

const page = usePage()

const user = computed(() => {
    return page.props.auth?.user ?? null
})
</script>

<template>
    <div class="flex min-h-screen bg-[#f5f7fb]">

        <!-- Sidebar -->
        <EncadrantSidebar />

        <!-- Main content -->
        <div class="flex min-w-0 flex-1 flex-col">

            <!-- Header -->
            <DashboardHeader
                v-if="user"
                :user="user"
            />

            <!-- Page content -->
            <main class="flex-1 overflow-x-hidden p-6">
                <slot />
            </main>

        </div>

    </div>
</template>
