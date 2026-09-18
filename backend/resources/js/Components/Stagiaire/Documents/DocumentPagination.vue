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
        class="mt-5 flex
               flex-wrap
               justify-center
               gap-1"
    >
        <Link
            v-for="(link, index) in links"
            :key="index"
            :href="link.url || '#'"
            :disabled="!link.url"
            preserve-scroll
            class="rounded-[6px]
                   px-2.5 py-1.5
                   text-[9px]
                   font-medium
                   no-underline
                   transition"
            :class="[
                link.active
                    ? 'bg-[#2f6690] text-white'
                    : 'bg-white text-[#64748b] hover:bg-[#eef5f8] hover:text-[#286d93]',
                !link.url
                    ? 'cursor-not-allowed opacity-40'
                    : '',
            ]"
            v-html="link.label"
        />
    </div>
</template>