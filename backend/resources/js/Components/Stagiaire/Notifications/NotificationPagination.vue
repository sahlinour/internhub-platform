<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    links: {
        type: Array,
        default: () => [],
    },
})
</script>

<template>
    <div
        v-if="links.length > 3"
        class="flex items-center justify-center
               border-t border-slate-100 px-4 py-3"
    >
        <div class="flex items-center gap-1">
            <template
                v-for="(link, index) in links"
                :key="index"
            >
                <Link
                    v-if="link.url"
                    :href="link.url"
                    preserve-scroll
                    class="flex h-7 min-w-7 items-center
                           justify-center rounded-md px-2
                           text-[9px] font-medium transition"
                    :class="
                        link.active
                            ? 'bg-[#16425B] text-white'
                            : 'text-slate-500 hover:bg-slate-100'
                    "
                    v-html="link.label"
                />

                <span
                    v-else
                    class="flex h-7 min-w-7 items-center
                           justify-center px-2 text-[9px]
                           text-slate-300"
                    v-html="link.label"
                />
            </template>
        </div>
    </div>
</template>