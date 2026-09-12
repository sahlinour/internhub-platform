<script setup>
import { computed } from 'vue'

const props = defineProps({
    modelValue: {
        type: String,
        default: '',
    },

    error: {
        type: String,
        default: null,
    },
})

const emit = defineEmits([
    'update:modelValue',
])

const characterCount = computed(() => {
    return props.modelValue.length
})

const updateValue = (event) => {
    emit('update:modelValue', event.target.value)
}
</script>

<template>
    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
        <div class="mb-6">
            <h2 class="text-xl font-bold text-slate-900">
                Cover Letter
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Tell the company why you are interested in this internship.
            </p>
        </div>

        <div>
            <label
                for="cover-letter"
                class="mb-2 block text-sm font-medium text-slate-700"
            >
                Your cover letter
            </label>

            <textarea
                id="cover-letter"
                :value="modelValue"
                @input="updateValue"
                rows="12"
                maxlength="2000"
                placeholder="Write your cover letter here..."
                class="w-full resize-y rounded-xl border border-slate-300 px-4 py-3 text-sm leading-6 text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-[#2F6690] focus:ring-2 focus:ring-[#2F6690]/10"
            ></textarea>

            <div class="mt-2 flex items-start justify-between gap-4">
                <p
                    v-if="error"
                    class="text-sm text-red-600"
                >
                    {{ error }}
                </p>

                <p class="ml-auto shrink-0 text-xs text-slate-400">
                    {{ characterCount }}/2000
                </p>
            </div>
        </div>

        <div class="mt-6 rounded-xl bg-[#2F6690]/5 p-4">
            <p class="text-sm font-medium text-slate-700">
                Tip
            </p>

            <p class="mt-1 text-sm leading-6 text-slate-500">
                Explain your motivation, relevant skills and why this internship
                is a good fit for your career goals.
            </p>
        </div>
    </section>
</template>