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
        default: 'briefcase',
    },
    color: {
        type: String,
        default: 'blue',
    },
})
</script>

<template>
    <div
        class="min-w-[150px] flex-1 rounded-2xl border border-slate-200
               bg-white px-4 py-4 shadow-sm"
    >
        <div class="flex items-center gap-3">
            <div
                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl"
                :class="{
                    'bg-blue-50 text-[#2d7da0]': color === 'blue',
                    'bg-emerald-50 text-emerald-500': color === 'green',
                    'bg-amber-50 text-amber-500': color === 'amber',
                    'bg-red-50 text-red-500': color === 'red',
                }"
            >
                <!-- Briefcase -->
                <svg
                    v-if="icon === 'briefcase'"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    class="h-5 w-5"
                >
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
                </svg>

                <!-- Check -->
                <svg
                    v-else-if="icon === 'check'"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    class="h-5 w-5"
                >
                    <path d="m5 12 4 4L19 6" />
                </svg>
            </div>

            <div class="min-w-0">
                <p class="text-xs font-medium text-slate-400">
                    {{ title }}
                </p>

                <p class="mt-0.5 text-xl font-bold text-[#16425B]">
                    {{ value }}
                </p>
            </div>
        </div>
    </div>
</template>