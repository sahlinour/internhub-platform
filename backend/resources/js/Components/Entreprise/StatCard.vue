<script setup>
defineProps({
    title: {
        type: String,
        required: true,
    },
    value: {
        type: [String, Number],
        default: 0,
    },
    subtitle: {
        type: String,
        default: '',
    },
    icon: {
        type: String,
        default: 'briefcase',
    },
    iconBg: {
        type: String,
        default: 'bg-blue-50',
    },
    iconColor: {
        type: String,
        default: 'text-[#2d7da0]',
    },
    subtitleColor: {
        type: String,
        default: 'text-gray-400',
    },
})
</script>

<template>
    <div
        class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md"
    >
        <div class="flex items-start justify-between gap-4">
            <div>
                <p class="text-[10px] font-medium text-gray-400">
                    {{ title }}
                </p>

                <p class="mt-2 text-[25px] font-bold text-gray-800">
                    {{ value }}
                </p>

                <p
                    v-if="subtitle"
                    class="mt-1 text-[9px]"
                    :class="subtitleColor"
                >
                    {{ subtitle }}
                </p>
            </div>

            <div
                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl"
                :class="[iconBg, iconColor]"
            >
                <!-- Briefcase -->
                <svg
                    v-if="icon === 'briefcase'"
                    viewBox="0 0 24 24"
                    class="h-5 w-5"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                >
                    <rect x="3" y="7" width="18" height="13" rx="2" />
                    <path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                </svg>

                <!-- Users -->
                <svg
                    v-else-if="icon === 'users'"
                    viewBox="0 0 24 24"
                    class="h-5 w-5"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                >
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                </svg>

                <!-- Check -->
                <svg
                    v-else-if="icon === 'check'"
                    viewBox="0 0 24 24"
                    class="h-5 w-5"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <path d="M20 6 9 17l-5-5" />
                </svg>

                <!-- Graduation -->
                <svg
                    v-else-if="icon === 'graduation'"
                    viewBox="0 0 24 24"
                    class="h-5 w-5"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                >
                    <path d="M22 10 12 5 2 10l10 5 10-5Z" />
                    <path d="M6 12v5c3 2 9 2 12 0v-5" />
                </svg>
            </div>
        </div>
    </div>
</template>
