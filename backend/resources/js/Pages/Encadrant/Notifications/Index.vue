<script setup>
import { Head, router } from '@inertiajs/vue3'

import EncadrantLayout from '@/Layouts/EncadrantLayout.vue'

defineProps({
    notifications: {
        type: Array,
        default: () => [],
    },

    unreadCount: {
        type: Number,
        default: 0,
    },
})

const markAsRead = (notification) => {
    if (!notification?.id || notification.lu) return

    router.patch(
        route('encadrant.notifications.read', {
            id: notification.id,
        }),
        {},
        {
            preserveScroll: true,
        }
    )
}

const markAllAsRead = () => {
    router.patch(
        route('encadrant.notifications.readAll'),
        {},
        {
            preserveScroll: true,
        }
    )
}

const deleteNotification = (notification) => {
    if (!notification?.id) return

    router.delete(
        route('encadrant.notifications.destroy', {
            id: notification.id,
        }),
        {
            preserveScroll: true,
        }
    )
}

const formatDate = (date) => {
    if (!date) return ''

    return new Intl.DateTimeFormat('en', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    }).format(new Date(date))
}
</script>

<template>
    <Head title="Notifications" />

    <EncadrantLayout>
        <div class="w-full p-6 lg:p-8">
            <!-- Header -->
            <div
                class="mb-7 flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between"
            >
                <div class="flex items-center gap-3">
                    <div
                        class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#F2F8FA] text-[#39719F]"
                    >
                        <svg
                            class="h-5 w-5"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            aria-hidden="true"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M18 8a6 6 0 00-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9M13.73 21a2 2 0 01-3.46 0"
                            />
                        </svg>
                    </div>

                    <div>
                        <h1
                            class="text-2xl font-bold tracking-tight text-[#072B4E]"
                        >
                            Notifications
                        </h1>

                        <p class="mt-0.5 text-sm text-[#507291]">
                            Keep track of your latest updates and activities.
                        </p>
                    </div>
                </div>

                <button
                    v-if="unreadCount > 0"
                    type="button"
                    class="inline-flex w-fit items-center justify-center gap-2 rounded-lg bg-[#39719F] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#072B4E] hover:shadow-md focus:outline-none focus:ring-2 focus:ring-[#60ADC6]/40"
                    @click="markAllAsRead"
                >
                    <svg
                        class="h-4 w-4"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        aria-hidden="true"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M5 13l4 4L19 7"
                        />
                    </svg>

                    Mark all as read
                </button>
            </div>

            <!-- Statistics -->
            <div class="mb-5 flex flex-wrap items-center gap-3">
                <div
                    class="inline-flex items-center gap-2 rounded-full border border-[#A9CEDB] bg-white px-3.5 py-1.5 text-xs font-medium text-[#507291]"
                >
                    <span
                        class="flex h-5 w-5 items-center justify-center rounded-full bg-[#F2F8FA] text-[10px] font-semibold text-[#072B4E]"
                    >
                        {{ notifications.length }}
                    </span>

                    Total notifications
                </div>

                <div
                    class="inline-flex items-center gap-2 rounded-full border px-3.5 py-1.5 text-xs font-medium"
                    :class="
                        unreadCount > 0
                            ? 'border-[#A9CEDB] bg-[#F2F8FA] text-[#39719F]'
                            : 'border-[#A9CEDB] bg-white text-[#6695AF]'
                    "
                >
                    <span
                        v-if="unreadCount > 0"
                        class="h-2 w-2 rounded-full bg-[#39719F]"
                    ></span>

                    {{ unreadCount }} unread
                </div>
            </div>

            <!-- Empty state -->
            <div
                v-if="notifications.length === 0"
                class="rounded-2xl border border-[#A9CEDB]/80 bg-white px-6 py-20 text-center shadow-sm"
            >
                <div
                    class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-[#F2F8FA] text-[#39719F]"
                >
                    <svg
                        class="h-7 w-7"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.7"
                        aria-hidden="true"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M18 8a6 6 0 00-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9M13.73 21a2 2 0 01-3.46 0"
                        />
                    </svg>
                </div>

                <h2 class="mt-5 text-base font-semibold text-[#072B4E]">
                    You're all caught up
                </h2>

                <p class="mx-auto mt-2 max-w-sm text-sm text-[#507291]">
                    New notifications about your interns, documents, tasks
                    and evaluations will appear here.
                </p>
            </div>

            <!-- Notification list -->
            <div v-else class="space-y-3">
                <article
                    v-for="notification in notifications"
                    :key="notification.id"
                    class="group relative overflow-hidden rounded-xl border bg-white shadow-sm transition duration-200 hover:-translate-y-[1px] hover:shadow-md"
                    :class="
                        !notification.lu
                            ? 'border-[#60ADC6]'
                            : 'border-[#A9CEDB]/70'
                    "
                >
                    <!-- Unread indicator -->
                    <div
                        v-if="!notification.lu"
                        class="absolute inset-y-0 left-0 w-1 bg-gradient-to-b from-[#39719F] to-[#60ADC6]"
                    ></div>

                    <div
                        class="flex items-start gap-4 px-5 py-5 sm:px-6"
                    >
                        <!-- Bell icon -->
                        <div
                            class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl"
                            :class="
                                !notification.lu
                                    ? 'bg-[#F2F8FA] text-[#39719F]'
                                    : 'bg-[#F2F8FA] text-[#6695AF]'
                            "
                        >
                            <svg
                                class="h-5 w-5"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M18 8a6 6 0 00-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9M13.73 21a2 2 0 01-3.46 0"
                                />
                            </svg>
                        </div>

                        <!-- Content -->
                        <div class="min-w-0 flex-1">
                            <div
                                class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between"
                            >
                                <div class="min-w-0">
                                    <!-- Title -->
                                    <div
                                        class="flex flex-wrap items-center gap-2"
                                    >
                                        <h3
                                            class="truncate text-sm text-[#072B4E]"
                                            :class="
                                                !notification.lu
                                                    ? 'font-semibold'
                                                    : 'font-medium'
                                            "
                                        >
                                            {{ notification.titre }}
                                        </h3>

                                        <span
                                            v-if="!notification.lu"
                                            class="h-2 w-2 shrink-0 rounded-full bg-[#39719F]"
                                        ></span>

                                        <span
                                            v-if="!notification.lu"
                                            class="rounded-full border border-[#A9CEDB] bg-[#F2F8FA] px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wide text-[#39719F]"
                                        >
                                            New
                                        </span>
                                    </div>

                                    <!-- Message -->
                                    <p
                                        class="mt-1.5 max-w-3xl text-sm leading-6 text-[#507291]"
                                    >
                                        {{ notification.message }}
                                    </p>

                                    <!-- Date -->
                                    <div
                                        class="mt-3 flex items-center gap-1.5 text-xs text-[#6695AF]"
                                    >
                                        <svg
                                            class="h-3.5 w-3.5"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            aria-hidden="true"
                                        >
                                            <circle
                                                cx="12"
                                                cy="12"
                                                r="9"
                                                stroke-width="1.7"
                                            />

                                            <path
                                                stroke-linecap="round"
                                                stroke-width="1.7"
                                                d="M12 7v5l3 2"
                                            />
                                        </svg>

                                        {{
                                            formatDate(
                                                notification.date_envoi
                                            )
                                        }}
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div
                                    class="flex shrink-0 items-center gap-1"
                                >
                                    <button
                                        v-if="!notification.lu"
                                        type="button"
                                        class="rounded-lg px-3 py-2 text-xs font-semibold text-[#39719F] transition hover:bg-[#F2F8FA] hover:text-[#072B4E]"
                                        @click="
                                            markAsRead(notification)
                                        "
                                    >
                                        Mark as read
                                    </button>

                                    <button
                                        type="button"
                                        title="Delete notification"
                                        aria-label="Delete notification"
                                        class="flex h-8 w-8 items-center justify-center rounded-lg text-[#6695AF] transition hover:bg-red-50 hover:text-red-500"
                                        @click="
                                            deleteNotification(
                                                notification
                                            )
                                        "
                                    >
                                        <svg
                                            class="h-4 w-4"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                            aria-hidden="true"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M6 18L18 6M6 6l12 12"
                                            />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </EncadrantLayout>
</template>
