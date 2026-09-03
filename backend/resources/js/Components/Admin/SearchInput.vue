<script setup>
const model = defineModel({
    type: String,
    default: '',
})

defineProps({
    placeholder: {
        type: String,
        default: 'Search...',
    },
})

const emit = defineEmits(['search'])

const submit = () => {
    emit('search')
}

const clearSearch = () => {
    model.value = ''
    emit('search')
}
</script>

<template>
    <form
        class="flex min-h-[42px] w-[320px]
               items-center gap-[10px]
               rounded-[10px]
               border border-[#d9e3ea]
               bg-white px-[14px]
               text-[#7e929f]
               shadow-[0_1px_2px_rgba(30,60,80,0.03)]
               transition duration-[180ms]
               focus-within:border-[#6f9eb7]
               focus-within:shadow-[0_0_0_3px_rgba(39,109,147,0.08)]
               max-[700px]:w-full"
        @submit.prevent="submit"
    >
        <!-- SEARCH ICON -->
        <svg
            viewBox="0 0 24 24"
            class="h-[15px] w-[15px] shrink-0
                   fill-none stroke-current
                   [stroke-width:1.8]
                   [stroke-linecap:round]
                   [stroke-linejoin:round]"
            aria-hidden="true"
        >
            <circle cx="11" cy="11" r="7" />
            <path d="m20 20-3.5-3.5" />
        </svg>

        <!-- INPUT -->
        <input
            v-model="model"
            type="search"
            :placeholder="placeholder"
            class="min-w-0 flex-1
                   border-0 bg-transparent p-0
                   text-[12px] text-[#314b5c]
                   outline-none ring-0
                   placeholder:text-[#9aaab4]
                   focus:border-0
                   focus:outline-none
                   focus:ring-0"
        />

        <!-- CLEAR -->
        <button
            v-if="model"
            type="button"
            aria-label="Clear search"
            class="flex h-[26px] w-[26px]
                   shrink-0 cursor-pointer
                   items-center justify-center
                   rounded-md border-0
                   bg-transparent p-0
                   text-[16px] leading-none
                   text-[#81929d]
                   transition duration-[180ms]
                   hover:bg-[#f1f5f7]
                   hover:text-[#37596c]"
            @click="clearSearch"
        >
            ×
        </button>
    </form>
</template>
