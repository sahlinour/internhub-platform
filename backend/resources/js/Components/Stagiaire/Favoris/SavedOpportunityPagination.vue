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
        class="mt-6 flex flex-wrap justify-center gap-1"
    >
        <Link
            v-for="(link, index) in links"
            :key="index"
            :href="link.url || '#'"
            preserve-scroll
            class="flex min-h-8 min-w-8 items-center justify-center
                   rounded-lg border px-2 text-[10px] transition"
            :class="[
                link.active
                    ? 'border-[#2F6690] bg-[#2F6690] text-white'
                    : 'border-slate-200 bg-white text-slate-500 hover:border-[#2F6690] hover:text-[#2F6690]',
                !link.url ? 'pointer-events-none opacity-40' : '',
            ]"
            v-html="link.label"
        />
    </div>
</template>