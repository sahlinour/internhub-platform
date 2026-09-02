<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import AuthHeroPanel from '@/Components/Auth/AuthHeroPanel.vue'
import InputLabel from '@/Components/Shared/InputLabel.vue'
import TextInput from '@/Components/Shared/TextInput.vue'
import InputError from '@/Components/Shared/InputError.vue'
import Checkbox from '@/Components/Shared/Checkbox.vue'
import PrimaryButton from '@/Components/Shared/PrimaryButton.vue'

defineProps({
  status: {
    type: String,
    default: null
  }
})

const form = useForm({
  email: '',
  password: '',
  remember: false
})

const submit = () => {
  form.post(route('login'), {
    onFinish: () => form.reset('password')
  })
}
</script>

<template>
  <Head title="Se connecter" />

  <div class="auth-screen">


    <div class="hero-panel">
     <AuthHeroPanel
  title="Welcome back. <strong>Your journey continues.</strong>"
  subtitle="Sign in to access your opportunities, applications, and professional connections."
  :features="[
    {
      title: 'Continue your applications',
      text: 'Track the internships you have applied to and stay updated on their progress.'
    },
    {
      title: 'Stay connected',
      text: 'Keep in touch with companies, mentors, and opportunities relevant to your career.'
    },
    {
      title: 'Discover what is next',
      text: 'Explore new internships and opportunities tailored to your profile.'
    }
  ]"
  footer="Your next opportunity may already be waiting."
/>
    </div>

    <div class="form-panel">
      <div class="form-wrapper">

       <div class="brand">
            <img
                src="/images/LogoBgWhiteInternHub.png"
                alt="InternHub"
                class="brand-logo"
        />
        </div>
        <div class="heading">
          <h2 class="title">Welcome back</h2>

          <p class="subtitle">
            Sign in to keep bridging ambition and opportunity.
          </p>
        </div>

        <div
          v-if="status"
          class="status-banner"
        >
          {{ status }}
        </div>


       

        <form @submit.prevent="submit">


          <div class="field-group">
            <InputLabel
              for="email"
              value="E-Mail Address"
              class="field-label"
            />

            <TextInput
              id="email"
              v-model="form.email"
              type="email"
              placeholder="name@university.edu"
              class="field-input"
              autofocus
              autocomplete="username"
            />

            <InputError
              :message="form.errors.email"
              class="field-error"
            />
          </div>

          <!-- PASSWORD -->
          <div class="field-group">
            <InputLabel
              for="password"
              value="Password"
              class="field-label"
            />

            <TextInput
              id="password"
              v-model="form.password"
              type="password"
              placeholder="••••••••••••"
              class="field-input"
              autocomplete="current-password"
            />

            <InputError
              :message="form.errors.password"
              class="field-error"
            />
          </div>

          <!-- OPTIONS -->
          <div class="row-between">

            <label class="remember">
              <Checkbox v-model:checked="form.remember" />

              <span>Remember me</span>
            </label>

            <Link
              href="/forgot-password"
              class="forgot-link"
            >
              Forgot password?
            </Link>

          </div>

          <!-- BUTTON -->
          <PrimaryButton
            class="submit-btn"
            :disabled="form.processing"
          >
            <span v-if="form.processing">
              Signing in...
            </span>

            <span v-else>
              Sign In
            </span>
          </PrimaryButton>

        </form>

        <p class="login-link">
          Don't have an account?

          <Link :href="route('register')">
            Sign up for free
          </Link>
        </p>

      </div>
    </div>

  </div>
</template>

<style scoped>
.auth-screen {
  display: grid;
  grid-template-columns: 1fr 1fr;
  min-height: 100vh;
  background: #ffffff;
}

.hero-panel {
  min-width: 0;
  background: #1c3a52;
}

.form-panel {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 48px 64px;
  background: #ffffff;
}

.form-wrapper {
  width: 100%;
  max-width: 440px;
}

.brand {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-bottom: 34px;
}

.brand-logo {
  width: 180px;
  height: auto;
  display: block;
  object-fit: contain;
}

