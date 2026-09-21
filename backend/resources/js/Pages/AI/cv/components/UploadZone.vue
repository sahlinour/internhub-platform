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

  // Send the selected file to App.vue
  emit('file', file)
}

function handleFileChange(event) {
  const file = event.target.files?.[0]

  if (file) {
    validateFile(file)
  }

  // Reset input so the same CV can be selected again
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

    <!-- Upload zone -->
    <label
      for="cv-upload"
      class="group block cursor-pointer"
      @dragenter="handleDragEnter"
      @dragover="handleDragOver"
      @dragleave="handleDragLeave"
      @drop="handleDrop"
    >
      <div
        class="rounded-2xl border-2 border-dashed px-6 py-14 text-center transition-all duration-200"
        :class="
          dragging
            ? 'border-steel bg-sky/20'
            : 'border-steel/50 bg-white hover:border-steel hover:bg-mist'
        "
      >

        <!-- Icon -->
        <div
          class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-sky transition-transform duration-200 group-hover:scale-105"
        >
          <svg
            class="h-8 w-8 text-navy"
            viewBox="0 0 24 24"
            fill="none"
            aria-hidden="true"
          >
            <path
              d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"
              stroke="currentColor"
              stroke-width="1.8"
            />

            <path
              d="M14 2v6h6"
              stroke="currentColor"
              stroke-width="1.8"
            />

            <path
              d="M8 13h8M8 17h5"
              stroke="currentColor"
              stroke-width="1.8"
              stroke-linecap="round"
            />
          </svg>
        </div>

        <!-- Title -->
        <h3 class="mt-5 font-display text-xl font-bold text-navy">
          Upload your CV
        </h3>

        <!-- Description -->
        <p class="mx-auto mt-2 max-w-md text-sm text-navy/70">
          Upload your CV in PDF format and we'll compare
          your profile with available internship offers.
        </p>

        <!-- Button visual -->
        <span
          class="mt-6 inline-flex items-center justify-center rounded-lg bg-navy px-5 py-3 text-sm font-semibold text-white transition-colors group-hover:bg-steel"
        >
          Choose PDF
        </span>

        <!-- Real file input -->
        <input
          id="cv-upload"
          type="file"
          accept=".pdf,application/pdf"
          class="sr-only"
          @change="handleFileChange"
        />

        <!-- Info -->
        <p class="mt-4 text-xs text-navy/55">
          PDF only · Maximum 10 MB
        </p>

        <p class="mt-1 text-xs text-navy/50">
          Click anywhere in this box or drag and drop your CV here
        </p>

      </div>
    </label>

    <!-- Error -->
    <div
      v-if="error"
      class="mt-4 rounded-xl border border-red-200 bg-red-50 p-4"
      role="alert"
    >
      <p class="font-semibold text-red-700">
        Invalid file
      </p>

      <p class="mt-1 text-sm text-red-600">
        {{ error }}
      </p>
    </div>

  </div>
</template>