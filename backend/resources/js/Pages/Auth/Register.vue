<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import AuthHeroPanel from '@/Components/Auth/AuthHeroPanel.vue'
import RoleSelector from '@/Components/Auth/RoleSelector.vue'
import InputLabel from '@/Components/Shared/InputLabel.vue'
import TextInput from '@/Components/Shared/TextInput.vue'
import InputError from '@/Components/Shared/InputError.vue'
import Checkbox from '@/Components/Shared/Checkbox.vue'
import PrimaryButton from '@/Components/Shared/PrimaryButton.vue'

const props = defineProps({
  villes: {
    type: Array,
    default: () => []
  }
})

const form = useForm({
  role: 'Stagiaire',
  name: '',
  email: '',
  ville_id: '',

  secteur: '',
  adresse: '',
  site_web: '',
  description: '',

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
  <Head title="Create an account" />

  <div class="auth-screen">


    <div class="hero-panel">
     <AuthHeroPanel
    title="Start your journey. <strong>Build your future.</strong>"
    subtitle="Create your InternHub account and connect your potential with real internship opportunities."
    :features="[
        {
        title: 'Create your professional profile',
        text: 'Showcase your skills, experience, and ambitions to companies looking for emerging talent.'
        },
        {
        title: 'Find the right internship',
        text: 'Discover opportunities that match your interests, skills, and career goals.'
        },
        {
        title: 'Connect with companies',
        text: 'Build meaningful connections with organizations searching for their next talent.'
        }
    ]"
    footer="Your professional journey starts here."
    />
    </div>


    <div class="form-panel">

      <div class="form-wrapper">

        <!-- Logo -->
        <div class="brand">
          <img
            src="/images/LogoBgWhiteInternHub.png"
            alt="InternHub"
            class="brand-logo"
          />
        </div>

        <!-- Heading -->
        <div class="heading">
          <h1 class="title">
            Create your account
          </h1>

          <p class="subtitle">
            Join our ecosystem of professionals and future leaders.
          </p>
        </div>

        <!-- Role -->
        <RoleSelector v-model="form.role" />


        <form @submit.prevent="submit">

          <!-- Full name -->
          <div class="field-group">
            <InputLabel
              for="name"
              value="Full Name"
              class="field-label"
            />

            <TextInput
              id="name"
              v-model="form.name"
              type="text"
              placeholder="John Doe"
              class="field-input"
              autofocus
              autocomplete="name"
            />

            <InputError
              :message="form.errors.name"
              class="field-error"
            />
          </div>

          <!-- Email -->
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
              autocomplete="username"
            />

            <InputError
              :message="form.errors.email"
              class="field-error"
            />
          </div>

          <!-- City -->
          <div class="field-group">

            <InputLabel
              for="ville_id"
              value="City"
              class="field-label"
            />

            <select
              id="ville_id"
              v-model="form.ville_id"
              class="field-input"
            >
              <option value="" disabled>
                Select your city
              </option>

              <option
                v-for="ville in props.villes"
                :key="ville.id"
                :value="ville.id"
              >
                {{ ville.nom }}
              </option>
            </select>

            <InputError
              :message="form.errors.ville_id"
              class="field-error"
            />

          </div>

          <!-- ========================================
               COMPANY ONLY
          ========================================= -->

          <template v-if="form.role === 'Entreprise'">

            <!-- Industry -->
            <div class="field-group">

              <InputLabel
                for="secteur"
                value="Industry"
                class="field-label"
              />

              <TextInput
                id="secteur"
                v-model="form.secteur"
                type="text"
                placeholder="e.g. Information Technology"
                class="field-input"
              />

              <InputError
                :message="form.errors.secteur"
                class="field-error"
              />

            </div>

            <!-- Address -->
            <div class="field-group">

              <InputLabel
                for="adresse"
                value="Address"
                class="field-label"
              />

              <TextInput
                id="adresse"
                v-model="form.adresse"
                type="text"
                placeholder="Company address"
                class="field-input"
              />

              <InputError
                :message="form.errors.adresse"
                class="field-error"
              />

            </div>

            <!-- Website -->
            <div class="field-group">

              <InputLabel
                for="site_web"
                value="Website"
                class="field-label"
              />

              <TextInput
                id="site_web"
                v-model="form.site_web"
                type="url"
                placeholder="https://www.company.com"
                class="field-input"
              />

              <InputError
                :message="form.errors.site_web"
                class="field-error"
              />

            </div>

            <!-- Description -->
            <div class="field-group">

              <InputLabel
                for="description"
                value="Company Description"
                class="field-label"
              />

              <textarea
                id="description"
                v-model="form.description"
                class="field-input textarea-input"
                placeholder="Tell us about your company..."
                rows="4"
              ></textarea>

              <InputError
                :message="form.errors.description"
                class="field-error"
              />

            </div>

          </template>

          <!-- Password -->
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
              autocomplete="new-password"
            />

            <InputError
              :message="form.errors.password"
              class="field-error"
            />

          </div>

          <!-- Confirm Password -->
          <div class="field-group">

            <InputLabel
              for="password_confirmation"
              value="Confirm Password"
              class="field-label"
            />

            <TextInput
              id="password_confirmation"
              v-model="form.password_confirmation"
              type="password"
              placeholder="••••••••••••"
              class="field-input"
              autocomplete="new-password"
            />

            <InputError
              :message="form.errors.password_confirmation"
              class="field-error"
            />

          </div>

          <!-- Terms -->
          <label class="terms">

            <Checkbox v-model:checked="form.terms" />

            <span>
              I agree to the

              <Link href="/terms" target="_blank">
                Terms of Service
              </Link>

              and

              <Link href="/privacy" target="_blank">
                Privacy Policy
              </Link>.
            </span>

          </label>

          <InputError
            :message="form.errors.terms"
            class="field-error"
          />

          <!-- Submit -->
          <PrimaryButton
            class="submit-btn"
            :disabled="form.processing"
          >

            <span v-if="form.processing">
              Creating account...
            </span>

            <span v-else>
              Create Account
            </span>

          </PrimaryButton>

        </form>

        <!-- Login -->
        <p class="login-link">
          Already have an account?

          <Link :href="route('login')">
            Sign in
          </Link>
        </p>

      </div>

    </div>

  </div>
</template>

<style scoped>

/* =========================================
   MAIN LAYOUT

   LEFT  = BLUE
   RIGHT = FORM
========================================= */

.auth-screen {
  display: grid;
  grid-template-columns: 1fr 1fr;

  min-height: 100vh;

  background: #ffffff;
}


/* =========================================
   LEFT — BLUE HERO
========================================= */

.hero-panel {
  grid-column: 1;

  min-width: 0;

  background: #123b55;
}

.hero-panel :deep(.auth-hero) {
  position: sticky;

  top: 0;

  width: 100%;
  height: 100vh;
  min-height: 100vh;
}


/* =========================================
   RIGHT — FORM
========================================= */

.form-panel {
  grid-column: 2;

  display: flex;

  align-items: flex-start;
  justify-content: center;

  min-width: 0;
  min-height: 100vh;

  padding: 48px 48px;

  box-sizing: border-box;

  background: #ffffff;
}

.form-wrapper {
  width: 100%;
  max-width: 440px;
}


/* =========================================
   LOGO
========================================= */

.brand {
  display: flex;

  align-items: center;
  justify-content: center;

  margin-bottom: 30px;
}

.brand-logo {
  display: block;

  width: 180px;
  height: auto;

  object-fit: contain;
}


/* =========================================
   HEADING
========================================= */

.heading {
  margin-bottom: 26px;

  text-align: center;
}

.title {
  margin: 0 0 8px;

  color: #1c3a52;

  font-size: 28px;
  font-weight: 800;

  line-height: 1.2;

  letter-spacing: -0.5px;
}

.subtitle {
  margin: 0;

  color: #6d8292;

  font-size: 14px;
  line-height: 1.6;
}


/* =========================================
   DIVIDER
========================================= */

.divider {
  display: flex;

  align-items: center;

  gap: 12px;

  margin: 24px 0;
}

.divider .line {
  flex: 1;

  height: 1px;

  background: #dce6ec;
}

.divider-text {
  color: #7c8f9d;

  font-size: 12px;
  font-weight: 600;

  white-space: nowrap;
}


/* =========================================
   FORM FIELDS
========================================= */

.field-group {
  margin-bottom: 16px;
}

.field-label {
  display: block;

  margin-bottom: 7px;

  color: #1c3a52;

  font-size: 13px;
  font-weight: 600;
}

.field-input {
  width: 100%;
  min-height: 46px;

  box-sizing: border-box;

  padding: 11px 14px;

  border: 1px solid #d3e0e8;

  border-radius: 9px;

  background: #f4f8fa;

  color: #1c3a52;

  font-size: 14px;

  transition:
    border-color 0.2s ease,
    background 0.2s ease,
    box-shadow 0.2s ease;
}

.field-input:focus {
  outline: none;

  border-color: #3b9ec4;

  background: #ffffff;

  box-shadow:
    0 0 0 3px rgba(59, 158, 196, 0.12);
}

.field-input::placeholder {
  color: #9babb6;
}

.field-error {
  margin-top: 5px;
}


/* =========================================
   TEXTAREA
========================================= */

.textarea-input {
  min-height: 110px;

  resize: vertical;

  font-family: inherit;
}


/* =========================================
   TERMS
========================================= */

.terms {
  display: flex;

  align-items: flex-start;

  gap: 9px;

  margin-top: 5px;

  color: #526a7b;

  font-size: 13px;
  line-height: 1.5;

  cursor: pointer;
}

.terms :deep(a) {
  color: #2f8fd6;

  font-weight: 600;

  text-decoration: none;
}

.terms :deep(a):hover {
  color: #1c3a52;
}


/* =========================================
   CREATE ACCOUNT BUTTON
========================================= */

.submit-btn {
  display: flex !important;

  align-items: center;
  justify-content: center;

  width: 100% !important;

  min-height: 48px;

  box-sizing: border-box;

  margin-top: 20px;

  padding: 12px 16px;

  border: none;

  border-radius: 9px;

  background: #1c3a52;

  color: #ffffff;

  font-size: 14px;
  font-weight: 700;

  text-transform: none;
  letter-spacing: normal;

  box-shadow:
    0 8px 20px rgba(28, 58, 82, 0.14);

  transition:
    background 0.2s ease,
    transform 0.2s ease,
    box-shadow 0.2s ease;
}

.submit-btn:hover:not(:disabled) {
  background: #285a78;

  transform: translateY(-1px);

  box-shadow:
    0 10px 24px rgba(28, 58, 82, 0.2);
}

.submit-btn:disabled {
  opacity: 0.65;

  cursor: not-allowed;
}


/* =========================================
   LOGIN LINK
========================================= */

.login-link {
  margin: 22px 0 0;

  color: #6d8292;

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


/* =========================================
   TABLET / MOBILE
========================================= */

@media (max-width: 900px) {

  .auth-screen {
    display: flex;

    flex-direction: column;
  }

  /* blue first */
  .hero-panel {
    order: 1;
  }

  .hero-panel :deep(.auth-hero) {
    position: relative;

    height: auto;
    min-height: 320px;
  }

  /* form underneath */
  .form-panel {
    order: 2;

    width: 100%;
    min-height: auto;

    padding: 44px 24px;
  }
}


/* =========================================
   MOBILE
========================================= */

@media (max-width: 600px) {

  .form-panel {
    padding: 36px 20px;
  }

  .form-wrapper {
    max-width: 100%;
  }

  .brand {
    margin-bottom: 25px;
  }

  .brand-logo {
    width: 160px;
  }

  .title {
    font-size: 25px;
  }

  .subtitle {
    font-size: 13px;
  }
}

</style>
