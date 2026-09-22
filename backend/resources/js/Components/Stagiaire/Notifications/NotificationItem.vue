<script setup>
import { router } from '@inertiajs/vue3'

const props = defineProps({
    notification: {
        type: Object,
        required: true,
    },
})

const title = () => {
    return (
        props.notification?.titre ||
        props.notification?.title ||
        props.notification?.data?.title ||
        'Notification'
    )
}

const description = () => {
    return (
        props.notification?.message ||
        props.notification?.description ||
        props.notification?.data?.message ||
        ''
    )
}

const date = () => {
    return (
        props.notification?.created_at ||
        props.notification?.date ||
        null
    )
}

const isUnread = () => {
    return (
        props.notification?.lu === false ||
        props.notification?.read_at === null ||
        props.notification?.is_read === false
    )
}

const formatDate = (value) => {
    if (!value) return ''

    const notificationDate = new Date(value)
    const now = new Date()

    const diff = now - notificationDate
    const minutes = Math.floor(diff / 60000)
    const hours = Math.floor(diff / 3600000)
    const days = Math.floor(diff / 86400000)

    if (minutes < 1) {
        return 'Just now'
    }

    if (minutes < 60) {
        return `${minutes} min ago`
    }

    if (hours < 24) {
        return `${hours} hr ago`
    }

    if (days === 1) {
        return 'Yesterday'
    }

    if (days < 7) {
        return `${days} days ago`
    }

    return notificationDate.toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric',
    })
}

const iconColor = () => {
    const type =
        props.notification?.type ||
        props.notification?.data?.type ||
        ''

    if (
        type.includes('interview') ||
        type.includes('reminder')
    ) {
        return 'bg-amber-50'
    }

    if (
        type.includes('match') ||
        type.includes('offer')
    ) {
        return 'bg-emerald-50'
    }

    if (
        type.includes('message') ||
        type.includes('rejected')
    ) {
        return 'bg-red-50'
    }

    return 'bg-blue-50'
}

const markAsRead = () => {
    if (!isUnread()) return

    router.patch(
        route('notifications.read', props.notification.id),
        {},
        {
            preserveScroll: true,
        }
    )
}
</script>

<template>
    <button
        type="button"
        @click="markAsRead"
        class="group flex w-full items-start gap-3
               border-b border-slate-100 px-4 py-3.5
               text-left transition last:border-b-0
               hover:bg-slate-50/70 sm:px-5"
    >
        <!-- Icon -->
        <div
            class="flex h-7 w-7 shrink-0 items-center
                   justify-center rounded-lg"
            :class="iconColor()"
        >
            <!-- Bell -->
            <svg
                class="h-3.5 w-3.5 text-[#2F6690]"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1.7"
                    d="M15 17h5l-1.5-1.5A2 2 0 0118 14v-3a6 6 0 00-12 0v3a2 2 0 01-.5 1.5L4 17h5m6 0a3 3 0 01-6 0m6 0H9"
                />
            </svg>
        </div>

        <!-- Content -->
        <div class="min-w-0 flex-1">
            <div class="flex items-start justify-between gap-3">
                <div class="min-w-0">
                    <p
                        class="truncate text-[10px] font-semibold
                               text-slate-800"
                    >
                        {{ title() }}
                    </p>

                    <p
                        v-if="description()"
                        class="mt-0.5 truncate text-[9px]
                               text-slate-500"
                    >
                        {{ description() }}
                    </p>

                    <p
                        class="mt-1 text-[8px] text-slate-400"
                    >
                        {{ formatDate(date()) }}
                    </p>
                </div>

                <!-- Unread indicator -->
                <span
                    v-if="isUnread()"
                    class="mt-1.5 h-1.5 w-1.5 shrink-0
                           rounded-full bg-blue-500"
                ></span>
            </div>
        </div>
    </button>
</template>