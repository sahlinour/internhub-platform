<script setup>
import { router } from '@inertiajs/vue3'

const markAllAsRead = () => {
    router.patch(
        route('notifications.readAll'),
        {},
        {
            preserveScroll: true,
        }
    )
}
</script>

<template>
    <div
        class="mb-4 flex items-start justify-between gap-4"
    >
        <div>
            <h1 class="text-xl font-bold text-slate-800">
                Notifications
            </h1>

            <p class="mt-1 text-[10px] text-slate-400">
                Stay updated
            </p>
        </div>

        <button
            type="button"
            @click="markAllAsRead"
            class="shrink-0 rounded-lg border border-slate-200
                   bg-white px-3 py-2 text-[10px] font-semibold
                   text-slate-700 shadow-sm
                   transition hover:bg-slate-50"
        >
            Mark all as read
        </button>
    </div>
</template>