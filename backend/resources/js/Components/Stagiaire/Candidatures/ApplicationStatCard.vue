<script setup>
defineProps({
    title: {
        type: String,
        required: true,
    },

    value: {
        type: [Number, String],
        required: true,
    },

    icon: {
        type: String,
        default: 'document',
    },

    color: {
        type: String,
        default: 'blue',
    },
})
</script>

<template>
    <div
        class="flex min-w-[148px] flex-1 shrink-0
               items-center gap-3
               rounded-xl border border-slate-200 bg-white
               px-3 py-3.5 shadow-sm
               transition duration-200
               hover:border-slate-300 hover:shadow-md"
    >
        <!-- Icon -->
        <div
            class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg"
            :class="{
                'bg-blue-50 text-blue-600': color === 'blue',
                'bg-amber-50 text-amber-600': color === 'amber',
                'bg-sky-50 text-sky-600': color === 'sky',
                'bg-emerald-50 text-emerald-600': color === 'green',
                'bg-red-50 text-red-600': color === 'red',
            }"
        >
            <!-- Applied -->
            <svg
                v-if="icon === 'document'"
                class="h-4 w-4"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1.8"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                />
            </svg>

            <!-- Under Review -->
            <svg
                v-else-if="icon === 'clock'"
                class="h-4 w-4"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1.8"
                    d="M12 8v4l2.5 2.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                />
            </svg>

            <!-- Interview -->
            <svg
                v-else-if="icon === 'calendar'"
                class="h-4 w-4"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1.8"
                    d="M8 7V3m8 4V3M4 11h16M5 5h14a1 1 0 011 1v13a1 1 0 01-1 1H5a1 1 0 01-1-1V6a1 1 0 011-1z"
                />
            </svg>

            <!-- Offer -->
            <svg
                v-else-if="icon === 'check'"
                class="h-4 w-4"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M5 13l4 4L19 7"
                />
            </svg>

            <!-- Rejected -->
            <svg
                v-else-if="icon === 'x'"
                class="h-4 w-4"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1.8"
                    d="M6 6l12 12M18 6L6 18"
                />
            </svg>
        </div>

        <!-- Information -->
        <div class="min-w-0">
            <p class="truncate whitespace-nowrap text-[10px] font-medium text-slate-500">
                {{ title }}
            </p>

            <p class="mt-1 whitespace-nowrap text-xl font-bold leading-none text-[#16425B]">
                {{ value }}
            </p>
        </div>
    </div>
</template>