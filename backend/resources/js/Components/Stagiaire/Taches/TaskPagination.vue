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
        v-if="links?.length > 3"
        class="flex flex-wrap items-center justify-center gap-1 border-t border-slate-100 px-5 py-4"
    >
        <template
            v-for="(link, index) in links"
            :key="index"
        >
            <Link
                v-if="link.url"
                :href="link.url"
                preserve-scroll
                class="flex h-7 min-w-7 items-center justify-center rounded-md px-2 text-[9px] font-medium transition"
                :class="
                    link.active
                        ? 'bg-[#3A7CA5] text-white'
                        : 'text-slate-500 hover:bg-slate-100'
                "
            >
                <span v-html="link.label"></span>
            </Link>

            <span
                v-else
                class="flex h-7 min-w-7 items-center justify-center rounded-md px-2 text-[9px] text-slate-300"
            >
                <span v-html="link.label"></span>
            </span>
        </template>
    </div>
</template>