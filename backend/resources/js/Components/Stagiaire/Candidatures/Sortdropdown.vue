<script setup>
import { computed, onBeforeUnmount, onMounted, ref } from 'vue'

const props = defineProps({
    modelValue: {
        type: String,
        required: true,
    },

    options: {
        type: Array,
        default: () => [
            {
                label: 'Recently Updated',
                value: 'recently_updated',
            },
            {
                label: 'Recently Applied',
                value: 'recently_applied',
            },
            {
                label: 'Company (A-Z)',
                value: 'company_asc',
            },
            {
                label: 'Status',
                value: 'status',
            },
            {
                label: 'Deadline',
                value: 'deadline',
            },
        ],
    },
})

const emit = defineEmits(['update:modelValue'])

const isOpen = ref(false)
const root = ref(null)

const selectedLabel = computed(() => {
    return (
        props.options.find(
            (option) => option.value === props.modelValue
        )?.label ?? props.options[0]?.label
    )
})

const select = (option) => {
    emit('update:modelValue', option.value)
    isOpen.value = false
}

const handleClickOutside = (event) => {
    if (root.value && !root.value.contains(event.target)) {
        isOpen.value = false
    }
}

onMounted(() => {
    document.addEventListener('click', handleClickOutside)
})

onBeforeUnmount(() => {
    document.removeEventListener('click', handleClickOutside)
})
</script>

<template>
    <div ref="root" class="relative shrink-0">
        <button
            type="button"
            class="flex items-center gap-2 rounded-lg border
                   border-slate-200 bg-white px-3.5 py-2
                   text-xs font-medium text-slate-600 shadow-sm
                   transition hover:border-slate-300 hover:bg-slate-50"
            @click="isOpen = !isOpen"
        >
            <svg
                class="h-3.5 w-3.5 text-slate-400"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1.8"
                    d="M3 7h18M6 12h12M10 17h4"
                />
            </svg>

            <span class="text-slate-400">
                Sort by:
            </span>

            <span class="font-semibold text-[#16425B]">
                {{ selectedLabel }}
            </span>

            <svg
                class="h-3.5 w-3.5 shrink-0 text-slate-400 transition duration-150"
                :class="{ 'rotate-180': isOpen }"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1.8"
                    d="m6 9 6 6 6-6"
                />
            </svg>
        </button>

        <Transition
            enter-active-class="transition duration-150 ease-out"
            enter-from-class="opacity-0 -translate-y-1"
            enter-to-class="opacity-100 translate-y-0"
            leave-active-class="transition duration-100 ease-in"
            leave-from-class="opacity-100 translate-y-0"
            leave-to-class="opacity-0 -translate-y-1"
        >
            <div
                v-if="isOpen"
                class="absolute right-0 z-20 mt-2 w-52
                       overflow-hidden rounded-xl border
                       border-slate-200 bg-white py-1.5 shadow-lg"
            >
                <button
                    v-for="option in options"
                    :key="option.value"
                    type="button"
                    class="flex w-full items-center justify-between
                           px-3.5 py-2 text-left text-xs
                           transition hover:bg-slate-50"
                    :class="
                        option.value === modelValue
                            ? 'font-semibold text-[#16425B]'
                            : 'text-slate-600'
                    "
                    @click="select(option)"
                >
                    {{ option.label }}

                    <svg
                        v-if="option.value === modelValue"
                        class="h-3.5 w-3.5 shrink-0 text-[#16425B]"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M5 13l4 4L19 7"
                        />
                    </svg>
                </button>
            </div>
        </Transition>
    </div>
</template>