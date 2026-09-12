<script setup>
import { Head } from '@inertiajs/vue3'

import StagiaireLayout from '@/Components/Stagiaire/StagiaireLayout.vue'

import NotificationHeader from '@/Components/Stagiaire/Notifications/NotificationHeader.vue'
import NotificationFilters from '@/Components/Stagiaire/Notifications/NotificationFilters.vue'
import NotificationList from '@/Components/Stagiaire/Notifications/NotificationList.vue'
import NotificationPagination from '@/Components/Stagiaire/Notifications/NotificationPagination.vue'

defineProps({
    notifications: {
        type: Object,
        default: () => ({
            data: [],
            links: [],
            current_page: 1,
            last_page: 1,
            total: 0,
        }),
    },

    filters: {
        type: Object,
        default: () => ({
            filter: 'all',
        }),
    },

    unreadCount: {
        type: Number,
        default: 0,
    },
})
</script>

<template>
    <Head title="Notifications" />

    <StagiaireLayout>
        <div class="w-full">
            <NotificationHeader
                :unread-count="unreadCount"
            />

            <div
                class="overflow-hidden rounded-xl border border-slate-200
                       bg-white shadow-sm"
            >
                <NotificationFilters
                    :current-filter="filters.filter"
                />

                <NotificationList
                    :notifications="notifications.data"
                />

                <NotificationPagination
                    v-if="notifications.links && notifications.links.length > 3"
                    :links="notifications.links"
                />
            </div>
        </div>
    </StagiaireLayout>
</template>