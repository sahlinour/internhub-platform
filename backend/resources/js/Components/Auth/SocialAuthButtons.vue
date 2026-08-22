<script setup>
const providers = [
  { value: 'google', label: 'Google' },
  { value: 'linkedin', label: 'Linkedin' }
]

function redirectToProvider(provider) {
  // Route Laravel Socialite attendue : GET /auth/{provider}/redirect
  window.location.href = `/auth/${provider}/redirect`
}
</script>

<template>
  <div class="social-buttons">
    <button
      v-for="provider in providers"
      :key="provider.value"
      type="button"
      class="social-btn"
      @click="redirectToProvider(provider.value)"
    >
      {{ provider.label }}
    </button>
  </div>
</template>

<style scoped>
.social-buttons {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 12px;
  margin-bottom: 24px;
}

.social-btn {
  padding: 14px;
  border-radius: 8px;
  border: 1.5px solid #cfe0ea;
  background: #fff;
  font-weight: 600;
  font-size: 15px;
  color: #1c3a52;
}

.social-btn:hover {
  border-color: #3b9ec4;
}
</style>
