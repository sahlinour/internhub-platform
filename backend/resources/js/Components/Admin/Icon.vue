<script setup>
defineProps({
    name: {
        type: String,
        required: true,
    },

    size: {
        type: Number,
        default: 18,
    },
})
</script>

<template>
    <svg
        :width="size"
        :height="size"
        viewBox="0 0 24 24"
        class="shrink-0 fill-none stroke-current
               [stroke-width:1.8]
               [stroke-linecap:round]
               [stroke-linejoin:round]"
        aria-hidden="true"
    >
        <!-- DASHBOARD -->
        <template v-if="name === 'dashboard'">
            <rect x="3" y="3" width="7" height="7" rx="1" />
            <rect x="14" y="3" width="7" height="7" rx="1" />
            <rect x="3" y="14" width="7" height="7" rx="1" />
            <rect x="14" y="14" width="7" height="7" rx="1" />
        </template>

        <!-- USERS -->
        <template v-else-if="name === 'users'">
            <path
                d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"
            />
            <circle cx="9" cy="7" r="4" />
            <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
        </template>

        <!-- COMPANY -->
        <template v-else-if="name === 'company'">
            <rect
                x="3"
                y="3"
                width="18"
                height="18"
                rx="2"
            />
            <path d="M9 21V9h6v12" />
            <path d="M7 6h.01M12 6h.01M17 6h.01" />
        </template>

        <!-- USER -->
        <template v-else-if="name === 'user'">
            <circle cx="12" cy="7" r="4" />
            <path d="M5.5 21a6.5 6.5 0 0 1 13 0" />
        </template>

        <!-- BRIEFCASE -->
        <template v-else-if="name === 'briefcase'">
            <rect
                x="3"
                y="7"
                width="18"
                height="13"
                rx="2"
            />
            <path
                d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"
            />
            <path d="M3 12h18" />
        </template>

        <!-- CHECK -->
        <template v-else-if="name === 'check'">
            <path d="M9 11l3 3L22 4" />
            <path
                d="M21 12v7a2 2 0 0 1-2 2H5
                   a2 2 0 0 1-2-2V5
                   a2 2 0 0 1 2-2h11"
            />
        </template>

        <!-- GRADUATION -->
        <template v-else-if="name === 'graduation'">
            <path d="M3 10l9-5 9 5-9 5-9-5Z" />
            <path d="M7 12.5V17c3 2 7 2 10 0v-4.5" />
        </template>

        <!-- ALERT -->
        <template v-else-if="name === 'alert'">
            <path
                d="M10.3 3.7 2.5 17
                   a2 2 0 0 0 1.7 3h15.6
                   a2 2 0 0 0 1.7-3L13.7 3.7
                   a2 2 0 0 0-3.4 0Z"
            />
            <path d="M12 9v4" />
            <path d="M12 17h.01" />
        </template>

        <!-- BELL -->
        <template v-else-if="name === 'bell'">
            <path
                d="M18 8a6 6 0 0 0-12 0
                   c0 7-3 7-3 9h18
                   c0-2-3-2-3-9"
            />
            <path d="M13.7 21a2 2 0 0 1-3.4 0" />
        </template>

        <!-- SETTINGS -->
        <template v-else-if="name === 'settings'">
            <circle cx="12" cy="12" r="3" />

            <path
                d="M19.4 15
                   a1.7 1.7 0 0 0 .3 1.9
                   l.1.1-2.8 2.8-.1-.1
                   a1.7 1.7 0 0 0-1.9-.3
                   1.7 1.7 0 0 0-1 1.5v.1h-4v-.1
                   a1.7 1.7 0 0 0-1-1.5
                   1.7 1.7 0 0 0-1.9.3l-.1.1
                   -2.8-2.8.1-.1
                   A1.7 1.7 0 0 0 4.6 15
                   a1.7 1.7 0 0 0-1.5-1H3v-4h.1
                   a1.7 1.7 0 0 0 1.5-1
                   1.7 1.7 0 0 0-.3-1.9L4.2 7
                   l2.8-2.8.1.1
                   A1.7 1.7 0 0 0 9 4.6
                   a1.7 1.7 0 0 0 1-1.5V3h4v.1
                   a1.7 1.7 0 0 0 1 1.5
                   1.7 1.7 0 0 0 1.9-.3l.1-.1
                   L19.8 7l-.1.1
                   a1.7 1.7 0 0 0-.3 1.9
                   1.7 1.7 0 0 0 1.5 1h.1v4h-.1
                   a1.7 1.7 0 0 0-1.5 1Z"
            />
        </template>
    </svg>
</template>
