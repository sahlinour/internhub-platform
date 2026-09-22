<script setup>
import NotificationItem from './NotificationItem.vue'

defineProps({
    notifications: {
        type: Array,
        default: () => [],
    },
})
</script>

<template>
    <div>
        <!-- Notifications -->
        <NotificationItem
            v-for="notification in notifications"
            :key="notification.id"
            :notification="notification"
        />

        <!-- Empty -->
        <div
            v-if="!notifications.length"
            class="px-5 py-12 text-center"
        >
            <div
                class="mx-auto flex h-10 w-10 items-center
                       justify-center rounded-full bg-slate-100"
            >
                <svg
                    class="h-5 w-5 text-slate-400"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.7"
                        d="M15 17h5l-1.5-1.5A2 2 0 0118 14v-3a6 6 0 00-12 0v3a2 2 0 01-.5 1.5L4 17h5m6 0a3 3 0 01-6 0"
                    />
                </svg>
            </div>

            <p class="mt-3 text-xs font-medium text-slate-600">
                No notifications
            </p>

            <p class="mt-1 text-[10px] text-slate-400">
                You're all caught up.
            </p>
        </div>
    </div>
</template>