<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { Link } from '@inertiajs/vue3'

const menuOuvert = ref(false)
const scrolled = ref(false)

const navLinks = [
    { href: '#home', label: 'Home' },
    { href: '#about', label: 'About Us' },
    { href: '#explore', label: 'Explore' },
    { href: '#how-it-works', label: 'How It Works' },
]

function handleScroll() {
    scrolled.value = window.scrollY > 50
}

function scrollToSection(id) {
    const element = document.querySelector(id)

    if (element) {
        element.scrollIntoView({
            behavior: 'smooth',
            block: 'start',
        })
    }

    menuOuvert.value = false
}

onMounted(() => {
    window.addEventListener('scroll', handleScroll)
})

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll)
})
</script>

<template>
    <nav
        class="fixed top-0 left-0 w-full z-50 transition-all duration-500 shadow-lg shadow-gray-900/20 backdrop-blur-lg"
        :class="scrolled
            ? 'bg-gradient-to-br from-brand-darkest/[0.97] to-brand-dark/[0.97] shadow-[0_2px_0_rgba(0,0,0,0.3)]'
            : 'bg-gradient-to-br from-brand-darkest/40 via-brand-dark/20 to-brand/[0.05] backdrop-blur-sm'"
    >

        <div class="max-w-7xl mx-auto px-8 py-5 flex justify-between items-center">

            <!-- Logo -->
            <button
                @click="scrollToSection('#home')"
                class="flex items-center gap-2 group"
            >
                <img
                    src="/images/LogoBgDarkInternHub.png"
                    alt="InternHub"
                    class="block h-auto w-[120px] object-contain"
                />
            </button>

            <!-- Desktop menu -->
            <div class="hidden md:flex items-center gap-2">

                <template
                    v-for="(link, i) in navLinks"
                    :key="link.href"
                >

                    <button
                        @click="scrollToSection(link.href)"
                        class="relative px-4 py-2 text-sm font-medium tracking-widest uppercase font-body text-brand-muted/90 transition-all duration-200 group"
                    >
                        <span
                            class="group-hover:text-white transition-colors duration-200"
                        >
                            {{ link.label }}
                        </span>

                        <span
                            class="absolute bottom-0 left-1/2 -translate-x-1/2 w-0 h-0.5 bg-brand-light group-hover:w-4 transition-all duration-300 rounded-full"
                        ></span>
                    </button>

                    <span
                        v-if="i < navLinks.length - 1"
                        class="text-lg text-brand-light/40"
                    >
                        |
                    </span>

                </template>

                <!-- Hire Talent -->
                <Link
                    href="/register"
                    class="ml-6 px-6 py-2.5 rounded-xl text-sm font-bold font-body text-brand-darkest relative overflow-hidden group bg-gradient-to-br from-brand-light to-brand shadow-[0_4px_15px_rgba(129,195,215,0.4)] transition-all duration-300"
                >
                    <span class="relative z-10">
                        Hire Talent
                    </span>

                    <div
                        class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-gradient-to-br from-white to-brand-light"
                    ></div>
                </Link>

            </div>

            <!-- Mobile menu button -->
            <button
                @click="menuOuvert = !menuOuvert"
                class="md:hidden text-white text-2xl p-2"
            >
                {{ menuOuvert ? '✕' : '☰' }}
            </button>

        </div>

        <!-- Mobile menu -->
        <div
            v-if="menuOuvert"
            class="md:hidden px-8 py-6 flex flex-col gap-4 bg-[linear-gradient(105deg,#16425B_0%,rgba(22,66,91,0.85)_50%)] backdrop-blur-md"
        >

            <button
                v-for="link in navLinks"
                :key="link.href"
                @click="scrollToSection(link.href)"
                class="text-left text-white text-sm tracking-widest uppercase font-medium hover:text-brand-light transition"
            >
                {{ link.label }}
            </button>

            <Link
                href="/register"
                class="text-center px-6 py-3 rounded-xl font-bold text-sm shadow-lg transition-all duration-300 text-brand-darkest bg-gradient-to-br from-white to-brand-light"
                @click="menuOuvert = false"
            >
                Hire Talent
            </Link>

        </div>

    </nav>
</template>