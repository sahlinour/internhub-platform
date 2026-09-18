<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

const page = usePage()

/* =========================
   AUTHENTICATED USER
========================= */

const user = computed(() => page.props.auth?.user ?? {})

const displayName = computed(() => {
    return user.value.nom_complet || 'Encadrant'
})

const initials = computed(() => {
    const name = displayName.value.trim()

    if (!name) {
        return 'EN'
    }

    const parts = name.split(/\s+/)

    if (parts.length === 1) {
        return parts[0].substring(0, 2).toUpperCase()
    }

    return (
        parts[0][0] +
        parts[parts.length - 1][0]
    ).toUpperCase()
})

const currentUrl = computed(() => page.url)

/* =========================
   MENU
========================= */

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
        label: 'Task Reviews',
        href: '/encadrant/task-reviews',
        icon: 'review',
    },
    {
        label: 'Documents',
        href: '/encadrant/documents',
        icon: 'document',
    },
    {
        label: 'Progress Tracking',
        href: '/encadrant/progress',
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

        <!-- =========================
             LOGO
        ========================== -->
        <div class="flex h-20 items-center px-6">
            <img
                :src="'/images/LogoBgDarkInternHub.png'"
                alt="InternHub"
                class="h-auto w-[125px] object-contain"
            />
        </div>


        <!-- =========================
             USER
        ========================== -->
        <div class="mx-4 mb-5 rounded-xl bg-white/5 p-3">

            <div class="flex items-center gap-3">

                <!-- Avatar -->
                <div
                    class="flex h-9 w-9 shrink-0
                           items-center justify-center
                           overflow-hidden rounded-full
                           bg-violet-500
                           text-xs font-semibold text-white"
                >

                    <!-- Profile photo -->
                    <img
                        v-if="user.photo"
                        :src="`/storage/${user.photo}`"
                        :alt="displayName"
                        class="h-full w-full object-cover"
                    />

                    <!-- Initials -->
                    <span v-else>
                        {{ initials }}
                    </span>

                </div>


                <!-- User information -->
                <div class="min-w-0">

                    <p class="truncate text-xs font-semibold text-white">
                        {{ displayName }}
                    </p>

                    <p class="truncate text-[10px] text-blue-200">
                        {{ user.role || 'Encadrant' }}
                    </p>

                </div>

            </div>


            <div
                class="mt-3 border-t border-white/10
                       pt-3 text-[10px] text-blue-200"
            >
                Encadrant pédagogique
            </div>

        </div>


        <!-- =========================
             NAVIGATION
        ========================== -->
        <nav class="space-y-1 px-3">

            <Link
                v-for="item in menuItems"
                :key="item.href"
                :href="item.href"
                class="group flex items-center gap-3
                       rounded-lg px-3 py-2.5
                       text-xs transition-all duration-200"
                :class="
                    isActive(item.href)
                        ? 'bg-blue-500/60 text-white shadow-sm'
                        : 'text-blue-100 hover:bg-white/10 hover:text-white'
                "
            >

                <!-- Dashboard -->
                <svg
                    v-if="item.icon === 'dashboard'"
                    class="h-[17px] w-[17px] shrink-0"
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


                <!-- Assigned Interns -->
                <svg
                    v-else-if="item.icon === 'users'"
                    class="h-[17px] w-[17px] shrink-0"
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


                <!-- Assign Tasks -->
                <svg
                    v-else-if="item.icon === 'tasks'"
                    class="h-[17px] w-[17px] shrink-0"
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


                <!-- Task Reviews -->
                <svg
                    v-else-if="item.icon === 'review'"
                    class="h-[17px] w-[17px] shrink-0"
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


                <!-- Documents -->
                <svg
                    v-else-if="item.icon === 'document'"
                    class="h-[17px] w-[17px] shrink-0"
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
                    class="h-[17px] w-[17px] shrink-0"
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


                <!-- Evaluations -->
                <svg
                    v-else-if="item.icon === 'evaluation'"
                    class="h-[17px] w-[17px] shrink-0"
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


                <!-- Notifications -->
                <svg
                    v-else-if="item.icon === 'notification'"
                    class="h-[17px] w-[17px] shrink-0"
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


                <!-- Label -->
                <span class="flex-1">
                    {{ item.label }}
                </span>

            </Link>

        </nav>


        <!-- =========================
             SETTINGS + LOGOUT
        ========================== -->
        <div
            class="mx-3 mt-3 space-y-1
                   border-t border-white/10 pt-3"
        >

            <!-- Settings -->
            <Link
                href="/encadrant/profile"
                class="flex w-full items-center gap-3
                       rounded-lg px-3 py-2.5
                       text-xs transition-all duration-200"
                :class="
                    currentUrl.startsWith('/encadrant/profile')
                        ? 'bg-blue-500/60 text-white shadow-sm'
                        : 'text-blue-100 hover:bg-white/10 hover:text-white'
                "
            >
                <svg
                    class="h-[17px] w-[17px] shrink-0"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <circle
                        cx="12"
                        cy="12"
                        r="3"
                        stroke-width="1.7"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
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

                <span>Settings</span>
            </Link>


            <!-- Logout -->
            <Link
                href="/logout"
                method="post"
                as="button"
                class="flex w-full items-center gap-3
                       rounded-lg px-3 py-2.5
                       text-xs text-blue-100
                       transition-all duration-200
                       hover:bg-white/10 hover:text-white"
            >
                <svg
                    class="h-[17px] w-[17px] shrink-0"
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

                <span>Logout</span>

            </Link>

        </div>

    </aside>
</template>
