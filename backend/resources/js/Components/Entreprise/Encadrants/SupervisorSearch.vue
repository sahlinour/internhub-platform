<script setup>
defineProps({
    modelValue: {
        type: String,
        default: '',
    },
})

const emit = defineEmits(['update:modelValue'])
</script>

<template>
    <div class="max-w-md">
        <div class="relative">
            <svg
                class="absolute left-3.5 top-1/2 h-4 w-4
                       -translate-y-1/2 text-slate-400"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <circle
                    cx="11"
                    cy="11"
                    r="8"
                    stroke-width="2"
                />

                <path
                    stroke-linecap="round"
                    stroke-width="2"
                    d="m21 21-4.35-4.35"
                />
            </svg>

            <input
                :value="modelValue"
                type="text"
                placeholder="Search supervisors..."
                class="w-full rounded-xl
                       border border-slate-200
                       bg-white py-2.5 pl-10 pr-4
                       text-xs text-slate-700
                       outline-none transition
                       placeholder:text-slate-400
                       focus:border-[#3A7CA5]
                       focus:ring-2
                       focus:ring-[#3A7CA5]/10"
                @input="
                    emit(
                        'update:modelValue',
                        $event.target.value
                    )
                "
            />
        </div>
    </div>
</template>