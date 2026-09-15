<script setup>
import EncadrantSidebar from '@/Components/Encadrant/EncadrantSidebar.vue'
import DashboardHeader from '@/Components/Encadrant/DashboardHeader.vue'
import { usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

const page = usePage()

const user = computed(() => page.props.auth?.user ?? {})
</script>

<template>
    <div class="flex min-h-screen bg-[#f5f7fb]">

        <!-- Sidebar -->
        <EncadrantSidebar />

        <!-- Main area -->
        <div class="flex min-w-0 flex-1 flex-col">

            <!-- Top header -->
            <DashboardHeader :user="user" />

            <!-- Page -->
            <main class="flex-1 overflow-x-hidden p-6">
                <slot />
            </main>

        </div>

    </div>
</template>
