<script setup>
defineProps({
  title: {
    type: String,
    default: 'Find your place. <strong>Build your future.</strong>'
  },

  subtitle: {
    type: String,
    default:
      'Discover opportunities that match your ambitions and connect with companies looking for emerging talent.'
  },

  features: {
    type: Array,
    default: () => []
  },

  footer: {
    type: String,
    default: 'From potential to opportunity.'
  }
})
</script>

<template>
  <div class="auth-hero">
    <div class="circle circle-top"></div>
    <div class="circle circle-bottom"></div>
    <div class="glow"></div>

    <div class="hero-content">

      <!-- Logo -->
      <div class="hero-logo">
        <img
          src="/images/LogoBgDarkInternHub.png"
          alt="InternHub"
        />
      </div>

      <!-- Main text -->
      <div class="hero-message">
        <div class="accent-line"></div>

        <h2 v-html="title"></h2>

        <p class="hero-subtitle">
          {{ subtitle }}
        </p>
      </div>

      <!-- Dynamic features -->
      <div
        v-if="features.length"
        class="hero-features"
      >
        <div
          v-for="(feature, index) in features"
          :key="index"
          class="feature"
        >
          <span class="feature-icon">✓</span>

          <div>
            <strong>{{ feature.title }}</strong>

            <p>
              {{ feature.text }}
            </p>
          </div>
        </div>
      </div>

      <!-- Footer -->
      <div class="hero-footer">
        <span></span>

        <p>
          {{ footer }}
        </p>
      </div>

    </div>
  </div>
</template>

<style scoped>
.auth-hero {
  position: relative;
  width: 100%;
  height: 100%;
  min-height: 100vh;

  display: flex;
  align-items: center;

  overflow: hidden;

  background:
    radial-gradient(
      circle at 18% 18%,
      rgba(70, 176, 220, 0.18),
      transparent 35%
    ),
    linear-gradient(
      145deg,
      #0d3854 0%,
      #145675 48%,
      #102f47 100%
    );
}

.circle {
  position: absolute;
  border-radius: 50%;
  pointer-events: none;
}

.circle-top {
  width: 440px;
  height: 440px;
  top: -190px;
  right: -140px;

  background:
    linear-gradient(
      145deg,
      rgba(91, 190, 227, 0.17),
      rgba(56, 138, 184, 0.025)
    );
}

.circle-bottom {
  width: 520px;
  height: 520px;
  left: -230px;
  bottom: -260px;

  background:
    linear-gradient(
      145deg,
      rgba(52, 157, 203, 0.19),
      rgba(36, 111, 151, 0.03)
    );
}

.glow {
  position: absolute;
  width: 320px;
  height: 320px;

  top: 35%;
  right: -180px;

  border-radius: 50%;

  background: rgba(80, 190, 230, 0.09);

  filter: blur(60px);

  pointer-events: none;
}

.hero-content {
  position: relative;
  z-index: 2;

  width: 100%;
  max-width: 620px;

  box-sizing: border-box;

  padding: 58px 64px;

  color: #ffffff;
}

.hero-logo {
  margin-bottom: 58px;
}

.hero-logo img {
  display: block;

  width: 185px;
  height: auto;

  object-fit: contain;
}

.accent-line {
  width: 48px;
  height: 4px;

  margin-bottom: 24px;

  border-radius: 999px;

  background:
    linear-gradient(
      90deg,
      #4fc0e9,
      #8eddf5
    );
}

.hero-message h2 {
  max-width: 520px;

  margin: 0 0 20px;

  color: #ffffff;

  font-size: clamp(38px, 4vw, 54px);
  font-weight: 800;

  line-height: 1.08;

  letter-spacing: -1.5px;
}

.hero-message :deep(strong) {
  color: #77d2f1;
}

.hero-subtitle {
  max-width: 500px;

  margin: 0;

  color: rgba(235, 247, 252, 0.82);

  font-size: 15px;

  line-height: 1.75;
}

.hero-features {
  display: flex;
  flex-direction: column;

  gap: 19px;

  margin-top: 38px;
}

.feature {
  display: flex;

  align-items: flex-start;

  gap: 14px;
}

.feature-icon {
  flex-shrink: 0;

  display: flex;
  align-items: center;
  justify-content: center;

  width: 27px;
  height: 27px;

  margin-top: 1px;

  border: 1px solid rgba(112, 210, 242, 0.3);

  border-radius: 50%;

  background: rgba(92, 190, 225, 0.12);

  color: #77d7f4;

  font-size: 13px;
  font-weight: 800;
}

.feature strong {
  display: block;

  margin-bottom: 3px;

  color: #ffffff;

  font-size: 14px;
  font-weight: 700;
}

.feature p {
  margin: 0;

  color: rgba(224, 240, 247, 0.67);

  font-size: 12px;

  line-height: 1.5;
}

.hero-footer {
  display: flex;

  align-items: center;

  gap: 14px;

  margin-top: 45px;
}

.hero-footer span {
  width: 35px;
  height: 1px;

  background: rgba(126, 211, 239, 0.55);
}

.hero-footer p {
  margin: 0;

  color: rgba(225, 242, 249, 0.62);

  font-size: 12px;
  font-weight: 500;

  letter-spacing: 0.3px;
}

@media (max-width: 900px) {
  .auth-hero {
    min-height: auto;
  }

  .hero-content {
    padding: 45px 32px;
  }

  .hero-logo {
    margin-bottom: 35px;
  }

  .hero-logo img {
    width: 160px;
  }

  .hero-message h2 {
    font-size: 34px;
  }

  .hero-features {
    display: none;
  }
}
</style>
