<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import AuthHeroPanel from '@/Components/Auth/AuthHeroPanel.vue'
import SocialAuthButtons from '@/Components/Auth/SocialAuthButtons.vue'
import InputLabel from '@/Components/Shared/InputLabel.vue';
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
    <div class="form-panel">
      <div class="form-wrapper">
        <div class="brand">
          <span class="line" />
          <h1>Talent<strong>Bridge</strong></h1>
          <span class="line" />
        </div>

        <h2 class="title">Welcome back</h2>
        <p class="subtitle">Sign in to keep bridging ambition and opportunity.</p>

        <div v-if="status" class="status-banner">{{ status }}</div>

        <SocialAuthButtons />

        <div class="divider">
          <span class="line" />
          <span class="divider-text">Or with Email</span>
          <span class="line" />
        </div>

        <form @submit.prevent="submit">
          <InputLabel for="email" value="E-Mail Address" class="field-label" />
          <TextInput
            id="email"
            v-model="form.email"
            type="email"
            placeholder="name@university.edu"
            class="field-input"
            autofocus
            autocomplete="username"
          />
          <InputError :message="form.errors.email" class="field-error" />

          <InputLabel for="password" value="Password" class="field-label" />
          <TextInput
            id="password"
            v-model="form.password"
            type="password"
            placeholder="••••••••••••"
            class="field-input"
            autocomplete="current-password"
          />
          <InputError :message="form.errors.password" class="field-error" />

          <div class="row-between">
            <label class="remember">
              <Checkbox v-model:checked="form.remember" />
              <span>Remember me</span>
            </label>
            <Link href="/forgot-password" class="forgot-link">Forgot password?</Link>
          </div>

          <PrimaryButton class="submit-btn" :disabled="form.processing"> Sign In </PrimaryButton>
        </form>

        <p class="login-link">
          Don't have an account?
          <Link :href="route('register')">Sign up for free</Link>
        </p>
      </div>
    </div>

    <AuthHeroPanel
      title="Welcome back to <strong>TalentBridge</strong>."
      subtitle="Pick up where you left off — new opportunities are waiting."
    />
  </div>
</template>

<style scoped>
.auth-screen {
  display: grid;
  grid-template-columns: 1fr 1fr;
  min-height: 100vh;
}

.form-panel {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 48px 32px;
}

.form-wrapper {
  width: 100%;
  max-width: 420px;
}

.brand {
  display: flex;
  align-items: center;
  gap: 12px;
  justify-content: center;
  margin-bottom: 28px;
}

.brand .line {
  flex: 1;
  height: 1px;
  background: #cfe0ea;
}

.brand h1 {
  font-size: 18px;
  font-weight: 600;
  color: #3b9ec4;
  white-space: nowrap;
  margin: 0;
}

.brand h1 strong {
  color: #1c3a52;
}

.title {
  text-align: center;
  font-size: 24px;
  font-weight: 700;
  margin: 0 0 6px;
  color: #1c3a52;
}

.subtitle {
  text-align: center;
  font-size: 14px;
  font-style: italic;
  color: #5c7488;
  margin: 0 0 24px;
}

.status-banner {
  margin-bottom: 16px;
  padding: 10px 14px;
  border-radius: 8px;
  background: #e6f4ea;
  color: #256d3d;
  font-size: 13px;
  font-weight: 600;
  text-align: center;
}

.divider {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 20px;
}

.divider .line {
  flex: 1;
  height: 1px;
  background: #cfe0ea;
}

.divider-text {
  font-size: 13px;
  font-weight: 600;
  color: #1c3a52;
  white-space: nowrap;
}

.field-label {
  margin-bottom: 6px;
  font-weight: 600;
  color: #1c3a52;
}

.field-input {
  width: 100%;
  padding: 12px 14px;
  border-radius: 8px;
  background: #eaf2f7;
  border-color: #cfe0ea;
  margin-top: 6px;
  margin-bottom: 6px;
}

.field-error {
  margin-bottom: 12px;
}

.row-between {
  display: flex;
  align-items: center;
  justify-content: space-between;
  width: 100%;
  margin: 12px 0 0;
  font-size: 13px;
}

.remember {
  display: flex;
  align-items: center;
  gap: 8px;
  color: #1c3a52;
  cursor: pointer;
  margin: 0;
}

.forgot-link {
  color: #2f8fd6;
  font-weight: 600;
  text-decoration: none;
}

.submit-btn {
  display: flex;
  width: 100%;
  box-sizing: border-box;
  align-items: center;
  justify-content: center;
  padding: 14px;
  margin-top: 16px;
  border-radius: 8px;
  background: #2f6690;
  font-size: 15px;
  font-weight: 700;
  text-transform: none;
  letter-spacing: normal;
}

.submit-btn:hover:not(:disabled) {
  background: #1c3a52;
}

.login-link {
  text-align: center;
  font-size: 14px;
  color: #1c3a52;
  margin-top: 18px;
}

.login-link :deep(a) {
  color: #2f8fd6;
  font-weight: 600;
  text-decoration: none;
}

@media (max-width: 900px) {
  .auth-screen {
    grid-template-columns: 1fr;
  }
}
</style>
