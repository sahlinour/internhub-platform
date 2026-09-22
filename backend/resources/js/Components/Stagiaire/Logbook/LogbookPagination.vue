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
        class="mt-6 flex flex-wrap
               items-center justify-center gap-1"
    >
        <Link
            v-for="(link, index) in links"
            :key="index"
            :href="link.url ?? '#'"
            class="rounded-lg px-3 py-1.5
                   text-[9px] font-medium
                   transition"
            :class="[
                link.active
                    ? 'bg-[#2F6690] text-white'
                    : 'bg-white text-[#64748B] hover:bg-[#E8F1F5]',
                !link.url
                    ? 'pointer-events-none opacity-40'
                    : ''
            ]"
            v-html="link.label"
        />
    </div>
</template>