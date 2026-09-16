<script setup>
import Icon from '@/Components/Stagiaire/Icon.vue'

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
    iconClass: {
        type: String,
        default: 'bg-blue-50 text-[#2d7da0]',
    },
    detailClass: {
        type: String,
        default: 'text-gray-400',
    },
})
</script>

<template>
    <article
        class="rounded-xl border border-gray-100
               bg-white p-5 shadow-sm
               transition duration-200
               hover:-translate-y-0.5 hover:shadow-md"
    >
        <div class="flex items-start justify-between">
            <div>
                <p class="text-[10px] font-medium text-gray-400">
                    {{ label }}
                </p>

                <p class="mt-2 text-[25px] font-bold text-gray-800">
                    {{ value }}
                </p>

                <p
                    v-if="detail"
                    class="mt-1 text-[9px]"
                    :class="detailClass"
                >
                    {{ detail }}
                </p>
            </div>

            <div
                class="flex h-10 w-10 items-center justify-center
                       rounded-xl"
                :class="iconClass"
            >
                <Icon
                    :name="icon"
                    :size="20"
                />
            </div>
        </div>
    </article>
</template>