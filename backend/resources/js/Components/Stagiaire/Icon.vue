<script setup>
defineProps({
    name: {
        type: String,
        required: true,
    },

    size: {
        type: [String, Number],
        default: 18,
    },
})
</script>

<template>
    <svg
        :width="size"
        :height="size"
        viewBox="0 0 24 24"
        class="shrink-0 fill-none stroke-current [stroke-width:1.8] [stroke-linecap:round] [stroke-linejoin:round]"
        aria-hidden="true"
    >
        <!-- DASHBOARD -->
        <template v-if="name === 'dashboard'">
            <rect x="3" y="3" width="7" height="7" rx="1" />
            <rect x="14" y="3" width="7" height="7" rx="1" />
            <rect x="3" y="14" width="7" height="7" rx="1" />
            <rect x="14" y="14" width="7" height="7" rx="1" />
        </template>

        <!-- INTERNSHIP OFFERS -->
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

        <!-- MY INTERNSHIP -->
        <template v-else-if="name === 'graduation'">
            <path d="M3 9.5 12 5l9 4.5-9 4.5-9-4.5Z" />
            <path d="M6 11.5V16c0 1.5 2.7 3 6 3s6-1.5 6-3v-4.5" />
            <path d="M21 10v6" />
        </template>

        <!-- MY TASKS -->
        <template v-else-if="name === 'tasks'">
            <rect x="4" y="4" width="16" height="16" rx="2" />
            <path d="m8 12 2 2 4-4" />
            <path d="M8 8h8" />
        </template>

        <!-- MY APPLICATIONS -->
        <template v-else-if="name === 'check'">
            <path d="M9 11l3 3L22 4" />
            <path
                d="M21 12v7a2 2 0 0 1-2 2H5
                   a2 2 0 0 1-2-2V5
                   a2 2 0 0 1 2-2h11"
            />
        </template>

        <!-- MY CV -->
        <template v-else-if="name === 'documents'">
            <path
                d="M6 3h8l4 4v14H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z"
            />
            <path d="M14 3v5h5" />
            <path d="M8 13h8" />
            <path d="M8 17h6" />
        </template>

        <!-- CAREER ASSISTANT -->
        <template v-else-if="name === 'skills'">
            <path d="M12 3a5 5 0 0 0-3 9v3h6v-3a5 5 0 0 0-3-9Z" />
            <path d="M9 19h6" />
            <path d="M10 22h4" />
        </template>

        <!-- NOTIFICATIONS -->
        <template v-else-if="name === 'bell'">
            <path
                d="M18 8a6 6 0 0 0-12 0
                   c0 7-3 7-3 9h18
                   c0-2-3-2-3-9"
            />
            <path d="M13.7 21a2 2 0 0 1-3.4 0" />
        </template>

        <!-- SAVED OPPORTUNITIES -->
        <template v-else-if="name === 'heart'">
            <path d="M6 4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18l-6-4-6 4V4Z" />
        </template>
        
        <!-- PROFILE -->
        <template v-else-if="name === 'user'">
            <circle cx="12" cy="7" r="4" />
            <path d="M5.5 21a6.5 6.5 0 0 1 13 0" />
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