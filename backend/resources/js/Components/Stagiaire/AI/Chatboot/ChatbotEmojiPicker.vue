<script setup>
defineProps({
    emojis: {
        type: Array,
        required: true
    }
})

defineEmits(['select'])
</script>

<template>
    <div
        class="absolute bottom-full left-3 mb-2
               grid w-60 grid-cols-6 gap-1
               rounded-2xl
               border border-[#E2E8F0]
               bg-white p-3
               shadow-[0_10px_30px_rgba(22,66,91,0.15)]"
    >
        <button
            v-for="emoji in emojis"
            :key="emoji"
            type="button"
            @click="$emit('select', emoji)"
            class="rounded-lg p-1.5 text-lg
                   transition hover:bg-[#E8F1F5]"
        >
            {{ emoji }}
        </button>
    </div>
</template>