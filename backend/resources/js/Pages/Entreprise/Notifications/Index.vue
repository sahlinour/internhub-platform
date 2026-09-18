<script setup>
import { Head, router } from '@inertiajs/vue3'
import EntrepriseSidebar from '@/Components/Entreprise/EntrepriseSidebar.vue'

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
        `/entreprise/notifications/${notification.id}/read`,
        {},
        {
            preserveScroll: true,
        }
    )
}

const markAllAsRead = () => {
    if (props.unreadCount === 0) return

    router.patch(
        '/entreprise/notifications/read-all',
        {},
        {
            preserveScroll: true,
        }
    )
}

const deleteNotification = (notification) => {
    router.delete(
        `/entreprise/notifications/${notification.id}`,
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

    <div class="flex min-h-screen bg-[#f5f7fa]">

        <!-- SIDEBAR -->
        <EntrepriseSidebar />

        <!-- MAIN CONTENT -->
        <main class="ml-[230px] min-h-screen flex-1 max-[850px]:ml-0">

            <!-- HEADER -->
            <div
                class="flex items-center justify-between
                       border-b border-gray-200
                       bg-white px-8 py-6"
            >
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">
                        Notifications
                    </h1>

                    <p class="mt-1 text-sm text-gray-500">
                        Stay updated with your latest activities and information.
                    </p>
                </div>

                <button
                    v-if="unreadCount > 0"
                    type="button"
                    @click="markAllAsRead"
                    class="rounded-lg border border-gray-200
                           bg-white px-4 py-2
                           text-sm font-semibold text-gray-700
                           shadow-sm transition
                           hover:bg-gray-50"
                >
                    Mark all as read
                </button>
            </div>


            <!-- CONTENT -->
            <div class="px-8 py-8">

                <div class="mx-auto max-w-5xl">

                    <!-- SECTION HEADER -->
                    <div
                        class="mb-6 flex items-center
                               justify-between"
                    >
                        <div>
                            <h2
                                class="text-lg font-semibold
                                       text-gray-900"
                            >
                                Your notifications
                            </h2>

                            <p class="mt-1 text-sm text-gray-500">
                                <template v-if="unreadCount > 0">
                                    You have

                                    <span class="font-semibold text-[#17629b]">
                                        {{ unreadCount }}
                                    </span>

                                    unread
                                    {{
                                        unreadCount === 1
                                            ? 'notification'
                                            : 'notifications'
                                    }}.
                                </template>

                                <template v-else>
                                    You're all caught up.
                                </template>
                            </p>
                        </div>

                        <!-- Bell -->
                        <div
                            class="flex h-10 w-10
                                   items-center justify-center
                                   rounded-xl
                                   bg-[#eaf3fa]
                                   text-[#17629b]"
                        >
                            <svg
                                viewBox="0 0 24 24"
                                width="20"
                                height="20"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path
                                    d="M18 8a6 6 0 00-12 0
                                       c0 7-3 7-3 9h18
                                       c0-2-3-2-3-9"
                                />

                                <path
                                    d="M13.73 21
                                       a2 2 0 01-3.46 0"
                                />
                            </svg>
                        </div>
                    </div>


                    <!-- EMPTY STATE -->
                    <div
                        v-if="notifications.length === 0"
                        class="rounded-2xl border
                               border-gray-200 bg-white
                               px-6 py-16 text-center
                               shadow-sm"
                    >
                        <div
                            class="mx-auto flex h-14 w-14
                                   items-center justify-center
                                   rounded-full
                                   bg-[#eaf3fa]
                                   text-[#17629b]"
                        >
                            <svg
                                viewBox="0 0 24 24"
                                width="25"
                                height="25"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path
                                    d="M18 8a6 6 0 00-12 0
                                       c0 7-3 7-3 9h18
                                       c0-2-3-2-3-9"
                                />

                                <path
                                    d="M13.73 21
                                       a2 2 0 01-3.46 0"
                                />
                            </svg>
                        </div>

                        <h3
                            class="mt-4 text-base
                                   font-semibold text-gray-900"
                        >
                            No notifications
                        </h3>

                        <p class="mt-2 text-sm text-gray-500">
                            You don't have any notifications at the moment.
                        </p>
                    </div>


                    <!-- NOTIFICATION CARDS -->
                    <div
                        v-else
                        class="space-y-3"
                    >
                        <div
                            v-for="notification in notifications"
                            :key="notification.id"
                            class="relative overflow-hidden
                                   rounded-xl border
                                   bg-white transition
                                   hover:shadow-md"
                            :class="
                                notification.lu
                                    ? 'border-gray-200'
                                    : 'border-[#b8d7ec] bg-[#fbfdff]'
                            "
                        >

                            <!-- UNREAD INDICATOR -->
                            <div
                                v-if="!notification.lu"
                                class="absolute bottom-0
                                       left-0 top-0
                                       w-[4px]
                                       bg-[#17629b]"
                            ></div>


                            <div class="flex gap-4 p-5">

                                <!-- ICON -->
                                <div
                                    class="flex h-11 w-11
                                           shrink-0 items-center
                                           justify-center
                                           rounded-full"
                                    :class="
                                        notification.lu
                                            ? 'bg-gray-100 text-gray-500'
                                            : 'bg-[#eaf3fa] text-[#17629b]'
                                    "
                                >
                                    <svg
                                        viewBox="0 0 24 24"
                                        width="20"
                                        height="20"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    >
                                        <path
                                            d="M18 8a6 6 0 00-12 0
                                               c0 7-3 7-3 9h18
                                               c0-2-3-2-3-9"
                                        />

                                        <path
                                            d="M13.73 21
                                               a2 2 0 01-3.46 0"
                                        />
                                    </svg>
                                </div>


                                <!-- BODY -->
                                <div class="min-w-0 flex-1">

                                    <div
                                        class="flex items-start
                                               justify-between gap-4"
                                    >
                                        <div class="min-w-0 flex-1">

                                            <!-- TITLE -->
                                            <div
                                                class="flex items-center
                                                       gap-2"
                                            >
                                                <h3
                                                    class="text-sm
                                                           font-semibold
                                                           text-gray-900"
                                                >
                                                    {{ notification.titre }}
                                                </h3>

                                                <span
                                                    v-if="!notification.lu"
                                                    class="h-2 w-2
                                                           rounded-full
                                                           bg-[#17629b]"
                                                ></span>
                                            </div>


                                            <!-- MESSAGE -->
                                            <p
                                                class="mt-2
                                                       whitespace-pre-line
                                                       text-sm leading-6
                                                       text-gray-600"
                                            >
                                                {{ notification.message }}
                                            </p>


                                            <!-- DATE -->
                                            <p
                                                class="mt-3
                                                       text-xs
                                                       text-gray-400"
                                            >
                                                {{
                                                    formatDate(
                                                        notification.date_envoi
                                                    )
                                                }}
                                            </p>

                                        </div>


                                        <!-- DELETE -->
                                        <button
                                            type="button"
                                            title="Delete notification"
                                            @click.stop="
                                                deleteNotification(notification)
                                            "
                                            class="flex h-8 w-8
                                                   shrink-0
                                                   items-center
                                                   justify-center
                                                   rounded-lg
                                                   text-gray-400
                                                   transition
                                                   hover:bg-red-50
                                                   hover:text-red-500"
                                        >
                                            <svg
                                                viewBox="0 0 24 24"
                                                width="17"
                                                height="17"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="1.8"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            >
                                                <path d="M3 6h18" />
                                                <path d="M8 6V4h8v2" />
                                                <path d="M19 6l-1 14H6L5 6" />
                                                <path d="M10 11v5" />
                                                <path d="M14 11v5" />
                                            </svg>
                                        </button>

                                    </div>


                                    <!-- MARK AS READ -->
                                    <div
                                        v-if="!notification.lu"
                                        class="mt-4"
                                    >
                                        <button
                                            type="button"
                                            @click="
                                                markAsRead(notification)
                                            "
                                            class="text-xs
                                                   font-semibold
                                                   text-[#17629b]
                                                   transition
                                                   hover:text-[#0b3454]"
                                        >
                                            Mark as read
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
