<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

const page = usePage()

const currentUrl = computed(() => page.url)

const menuItems = [
    {
        label: 'Dashboard',
        href: '/encadrant/dashboard',
        icon: 'dashboard',
    },
    {
        label: 'Assigned Interns',
        href: '/encadrant/stagiaires',
        icon: 'users',
    },
    {
        label: 'Assign Tasks',
        href: '/encadrant/taches',
        icon: 'tasks',
    },
    {
        label: 'Task Tracking',
        href: '/encadrant/suivi-taches',
        icon: 'review',
        badge: 5,
    },
    {
        label: 'Meetings',
        href: '/encadrant/reunions',
        icon: 'calendar',
    },
    {
        label: 'Documents',
        href: '/encadrant/documents',
        icon: 'document',
    },
    {
        label: 'Progress Tracking',
        href: '/encadrant/progression',
        icon: 'progress',
    },
    {
        label: 'Evaluations',
        href: '/encadrant/evaluations',
        icon: 'evaluation',
    },
    {
        label: 'Notifications',
        href: '/encadrant/notifications',
        icon: 'notification',
        badge: 4,
    },
]

const isActive = (href) => {
    if (href === '/encadrant/dashboard') {
        return currentUrl.value === href
    }

    return currentUrl.value.startsWith(href)
}
</script>

