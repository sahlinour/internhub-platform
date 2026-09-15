<script setup>
defineProps({
    title: {
        type: String,
        required: true,
    },
    value: {
        type: [String, Number],
        required: true,
    },
    subtitle: {
        type: String,
        default: '',
    },
    icon: {
        type: String,
        default: 'users',
    },
    variant: {
        type: String,
        default: 'blue',
    },
})
</script>

<template>
    <div
        class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm
               transition hover:-translate-y-0.5 hover:shadow-md"
    >
        <div
            class="mb-4 flex h-10 w-10 items-center justify-center rounded-lg"
            :class="{
                'bg-blue-50 text-blue-600': variant === 'blue',
                'bg-violet-50 text-violet-600': variant === 'violet',
                'bg-orange-50 text-orange-500': variant === 'orange',
                'bg-emerald-50 text-emerald-600': variant === 'green',
            }"
        >
            <!-- Users -->
            <svg
                v-if="icon === 'users'"
                class="h-5 w-5"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1.8"
                    d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H2v-2a4 4 0 014-4h3m6-4a4 4 0 11-8 0 4 4 0 018 0zm6 1a3 3 0 10-3-3"
                />
            </svg>

            <!-- Tasks -->
            <svg
                v-else-if="icon === 'tasks'"
                class="h-5 w-5"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1.8"
                    d="M9 11l3 3L22 4M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"
                />
            </svg>

            <!-- Calendar -->
            <svg
                v-else-if="icon === 'calendar'"
                class="h-5 w-5"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1.8"
                    d="M8 7V3m8 4V3M5 11h14M5 5h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z"
                />
            </svg>

            <!-- Progress -->
            <svg
                v-else
                class="h-5 w-5"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1.8"
                    d="M4 18l5-5 4 4 7-9M16 8h4v4"
                />
            </svg>
        </div>

        <p class="text-2xl font-bold text-gray-900">
            {{ value }}
        </p>

        <p class="mt-1 text-sm font-medium text-gray-700">
            {{ title }}
        </p>

        <p
            v-if="subtitle"
            class="mt-1 text-xs text-gray-400"
        >
            {{ subtitle }}
        </p>
    </div>
</template>
