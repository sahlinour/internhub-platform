<script setup>
import Icon from '@/Components/Admin/Icon.vue'

defineProps({
    title: {
        type: String,
        default: 'No results found',
    },

    description: {
        type: String,
        default: '',
    },

    icon: {
        type: String,
        default: 'users',
    },
})
</script>

<template>
    <div
        class="flex flex-col items-center
               px-5 py-[55px]
               text-center"
    >
        <!-- ICON -->
        <div
            class="mb-3 flex h-[50px] w-[50px]
                   items-center justify-center
                   rounded-full
                   bg-[#edf4f8]
                   text-[#447893]
                   [&_svg]:fill-none
                   [&_svg]:stroke-current"
        >
            <Icon
                :name="icon"
                :size="24"
            />
        </div>

        <!-- TITLE -->
        <h3
            class="mb-[5px]
                   text-[13px] font-semibold
                   text-[#334f61]"
        >
            {{ title }}
        </h3>

        <!-- DESCRIPTION -->
        <p
            v-if="description"
            class="m-0 max-w-md
                   text-[10px] leading-relaxed
                   text-[#92a1ac]"
        >
            {{ description }}
        </p>
    </div>
</template>
