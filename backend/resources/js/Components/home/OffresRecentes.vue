<script setup>
import { Link } from '@inertiajs/vue3'
import OffreCardHome from '@/Components/home/OffreCardHome.vue'

defineProps({
    offres: {
        type: Array,
        default: () => [],
    },
})
</script>

<template>
    <section class="bg-[#F4F7F9] py-16">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">

            <div class="mb-10 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p  
                        class="inline-block px-4 py-1.5 rounded-full text-xs font-semibold tracking-widest uppercase mb-4"
                        style="background:rgba(129,195,215,.15);color:#3A7CA5"
                    >
                        Opportunities
                    </p>

                    <h2 class="text-3xl font-bold text-[#16425B] sm:text-4xl" style="font-family:'Playfair Display',serif;color:#16425B">
                        Latest Internships
                    </h2>

                    <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">
                        Discover the most recent internship opportunities available on InternHub.
                    </p>
                </div>

             <Link
                    :href="route('register')"
                    class="inline-flex items-center gap-2 text-sm font-semibold text-[#2F6690] transition hover:text-[#16425B]"
                >
                    View All Offers

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-4 w-4"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M5 12h14m-6-6 6 6-6 6"
                        />
                    </svg>
                </Link>
            </div>

            <div
                v-if="offres.length"
                class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3"
            >
                <OffreCardHome
                    v-for="offre in offres"
                    :key="offre.id"
                    :offre="offre"
                />
            </div>

            <div
                v-else
                class="rounded-2xl border border-slate-200 bg-white px-6 py-12 text-center shadow-sm"
            >
                <p class="text-sm text-slate-500">
                    No internship opportunities available at the moment.
                </p>
            </div>

        </div>
    </section>
</template>