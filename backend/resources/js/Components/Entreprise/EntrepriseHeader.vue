<script setup>
import { usePage } from '@inertiajs/vue3'
import { ref } from 'vue'

const page = usePage()
const search = ref('')

const entreprise = page.props.auth?.user

const initials = () => {
    const name = entreprise?.nom_complet

    if (!name) return 'EN'

    return name
        .split(' ')
        .filter(Boolean)
        .map(word => word[0])
        .join('')
        .slice(0, 2)
        .toUpperCase()
}
</script>

<template>
    <header
        class="sticky top-0 z-40 flex h-[72px] items-center justify-between
               border-b border-gray-100 bg-white px-7"
    >
        <!-- SEARCH -->
        <div class="relative w-full max-w-[380px]">
            <svg
                class="absolute left-3.5 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
            >
                <circle cx="11" cy="11" r="7" />
                <path d="m20 20-3.5-3.5" />
            </svg>

            <input
                v-model="search"
                type="text"
                placeholder="Search applicants, interns..."
                class="h-[40px] w-full rounded-lg border border-gray-200
                       bg-white pl-10 pr-4 text-[12px] text-gray-700
                       outline-none transition
                       placeholder:text-gray-400
                       focus:border-[#63a9c6]
                       focus:ring-2 focus:ring-[#63a9c6]/10"
            />
        </div>

        <!-- RIGHT -->
        <div class="ml-6 flex shrink-0 items-center gap-5">

            <!-- NOTIFICATIONS -->
            <button
                type="button"
                class="relative flex h-9 w-9 items-center justify-center
                       rounded-full text-gray-500 transition
                       hover:bg-gray-100 hover:text-[#174e6d]"
            >
                <svg
                    viewBox="0 0 24 24"
                    class="h-[19px] w-[19px]"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9" />
                    <path d="M10 21h4" />
                </svg>

                <span
                    v-if="page.props.notifications_count"
                    class="absolute right-[5px] top-[4px] h-[7px] w-[7px]
                           rounded-full border border-white bg-red-500"
                ></span>
            </button>

            <!-- DIVIDER -->
            <div class="h-8 w-px bg-gray-100"></div>

            <!-- COMPANY -->
            <div class="flex items-center gap-3">
                <div
                    class="flex h-[36px] w-[36px] items-center justify-center
                           rounded-full bg-[#63a9c6]
                           text-[10px] font-bold text-white"
                >
                    {{ initials() }}
                </div>

                <div class="hidden min-w-0 sm:block">
                    <p
                        class="max-w-[150px] truncate
                               text-[11px] font-semibold text-gray-800"
                    >
                        {{ entreprise?.nom_complet ?? 'Company' }}
                    </p>

                    <p class="mt-[1px] text-[9px] text-gray-400">
                        Company
                    </p>
                </div>
            </div>
        </div>
    </header>
</template>