<template>
    <aside
        class="flex min-h-screen w-[230px] shrink-0 flex-col
               bg-gradient-to-b from-[#17629b] to-[#0b3454]
               text-white"
    >
        <!-- Logo -->
        <div class="flex h-20 items-center px-6">
            <img
                :src="'/images/LogoBgDarkInternHub.png'"
                alt="InternHub"
                class="h-auto w-[125px] object-contain"
            />
        </div>

        <!-- User -->
        <div class="mx-4 mb-5 rounded-xl bg-white/5 p-3">
            <div class="flex items-center gap-3">
                <div
                    class="flex h-9 w-9 shrink-0 items-center
                           justify-center rounded-full bg-violet-500
                           text-xs font-semibold"
                >
                    EN
                </div>

                <div class="min-w-0">
                    <p class="truncate text-xs font-semibold">
                        Encadrant
                    </p>

                    <p class="truncate text-[10px] text-blue-200">
                        InternHub
                    </p>
                </div>
            </div>

            <div
                class="mt-3 border-t border-white/10 pt-3
                       text-[10px] text-blue-200"
            >
                Encadrant pédagogique
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 space-y-1 px-3">
            <Link
                v-for="item in menuItems"
                :key="item.href"
                :href="item.href"
                class="group flex items-center justify-between
                       rounded-lg px-3 py-2.5 text-xs
                       transition-all duration-200"
                :class="
                    isActive(item.href)
                        ? 'bg-blue-500/60 text-white shadow-sm'
                        : 'text-blue-100 hover:bg-white/10 hover:text-white'
                "
            >
                <div class="flex items-center gap-3">

                    <!-- Dashboard -->
                    <svg
                        v-if="item.icon === 'dashboard'"
                        class="h-[17px] w-[17px]"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <rect
                            x="3"
                            y="3"
                            width="7"
                            height="7"
                            rx="1"
                            stroke-width="1.7"
                        />
                        <rect
                            x="14"
                            y="3"
                            width="7"
                            height="7"
                            rx="1"
                            stroke-width="1.7"
                        />
                        <rect
                            x="3"
                            y="14"
                            width="7"
                            height="7"
                            rx="1"
                            stroke-width="1.7"
                        />
                        <rect
                            x="14"
                            y="14"
                            width="7"
                            height="7"
                            rx="1"
                            stroke-width="1.7"
                        />
                    </svg>

                    <!-- Users -->
                    <svg
                        v-else-if="item.icon === 'users'"
                        class="h-[17px] w-[17px]"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.7"
                            d="M16 21v-2a4 4 0 00-4-4H6
                               a4 4 0 00-4 4v2
                               M9 11a4 4 0 100-8 4 4 0 000 8
                               M22 21v-2a4 4 0 00-3-3.87
                               M16 3.13a4 4 0 010 7.75"
                        />
                    </svg>

                    <!-- Tasks -->
                    <svg
                        v-else-if="item.icon === 'tasks'"
                        class="h-[17px] w-[17px]"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.7"
                            d="M9 11l3 3L22 4
                               M21 12v7a2 2 0 01-2 2H5
                               a2 2 0 01-2-2V5
                               a2 2 0 012-2h11"
                        />
                    </svg>

                    <!-- Review -->
                    <svg
                        v-else-if="item.icon === 'review'"
                        class="h-[17px] w-[17px]"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.7"
                            d="M9 12l2 2 4-4
                               M7 3h10a2 2 0 012 2v14
                               a2 2 0 01-2 2H7
                               a2 2 0 01-2-2V5
                               a2 2 0 012-2z"
                        />
                    </svg>

                    <!-- Calendar -->
                    <svg
                        v-else-if="item.icon === 'calendar'"
                        class="h-[17px] w-[17px]"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.7"
                            d="M8 7V3m8 4V3
                               M5 11h14
                               M5 5h14a2 2 0 012 2v12
                               a2 2 0 01-2 2H5
                               a2 2 0 01-2-2V7
                               a2 2 0 012-2z"
                        />
                    </svg>

                    <!-- Document -->
                    <svg
                        v-else-if="item.icon === 'document'"
                        class="h-[17px] w-[17px]"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.7"
                            d="M14 2H6a2 2 0 00-2 2v16
                               a2 2 0 002 2h12
                               a2 2 0 002-2V8z
                               M14 2v6h6
                               M8 13h8
                               M8 17h8"
                        />
                    </svg>

                    <!-- Progress -->
                    <svg
                        v-else-if="item.icon === 'progress'"
                        class="h-[17px] w-[17px]"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.7"
                            d="M4 18l5-5 4 4 7-9
                               M16 8h4v4"
                        />
                    </svg>

                    <!-- Evaluation -->
                    <svg
                        v-else-if="item.icon === 'evaluation'"
                        class="h-[17px] w-[17px]"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.7"
                            d="M12 2l3 6 6 .9-4.5 4.4
                               1 6.2L12 16.6
                               6.5 19.5l1-6.2L3 8.9
                               9 8z"
                        />
                    </svg>

                    <!-- Notification -->
                    <svg
                        v-else
                        class="h-[17px] w-[17px]"
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
                               M13.7 21a2 2 0 01-3.4 0"
                        />
                    </svg>

                    <span>
                        {{ item.label }}
                    </span>
                </div>

                <span
                    v-if="item.badge"
                    class="flex h-5 min-w-5 items-center justify-center
                           rounded-full bg-red-500 px-1.5
                           text-[9px] font-bold text-white"
                >
                    {{ item.badge }}
                </span>
            </Link>
        </nav>

        <!-- Bottom -->
        <div class="space-y-1 border-t border-white/10 p-3">
            <Link
                href="/encadrant/profile"
                class="flex items-center gap-3 rounded-lg px-3 py-2.5
                       text-xs text-blue-100 transition
                       hover:bg-white/10 hover:text-white"
            >
                <svg
                    class="h-[17px] w-[17px]"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <circle cx="12" cy="12" r="3" stroke-width="1.7" />
                    <path
                        stroke-linecap="round"
                        stroke-width="1.7"
                        d="M19.4 15a1.7 1.7 0 00.34 1.88l.06.06
                           -2.83 2.83-.06-.06
                           A1.7 1.7 0 0015 19.4
                           1.7 1.7 0 0013.5 21h-3
                           A1.7 1.7 0 009 19.4
                           a1.7 1.7 0 00-1.88.34l-.06.06
                           -2.83-2.83.06-.06
                           A1.7 1.7 0 004.6 15
                           1.7 1.7 0 003 13.5v-3
                           A1.7 1.7 0 004.6 9
                           a1.7 1.7 0 00-.34-1.88l-.06-.06
                           2.83-2.83.06.06
                           A1.7 1.7 0 009 4.6
                           1.7 1.7 0 0010.5 3h3
                           A1.7 1.7 0 0015 4.6
                           a1.7 1.7 0 001.88-.34l.06-.06
                           2.83 2.83-.06.06
                           A1.7 1.7 0 0019.4 9
                           1.7 1.7 0 0021 10.5v3
                           A1.7 1.7 0 0019.4 15z"
                    />
                </svg>

                Settings
            </Link>

            <Link
                href="/logout"
                method="post"
                as="button"
                class="flex w-full items-center gap-3 rounded-lg
                       px-3 py-2.5 text-xs text-blue-100
                       transition hover:bg-white/10 hover:text-white"
            >
                <svg
                    class="h-[17px] w-[17px]"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.7"
                        d="M10 17l5-5-5-5
                           M15 12H3
                           M21 19V5a2 2 0 00-2-2h-6"
                    />
                </svg>

                Logout
            </Link>
        </div>
    </aside>
</template>
