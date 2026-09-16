<script setup>
import { Link } from '@inertiajs/vue3'

const socials = [
    { label: 'LinkedIn', href: '#', icon: 'linkedin' },
    { label: 'Twitter', href: '#', icon: 'twitter' },
    { label: 'Instagram', href: '#', icon: 'instagram' },
]

const navLinks = [
    { label: 'Home', href: '#' },
    { label: 'Browse Internships', href: '#' },
    { label: 'For Companies', href: '#' },
    { label: 'Sign In', href: '#' },
    { label: 'Create Account', href: '#' },
]

const legalLinks = [
    'Privacy Policy',
    'Terms of Service',
    'Cookie Policy',
]
</script>

<template>
    <footer class="bg-[#16425B] text-white">
        <div class="mx-auto max-w-7xl px-6 py-14 sm:px-8 lg:py-16">
            <div class="grid grid-cols-1 gap-12 lg:grid-cols-12 lg:gap-10">

                <div class="lg:col-span-5">
                    <Link href="/" class="inline-flex items-center">
                        <img
                            :src="`/images/LogoBgDarkInternHub.png`"
                            alt="InternHub"
                            class="h-auto w-[150px] object-contain"
                        />
                    </Link>

                    <p class="mt-5 max-w-md text-sm leading-7 text-[#D9DCD6]/65">
                        InternHub simplifies the internship journey by connecting
                        students with opportunities and companies with talented
                        future professionals.
                    </p>

                    <div class="mt-6 flex items-center gap-3">
                        <a
                            v-for="social in socials"
                            :key="social.label"
                            :href="social.href"
                            :aria-label="social.label"
                            class="flex h-10 w-10 items-center justify-center
                                   rounded-xl border border-[#81C3D7]/15
                                   bg-[#81C3D7]/10 text-[#81C3D7]
                                   transition-all duration-200
                                   hover:-translate-y-1
                                   hover:border-[#81C3D7]/30
                                   hover:bg-[#81C3D7]/20
                                   hover:text-white"
                        >
                            <svg
                                v-if="social.icon === 'linkedin'"
                                class="h-4 w-4"
                                fill="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    d="M6.5 8.5H3V21h3.5V8.5ZM4.75 3A2.1 2.1 0 1 0 4.75 7.2 2.1 2.1 0 0 0 4.75 3ZM21 13.9c0-3.77-2-5.53-4.67-5.53-2.15 0-3.1 1.18-3.64 2.01V8.5H9.2V21h3.49v-6.2c0-1.64.31-3.23 2.35-3.23 2 0 2.03 1.87 2.03 3.34V21H21v-7.1Z"
                                />
                            </svg>

                            <svg
                                v-else-if="social.icon === 'twitter'"
                                class="h-4 w-4"
                                fill="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    d="M18.9 2H22l-6.77 7.74L23.2 22h-6.25l-4.9-6.39L6.46 22H3.36l7.24-8.28L2.8 2h6.41l4.43 5.86L18.9 2Zm-1.1 17.75h1.73L8.27 4.13H6.41L17.8 19.75Z"
                                />
                            </svg>

                            <svg
                                v-else
                                class="h-4 w-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <rect
                                    x="3"
                                    y="3"
                                    width="18"
                                    height="18"
                                    rx="5"
                                />
                                <circle cx="12" cy="12" r="4.2" />
                                <circle
                                    cx="17.5"
                                    cy="6.5"
                                    r="1"
                                    fill="currentColor"
                                    stroke="none"
                                />
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <p
                        class="mb-5 text-[10px] font-bold uppercase
                               tracking-[0.18em] text-[#81C3D7]"
                    >
                        Navigation
                    </p>

                    <nav class="space-y-3">
                        <a
                            v-for="link in navLinks"
                            :key="link.label"
                            :href="link.href"
                            class="group flex items-center gap-2 text-sm
                                   text-[#D9DCD6]/60 transition-colors
                                   duration-200 hover:text-white"
                        >
                            <span
                                class="h-1 w-1 rounded-full bg-[#81C3D7]
                                       opacity-0 transition-opacity
                                       group-hover:opacity-100"
                            ></span>

                            {{ link.label }}
                        </a>
                    </nav>
                </div>

                <div class="lg:col-span-2">
                    <p
                        class="mb-5 text-[10px] font-bold uppercase
                               tracking-[0.18em] text-[#81C3D7]"
                    >
                        Contact
                    </p>

                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <div
                                class="mt-0.5 flex h-8 w-8 shrink-0 items-center
                                       justify-center rounded-lg
                                       bg-[#81C3D7]/10 text-[#81C3D7]"
                            >
                                <svg
                                    class="h-4 w-4"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M3 6.75A2.75 2.75 0 0 1 5.75 4h12.5A2.75 2.75 0 0 1 21 6.75v10.5A2.75 2.75 0 0 1 18.25 20H5.75A2.75 2.75 0 0 1 3 17.25V6.75Z"
                                    />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="m4 6 8 6 8-6"
                                    />
                                </svg>
                            </div>

                            <div>
                                <p class="text-[9px] uppercase tracking-wider text-[#D9DCD6]/35">
                                    Email
                                </p>
                                <p class="mt-0.5 text-xs text-[#D9DCD6]/65">
                                    contact@internhub.ma
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div
                                class="mt-0.5 flex h-8 w-8 shrink-0 items-center
                                       justify-center rounded-lg
                                       bg-[#81C3D7]/10 text-[#81C3D7]"
                            >
                                <svg
                                    class="h-4 w-4"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 21s7-5.1 7-11a7 7 0 1 0-14 0c0 5.9 7 11 7 11Z"
                                    />
                                    <circle cx="12" cy="10" r="2.3" />
                                </svg>
                            </div>

                            <div>
                                <p class="text-[9px] uppercase tracking-wider text-[#D9DCD6]/35">
                                    Location
                                </p>
                                <p class="mt-0.5 text-xs text-[#D9DCD6]/65">
                                    Morocco
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div
                                class="mt-0.5 flex h-8 w-8 shrink-0 items-center
                                       justify-center rounded-lg
                                       bg-[#81C3D7]/10 text-[#81C3D7]"
                            >
                                <svg
                                    class="h-4 w-4"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M5 4h3l2 5-2.2 1.7a15.5 15.5 0 0 0 5.5 5.5L15 14l5 2v3a2 2 0 0 1-2 2C10.27 21 3 13.73 3 5a2 2 0 0 1 2-1Z"
                                    />
                                </svg>
                            </div>

                            <div>
                                <p class="text-[9px] uppercase tracking-wider text-[#D9DCD6]/35">
                                    Phone
                                </p>
                                <p class="mt-0.5 text-xs text-[#D9DCD6]/65">
                                    +212 6XX XXX XXX
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-3">
                    <p
                        class="mb-5 text-[10px] font-bold uppercase
                               tracking-[0.18em] text-[#81C3D7]"
                    >
                        Stay Updated
                    </p>

                    <p class="mb-4 text-xs leading-5 text-[#D9DCD6]/50">
                        Get the latest internship opportunities and updates
                        from InternHub.
                    </p>

                    <div
                        class="flex items-center gap-2 rounded-xl
                               border border-[#81C3D7]/15
                               bg-white/[0.04] p-1.5"
                    >
                        <input
                            type="email"
                            placeholder="Your email"
                            class="min-w-0 flex-1 bg-transparent px-2
                                   text-xs text-white outline-none
                                   placeholder:text-[#D9DCD6]/30"
                        />

                        <button
                            type="button"
                            aria-label="Subscribe"
                            class="flex h-9 w-9 shrink-0 items-center
                                   justify-center rounded-lg
                                   bg-[#81C3D7] text-[#16425B]
                                   transition-all duration-200
                                   hover:bg-[#3A7CA5]
                                   hover:text-white"
                        >
                            <svg
                                class="h-4 w-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M5 12h14M13 6l6 6-6 6"
                                />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="border-t border-[#81C3D7]/10">
            <div
                class="mx-auto flex max-w-7xl flex-col items-center
                       justify-between gap-3 px-6 py-5 sm:px-8
                       md:flex-row"
            >
                <p class="text-[10px] text-[#D9DCD6]/35">
                    © 2026 InternHub. All rights reserved.
                </p>

                <div
                    class="flex flex-wrap items-center justify-center
                           gap-x-6 gap-y-2"
                >
                    <a
                        v-for="legal in legalLinks"
                        :key="legal"
                        href="#"
                        class="text-[10px] text-[#D9DCD6]/35
                               transition-colors duration-200
                               hover:text-[#81C3D7]"
                    >
                        {{ legal }}
                    </a>
                </div>
            </div>
        </div>
    </footer>
</template>