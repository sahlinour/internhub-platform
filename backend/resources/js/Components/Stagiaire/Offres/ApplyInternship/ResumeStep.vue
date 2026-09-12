<script setup>
import { computed } from 'vue'

const props = defineProps({
    stagiaire: {
        type: Object,
        default: null,
    },

    modelValue: {
        type: [Object, File, null],
        default: null,
    },

    error: {
        type: String,
        default: null,
    },
})

const emit = defineEmits([
    'update:modelValue',
])

const currentCv = computed(() => {
    return props.stagiaire?.stagiaire?.cv_url ||
        props.stagiaire?.cv_url ||
        null
})

const currentCvName = computed(() => {
    if (!currentCv.value) {
        return null
    }

    return currentCv.value.split('/').pop()
})

const selectedFileName = computed(() => {
    return props.modelValue?.name || null
})

const handleFileChange = (event) => {
    const file = event.target.files[0] || null

    emit('update:modelValue', file)
}
</script>

<template>
    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
        <div class="mb-6">
            <h2 class="text-xl font-bold text-slate-900">
                Resume
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Add your CV to complete your application.
            </p>
        </div>

        <!-- Existing CV -->
        <div
            v-if="currentCv"
            class="mb-6 rounded-xl border border-slate-200 bg-slate-50 p-4"
        >
            <div class="flex items-center gap-4">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-[#2F6690]/10 text-[#2F6690]">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M7 3h7l5 5v13H7V3z"
                        />
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M14 3v6h5"
                        />
                    </svg>
                </div>

                <div class="min-w-0">
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                        Current resume
                    </p>

                    <p class="mt-1 truncate text-sm font-semibold text-slate-800">
                        {{ currentCvName }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Upload -->
        <div>
            <label class="mb-2 block text-sm font-medium text-slate-700">
                {{ currentCv ? 'Replace your resume' : 'Upload your resume' }}
            </label>

            <label
                class="flex cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-slate-300 px-6 py-10 text-center transition hover:border-[#2F6690] hover:bg-[#2F6690]/5"
            >
                <div class="mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-[#2F6690]/10 text-[#2F6690]">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 16V4m0 0L7 9m5-5l5 5"
                        />
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M5 20h14"
                        />
                    </svg>
                </div>

                <p class="text-sm font-semibold text-slate-700">
                    {{ selectedFileName || 'Click to upload your CV' }}
                </p>

                <p class="mt-1 text-xs text-slate-400">
                    PDF, DOC or DOCX — maximum 5 MB
                </p>

                <input
                    type="file"
                    accept=".pdf,.doc,.docx"
                    class="hidden"
                    @change="handleFileChange"
                />
            </label>

            <p
                v-if="error"
                class="mt-2 text-sm text-red-600"
            >
                {{ error }}
            </p>

            <p
                v-if="selectedFileName"
                class="mt-3 text-sm text-[#2F6690]"
            >
                Selected file: {{ selectedFileName }}
            </p>
        </div>

        <div class="mt-6 rounded-xl bg-slate-50 p-4">
            <p class="text-sm text-slate-600">
                If you don't upload a new CV, your current profile CV will be used automatically.
            </p>
        </div>
    </section>
</template>