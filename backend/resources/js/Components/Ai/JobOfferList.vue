<script setup>
import JobOfferCard from './JobOfferCard.vue'

defineProps({
  offers: { type: Array, required: true },
})
</script>

<template>
  <div class="space-y-3">
    <JobOfferCard
      v-for="(offer, index) in offers"
      :key="offer.id"
      :offer="offer"
      :rank="index + 1"
    />
  </div>
</template>
