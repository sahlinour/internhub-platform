<script setup>
import { computed } from 'vue'

const props = defineProps({
    name: {
        type: String,
        default: '',
    },

    photo: {
        type: String,
        default: null,
    },

    size: {
        type: Number,
        default: 32,
    },
})

const initials = computed(() => {
    if (!props.name) return 'U'

    return props.name
        .trim()
        .split(/\s+/)
        .map(word => word.charAt(0))
        .join('')
        .slice(0, 2)
        .toUpperCase()
})

const photoUrl = computed(() => {
    if (!props.photo) return null

    // Already a complete URL
    if (
        props.photo.startsWith('http://') ||
        props.photo.startsWith('https://')
    ) {
        return props.photo
    }

    // Already points to Laravel storage
    if (props.photo.startsWith('/storage/')) {
        return props.photo
    }

    // Stored Laravel path:
    // profiles/entreprises/example.jpg
    return `/storage/${props.photo}`
})
</script>

<template>
    <div
        class="inline-flex shrink-0
               select-none items-center justify-center
               overflow-hidden rounded-xl
               bg-[#e7f0f5]
               text-[12px] font-bold
               leading-none text-[#174966]"
        :style="{
            width: `${size}px`,
            height: `${size}px`,
        }"
    >
        <!-- PHOTO -->
        <img
            v-if="photoUrl"
            :src="photoUrl"
            :alt="name || 'User'"
            class="block h-full w-full
                   object-cover object-center"
        />

        <!-- INITIALS -->
        <span
            v-else
            class="flex h-full w-full
                   items-center justify-center"
        >
            {{ initials }}
        </span>
    </div>
</template>
