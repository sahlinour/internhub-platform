<script setup>
import { onMounted, ref } from 'vue'

defineProps({
  modelValue: {
    type: String,
    default: ''
  }
})

defineEmits(['update:modelValue'])

const input = ref(null)

onMounted(() => {
  if (input.value?.hasAttribute('autofocus')) {
    input.value.focus()
  }
})

defineExpose({
  focus: () => input.value?.focus()
})
</script>

<template>
  <input
    ref="input"
    :value="modelValue"
    @input="$emit('update:modelValue', $event.target.value)"
    class="rounded-md border-gray-300 shadow-sm focus:border-[#3A7CA5] focus:ring-[#16425B]"
    v-bind="$attrs"
  />
</template>
