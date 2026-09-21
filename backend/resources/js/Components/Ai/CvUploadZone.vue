<script setup>
import { ref } from 'vue'

const emit = defineEmits(['analyze'])

const isDragging = ref(false)
const selectedFile = ref(null)
const errorMessage = ref('')
const fileInput = ref(null)

const ALLOWED_EXTENSIONS = ['.pdf', '.doc', '.docx']
const MAX_SIZE_MB = 5

function validateFile(file) {
  const ext = '.' + file.name.split('.').pop().toLowerCase()
  if (!ALLOWED_EXTENSIONS.includes(ext)) {
    return `Unsupported format. Use a ${ALLOWED_EXTENSIONS.join(', ')} file.`
  }
  if (file.size > MAX_SIZE_MB * 1024 * 1024) {
    return `File exceeds ${MAX_SIZE_MB} MB.`
  }
  return ''
}

function handleFile(file) {
  const error = validateFile(file)
  if (error) {
    errorMessage.value = error
    selectedFile.value = null
    return
  }
  errorMessage.value = ''
  selectedFile.value = file
}

function onDrop(e) {
  isDragging.value = false
  const file = e.dataTransfer.files[0]
  if (file) handleFile(file)
}

function onFileInputChange(e) {
  const file = e.target.files[0]
  if (file) handleFile(file)
}

function removeFile() {
  selectedFile.value = null
  errorMessage.value = ''
  if (fileInput.value) fileInput.value.value = ''
}

function formatSize(bytes) {
  const kb = bytes / 1024
  return kb < 1024 ? `${kb.toFixed(0)} KB` : `${(kb / 1024).toFixed(1)} MB`
}

function startAnalysis() {
  if (selectedFile.value) emit('analyze', selectedFile.value)
}
</script>

<template>
  <div class="w-full max-w-xl mx-auto">
    <label
      class="relative flex flex-col items-center justify-center gap-3 rounded-2xl border-2 border-dashed px-6 py-12 text-center cursor-pointer transition-colors"
      :class="isDragging ? 'border-secondary bg-accent/20' : 'border-secondary/25 bg-surface hover:border-secondary/50'"
      @dragover.prevent="isDragging = true"
      @dragleave.prevent="isDragging = false"
      @drop.prevent="onDrop"
    >
      <input
        ref="fileInput"
        type="file"
        accept=".pdf,.doc,.docx"
        class="sr-only"
        @change="onFileInputChange"
      />

      <svg class="h-10 w-10 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9m0 0-3 3m3-3 3 3M6.75 19.5a4.5 4.5 0 0 1-1.41-8.775 5.25 5.25 0 0 1 10.233-2.33 3.75 3.75 0 0 1 4.874 3.723A4.5 4.5 0 0 1 18.75 19.5H6.75Z" />
      </svg>

      <div>
        <p class="font-display font-medium text-primary">Drag your CV here or click to browse</p>
        <p class="mt-1 text-sm text-primary/60">PDF, DOC or DOCX — 5 MB max</p>
      </div>
    </label>

    <p v-if="errorMessage" class="mt-3 text-sm text-red-600">{{ errorMessage }}</p>

    <div v-if="selectedFile" class="mt-4 flex items-center justify-between rounded-xl border border-secondary/15 bg-surface px-4 py-3">
      <div class="flex min-w-0 items-center gap-3">
        <svg class="h-6 w-6 shrink-0 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
        </svg>
        <div class="min-w-0">
          <p class="truncate text-sm font-medium text-primary">{{ selectedFile.name }}</p>
          <p class="text-xs text-primary/60">{{ formatSize(selectedFile.size) }}</p>
        </div>
      </div>
      <button
        type="button"
        class="shrink-0 rounded-full p-1.5 text-primary/50 hover:bg-white hover:text-primary"
        @click="removeFile"
        aria-label="Remove file"
      >
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
        </svg>
      </button>
    </div>

    <button
      type="button"
      class="mt-5 w-full rounded-xl bg-primary py-3 font-display font-medium text-white transition-opacity hover:opacity-90 disabled:cursor-not-allowed disabled:opacity-40"
      :disabled="!selectedFile"
      @click="startAnalysis"
    >
      Analyze my CV
    </button>
  </div>
</template>
