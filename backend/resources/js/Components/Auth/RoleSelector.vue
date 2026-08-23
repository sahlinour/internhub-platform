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
  <div class="role-selector">
    <button
      v-for="role in roles"
      :key="role.value"
      type="button"
      class="role-btn"
      :class="{ active: modelValue === role.value }"
      @click="$emit('update:modelValue', role.value)"
    >
      {{ role.label }}
    </button>
  </div>
</template>

<style scoped>
.role-selector {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 12px;
  margin-bottom: 12px;
}

.role-btn {
  padding: 14px;
  border-radius: 8px;
  border: 1.5px solid #cfe0ea;
  background: #fff;
  font-weight: 600;
  font-size: 15px;
  color: #1c3a52;
  transition: border-color 0.15s ease, color 0.15s ease;
}

.role-btn.active {
  border-color: #2f8fd6;
  color: #2f8fd6;
}
</style>
