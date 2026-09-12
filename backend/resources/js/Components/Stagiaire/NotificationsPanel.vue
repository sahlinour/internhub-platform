<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    notifications: {
        type: Array,
        default: () => [],
    },
});

function notificationIcon(type) {
    if (type === 'success') return '✓';
    if (type === 'warning') return '!';
    if (type === 'error') return '×';

    return '•';
}

function notificationClass(type) {
    if (type === 'success') {
        return 'bg-emerald-50 text-emerald-600';
    }

    if (type === 'warning') {
        return 'bg-amber-50 text-amber-600';
    }

    if (type === 'error') {
        return 'bg-red-50 text-red-600';
    }

    return 'bg-[#EAF4F8] text-[#2F6690]';
}
</script>

<template>
    <section class="rounded-2xl border border-slate-200 bg-white p-5">
        <div class="mb-4 flex items-center justify-between">
            <div>
                <h2 class="font-bold text-slate-800">
                    Notifications
                </h2>

                <p class="mt-1 text-xs text-slate-400">
                    Vos dernières notifications
                </p>
            </div>

            <Link
                :href="route('notifications.index')"
                class="text-xs font-semibold text-[#2F6690] hover:text-[#16425B]"
            >
                Voir tout
            </Link>
        </div>

        <div
            v-if="notifications.length"
            class="space-y-3"
        >
            <div
                v-for="notification in notifications"
                :key="notification.id"
                class="flex gap-3 rounded-xl p-2 transition hover:bg-slate-50"
            >
                <div
                    class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full text-xs font-bold"
                    :class="notificationClass(notification.type)"
                >
                    {{ notificationIcon(notification.type) }}
                </div>

                <div class="min-w-0">
                    <p class="text-sm font-medium text-slate-700">
                        {{ notification.title || 'Notification' }}
                    </p>

                    <p
                        v-if="notification.message"
                        class="mt-0.5 line-clamp-2 text-xs text-slate-400"
                    >
                        {{ notification.message }}
                    </p>

                    <span
                        v-if="notification.created_at"
                        class="mt-1 block text-[11px] text-slate-300"
                    >
                        {{ notification.created_at }}
                    </span>
                </div>
            </div>
        </div>

        <div
            v-else
            class="py-8 text-center"
        >
            <div class="text-2xl">🔔</div>

            <p class="mt-2 text-sm text-slate-400">
                Aucune nouvelle notification.
            </p>
        </div>
    </section>
</template>