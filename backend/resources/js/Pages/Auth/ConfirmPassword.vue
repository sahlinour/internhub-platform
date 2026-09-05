<script setup>
import InputLabel from '@/Components/Shared/InputLabel.vue'
import PrimaryButton from '@/Components/Shared/PrimaryButton.vue'
import TextInput from '@/Components/Shared/TextInput.vue'
import InputError from '@/Components/Shared/InputError.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'

const form = useForm({
    password: '',
})

const submit = () => {
    form.post(route('password.confirm'), {
        onFinish: () => form.reset(),
    })
}
</script>

<template>
    <Head title="Confirm Password" />

    <div
        class="relative flex min-h-screen w-full items-center justify-center overflow-hidden bg-slate-50 px-4 py-8 sm:px-6 lg:px-8"
    >
        <!-- Background decorations -->
        <div
            class="pointer-events-none absolute -right-24 -top-24 h-80 w-80 rounded-full bg-[#1c3a52]/5"
        ></div>

        <div
            class="pointer-events-none absolute -bottom-20 -left-20 h-64 w-64 rounded-full border border-[#1c3a52]/10"
        ></div>

        <!-- MAIN CARD -->
        <div
            class="relative z-10 grid w-full max-w-6xl overflow-hidden rounded-[30px] bg-white shadow-2xl shadow-slate-300/50 lg:grid-cols-2"
        >
            <!-- LEFT PANEL -->
            <section
                class="relative hidden min-h-[650px] overflow-hidden bg-[#1c3a52] p-14 lg:flex lg:flex-col"
            >
                <!-- Decorative elements -->
                <div
                    class="absolute -right-36 top-16 h-80 w-80 rounded-full border border-white/10"
                ></div>

                <div
                    class="absolute -bottom-24 -left-16 h-64 w-64 rounded-full border border-white/5"
                ></div>

                <div
                    class="absolute bottom-20 right-16 h-24 w-24 rounded-full bg-white/[0.03]"
                ></div>

                <div class="relative z-10 flex h-full flex-col">
                    <!-- Logo -->
                    <Link href="/" class="w-fit">
                        <img
                            src="/images/LogoBgWhiteInternHub.png"
                            alt="InternHub"
                            class="w-44 object-contain"
                        />
                    </Link>

                    <!-- Content -->
                    <div class="my-auto max-w-md">
                        <span
                            class="mb-5 inline-block text-xs font-bold uppercase tracking-[0.28em] text-sky-200"
                        >
                            Secure Area
                        </span>

                        <h1
                            class="text-5xl font-semibold leading-[1.08] tracking-tight text-white"
                        >
                            Protecting your

                            <span class="block text-sky-200">
                                InternHub account.
                            </span>
                        </h1>

                        <p
                            class="mt-7 max-w-sm text-[15px] leading-7 text-white/60"
                        >
                            Some areas of InternHub contain sensitive account
                            information. Confirm your password before continuing
                            to keep your account secure.
                        </p>

                        <div class="mt-9 space-y-4">
                            <div
                                class="flex items-center gap-3 text-sm text-white/60"
                            >
                                <div
                                    class="flex h-8 w-8 items-center justify-center rounded-full bg-white/10 text-sky-200"
                                >
                                    <svg
                                        class="h-4 w-4"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                    >
                                        <path
                                            d="M5 12L10 17L19 8"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        />
                                    </svg>
                                </div>

                                Extra protection for sensitive actions
                            </div>

                            <div
                                class="flex items-center gap-3 text-sm text-white/60"
                            >
                                <div
                                    class="flex h-8 w-8 items-center justify-center rounded-full bg-white/10 text-sky-200"
                                >
                                    <svg
                                        class="h-4 w-4"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                    >
                                        <path
                                            d="M5 12L10 17L19 8"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        />
                                    </svg>
                                </div>

                                Secure account verification
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div
                        class="flex items-center gap-3 text-[11px] font-medium uppercase tracking-[0.22em] text-white/40"
                    >
                        <span class="h-px w-9 bg-white/30"></span>
                        Connect. Learn. Grow.
                    </div>
                </div>
            </section>

            <!-- RIGHT PANEL -->
            <section
                class="flex min-h-[650px] items-center justify-center px-7 py-12 sm:px-12 lg:px-20"
            >
                <div class="w-full max-w-md">
                    <!-- Mobile logo -->
                    <div class="mb-9 lg:hidden">
                        <div
                            class="inline-flex rounded-xl bg-[#1c3a52] px-4 py-3"
                        >
                            <img
                                src="/images/LogoBgWhiteInternHub.png"
                                alt="InternHub"
                                class="w-36"
                            />
                        </div>
                    </div>

                    <!-- Icon -->
                    <div
                        class="mb-7 flex h-14 w-14 items-center justify-center rounded-2xl bg-[#1c3a52]/5 text-[#1c3a52]"
                    >
                        <svg
                            class="h-7 w-7"
                            viewBox="0 0 24 24"
                            fill="none"
                        >
                            <path
                                d="M8.5 10V7.5C8.5 5.567 10.067 4 12 4C13.933 4 15.5 5.567 15.5 7.5V10"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                            />

                            <path
                                d="M7 10H17C18.105 10 19 10.895 19 12V19C19 20.105 18.105 21 17 21H7C5.895 21 5 20.105 5 19V12C5 10.895 5.895 10 7 10Z"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linejoin="round"
                            />
                        </svg>
                    </div>

                    <!-- Header -->
                    <p
                        class="text-[11px] font-bold uppercase tracking-[0.22em] text-slate-400"
                    >
                        Security Check
                    </p>

                    <h2
                        class="mt-3 text-4xl font-semibold tracking-tight text-slate-900"
                    >
                        Confirm your password
                    </h2>

                    <p
                        class="mt-4 text-sm leading-7 text-slate-500"
                    >
                        This is a protected area of InternHub. Enter your
                        current password to confirm your identity before
                        continuing.
                    </p>

                    <!-- Info box -->
                    <div
                        class="mt-7 flex gap-4 rounded-2xl border border-slate-200 bg-slate-50 p-5"
                    >
                        <div
                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-[#1c3a52] shadow-sm"
                        >
                            <svg
                                class="h-5 w-5"
                                viewBox="0 0 24 24"
                                fill="none"
                            >
                                <path
                                    d="M12 3L20 6V11C20 16 16.5 20 12 21C7.5 20 4 16 4 11V6L12 3Z"
                                    stroke="currentColor"
                                    stroke-width="1.7"
                                    stroke-linejoin="round"
                                />

                                <path
                                    d="M9 12L11 14L15 10"
                                    stroke="currentColor"
                                    stroke-width="1.7"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />
                            </svg>
                        </div>

                        <div>
                            <p class="text-sm font-semibold text-slate-700">
                                Why do I need to confirm?
                            </p>

                            <p class="mt-1 text-xs leading-5 text-slate-500">
                                InternHub asks for your password again before
                                allowing access to sensitive account actions.
                            </p>
                        </div>
                    </div>

                    <!-- FORM -->
                    <form
                        class="mt-8"
                        @submit.prevent="submit"
                    >
                        <div>
                            <InputLabel
                                for="password"
                                value="Current password"
                                class="text-sm font-medium text-slate-700"
                            />

                            <div class="relative mt-2">
                                <!-- Password icon -->
                                <div
                                    class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400"
                                >
                                    <svg
                                        class="h-5 w-5"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                    >
                                        <path
                                            d="M8.5 10V7.5C8.5 5.567 10.067 4 12 4C13.933 4 15.5 5.567 15.5 7.5V10"
                                            stroke="currentColor"
                                            stroke-width="1.7"
                                            stroke-linecap="round"
                                        />

                                        <path
                                            d="M7 10H17C18.105 10 19 10.895 19 12V19C19 20.105 18.105 21 17 21H7C5.895 21 5 20.105 5 19V12C5 10.895 5.895 10 7 10Z"
                                            stroke="currentColor"
                                            stroke-width="1.7"
                                            stroke-linejoin="round"
                                        />
                                    </svg>
                                </div>

                                <TextInput
                                    id="password"
                                    v-model="form.password"
                                    type="password"
                                    required
                                    autocomplete="current-password"
                                    autofocus
                                    placeholder="Enter your current password"
                                    class="block w-full rounded-xl border-slate-200 bg-slate-50 py-4 pl-12 pr-4 text-sm text-slate-800 shadow-none focus:border-[#1c3a52] focus:bg-white focus:ring-[#1c3a52]/10"
                                />
                            </div>

                            <InputError
                                class="mt-2"
                                :message="form.errors.password"
                            />
                        </div>

                        <!-- Button -->
                        <PrimaryButton
                            :disabled="form.processing"
                            class="mt-6 flex w-full items-center justify-center gap-2 rounded-xl bg-[#1c3a52] px-6 py-4 text-sm font-semibold normal-case tracking-normal text-white transition hover:-translate-y-0.5 hover:bg-[#244b68] hover:shadow-lg hover:shadow-[#1c3a52]/15 disabled:cursor-not-allowed disabled:opacity-60"
                        >
                            <!-- Spinner -->
                            <svg
                                v-if="form.processing"
                                class="h-4 w-4 animate-spin"
                                viewBox="0 0 24 24"
                                fill="none"
                            >
                                <circle
                                    cx="12"
                                    cy="12"
                                    r="9"
                                    stroke="currentColor"
                                    stroke-width="3"
                                    class="opacity-25"
                                />

                                <path
                                    d="M21 12A9 9 0 0 0 12 3"
                                    stroke="currentColor"
                                    stroke-width="3"
                                    stroke-linecap="round"
                                    class="opacity-75"
                                />
                            </svg>

                            <span>
                                {{
                                    form.processing
                                        ? 'Confirming...'
                                        : 'Confirm password'
                                }}
                            </span>

                            <svg
                                v-if="!form.processing"
                                class="h-4 w-4"
                                viewBox="0 0 24 24"
                                fill="none"
                            >
                                <path
                                    d="M5 12H19M14 7L19 12L14 17"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />
                            </svg>
                        </PrimaryButton>
                    </form>

                    <!-- Forgot password -->
                    <div class="mt-6 text-center">
                        <Link
                            :href="route('password.request')"
                            class="text-sm font-medium text-slate-500 transition hover:text-[#1c3a52]"
                        >
                            Forgot your password?
                        </Link>
                    </div>

                    <!-- Security footer -->
                    <div
                        class="mt-8 flex items-center justify-center gap-2 border-t border-slate-100 pt-6 text-xs text-slate-400"
                    >
                        <svg
                            class="h-4 w-4"
                            viewBox="0 0 24 24"
                            fill="none"
                        >
                            <path
                                d="M12 3L20 6V11C20 16 16.5 20 12 21C7.5 20 4 16 4 11V6L12 3Z"
                                stroke="currentColor"
                                stroke-width="1.6"
                                stroke-linejoin="round"
                            />

                            <path
                                d="M9 12L11 14L15 10"
                                stroke="currentColor"
                                stroke-width="1.6"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>

                        Your password is used only to verify your identity.
                    </div>
                </div>
            </section>
        </div>
    </div>
</template>
