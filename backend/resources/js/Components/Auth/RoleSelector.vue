<script setup>
defineProps({
  modelValue: {
    type: String,
    required: true
  }
})

defineEmits(['update:modelValue'])

const roles = [
  { value: 'Stagiaire', label: 'Intern' },
  { value: 'Entreprise', label: 'Company' }
]
</script>

<template>
  <div class="mb-3 grid grid-cols-2 gap-3">
    <button
      v-for="role in roles"
      :key="role.value"
      type="button"
      class="rounded-lg border-[1.5px] bg-white p-3.5 text-[15px] font-semibold transition-colors duration-150"
      :class="
        modelValue === role.value
          ? 'border-[#2f8fd6] text-[#2f8fd6]'
          : 'border-[#cfe0ea] text-[#1c3a52]'
      "
      @click="$emit('update:modelValue', role.value)"
    >
      {{ role.label }}
    </button>
  </div>
</template>
