<script setup>
defineProps({
  title: {
    type: String,
    default: "Bridge the gap between ambition and opportunity."
  },
  subtitle: {
    type: String,
    default:
      'TalentBridge is the premier destination for next-gen talent to connect with industry leaders.'
  }
})
</script>

<template>
  <div class="auth-hero">
    <div class="overlay" />
    <div class="hero-content">
      <h2 v-html="title" />
      <p>{{ subtitle }}</p>
    </div>
  </div>
</template>

<style scoped>
.auth-hero {
  position: relative;
  background: url('https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?auto=format&fit=crop&w=1200&q=80')
    center / cover no-repeat;
  min-height: 320px;
}

.overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(180deg, rgba(28, 58, 82, 0.55) 0%, rgba(28, 58, 82, 0.8) 100%);
}

.hero-content {
  position: relative;
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: flex-end;
  padding: 48px;
  color: #fff;
}

.hero-content h2 {
  font-size: 32px;
  font-weight: 800;
  line-height: 1.3;
  margin: 0 0 16px;
}

.hero-content :deep(strong) {
  color: #3b9ec4;
  font-weight: 800;
}

.hero-content p {
  font-size: 15px;
  line-height: 1.6;
  color: #e4edf3;
  max-width: 380px;
  margin: 0;
}

@media (max-width: 900px) {
  .auth-hero {
    min-height: 240px;
  }
  .hero-content {
    padding: 32px;
  }
  .hero-content h2 {
    font-size: 26px;
  }
}
</style>
