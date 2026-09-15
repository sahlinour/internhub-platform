<script setup>
import { computed } from 'vue'

const props = defineProps({
    user: {
        type: Object,
        default: () => ({}),
    },
})

const initials = computed(() => {
    const name = props.user?.name ?? 'Encadrant'

    return name
        .split(' ')
        .filter(Boolean)
        .slice(0, 2)
        .map(word => word[0]?.toUpperCase())
        .join('')
})
</script>

<template>
    <header
        class="flex h-16 items-center justify-between
               border-b border-gray-100 bg-white px-6"
    >
        <div class="w-full max-w-md">
            <div class="relative">
                <svg
                    class="absolute left-3 top-1/2 h-4 w-4
                           -translate-y-1/2 text-gray-400"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="m21 21-4.35-4.35m2.35-5.65a8 8 0
                           11-16 0 8 8 0 0116 0z"
                    />
                </svg>

                <input
                    type="text"
                    placeholder="Rechercher un stagiaire, une tâche..."
                    class="w-full rounded-lg border border-gray-200
                           bg-gray-50 py-2 pl-10 pr-4 text-sm
                           outline-none transition
                           focus:border-[#17629b] focus:ring-1
                           focus:ring-[#17629b]"
                />
            </div>
        </div>

        <div class="ml-5 flex items-center gap-4">
            <button
                type="button"
                class="relative text-gray-500 hover:text-gray-700"
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
                        d="M15 17h5l-1.4-1.4A2 2 0 0118
                           14.2V11a6 6 0 10-12 0v3.2a2 2
                           0 01-.6 1.4L4 17h5m6 0a3 3
                           0 01-6 0"
                    />
                </svg>

                <span
                    class="absolute -right-1 -top-1 h-2 w-2
                           rounded-full bg-red-500"
                />
            </button>

            <div class="flex items-center gap-2">
                <div
                    class="flex h-9 w-9 items-center justify-center
                           rounded-full bg-violet-500
                           text-xs font-bold text-white"
                >
                    {{ initials }}
                </div>

                <div class="hidden md:block">
                    <p class="text-xs font-semibold text-gray-800">
                        {{ user?.name ?? 'Encadrant' }}
                    </p>

                    <p class="text-[10px] text-gray-400">
                        Encadrant
                    </p>
                </div>
            </div>
        </div>
    </header>
</template>
