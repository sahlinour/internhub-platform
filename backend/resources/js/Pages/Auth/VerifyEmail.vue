<script setup>
import { computed } from 'vue'
import PrimaryButton from '@/Components/Shared/PrimaryButton.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'

const props = defineProps({
    status: {
        type: String,
        default: null,
    },
})

const form = useForm({})

const submit = () => {
    form.post(route('verification.send'))
}

const verificationLinkSent = computed(
    () => props.status === 'verification-link-sent'
)
</script>

<template>
    <Head title="Email Verification" />

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

        <div
            class="pointer-events-none absolute bottom-24 right-[8%] hidden h-20 w-20 rounded-full bg-sky-100/50 lg:block"
        ></div>

        <!-- MAIN CARD -->
        <div
            class="relative z-10 grid w-full max-w-6xl overflow-hidden rounded-[30px] bg-white shadow-2xl shadow-slate-300/50 lg:grid-cols-2"
        >
            <!-- ========================================= -->
            <!-- LEFT PANEL -->
            <!-- ========================================= -->
            <section
                class="relative hidden min-h-[650px] overflow-hidden bg-[#1c3a52] p-14 lg:flex lg:flex-col"
            >
                <!-- Decorations -->
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

                    <!-- Hero content -->
                    <div class="my-auto max-w-md">
                        <span
                            class="mb-5 inline-block text-xs font-bold uppercase tracking-[0.28em] text-sky-200"
                        >
                            Almost There
                        </span>

                        <h1
                            class="text-5xl font-semibold leading-[1.08] tracking-tight text-white"
                        >
                            One last step to

                            <span class="block text-sky-200">
                                start your journey.
                            </span>
                        </h1>

                        <p
                            class="mt-7 max-w-sm text-[15px] leading-7 text-white/60"
                        >
                            Verify your email address to activate your InternHub
                            account and securely access your internship
                            opportunities and workspace.
                        </p>

                        <!-- Small features -->
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

                                Secure your InternHub account
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

                                Access your personalized workspace
                            </div>
                        </div>
                    </div>

                    <!-- Bottom -->
                    <div
                        class="flex items-center gap-3 text-[11px] font-medium uppercase tracking-[0.22em] text-white/40"
                    >
                        <span class="h-px w-9 bg-white/30"></span>

                        Connect. Learn. Grow.
                    </div>
                </div>
            </section>

            <!-- ========================================= -->
            <!-- RIGHT PANEL -->
            <!-- ========================================= -->
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

                    <!-- Email icon -->
                    <div
                        class="mb-7 flex h-14 w-14 items-center justify-center rounded-2xl bg-[#1c3a52]/5 text-[#1c3a52]"
                    >
                        <svg
                            class="h-7 w-7"
                            viewBox="0 0 24 24"
                            fill="none"
                        >
                            <path
                                d="M4 6L12 13L20 6"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />

                            <path
                                d="M5 19H19C20.105 19 21 18.105 21 17V7C21 5.895 20.105 5 19 5H5C3.895 5 3 5.895 3 7V17C3 18.105 3.895 19 5 19Z"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linejoin="round"
                            />
                        </svg>
                    </div>

                    <!-- Heading -->
                    <p
                        class="text-[11px] font-bold uppercase tracking-[0.22em] text-slate-400"
                    >
                        Email Verification
                    </p>

                    <h2
                        class="mt-3 text-4xl font-semibold tracking-tight text-slate-900"
                    >
                        Check your inbox
                    </h2>

                    <p
                        class="mt-4 text-sm leading-7 text-slate-500"
                    >
                        Thanks for signing up! We've sent a verification link
                        to the email address you provided during registration.
                    </p>

                    <!-- Information box -->
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

                        <div>
                            <p
                                class="text-sm font-semibold text-slate-700"
                            >
                                Verify your email address
                            </p>

                            <p
                                class="mt-1 text-xs leading-5 text-slate-500"
                            >
                                Open the email from InternHub and click the
                                verification link to activate your account.
                            </p>
                        </div>
                    </div>

                    <!-- SUCCESS MESSAGE -->
                    <div
                        v-if="verificationLinkSent"
                        class="mt-5 flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3.5 text-sm text-emerald-700"
                    >
                        <div
                            class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-emerald-100"
                        >
                            <svg
                                class="h-3.5 w-3.5"
                                viewBox="0 0 24 24"
                                fill="none"
                            >
                                <path
                                    d="M5 12L10 17L19 8"
                                    stroke="currentColor"
                                    stroke-width="2.5"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                />
                            </svg>
                        </div>

                        <div>
                            <p class="font-medium">
                                Verification email sent!
                            </p>

                            <p class="mt-1 text-xs leading-5 text-emerald-600">
                                A new verification link has been sent to your
                                email address.
                            </p>
                        </div>
                    </div>

                    <!-- FORM -->
                    <form
                        class="mt-7"
                        @submit.prevent="submit"
                    >
                        <!-- Resend button -->
                        <PrimaryButton
                            :disabled="form.processing"
                            class="flex w-full items-center justify-center gap-2 rounded-xl bg-[#1c3a52] px-6 py-4 text-sm font-semibold normal-case tracking-normal text-white transition hover:-translate-y-0.5 hover:bg-[#244b68] hover:shadow-lg hover:shadow-[#1c3a52]/15 disabled:cursor-not-allowed disabled:opacity-60"
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

                            <!-- Email icon -->
                            <svg
                                v-if="!form.processing"
                                class="h-4 w-4"
                                viewBox="0 0 24 24"
                                fill="none"
                            >
                                <path
                                    d="M4 6L12 13L20 6"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    stroke-linecap="round"
                                />

                                <path
                                    d="M5 19H19C20.105 19 21 18.105 21 17V7C21 5.895 20.105 5 19 5H5C3.895 5 3 5.895 3 7V17C3 18.105 3.895 19 5 19Z"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    stroke-linejoin="round"
                                />
                            </svg>

                            <span>
                                {{
                                    form.processing
                                        ? 'Sending verification email...'
                                        : 'Resend verification email'
                                }}
                            </span>
                        </PrimaryButton>
                    </form>

                    <!-- Didn't receive email -->
                    <p
                        class="mt-5 text-center text-xs leading-5 text-slate-400"
                    >
                        Didn't receive the email? Check your spam folder or
                        request another verification link.
                    </p>

                    <!-- Separator -->
                    <div class="my-7 flex items-center gap-4">
                        <div class="h-px flex-1 bg-slate-100"></div>

                        <span
                            class="text-[10px] font-medium uppercase tracking-wider text-slate-300"
                        >
                            or
                        </span>

                        <div class="h-px flex-1 bg-slate-100"></div>
                    </div>

                    <!-- Logout -->
                    <Link
                        :href="route('logout')"
                        method="post"
                        as="button"
                        class="flex w-full items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-6 py-3.5 text-sm font-medium text-slate-600 transition hover:border-slate-300 hover:bg-slate-50 hover:text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#1c3a52]/10"
                    >
                        <svg
                            class="h-4 w-4"
                            viewBox="0 0 24 24"
                            fill="none"
                        >
                            <path
                                d="M14 8L18 12L14 16M18 12H8"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />

                            <path
                                d="M11 5H6C4.895 5 4 5.895 4 7V17C4 18.105 4.895 19 6 19H11"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                            />
                        </svg>

                        Log out
                    </Link>

                    <!-- Security footer -->
                    <div
                        class="mt-7 flex items-center justify-center gap-2 border-t border-slate-100 pt-6 text-xs text-slate-400"
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

                        Verification helps keep your InternHub account secure.
                    </div>
                </div>
            </section>
        </div>
    </div>
</template>
