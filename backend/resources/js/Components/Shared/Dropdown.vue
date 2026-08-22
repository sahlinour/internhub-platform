<script setup>
import { onMounted, onUnmounted, ref } from 'vue'

defineProps({
  align: {
    type: String,
    default: 'right'
  },
  width: {
    type: String,
    default: '48'
  },
  contentClasses: {
    type: String,
    default: 'py-1 bg-white'
  }
})

const open = ref(false)

const closeOnEscape = (e) => {
  if (open.value && e.key === 'Escape') {
    open.value = false
  }
}

onMounted(() => document.addEventListener('keydown', closeOnEscape))
onUnmounted(() => document.removeEventListener('keydown', closeOnEscape))

const widthClass = {
  48: 'w-48'
}

const alignmentClasses = {
  left: 'ltr:origin-top-left rtl:origin-top-right start-0',
  right: 'ltr:origin-top-right rtl:origin-top-left end-0',
  top: 'origin-bottom'
}
</script>

<template>
  <div class="relative">
    <div @click="open = !open">
      <slot name="trigger" />
    </div>

    <div v-show="open" class="fixed inset-0 z-40" @click="open = false" />

    <transition
      enter-active-class="transition ease-out duration-200"
      enter-from-class="opacity-0 scale-95"
      enter-to-class="opacity-100 scale-100"
      leave-active-class="transition ease-in duration-75"
      leave-from-class="opacity-100 scale-100"
      leave-to-class="opacity-0 scale-95"
    >
      <div
        v-show="open"
        class="absolute z-50 mt-2 rounded-md shadow-lg"
        :class="[widthClass[width], alignmentClasses[align]]"
        style="display: none"
        @click="open = false"
      >
        <div class="rounded-md ring-1 ring-black ring-opacity-5" :class="contentClasses">
          <slot name="content" />
        </div>
      </div>
    </transition>
  </div>
</template>
