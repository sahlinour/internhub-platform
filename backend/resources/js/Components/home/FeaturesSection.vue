<script setup>
const stagiaireFeatures = [
    'Search for internship opportunities',
    'Apply with one click',
    'Track your applications',
    'Save your favorites',
]

const entrepriseFeatures = [
    'Post internship offers',
    'Manage applications',
    'Track your interns',
    'Comprehensive dashboard',
]

const adminFeatures = [
    'Manage all users',
    'Validate offers',
    'Handle reports',
    'View statistics',
]
</script>

<template>
    <section class="py-24 font-body" style="background:#F7F9FC">
        <div class="max-w-7xl mx-auto px-8">
            <div class="text-center mb-16">
                <span
                    class="inline-block px-4 py-1.5 rounded-full text-xs font-semibold tracking-widest uppercase mb-4"
                    style="background:rgba(129,195,215,.15);color:#3A7CA5"
                >
                    Platform
                </span>

                <h2
                    class="text-4xl md:text-5xl font-bold mb-4"
                    style="font-family:'Playfair Display',serif;color:#16425B"
                >
                    Platform For Everyone
                </h2>

                <p class="text-gray-400 text-lg max-w-xl mx-auto">
                    Three dedicated spaces according to your profile
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                <!-- Student -->
                <div
                    class="relative rounded-3xl p-8 overflow-hidden group hover:-translate-y-2 transition-all duration-300 cursor-pointer"
                    style="background:white;box-shadow:0 4px 24px rgba(22,66,91,.08);border:1px solid rgba(129,195,215,.15)"
                >
                    <div
                        class="absolute top-0 left-0 w-full h-1 rounded-t-3xl"
                        style="background:linear-gradient(90deg,#81C3D7,#3A7CA5)"
                    ></div>

                    <div
                        class="w-16 h-16 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300"
                        style="background:rgba(129,195,215,.12);color:#3A7CA5"
                    >
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 10.5 12 5l9 5.5-9 5-9-5Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 12.5V16c0 1.5 2.2 3 5 3s5-1.5 5-3v-3.5"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 10.5V16"/>
                        </svg>
                    </div>

                    <h3
                        class="text-xl font-bold mb-5"
                        style="font-family:'Playfair Display',serif;color:#16425B"
                    >
                        Student Space
                    </h3>

                    <ul class="space-y-3">
                        <li
                            v-for="item in stagiaireFeatures"
                            :key="item"
                            class="flex items-center gap-3 text-gray-500 text-sm"
                        >
                            <span
                                class="w-5 h-5 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0"
                                style="background:rgba(129,195,215,.2);color:#3A7CA5"
                            >✓</span>
                            {{ item }}
                        </li>
                    </ul>

                    <div class="mt-8">
                        <a
                            href="/register"
                            class="inline-flex items-center gap-2 text-sm font-semibold transition-colors duration-200"
                            style="color:#3A7CA5"
                        >
                            Commencer <span>→</span>
                        </a>
                    </div>
                </div>

                <!-- Company -->
                <div
                    class="relative rounded-3xl p-8 overflow-hidden group hover:-translate-y-2 transition-all duration-300 cursor-pointer"
                    style="background:linear-gradient(145deg,#16425B 0%,#2F6690 100%);box-shadow:0 12px 40px rgba(22,66,91,.3)"
                >
                    <div
                        class="absolute top-0 left-0 w-full h-1 rounded-t-3xl"
                        style="background:linear-gradient(90deg,#81C3D7,#D9DCD6)"
                    ></div>

                    <div
                        class="w-16 h-16 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300"
                        style="background:rgba(255,255,255,.1);color:#81C3D7"
                    >
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                            <rect x="3" y="7" width="18" height="13" rx="2"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V5.5A1.5 1.5 0 0 1 9.5 4h5A1.5 1.5 0 0 1 16 5.5V7M3 12h18M10 12v1.5h4V12"/>
                        </svg>
                    </div>

                    <h3
                        class="text-xl font-bold mb-5 text-white"
                        style="font-family:'Playfair Display',serif"
                    >
                        Company Space
                    </h3>

                    <ul class="space-y-3">
                        <li
                            v-for="item in entrepriseFeatures"
                            :key="item"
                            class="flex items-center gap-3 text-sm"
                            style="color:rgba(217,220,214,.85)"
                        >
                            <span
                                class="w-5 h-5 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0"
                                style="background:rgba(129,195,215,.25);color:#81C3D7"
                            >✓</span>
                            {{ item }}
                        </li>
                    </ul>

                    <div class="mt-8">
                        <a
                            href="/register"
                            class="inline-flex items-center gap-2 text-sm font-semibold transition-colors duration-200"
                            style="color:#81C3D7"
                        >
                            Commencer <span>→</span>
                        </a>
                    </div>
                </div>

                <!-- Admin -->
                <div
                    class="relative rounded-3xl p-8 overflow-hidden group hover:-translate-y-2 transition-all duration-300 cursor-pointer"
                    style="background:white;box-shadow:0 4px 24px rgba(22,66,91,.08);border:1px solid rgba(129,195,215,.15)"
                >
                    <div
                        class="absolute top-0 left-0 w-full h-1 rounded-t-3xl"
                        style="background:linear-gradient(90deg,#2F6690,#16425B)"
                    ></div>

                    <div
                        class="w-16 h-16 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300"
                        style="background:rgba(47,102,144,.1);color:#2F6690"
                    >
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3 5 6v5c0 4.5 2.8 7.8 7 10 4.2-2.2 7-5.5 7-10V6l-7-3Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="m9 12 2 2 4-4"/>
                        </svg>
                    </div>

                    <h3
                        class="text-xl font-bold mb-5"
                        style="font-family:'Playfair Display',serif;color:#16425B"
                    >
                        Admin Space
                    </h3>

                    <ul class="space-y-3">
                        <li
                            v-for="item in adminFeatures"
                            :key="item"
                            class="flex items-center gap-3 text-gray-500 text-sm"
                        >
                            <span
                                class="w-5 h-5 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0"
                                style="background:rgba(47,102,144,.1);color:#2F6690"
                            >✓</span>
                            {{ item }}
                        </li>
                    </ul>

                    <div class="mt-8">
                        <a
                            href="/register"
                            class="inline-flex items-center gap-2 text-sm font-semibold"
                            style="color:#2F6690"
                        >
                            Acess <span>→</span>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>
</template>