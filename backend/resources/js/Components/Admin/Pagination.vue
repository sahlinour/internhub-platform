<script setup>
import { router } from '@inertiajs/vue3'

defineProps({
    links: {
        type: Array,
        default: () => [],
    },
})

const goTo = (url) => {
    if (!url) {
        return
    }

    router.get(
        url,
        {},
        {
            preserveState: true,
            preserveScroll: true,
        }
    )
}
</script>

<template>
    <div
        v-if="links.length > 3"
        class="flex items-center justify-end gap-1.5 pt-5"
    >
        <button
            v-for="link in links"
            :key="link.label"
            type="button"
            :disabled="!link.url"
            @click="goTo(link.url)"
            v-html="link.label"
            class="h-[34px] min-w-[34px]
                   cursor-pointer rounded-lg
                   border border-[#d9e3ea]
                   bg-white px-[10px]
                   text-[10px] font-semibold
                   text-[#5b7180]
                   transition
                   duration-[180ms]
                   hover:border-[#aac3d0]
                   hover:bg-[#f7fafb]
                   disabled:cursor-default
                   disabled:opacity-40"
            :class="
                link.active
                    ? '!border-[#174966] !bg-[#174966] !text-white'
                    : ''
            "
        />
    </div>
</template>
