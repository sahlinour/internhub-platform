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
        class="mt-6 flex flex-wrap items-center justify-center gap-1"
    >
        <Link
            v-for="(link, index) in links"
            :key="index"
            :href="link.url || '#'"
            preserve-scroll
            class="min-w-9 rounded-lg px-3 py-2 text-sm font-medium transition"
            :class="[
                link.active
                    ? 'bg-[#2F6690] text-white'
                    : 'text-slate-500 hover:bg-slate-100 hover:text-[#16425B]',
                !link.url
                    ? 'pointer-events-none opacity-40'
                    : ''
            ]"
            v-html="link.label"
        />
    </div>
</template>