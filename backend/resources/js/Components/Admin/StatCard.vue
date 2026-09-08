<script setup>
import Icon from '@/Components/Admin/Icon.vue'

defineProps({
    label: {
        type: String,
        required: true,
    },

    value: {
        type: [String, Number],
        required: true,
    },

    detail: {
        type: String,
        default: '',
    },

    icon: {
        type: String,
        required: true,
    },
})
</script>

<template>
    <article
        class="rounded-[11px]
               border border-[#e1e7ec]
               bg-white p-4
               shadow-[0_2px_8px_rgba(35,63,85,0.04)]"
    >
        <!-- ICON -->
        <div
            class="mb-3 flex h-9 w-9
                   items-center justify-center
                   rounded-[9px]
                   bg-[#286d93]
                   text-white
                   [&_svg]:fill-none
                   [&_svg]:stroke-current"
        >
            <Icon
                :name="icon"
                :size="18"
            />
        </div>

        <!-- VALUE -->
        <strong
            class="mb-1 block
                   text-[20px] font-bold
                   text-[#1f3547]"
        >
            {{ value }}
        </strong>

        <!-- LABEL -->
        <span
            class="mb-1.5 block
                   text-[11px]
                   text-[#778b99]"
        >
            {{ label }}
        </span>

        <!-- DETAIL -->
        <small
            v-if="detail"
            class="text-[9px]
                   text-[#4baa70]"
        >
            {{ detail }}
        </small>
    </article>
</template>
