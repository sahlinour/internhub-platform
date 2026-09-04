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

  <div class="grid min-h-screen grid-cols-1 bg-white lg:grid-cols-2">

    <!-- LEFT PANEL -->
    <div class="min-w-0 bg-[#1c3a52]">
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

    <!-- RIGHT PANEL -->
    <div
      class="flex items-center justify-center bg-white px-5 py-9 sm:px-6 lg:px-10 xl:px-16"
    >
      <div class="w-full max-w-[440px]">

        <!-- LOGO -->
        <div class="mb-8 flex items-center justify-center">
          <img
            src="/images/LogoBgWhiteInternHub.png"
            alt="InternHub"
            class="block h-auto w-[180px] object-contain"
          />
        </div>

        <!-- HEADING -->
        <div class="mb-7">
          <h2
            class="mb-2 text-[30px] font-extrabold leading-tight tracking-[-0.7px] text-[#172f43]"
          >
            Welcome back
          </h2>

          <p class="text-sm leading-relaxed text-[#718596]">
            Sign in to keep bridging ambition and opportunity.
          </p>
        </div>

        <!-- STATUS -->
        <div
          v-if="status"
          class="mb-5 rounded-[10px] border border-[#cde8d5] bg-[#f1faf4] px-4 py-3 text-center text-[13px] font-semibold text-[#287342]"
        >
          {{ status }}
        </div>

        <!-- FORM -->
        <form @submit.prevent="submit">

          <!-- EMAIL -->
          <div class="mb-[18px]">
            <InputLabel
              for="email"
              value="E-Mail Address"
              class="mb-2 block text-[13px] font-semibold text-[#1c3a52]"
            />

            <TextInput
              id="email"
              v-model="form.email"
              type="email"
              placeholder="name@university.edu"
              autofocus
              autocomplete="username"
              class="box-border w-full rounded-[10px] border border-[#d7e2e9] bg-[#f8fafb] px-[15px] py-[13px] text-sm text-[#1c3a52] placeholder:text-[#9aabb7] transition duration-200 focus:border-[#3b9ec4] focus:bg-white focus:outline-none focus:ring-4 focus:ring-[#3b9ec4]/10"
            />

            <InputError
              :message="form.errors.email"
              class="mt-1"
            />
          </div>

          <!-- PASSWORD -->
          <div class="mb-[18px]">
            <InputLabel
              for="password"
              value="Password"
              class="mb-2 block text-[13px] font-semibold text-[#1c3a52]"
            />

            <TextInput
              id="password"
              v-model="form.password"
              type="password"
              placeholder="••••••••••••"
              autocomplete="current-password"
              class="box-border w-full rounded-[10px] border border-[#d7e2e9] bg-[#f8fafb] px-[15px] py-[13px] text-sm text-[#1c3a52] placeholder:text-[#9aabb7] transition duration-200 focus:border-[#3b9ec4] focus:bg-white focus:outline-none focus:ring-4 focus:ring-[#3b9ec4]/10"
            />

            <InputError
              :message="form.errors.password"
              class="mt-1"
            />
          </div>

          <!-- REMEMBER + FORGOT PASSWORD -->
          <div class="mt-1 flex items-center justify-between text-[13px]">

            <label
              class="flex cursor-pointer items-center gap-2 text-[#536b7c]"
            >
              <Checkbox v-model:checked="form.remember" />
              <span>Remember me</span>
            </label>

            <Link
              href="/forgot-password"
              class="font-semibold text-[#2f8fd6] no-underline transition-colors duration-200 hover:text-[#1c3a52]"
            >
              Forgot password?
            </Link>
          </div>

          <!-- SUBMIT -->
          <PrimaryButton
            :disabled="form.processing"
            class="mt-[22px] flex min-h-[50px] w-full items-center justify-center rounded-[10px] border-0 bg-[#1c3a52] text-sm font-bold tracking-[0.1px] text-white shadow-[0_8px_20px_rgba(28,58,82,0.14)] transition duration-200 hover:-translate-y-px hover:bg-[#28546f] hover:shadow-[0_10px_24px_rgba(28,58,82,0.2)] active:translate-y-0 disabled:cursor-not-allowed disabled:opacity-65"
          >
            <span v-if="form.processing">
              Signing in...
            </span>

            <span v-else>
              Sign In
            </span>
          </PrimaryButton>

        </form>

        <!-- REGISTER -->
        <p class="mt-6 text-center text-[13px] text-[#718596]">
          Don't have an account?

          <Link
            :href="route('register')"
            class="ml-1 font-bold text-[#2f8fd6] no-underline transition-colors hover:text-[#1c3a52]"
          >
            Sign up for free
          </Link>
        </p>

      </div>
    </div>

  </div>
</template>
