<script setup>
import { computed } from 'vue'

const props = defineProps({
    stagiaire: { type: Object, default: null },
    modelValue: { type: [File, null], default: null },
    error: { type: String, default: null },
})

const emit = defineEmits(['update:modelValue'])
const currentCv = computed(() =>
    props.stagiaire?.stagiaire?.cv_url || props.stagiaire?.cv_url || null
)
const currentCvName = computed(() =>
    currentCv.value ? currentCv.value.split('/').pop() : null
)
const selectedFileName = computed(() =>
    props.modelValue?.name || null
)
const handleFileChange = (event) => {
    emit('update:modelValue', event.target.files[0] || null)
}
</script>

<template>
    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
        <header class="mb-6">
            <h2 class="text-lg font-bold text-[#16425B]">Resume</h2>
            <p class="mt-1 text-xs text-slate-500">
                Add your CV to complete your application.
            </p>
        </header>

        <!-- Current CV -->
        <div
            v-if="currentCv && !selectedFileName"
            class="mb-6 rounded-xl border border-slate-200 bg-slate-50 p-4"
        >
            <div class="flex items-center gap-3">
                <div
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-[#E8F1F5] text-[#3A7CA5]"
                >
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
                    <p class="text-[10px] font-semibold uppercase tracking-wide text-slate-400">
                        Current resume
                    </p>
                    <p class="mt-1 truncate text-sm font-bold text-[#16425B]">
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

            <!-- Selected file -->
            <div
                v-if="selectedFileName"
                class="flex items-center justify-between gap-4 rounded-xl border border-[#81C3D7] bg-[#E8F1F5] p-4"
            >
                <div class="flex min-w-0 items-center gap-3">
                    <div
                        class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-white text-[#3A7CA5] shadow-sm"
                    >
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
                        <p class="text-[10px] font-semibold uppercase tracking-wide text-[#3A7CA5]">
                            Selected resume
                        </p>

                        <p class="mt-1 truncate text-sm font-bold text-[#16425B]">
                            {{ selectedFileName }}
                        </p>

                        <p class="mt-0.5 text-xs text-slate-500">
                            Ready to upload
                        </p>
                    </div>
                </div>

                <label
                    class="shrink-0 cursor-pointer rounded-lg bg-white px-3 py-2 text-xs font-semibold text-[#2F6690] shadow-sm transition hover:bg-[#16425B] hover:text-white"
                >
                    Change

                    <input
                        type="file"
                        accept=".pdf,.doc,.docx"
                        class="hidden"
                        @change="handleFileChange"
                    />
                </label>
            </div>

            <!-- Upload zone -->
            <label
                v-else
                class="flex cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-slate-300 bg-slate-50 px-6 py-9 text-center transition hover:border-[#3A7CA5] hover:bg-[#E8F1F5]"
            >
                <div
                    class="mb-3 flex h-11 w-11 items-center justify-center rounded-full bg-[#E8F1F5] text-[#3A7CA5]"
                >
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
                    Click to upload your CV
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

            <p v-if="error" class="mt-2 text-xs text-red-600">
                {{ error }}
            </p>
        </div>

        <!-- Information -->
        <div class="mt-6 rounded-xl bg-[#E8F1F5] p-4">
            <p class="text-xs leading-5 text-[#2F6690]">
                If you don't upload a new CV, your current profile CV will be used automatically.
            </p>
        </div>
    </section>
</template>

