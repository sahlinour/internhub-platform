<script setup>
import { Head, router } from '@inertiajs/vue3'
import EncadrantSidebar from '@/Components/Encadrant/EncadrantSidebar.vue'

const props = defineProps({
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
    if (notification.lu) return

    router.patch(
        `/encadrant/notifications/${notification.id}/read`,
        {},
        {
            preserveScroll: true,
        }
    )
}

const markAllAsRead = () => {
    router.patch(
        '/encadrant/notifications/read-all',
        {},
        {
            preserveScroll: true,
        }
    )
}

const deleteNotification = (notification) => {
    router.delete(
        `/encadrant/notifications/${notification.id}`,
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

    <div class="flex min-h-screen bg-[#f6f8fb]">

        <!-- Sidebar -->
        <EncadrantSidebar />

        <!-- Main -->
        <main class="min-w-0 flex-1">

            <div class="mx-auto max-w-6xl px-6 py-8 lg:px-10">

                <!-- Header -->
                <div
                    class="mb-7 flex flex-col gap-5
                           sm:flex-row sm:items-center sm:justify-between"
                >
                    <div>
                        <div class="flex items-center gap-3">

                            <div
                                class="flex h-11 w-11 items-center
                                       justify-center rounded-xl
                                       bg-blue-50 text-[#17629b]"
                            >
                                <svg
                                    class="h-5 w-5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.8"
                                        d="M18 8a6 6 0 00-12 0
                                           c0 7-3 7-3 9h18
                                           c0-2-3-2-3-9
                                           M13.73 21
                                           a2 2 0 01-3.46 0"
                                    />
                                </svg>
                            </div>

                            <div>
                                <h1
                                    class="text-2xl font-bold
                                           tracking-tight text-gray-900"
                                >
                                    Notifications
                                </h1>

                                <p class="mt-0.5 text-sm text-gray-500">
                                    Keep track of your latest updates and activities.
                                </p>
                            </div>

                        </div>
                    </div>

                    <!-- Mark all -->
                    <button
                        v-if="unreadCount > 0"
                        type="button"
                        @click="markAllAsRead"
                        class="inline-flex items-center justify-center
                               gap-2 rounded-lg bg-[#17629b]
                               px-4 py-2.5 text-sm font-medium
                               text-white shadow-sm
                               transition-all duration-200
                               hover:bg-[#124f7d]
                               hover:shadow-md"
                    >
                        <svg
                            class="h-4 w-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M5 13l4 4L19 7"
                            />
                        </svg>

                        Mark all as read
                    </button>
                </div>


                <!-- Stats -->
                <div class="mb-5 flex flex-wrap items-center gap-3">

                    <div
                        class="inline-flex items-center gap-2
                               rounded-full border border-gray-200
                               bg-white px-3.5 py-1.5
                               text-xs font-medium text-gray-600"
                    >
                        <span
                            class="flex h-5 w-5 items-center
                                   justify-center rounded-full
                                   bg-gray-100 text-[10px]
                                   font-semibold text-gray-700"
                        >
                            {{ notifications.length }}
                        </span>

                        Total notifications
                    </div>

                    <div
                        class="inline-flex items-center gap-2
                               rounded-full border px-3.5 py-1.5
                               text-xs font-medium"
                        :class="
                            unreadCount > 0
                                ? 'border-blue-100 bg-blue-50 text-[#17629b]'
                                : 'border-gray-200 bg-white text-gray-500'
                        "
                    >
                        <span
                            v-if="unreadCount > 0"
                            class="h-2 w-2 rounded-full bg-[#17629b]"
                        ></span>

                        {{ unreadCount }} unread
                    </div>

                </div>


                <!-- Empty state -->
                <div
                    v-if="notifications.length === 0"
                    class="rounded-2xl border border-gray-200
                           bg-white px-6 py-20 text-center
                           shadow-sm"
                >
                    <div
                        class="mx-auto flex h-16 w-16
                               items-center justify-center
                               rounded-2xl bg-gray-50
                               text-gray-400"
                    >
                        <svg
                            class="h-7 w-7"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.7"
                                d="M18 8a6 6 0 00-12 0
                                   c0 7-3 7-3 9h18
                                   c0-2-3-2-3-9
                                   M13.73 21
                                   a2 2 0 01-3.46 0"
                            />
                        </svg>
                    </div>

                    <h2 class="mt-5 text-base font-semibold text-gray-800">
                        You're all caught up
                    </h2>

                    <p class="mx-auto mt-2 max-w-sm text-sm text-gray-500">
                        New notifications about your interns, documents,
                        tasks and evaluations will appear here.
                    </p>
                </div>


                <!-- Notification List -->
                <div
                    v-else
                    class="space-y-3"
                >

                    <div
                        v-for="notification in notifications"
                        :key="notification.id"
                        class="group relative overflow-hidden
                               rounded-xl border bg-white
                               transition-all duration-200
                               hover:-translate-y-[1px]
                               hover:shadow-md"
                        :class="
                            !notification.lu
                                ? 'border-blue-100 shadow-sm'
                                : 'border-gray-200 shadow-sm'
                        "
                    >

                        <!-- Unread left indicator -->
                        <div
                            v-if="!notification.lu"
                            class="absolute bottom-0 left-0 top-0
                                   w-1 bg-[#17629b]"
                        ></div>

                        <div
                            class="flex items-start gap-4
                                   px-5 py-5 sm:px-6"
                        >

                            <!-- Bell icon -->
                            <div
                                class="flex h-11 w-11 shrink-0
                                       items-center justify-center
                                       rounded-xl transition"
                                :class="
                                    !notification.lu
                                        ? 'bg-blue-50 text-[#17629b]'
                                        : 'bg-gray-100 text-gray-400'
                                "
                            >
                                <svg
                                    class="h-5 w-5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.8"
                                        d="M18 8a6 6 0 00-12 0
                                           c0 7-3 7-3 9h18
                                           c0-2-3-2-3-9
                                           M13.73 21
                                           a2 2 0 01-3.46 0"
                                    />
                                </svg>
                            </div>


                            <!-- Content -->
                            <div class="min-w-0 flex-1">

                                <div
                                    class="flex flex-col gap-2
                                           sm:flex-row
                                           sm:items-start
                                           sm:justify-between"
                                >

                                    <div class="min-w-0">

                                        <!-- Title -->
                                        <div class="flex items-center gap-2">

                                            <h3
                                                class="truncate text-sm
                                                       text-gray-900"
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
                                                class="h-2 w-2 shrink-0
                                                       rounded-full
                                                       bg-[#17629b]"
                                            ></span>

                                            <span
                                                v-if="!notification.lu"
                                                class="rounded-full
                                                       bg-blue-50
                                                       px-2 py-0.5
                                                       text-[10px]
                                                       font-semibold
                                                       uppercase
                                                       tracking-wide
                                                       text-[#17629b]"
                                            >
                                                New
                                            </span>

                                        </div>


                                        <!-- Message -->
                                        <p
                                            class="mt-1.5 max-w-3xl
                                                   text-sm leading-6
                                                   text-gray-600"
                                        >
                                            {{ notification.message }}
                                        </p>


                                        <!-- Date -->
                                        <div
                                            class="mt-3 flex items-center
                                                   gap-1.5 text-xs
                                                   text-gray-400"
                                        >
                                            <svg
                                                class="h-3.5 w-3.5"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
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

                                            {{ formatDate(notification.date_envoi) }}
                                        </div>

                                    </div>


                                    <!-- Actions -->
                                    <div
                                        class="flex shrink-0
                                               items-center gap-1"
                                    >

                                        <!-- Mark read -->
                                        <button
                                            v-if="!notification.lu"
                                            type="button"
                                            @click="markAsRead(notification)"
                                            class="rounded-lg px-3 py-2
                                                   text-xs font-medium
                                                   text-[#17629b]
                                                   transition
                                                   hover:bg-blue-50"
                                        >
                                            Mark as read
                                        </button>


                                        <!-- Delete -->
                                        <button
                                            type="button"
                                            title="Delete notification"
                                            @click="deleteNotification(notification)"
                                            class="flex h-8 w-8
                                                   items-center justify-center
                                                   rounded-lg
                                                   text-gray-400
                                                   transition
                                                   hover:bg-red-50
                                                   hover:text-red-500"
                                        >
                                            <svg
                                                class="h-4 w-4"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="1.8"
                                                    d="M6 18L18 6M6 6l12 12"
                                                />
                                            </svg>
                                        </button>

                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </main>
    </div>
</template>
