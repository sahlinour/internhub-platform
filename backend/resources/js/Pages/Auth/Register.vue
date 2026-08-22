<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import AuthHeroPanel from '@/Components/Auth/AuthHeroPanel.vue'
import RoleSelector from '@/Components/Auth/RoleSelector.vue'
import SocialAuthButtons from '@/Components/Auth/SocialAuthButtons.vue'
import InputLabel from '@/Components/Shared/InputLabel.vue';
import TextInput from '@/Components/Shared/TextInput.vue'
import InputError from '@/Components/Shared/InputError.vue';
import Checkbox from '@/Components/Shared/Checkbox.vue'

const form = useForm({
  role: 'student',
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
  terms: false
})

const submit = () => {
  form.post(route('register'), {
    onFinish: () => form.reset('password', 'password_confirmation')
  })
}
</script>

<template>
  <Head title="Créer un compte" />

  <div class="auth-screen">
    <div class="form-panel">
      <div class="form-wrapper">
        <div class="brand">
          <span class="line" />
          <h1>Talent<strong>Bridge</strong></h1>
          <span class="line" />
        </div>

        <h2 class="title">Create your account</h2>
        <p class="subtitle">Join our ecosystem of professionals and future leaders.</p>

        <RoleSelector v-model="form.role" />
        <SocialAuthButtons />

        <div class="divider">
          <span class="line" />
          <span class="divider-text">Or with Email</span>
          <span class="line" />
        </div>

        <form @submit.prevent="submit">
          <InputLabel for="name" value="Full Name" class="field-label" />
          <TextInput
            id="name"
            v-model="form.name"
            type="text"
            placeholder="John Doe"
            class="field-input"
            autofocus
            autocomplete="name"
          />
          <InputError :message="form.errors.name" class="field-error" />

          <InputLabel for="email" value="E-Mail Address" class="field-label" />
          <TextInput
            id="email"
            v-model="form.email"
            type="email"
            placeholder="name@university.edu"
            class="field-input"
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
            autocomplete="new-password"
          />
          <InputError :message="form.errors.password" class="field-error" />

          <label class="terms">
            <Checkbox v-model:checked="form.terms" />
            <span>
              I agree to the
              <Link href="/terms" target="_blank">Terms of Service</Link>
              and
              <Link href="/privacy" target="_blank">Privacy Policy</Link>.
            </span>
          </label>
          <InputError :message="form.errors.terms" class="field-error" />

          <PrimaryButton class="submit-btn" :disabled="form.processing">
            Create Account
          </PrimaryButton>
        </form>

        <p class="login-link">
          Already have an account?
          <Link :href="route('login')">Sign up for free</Link>
        </p>
      </div>
    </div>

    <AuthHeroPanel />
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
  box-sizing: border-box;
  padding: 11px 14px;
  min-height: 44px;
  border-radius: 8px;
  background: #eaf2f7;
  border: 1px solid #cfe0ea;
  margin: 0 0 4px;
}

.field-error {
  margin-bottom: 10px;
}

.terms {
  display: flex;
  align-items: flex-start;
  gap: 8px;
  font-size: 13px;
  line-height: 1.5;
  color: #1c3a52;
  margin: 8px 0 0;
  cursor: pointer;
}

.terms :deep(a) {
  color: #2f8fd6;
  font-weight: 600;
  text-decoration: none;
}

.submit-btn {
  display: flex !important;
  width: 100% !important;
  box-sizing: border-box;
  justify-content: center;
  padding: 12px 14px;
  min-height: 46px;
  border-radius: 8px;
  background: #2f6690;
  font-size: 15px;
  font-weight: 700;
  text-transform: none;
  letter-spacing: normal;
  margin-top: 14px;
}

.submit-btn:hover:not(:disabled) {
  background: #1c3a52;
}

.login-link {
  text-align: center;
  font-size: 14px;
  color: #1c3a52;
  margin-top: 14px;
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
