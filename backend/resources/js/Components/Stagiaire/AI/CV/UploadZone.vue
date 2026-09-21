```vue
<script setup>
import { ref } from 'vue'

const emit = defineEmits(['file'])

const dragging = ref(false)
const error = ref('')

const MAX_SIZE = 10 * 1024 * 1024

function validateFile(file) {
    error.value = ''

    if (!file) {
        return
    }

    const isPdf =
        file.type === 'application/pdf' ||
        file.name.toLowerCase().endsWith('.pdf')

    if (!isPdf) {
        error.value = 'Please upload a PDF file.'
        return
    }

    if (file.size > MAX_SIZE) {
        error.value = 'Your CV must not exceed 10 MB.'
        return
    }

    emit('file', file)
}

function handleFileChange(event) {
    const file = event.target.files?.[0]

    if (file) {
        validateFile(file)
    }

    event.target.value = ''
}

function handleDragOver(event) {
    event.preventDefault()
    event.stopPropagation()
    dragging.value = true
}

function handleDragEnter(event) {
    event.preventDefault()
    event.stopPropagation()
    dragging.value = true
}

function handleDragLeave(event) {
    event.preventDefault()
    event.stopPropagation()
    dragging.value = false
}

function handleDrop(event) {
    event.preventDefault()
    event.stopPropagation()

    dragging.value = false

    const file = event.dataTransfer?.files?.[0]

    if (file) {
        validateFile(file)
    }
}
</script>

<template>
    <div class="w-full">

        <!-- Upload Card -->
        <label
            for="cv-upload"
            class="group block cursor-pointer"
            @dragenter="handleDragEnter"
            @dragover="handleDragOver"
            @dragleave="handleDragLeave"
            @drop="handleDrop"
        >
            <div
                class="relative overflow-hidden rounded-2xl border bg-white shadow-[0_2px_12px_rgba(22,66,91,0.05)] transition-all duration-200"
                :class="
                    dragging
                        ? 'border-[#3A7CA5] bg-[#F4FAFC] shadow-[0_6px_20px_rgba(47,102,144,0.10)]'
                        : 'border-[#E2E8F0] hover:border-[#81C3D7] hover:shadow-[0_6px_20px_rgba(22,66,91,0.08)]'
                "
            >

                <!-- Top accent -->
                <div
                    class="h-[3px] bg-gradient-to-r from-[#16425B] via-[#3A7CA5] to-[#81C3D7]"
                ></div>

                <div class="px-5 py-8 text-center sm:px-8 sm:py-10">

                    <!-- Upload Icon -->
                    <div
                        class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl border border-[#81C3D7]/40 bg-[#E8F1F5] text-[#16425B] transition-all duration-200 group-hover:scale-105 group-hover:bg-[#DDEDF3]"
                        :class="
                            dragging
                                ? 'scale-105 bg-[#DDEDF3]'
                                : ''
                        "
                    >
                        <svg
                            class="h-8 w-8"
                            viewBox="0 0 24 24"
                            fill="none"
                            aria-hidden="true"
                        >
                            <!-- PDF document -->
                            <path
                                d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"
                                stroke="currentColor"
                                stroke-width="1.7"
                                stroke-linejoin="round"
                            />

                            <path
                                d="M14 2v6h6"
                                stroke="currentColor"
                                stroke-width="1.7"
                                stroke-linejoin="round"
                            />

                            <!-- Upload arrow -->
                            <path
                                d="M12 16V11"
                                stroke="currentColor"
                                stroke-width="1.7"
                                stroke-linecap="round"
                            />

                            <path
                                d="M9.5 13.5L12 11l2.5 2.5"
                                stroke="currentColor"
                                stroke-width="1.7"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>
                    </div>

                    <!-- Title -->
                    <h3
                        class="mt-5 text-[17px] font-bold text-[#16425B] sm:text-[18px]"
                    >
                        Upload your CV
                    </h3>

                    <!-- Description -->
                    <p
                        class="mx-auto mt-2 max-w-lg text-[11px] leading-5 text-[#64748B]"
                    >
                        Upload your latest CV and let our AI analyze your
                        profile to find suitable internship opportunities.
                    </p>

                    <!-- Choose Button -->
                    <span
                        class="mt-5 inline-flex items-center gap-2 rounded-lg bg-[#16425B] px-5 py-2.5 text-[11px] font-semibold text-white shadow-sm transition-all duration-200 group-hover:bg-[#2F6690] group-hover:shadow-[0_4px_12px_rgba(22,66,91,0.16)]"
                    >
                        <svg
                            class="h-3.5 w-3.5"
                            viewBox="0 0 24 24"
                            fill="none"
                        >
                            <path
                                d="M12 16V4"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                            />

                            <path
                                d="M7 9l5-5 5 5"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />

                            <path
                                d="M5 20h14"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                            />
                        </svg>

                        Choose PDF
                    </span>

                    <!-- Real Input -->
                    <input
                        id="cv-upload"
                        type="file"
                        accept=".pdf,application/pdf"
                        class="sr-only"
                        @change="handleFileChange"
                    />

                    <!-- File Requirements -->
                    <div
                        class="mt-6 flex flex-wrap items-center justify-center gap-x-4 gap-y-2 text-[9px] text-[#94A3B8]"
                    >
                        <span class="inline-flex items-center gap-1.5">
                            <span
                                class="h-1.5 w-1.5 rounded-full bg-[#3A7CA5]"
                            ></span>
                            PDF only
                        </span>

                        <span class="text-[#CBD5E1]">•</span>

                        <span class="inline-flex items-center gap-1.5">
                            <span
                                class="h-1.5 w-1.5 rounded-full bg-[#81C3D7]"
                            ></span>
                            Maximum 10 MB
                        </span>
                    </div>

                    <!-- Drag & Drop Hint -->
                    <div
                        class="mt-4 inline-flex items-center gap-2 rounded-full bg-[#F4F7F9] px-3 py-1.5"
                    >
                        <svg
                            class="h-3 w-3 text-[#3A7CA5]"
                            viewBox="0 0 24 24"
                            fill="none"
                        >
                            <path
                                d="M12 16V4"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                            />

                            <path
                                d="M7 9l5-5 5 5"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />

                            <path
                                d="M5 20h14"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                            />
                        </svg>

                        <span
                            class="text-[9px] font-medium text-[#64748B]"
                        >
                            Click to browse or drag & drop your CV here
                        </span>
                    </div>

                </div>

                <!-- Dragging Overlay -->
                <div
                    v-if="dragging"
                    class="pointer-events-none absolute inset-0 flex items-center justify-center bg-[#E8F1F5]/30"
                >
                    <div
                        class="rounded-xl border border-[#3A7CA5] bg-white px-5 py-3 shadow-lg"
                    >
                        <p
                            class="text-[11px] font-bold text-[#16425B]"
                        >
                            Drop your CV here
                        </p>
                    </div>
                </div>

            </div>
        </label>

        <!-- Validation Error -->
        <div
            v-if="error"
            class="mt-4 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3.5"
            role="alert"
        >

            <div
                class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-red-100 text-red-600"
            >
                <svg
                    class="h-3.5 w-3.5"
                    viewBox="0 0 24 24"
                    fill="none"
                >
                    <path
                        d="M12 8v4"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                    />

                    <path
                        d="M12 16h.01"
                        stroke="currentColor"
                        stroke-width="2.5"
                        stroke-linecap="round"
                    />

                    <path
                        d="M10.3 3.8L2.9 17a2 2 0 0 0 1.7 3h14.8a2 2 0 0 0 1.7-3L13.7 3.8a2 2 0 0 0-3.4 0z"
                        stroke="currentColor"
                        stroke-width="1.7"
                        stroke-linejoin="round"
                    />
                </svg>
            </div>

            <div class="min-w-0">
                <p
                    class="text-[11px] font-bold text-red-700"
                >
                    Invalid file
                </p>

                <p
                    class="mt-0.5 text-[10px] leading-5 text-red-600"
                >
                    {{ error }}
                </p>
            </div>

        </div>

    </div>
</template>
```
