<script setup>
import { ref } from 'vue'

const emit = defineEmits(['file'])
const MAX_SIZE = 5 * 1024 * 1024
const ACCEPTED = ['.pdf', '.docx', '.txt']

const dragging = ref(false)
const localError = ref('')

function handle(file) {
  localError.value = ''
  if (!file) return
  const ok = ACCEPTED.some((ext) => file.name.toLowerCase().endsWith(ext))
  if (!ok) {
    localError.value = 'Use a PDF, DOCX or TXT file.'
    return
  }
  if (file.size > MAX_SIZE) {
    localError.value = 'The file is larger than 5 MB.'
    return
  }
  emit('file', file)
}

function onDrop(e) {
  dragging.value = false
  handle(e.dataTransfer.files[0])
}

function onChange(e) {
  handle(e.target.files[0])
  e.target.value = ''
}
</script>

<template>
  <div>
    <label
      for="cv-input"
      class="flex cursor-pointer flex-col items-center gap-4 rounded-2xl border-2 border-dashed px-6 py-10 text-center transition-colors focus-within:outline focus-within:outline-2 focus-within:outline-offset-2 focus-within:outline-steel sm:py-14"
      :class="dragging ? 'border-steel bg-sky/30' : 'border-steel/50 bg-white hover:border-steel hover:bg-sky/20'"
      @dragover.prevent="dragging = true"
      @dragleave.prevent="dragging = false"
      @drop.prevent="onDrop"
    >
      <svg class="h-12 w-12 text-steel" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z" />
        <path d="M14 3v5h5" />
        <path d="M12 17v-6" />
        <path d="m9.5 13.5 2.5-2.5 2.5 2.5" />
      </svg>
      <div>
        <p class="font-display text-lg font-semibold">Drop your CV here</p>
        <p class="mt-1 text-sm text-navy/70">or click to browse. PDF, DOCX or TXT, up to 5 MB.</p>
      </div>
      <span class="rounded-lg bg-navy px-5 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-steel">
        Choose a file
      </span>
      <input id="cv-input" type="file" class="sr-only" accept=".pdf,.docx,.txt" @change="onChange" />
    </label>
    <p v-if="localError" class="mt-3 text-sm font-medium text-navy" role="alert">{{ localError }}</p>
  </div>
</template>