.brand .line {
  flex: 1;
  height: 1px;
  background: #dce7ed;
}


.brand h1 strong {
  color: #1c3a52;
}

.heading {
  margin-bottom: 28px;
}

.title {
  margin: 0 0 8px;
  color: #172f43;
  font-size: 30px;
  line-height: 1.2;
  font-weight: 800;
  letter-spacing: -0.7px;
}

.subtitle {
  margin: 0;
  color: #718596;
  font-size: 14px;
  line-height: 1.6;
}

.status-banner {
  margin-bottom: 20px;
  padding: 12px 16px;
  border: 1px solid #cde8d5;
  border-radius: 10px;
  background: #f1faf4;
  color: #287342;
  font-size: 13px;
  font-weight: 600;
  text-align: center;
}

.divider {
  display: flex;
  align-items: center;
  gap: 12px;
  margin: 24px 0;
}

.divider .line {
  flex: 1;
  height: 1px;
  background: #e1e9ee;
}

.divider-text {
  color: #8495a2;
  font-size: 12px;
  font-weight: 500;
  white-space: nowrap;
}

.field-group {
  margin-bottom: 18px;
}

.field-label {
  display: block;
  margin-bottom: 8px;
  color: #1c3a52;
  font-size: 13px;
  font-weight: 650;
}

.field-input {
  width: 100%;
  box-sizing: border-box;
  padding: 13px 15px;
  border: 1px solid #d7e2e9;
  border-radius: 10px;
  background: #f8fafb;
  color: #1c3a52;
  font-size: 14px;
  transition:
    border-color 0.2s ease,
    background 0.2s ease,
    box-shadow 0.2s ease;
}

.field-input:focus {
  border-color: #3b9ec4;
  background: #ffffff;
  outline: none;
  box-shadow: 0 0 0 3px rgba(59, 158, 196, 0.12);
}

.field-input::placeholder {
  color: #9aabb7;
}

.field-error {
  margin-top: 5px;
}

.row-between {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-top: 4px;
  font-size: 13px;
}

.remember {
  display: flex;
  align-items: center;
  gap: 8px;
  color: #536b7c;
  cursor: pointer;
}

.forgot-link {
  color: #2f8fd6;
  font-weight: 600;
  text-decoration: none;
  transition: color 0.2s ease;
}

.forgot-link:hover {
  color: #1c3a52;
}

.submit-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
  box-sizing: border-box;
  min-height: 50px;
  margin-top: 22px;
  border: none;
  border-radius: 10px;
  background: #1c3a52;
  color: #ffffff;
  font-size: 14px;
  font-weight: 700;
  letter-spacing: 0.1px;
  box-shadow: 0 8px 20px rgba(28, 58, 82, 0.14);
  transition:
    background 0.2s ease,
    transform 0.2s ease,
    box-shadow 0.2s ease;
}

.submit-btn:hover:not(:disabled) {
  background: #28546f;
  transform: translateY(-1px);
  box-shadow: 0 10px 24px rgba(28, 58, 82, 0.2);
}

.submit-btn:active:not(:disabled) {
  transform: translateY(0);
}

.submit-btn:disabled {
  opacity: 0.65;
  cursor: not-allowed;
}

.login-link {
  margin: 24px 0 0;
  color: #718596;
  font-size: 13px;
  text-align: center;
}

.login-link :deep(a) {
  margin-left: 4px;
  color: #2f8fd6;
  font-weight: 700;
  text-decoration: none;
}

.login-link :deep(a):hover {
  color: #1c3a52;
}

@media (max-width: 1000px) {
  .form-panel {
    padding: 40px;
  }
}

@media (max-width: 900px) {
  .auth-screen {
    grid-template-columns: 1fr;
  }

  .hero-panel {
    order: 1;
  }

  .form-panel {
    order: 2;
    min-height: auto;
    padding: 48px 24px;
  }
}

@media (max-width: 600px) {
  .form-panel {
    padding: 36px 20px;
  }

  .form-wrapper {
    max-width: 100%;
  }

  .title {
    font-size: 26px;
  }

  .brand {
    margin-bottom: 30px;
  }
}
</style>
