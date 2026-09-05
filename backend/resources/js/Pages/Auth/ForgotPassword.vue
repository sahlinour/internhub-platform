<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import InputError from '@/Components/Shared/InputError.vue'
import InputLabel from '@/Components/Shared/InputLabel.vue'
import TextInput from '@/Components/Shared/TextInput.vue'
import PrimaryButton from '@/Components/Shared/PrimaryButton.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'

defineProps({
    status: {
        type: String,
        default: null,
    },
})

const form = useForm({
    email: '',
})

const submit = () => {
    form.post(route('password.email'))
}
</script>

<template>
    <GuestLayout>
        <Head title="Forgot Password" />

        <div
            class="relative flex min-h-screen w-full items-center justify-center overflow-hidden bg-slate-50 px-6 py-10"
        >
            <!-- Background -->
            <div
                class="pointer-events-none absolute -right-32 -top-32 h-96 w-96 rounded-full bg-[#1c3a52]/5"
            ></div>

            <div
                class="pointer-events-none absolute -bottom-32 -left-32 h-80 w-80 rounded-full border border-[#1c3a52]/10"
            ></div>

            <!-- Card -->
            <div
                class="relative z-10 grid w-full max-w-6xl overflow-hidden rounded-[32px] bg-white shadow-2xl shadow-slate-300/40 lg:grid-cols-2"
            >
                <!-- LEFT -->
                <section
                    class="relative hidden min-h-[650px] overflow-hidden bg-[#1c3a52] p-14 lg:flex lg:flex-col"
                >
                    <!-- Decorations -->
                    <div
                        class="absolute -right-32 top-20 h-80 w-80 rounded-full border border-white/10"
                    ></div>

                    <div
                        class="absolute -bottom-24 -left-20 h-72 w-72 rounded-full border border-white/5"
                    ></div>

                    <div
                        class="absolute bottom-16 right-12 h-24 w-24 rounded-full bg-white/[0.03]"
                    ></div>

                    <div class="relative z-10 flex h-full flex-col">
                        <!-- Logo -->
                        <Link href="/" class="w-fit">
                            <img
                                src="/images/LogoBgDarkInternHub-rbg.png"
                                alt="InternHub"
                                class="w-44 object-contain"
                            />
                        </Link>

                        <!-- Text -->
                        <div class="my-auto max-w-md">
                            <p
                                class="mb-5 text-xs font-bold uppercase tracking-[0.28em] text-sky-200"
                            >
                                Account Recovery
                            </p>

                            <h1
                                class="text-5xl font-semibold leading-[1.08] tracking-tight text-white"
                            >
                                Get back to your

                                <span class="block text-sky-200">
                                    internship journey.
                                </span>
                            </h1>

                            <p
                                class="mt-7 max-w-sm text-[15px] leading-7 text-white/60"
                            >
                                Recover access to your InternHub account and
                                continue exploring opportunities, managing
                                applications and building your career.
                            </p>
                        </div>

                        <div
                            class="flex items-center gap-3 text-[11px] font-medium uppercase tracking-[0.22em] text-white/40"
                        >
                            <span class="h-px w-9 bg-white/30"></span>

                            Connect. Learn. Grow.
                        </div>
                    </div>
                </section>

                <!-- RIGHT -->
                <section
                    class="flex min-h-[650px] items-center justify-center px-8 py-12 sm:px-14 lg:px-20"
                >
                    <div class="w-full max-w-md">
                        <!-- Mobile logo -->
                        <div class="mb-10 lg:hidden">
                            <div
                                class="inline-flex rounded-xl bg-[#1c3a52] px-4 py-3"
                            >
                                <img
                                    src="/images/LogoBgDarkInternHub-rbg.png"
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

                                <path
                                    d="M12 15V16"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    stroke-linecap="round"
                                />
                            </svg>
                        </div>

                        <!-- Heading -->
                        <p
                            class="text-[11px] font-bold uppercase tracking-[0.22em] text-slate-400"
                        >
                            Account Recovery
                        </p>

                        <h2
                            class="mt-3 text-4xl font-semibold tracking-tight text-slate-900"
                        >
                            Forgot your password?
                        </h2>

                        <p
                            class="mt-4 text-sm leading-7 text-slate-500"
                        >
                            Enter the email address linked to your InternHub
                            account and we'll send you a secure password reset
                            link.
                        </p>

                        <!-- Status -->
                        <div
                            v-if="status"
                            class="mt-6 flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700"
                        >
                            <svg
                                class="mt-0.5 h-5 w-5 shrink-0"
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

                            {{ status }}
                        </div>

                        <!-- Form -->
                        <form
                            class="mt-9"
                            @submit.prevent="submit"
                        >
                            <div>
                                <InputLabel
                                    for="email"
                                    value="Email address"
                                    class="text-sm font-medium text-slate-700"
                                />

                                <div class="relative mt-2">
                                    <div
                                        class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400"
                                    >
                                        <svg
                                            class="h-5 w-5"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                        >
                                            <path
                                                d="M4 6L12 13L20 6"
                                                stroke="currentColor"
                                                stroke-width="1.7"
                                                stroke-linecap="round"
                                            />

                                            <path
                                                d="M5 19H19C20.105 19 21 18.105 21 17V7C21 5.895 20.105 5 19 5H5C3.895 5 3 5.895 3 7V17C3 18.105 3.895 19 5 19Z"
                                                stroke="currentColor"
                                                stroke-width="1.7"
                                                stroke-linejoin="round"
                                            />
                                        </svg>
                                    </div>

                                    <TextInput
                                        id="email"
                                        v-model="form.email"
                                        type="email"
                                        required
                                        autofocus
                                        autocomplete="username"
                                        placeholder="name@example.com"
                                        class="block w-full rounded-xl border-slate-200 bg-slate-50 py-4 pl-12 pr-4 text-sm text-slate-800 shadow-none focus:border-[#1c3a52] focus:bg-white focus:ring-[#1c3a52]/10"
                                    />
                                </div>

                                <InputError
                                    :message="form.errors.email"
                                    class="mt-2"
                                />
                            </div>

                            <PrimaryButton
                                :disabled="form.processing"
                                class="mt-6 flex w-full items-center justify-center gap-2 rounded-xl bg-[#1c3a52] px-6 py-4 text-sm font-semibold normal-case tracking-normal text-white transition hover:bg-[#244b68] disabled:cursor-not-allowed disabled:opacity-60"
                            >
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

                                {{
                                    form.processing
                                        ? 'Sending...'
                                        : 'Send reset link'
                                }}

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

                        <!-- Back to login -->
                        <div class="mt-7 text-center">
                            <Link
                                :href="route('login')"
                                class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 transition hover:text-[#1c3a52]"
                            >
                                <svg
                                    class="h-4 w-4"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                >
                                    <path
                                        d="M19 12H5M10 17L5 12L10 7"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    />
                                </svg>

                                Back to sign in
                            </Link>
                        </div>

                        <!-- Security -->
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
                                />

                                <path
                                    d="M9 12L11 14L15 10"
                                    stroke="currentColor"
                                    stroke-width="1.6"
                                    stroke-linecap="round"
                                />
                            </svg>

                            Your account information is securely protected.
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </GuestLayout>
</template>
