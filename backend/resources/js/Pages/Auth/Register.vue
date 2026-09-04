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

  <div
    class="grid min-h-screen grid-cols-1 bg-white min-[901px]:grid-cols-2"
  >

    <!-- LEFT PANEL -->
    <div class="min-w-0 bg-[#123b55]">
      <div
        class="relative min-h-[320px] w-full
               min-[901px]:sticky
               min-[901px]:top-0
               min-[901px]:h-screen
               min-[901px]:min-h-screen"
      >
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
    </div>

    <!-- RIGHT PANEL -->
    <div
      class="flex min-h-0 w-full min-w-0 items-start justify-center bg-white
             px-5 py-9
             sm:px-6 sm:py-11
             min-[901px]:min-h-screen
             min-[901px]:px-12
             min-[901px]:py-12"
    >
      <div class="w-full max-w-[440px]">

        <!-- LOGO -->
        <div class="mb-6 flex items-center justify-center sm:mb-[30px]">
          <img
            src="/images/LogoBgWhiteInternHub.png"
            alt="InternHub"
            class="block h-auto w-[160px] object-contain sm:w-[180px]"
          />
        </div>

        <!-- HEADING -->
        <div class="mb-[26px] text-center">
          <h1
            class="mb-2 text-[25px] font-extrabold leading-[1.2]
                   tracking-[-0.5px] text-[#1c3a52] sm:text-[28px]"
          >
            Create your account
          </h1>

          <p
            class="text-[13px] leading-[1.6] text-[#6d8292]
                   sm:text-sm"
          >
            Join our ecosystem of professionals and future leaders.
          </p>
        </div>

        <!-- ROLE -->
        <RoleSelector v-model="form.role" />

        <form @submit.prevent="submit">

          <!-- FULL NAME -->
          <div class="mb-4">
            <InputLabel
              for="name"
              value="Full Name"
              class="mb-[7px] block text-[13px] font-semibold text-[#1c3a52]"
            />

            <TextInput
              id="name"
              v-model="form.name"
              type="text"
              placeholder="John Doe"
              autofocus
              autocomplete="name"
              class="min-h-[46px] w-full rounded-[9px] border border-[#d3e0e8]
                     bg-[#f4f8fa] px-[14px] py-[11px] text-sm text-[#1c3a52]
                     placeholder:text-[#9babb6]
                     focus:border-[#3b9ec4] focus:bg-white
                     focus:outline-none focus:ring-4 focus:ring-[#3b9ec4]/10"
            />

            <InputError
              :message="form.errors.name"
              class="mt-[5px]"
            />
          </div>

          <!-- EMAIL -->
          <div class="mb-4">
            <InputLabel
              for="email"
              value="E-Mail Address"
              class="mb-[7px] block text-[13px] font-semibold text-[#1c3a52]"
            />

            <TextInput
              id="email"
              v-model="form.email"
              type="email"
              placeholder="name@university.edu"
              autocomplete="username"
              class="min-h-[46px] w-full rounded-[9px] border border-[#d3e0e8]
                     bg-[#f4f8fa] px-[14px] py-[11px] text-sm text-[#1c3a52]
                     placeholder:text-[#9babb6]
                     focus:border-[#3b9ec4] focus:bg-white
                     focus:outline-none focus:ring-4 focus:ring-[#3b9ec4]/10"
            />

            <InputError
              :message="form.errors.email"
              class="mt-[5px]"
            />
          </div>

          <!-- CITY -->
          <div class="mb-4">
            <InputLabel
              for="ville_id"
              value="City"
              class="mb-[7px] block text-[13px] font-semibold text-[#1c3a52]"
            />

            <select
              id="ville_id"
              v-model="form.ville_id"
              class="min-h-[46px] w-full rounded-[9px] border border-[#d3e0e8]
                     bg-[#f4f8fa] px-[14px] py-[11px] text-sm text-[#1c3a52]
                     transition duration-200
                     focus:border-[#3b9ec4] focus:bg-white
                     focus:outline-none focus:ring-4 focus:ring-[#3b9ec4]/10"
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
              class="mt-[5px]"
            />
          </div>

          <!-- COMPANY ONLY -->
          <template v-if="form.role === 'Entreprise'">

            <!-- INDUSTRY -->
            <div class="mb-4">
              <InputLabel
                for="secteur"
                value="Industry"
                class="mb-[7px] block text-[13px] font-semibold text-[#1c3a52]"
              />

              <TextInput
                id="secteur"
                v-model="form.secteur"
                type="text"
                placeholder="e.g. Information Technology"
                class="min-h-[46px] w-full rounded-[9px] border border-[#d3e0e8]
                       bg-[#f4f8fa] px-[14px] py-[11px] text-sm text-[#1c3a52]
                       placeholder:text-[#9babb6]
                       focus:border-[#3b9ec4] focus:bg-white
                       focus:outline-none focus:ring-4 focus:ring-[#3b9ec4]/10"
              />

              <InputError
                :message="form.errors.secteur"
                class="mt-[5px]"
              />
            </div>

            <!-- ADDRESS -->
            <div class="mb-4">
              <InputLabel
                for="adresse"
                value="Address"
                class="mb-[7px] block text-[13px] font-semibold text-[#1c3a52]"
              />

              <TextInput
                id="adresse"
                v-model="form.adresse"
                type="text"
                placeholder="Company address"
                class="min-h-[46px] w-full rounded-[9px] border border-[#d3e0e8]
                       bg-[#f4f8fa] px-[14px] py-[11px] text-sm text-[#1c3a52]
                       placeholder:text-[#9babb6]
                       focus:border-[#3b9ec4] focus:bg-white
                       focus:outline-none focus:ring-4 focus:ring-[#3b9ec4]/10"
              />

              <InputError
                :message="form.errors.adresse"
                class="mt-[5px]"
              />
            </div>

            <!-- WEBSITE -->
            <div class="mb-4">
              <InputLabel
                for="site_web"
                value="Website"
                class="mb-[7px] block text-[13px] font-semibold text-[#1c3a52]"
              />

              <TextInput
                id="site_web"
                v-model="form.site_web"
                type="url"
                placeholder="https://www.company.com"
                class="min-h-[46px] w-full rounded-[9px] border border-[#d3e0e8]
                       bg-[#f4f8fa] px-[14px] py-[11px] text-sm text-[#1c3a52]
                       placeholder:text-[#9babb6]
                       focus:border-[#3b9ec4] focus:bg-white
                       focus:outline-none focus:ring-4 focus:ring-[#3b9ec4]/10"
              />

              <InputError
                :message="form.errors.site_web"
                class="mt-[5px]"
              />
            </div>

            <!-- DESCRIPTION -->
            <div class="mb-4">
              <InputLabel
                for="description"
                value="Company Description"
                class="mb-[7px] block text-[13px] font-semibold text-[#1c3a52]"
              />

              <textarea
                id="description"
                v-model="form.description"
                rows="4"
                placeholder="Tell us about your company..."
                class="min-h-[110px] w-full resize-y rounded-[9px]
                       border border-[#d3e0e8] bg-[#f4f8fa]
                       px-[14px] py-[11px] text-sm text-[#1c3a52]
                       placeholder:text-[#9babb6]
                       focus:border-[#3b9ec4] focus:bg-white
                       focus:outline-none focus:ring-4 focus:ring-[#3b9ec4]/10"
              ></textarea>

              <InputError
                :message="form.errors.description"
                class="mt-[5px]"
              />
            </div>

          </template>

          <!-- PASSWORD -->
          <div class="mb-4">
            <InputLabel
              for="password"
              value="Password"
              class="mb-[7px] block text-[13px] font-semibold text-[#1c3a52]"
            />

            <TextInput
              id="password"
              v-model="form.password"
              type="password"
              placeholder="••••••••••••"
              autocomplete="new-password"
              class="min-h-[46px] w-full rounded-[9px] border border-[#d3e0e8]
                     bg-[#f4f8fa] px-[14px] py-[11px] text-sm text-[#1c3a52]
                     placeholder:text-[#9babb6]
                     focus:border-[#3b9ec4] focus:bg-white
                     focus:outline-none focus:ring-4 focus:ring-[#3b9ec4]/10"
            />

            <InputError
              :message="form.errors.password"
              class="mt-[5px]"
            />
          </div>

          <!-- CONFIRM PASSWORD -->
          <div class="mb-4">
            <InputLabel
              for="password_confirmation"
              value="Confirm Password"
              class="mb-[7px] block text-[13px] font-semibold text-[#1c3a52]"
            />

            <TextInput
              id="password_confirmation"
              v-model="form.password_confirmation"
              type="password"
              placeholder="••••••••••••"
              autocomplete="new-password"
              class="min-h-[46px] w-full rounded-[9px] border border-[#d3e0e8]
                     bg-[#f4f8fa] px-[14px] py-[11px] text-sm text-[#1c3a52]
                     placeholder:text-[#9babb6]
                     focus:border-[#3b9ec4] focus:bg-white
                     focus:outline-none focus:ring-4 focus:ring-[#3b9ec4]/10"
            />

            <InputError
              :message="form.errors.password_confirmation"
              class="mt-[5px]"
            />
          </div>

          <!-- TERMS -->
          <label
            class="mt-[5px] flex cursor-pointer items-start gap-[9px]
                   text-[13px] leading-[1.5] text-[#526a7b]"
          >
            <Checkbox v-model:checked="form.terms" />

            <span>
              I agree to the

              <Link
                href="/terms"
                target="_blank"
                class="font-semibold text-[#2f8fd6] no-underline
                       hover:text-[#1c3a52]"
              >
                Terms of Service
              </Link>

              and

              <Link
                href="/privacy"
                target="_blank"
                class="font-semibold text-[#2f8fd6] no-underline
                       hover:text-[#1c3a52]"
              >
                Privacy Policy
              </Link>.
            </span>
          </label>

          <InputError
            :message="form.errors.terms"
            class="mt-[5px]"
          />

          <!-- SUBMIT -->
          <PrimaryButton
            :disabled="form.processing"
            class="mt-5 flex min-h-12 w-full items-center justify-center
                   rounded-[9px] border-0 bg-[#1c3a52] px-4 py-3
                   text-sm font-bold normal-case tracking-normal text-white
                   shadow-[0_8px_20px_rgba(28,58,82,0.14)]
                   transition duration-200
                   hover:-translate-y-px
                   hover:bg-[#285a78]
                   hover:shadow-[0_10px_24px_rgba(28,58,82,0.2)]
                   disabled:cursor-not-allowed
                   disabled:opacity-65"
          >
            <span v-if="form.processing">
              Creating account...
            </span>

            <span v-else>
              Create Account
            </span>
          </PrimaryButton>
        </form>

        <!-- LOGIN -->
        <p class="mt-[22px] text-center text-[13px] text-[#6d8292]">
          Already have an account?

          <Link
            :href="route('login')"
            class="ml-1 font-bold text-[#2f8fd6] no-underline
                   hover:text-[#1c3a52]"
          >
            Sign in
          </Link>
        </p>

      </div>
    </div>

  </div>
</template>
