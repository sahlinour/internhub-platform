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
        class="mt-6 flex flex-wrap justify-center gap-2"
    >
        <Link
            v-for="(link, index) in links"
            :key="index"
            :href="link.url ?? '#'"
            preserve-scroll
            class="rounded-lg border px-3 py-2 text-sm transition"
            :class="[
                link.active
                    ? 'border-[#2F6690] bg-[#2F6690] text-white'
                    : 'border-slate-200 bg-white text-slate-600 hover:bg-slate-50',
                !link.url ? 'pointer-events-none opacity-40' : '',
            ]"
        >
            <span v-html="link.label" />
        </Link>
    </div>
</template>