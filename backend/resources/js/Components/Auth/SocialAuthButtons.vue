<script setup>
const providers = [
  { value: 'google', label: 'Google' },
  { value: 'linkedin', label: 'Linkedin' }
]

function redirectToProvider(provider) {
  // Route Laravel Socialite : GET /auth/{provider}/redirect
  window.location.href = `/auth/${provider}/redirect`
}
</script>

<template>
  <div class="mb-6 grid grid-cols-2 gap-3">
    <button
      v-for="provider in providers"
      :key="provider.value"
      type="button"
      class="
        rounded-lg
        border-[1.5px] border-[#cfe0ea]
        bg-white
        p-3.5
        text-[15px] font-semibold text-[#1c3a52]
        transition-colors duration-150
        hover:border-[#3b9ec4]
      "
      @click="redirectToProvider(provider.value)"
    >
      {{ provider.label }}
    </button>
  </div>
</template>
