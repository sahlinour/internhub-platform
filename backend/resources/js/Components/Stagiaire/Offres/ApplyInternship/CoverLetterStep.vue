<script setup>
import { computed } from 'vue'

const props = defineProps({
    modelValue: { type: String, default: '' },
    error: { type: String, default: null },
})

const emit = defineEmits(['update:modelValue'])

const characterCount = computed(() => props.modelValue.length)

const updateValue = (event) =>
    emit('update:modelValue', event.target.value)
</script>

<template>
    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
        <header class="mb-5">
            <h2 class="text-lg font-bold text-[#16425B]">Cover Letter</h2>
            <p class="mt-1 text-xs text-slate-500">
                Tell the company why you are interested in this internship.
            </p>
        </header>

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
                rows="10"
                maxlength="2000"
                placeholder="Write your cover letter here..."
                @input="updateValue"
                class="w-full resize-y rounded-xl border border-slate-300 px-4 py-3 text-sm leading-6 text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-[#3A7CA5] focus:ring-2 focus:ring-[#3A7CA5]/10"
            ></textarea>

            <div class="mt-2 flex justify-between gap-4">
                <p v-if="error" class="text-xs text-red-600">
                    {{ error }}
                </p>

                <span class="ml-auto text-xs text-slate-400">
                    {{ characterCount }}/2000
                </span>
            </div>
        </div>

        <div class="mt-5 rounded-xl border border-[#81C3D7]/40 bg-[#E8F1F5] p-4">
            <p class="text-xs font-semibold text-[#16425B]">Tip</p>
            <p class="mt-1 text-xs leading-5 text-[#2F6690]">
                Explain your motivation, relevant skills and why this internship
                is a good fit for your career goals.
            </p>
        </div>
    </section>
</template>