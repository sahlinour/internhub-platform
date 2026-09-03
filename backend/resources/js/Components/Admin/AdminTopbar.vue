<script setup>
import { Link } from '@inertiajs/vue3'
import Icon from './Icon.vue'
</script>

<template>
    <header
        class="sticky top-0 z-30 flex h-[62px]
               items-center justify-between
               border-b border-[#e5ebf0]
               bg-white px-6
               max-[620px]:px-[14px]"
    >
        <!-- SEARCH -->
        <div
            class="flex w-[min(360px,45vw)]
                   items-center gap-[9px]
                   rounded-lg border border-[#dbe4eb]
                   bg-white px-3 py-2
                   text-[#8ca0ad]
                   max-[620px]:w-3/4"
        >
            <svg
                viewBox="0 0 24 24"
                class="h-4 w-4 shrink-0
                       fill-none stroke-current"
                stroke-width="1.8"
                stroke-linecap="round"
            >
                <circle cx="11" cy="11" r="7" />
                <path d="m20 20-3.5-3.5" />
            </svg>

            <input
                type="search"
                placeholder="Search users, companies, internships..."
                class="w-full border-0 bg-transparent
                       p-0 text-[11px] text-[#334f62]
                       outline-none ring-0
                       placeholder:text-[#9baab5]
                       focus:border-0 focus:ring-0"
            />
        </div>

        <!-- ACTIONS -->
        <div class="flex items-center gap-[17px]">

            <!-- NOTIFICATIONS -->
            <Link
                :href="route('admin.notifications.indexAll')"
                class="relative flex h-[34px] w-[34px]
                       items-center justify-center
                       rounded-lg text-[#587286]
                       no-underline transition
                       hover:bg-[#f2f6f8]
                       hover:text-[#286d93]"
            >
                <Icon
                    name="bell"
                    :size="18"
                />

                <span
                    class="absolute right-[6px] top-[5px]
                           h-[6px] w-[6px]
                           rounded-full border-2
                           border-white bg-[#d85e5e]"
                ></span>
            </Link>

            <!-- ADMIN PROFILE -->
            <div
                class="flex items-center gap-[9px]
                       max-[620px]:hidden"
            >
                <div
                    class="flex h-8 w-8
                           items-center justify-center
                           rounded-full bg-[#286d93]
                           text-[10px] font-bold text-white"
                >
                    A
                </div>

                <div>
                    <strong
                        class="block text-[10px]
                               font-bold text-[#294458]"
                    >
                        Administrator
                    </strong>

                    <span
                        class="mt-0.5 block
                               text-[8px] text-[#8d9ca7]"
                    >
                        InternHub Admin
                    </span>
                </div>
            </div>

        </div>
    </header>
</template>
