<script setup>
import { computed } from 'vue'

const props = defineProps({
    offre: {
        type: Object,
        required: true,
    },
})
const entreprise = computed(() => props.offre?.entreprise || null)
const user = computed(() => entreprise.value?.user || null)
const companyName = computed(() => {
    return user.value?.nom_complet || 'Company'
})
const email = computed(() => {
    return user.value?.email || null
})
const telephone = computed(() => {
    return user.value?.telephone || null
})
const ville = computed(() => {
    return user.value?.ville?.nom || null
})
const secteur = computed(() => {
    return entreprise.value?.secteur || null
})
const adresse = computed(() => {
    return entreprise.value?.adresse || null
})
const siteWeb = computed(() => {
    return entreprise.value?.site_web || null
})
const description = computed(() => {
    return entreprise.value?.description || null
})
const websiteUrl = computed(() => {
    if (!siteWeb.value) {
        return null
    }
    if (
        siteWeb.value.startsWith('http://') ||
        siteWeb.value.startsWith('https://')
    ) {
        return siteWeb.value
    }

    return `https://${siteWeb.value}`
})
</script>

<template>
    <section
        class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-7"
    >
        <!-- HEADER -->
        <div class="flex items-center gap-3">
            <div
                class="flex h-9 w-9 shrink-0 items-center justify-center
                       text-[#2F6690]"
            >
                <svg
                    class="h-5 w-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.8"
                        d="M3 21h18M5 21V5a2 2 0 012-2h10a2 2 0 012 2v16M9 7h2M13 7h2M9 11h2M13 11h2M9 15h2M13 15h2"
                    />
                </svg>
            </div>

            <div>
                <h2 class="text-lg font-bold text-[#16425B]">
                    About the Company
                </h2>

                <p class="mt-0.5 text-xs text-slate-400">
                    Information about the company offering this internship
                </p>
            </div>
        </div>

        <!-- DIVIDER -->
        <div class="my-5 border-t border-slate-100"></div>

        <!-- COMPANY IDENTITY -->
        <div class="flex items-start gap-4">
            <div
                class="flex h-14 w-14 shrink-0 items-center justify-center
                       rounded-xl bg-[#E8F1F5]
                       text-xl font-bold text-[#2F6690]"
            >
                {{ companyName.charAt(0).toUpperCase() }}
            </div>

            <div class="min-w-0">
                <h3 class="text-base font-bold text-[#16425B]">
                    {{ companyName }}
                </h3>

                <p
                    v-if="secteur"
                    class="mt-1 text-sm text-slate-500"
                >
                    {{ secteur }}
                </p>
            </div>
        </div>

        <!-- COMPANY INFORMATION -->
        <div
            class="mt-6 grid grid-cols-1 gap-4
                   sm:grid-cols-2"
        >
            <!-- LOCATION -->
            <div
                v-if="ville"
                class="flex items-start gap-3 rounded-xl
                       border border-slate-100 bg-slate-50 p-4"
            >
                <svg
                    class="mt-0.5 h-5 w-5 shrink-0 text-[#3A7CA5]"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.8"
                        d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.8"
                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                    />
                </svg>

                <div class="min-w-0">
                    <p class="text-xs text-slate-400">
                        City
                    </p>

                    <p class="mt-0.5 text-sm font-semibold text-slate-700">
                        {{ ville }}
                    </p>
                </div>
            </div>

            <!-- ADDRESS -->
            <div
                v-if="adresse"
                class="flex items-start gap-3 rounded-xl
                       border border-slate-100 bg-slate-50 p-4"
            >
                <svg
                    class="mt-0.5 h-5 w-5 shrink-0 text-[#3A7CA5]"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.8"
                        d="M4 6.5A2.5 2.5 0 016.5 4h11A2.5 2.5 0 0120 6.5v11a2.5 2.5 0 01-2.5 2.5h-11A2.5 2.5 0 014 17.5v-11Z"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.8"
                        d="M8 9h8M8 13h5"
                    />
                </svg>

                <div class="min-w-0">
                    <p class="text-xs text-slate-400">
                        Address
                    </p>

                    <p class="mt-0.5 text-sm font-semibold text-slate-700">
                        {{ adresse }}
                    </p>
                </div>
            </div>

            <!-- EMAIL -->
            <div
                v-if="email"
                class="flex items-start gap-3 rounded-xl
                       border border-slate-100 bg-slate-50 p-4"
            >
                <svg
                    class="mt-0.5 h-5 w-5 shrink-0 text-[#3A7CA5]"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.8"
                        d="M4 6h16v12H4z"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.8"
                        d="m4 7 8 6 8-6"
                    />
                </svg>

                <div class="min-w-0">
                    <p class="text-xs text-slate-400">
                        Email
                    </p>

                    <a
                        :href="`mailto:${email}`"
                        class="mt-0.5 block truncate text-sm font-semibold
                               text-[#2F6690] hover:underline"
                    >
                        {{ email }}
                    </a>
                </div>
            </div>

            <!-- PHONE -->
            <div
                v-if="telephone"
                class="flex items-start gap-3 rounded-xl
                       border border-slate-100 bg-slate-50 p-4"
            >
                <svg
                    class="mt-0.5 h-5 w-5 shrink-0 text-[#3A7CA5]"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.8"
                        d="M6.5 3.5h3l1.5 4-2 1.5a15 15 0 006 6l1.5-2 4 1.5v3a2 2 0 01-2 2C10.5 19.5 4.5 13.5 4.5 6.5a2 2 0 012-3Z"
                    />
                </svg>

                <div class="min-w-0">
                    <p class="text-xs text-slate-400">
                        Phone
                    </p>

                    <a
                        :href="`tel:${telephone}`"
                        class="mt-0.5 block text-sm font-semibold
                               text-[#2F6690] hover:underline"
                    >
                        {{ telephone }}
                    </a>
                </div>
            </div>

            <!-- WEBSITE -->
            <div
                v-if="websiteUrl"
                class="flex items-start gap-3 rounded-xl
                       border border-slate-100 bg-slate-50 p-4
                       sm:col-span-2"
            >
                <svg
                    class="mt-0.5 h-5 w-5 shrink-0 text-[#3A7CA5]"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <circle
                        cx="12"
                        cy="12"
                        r="9"
                        stroke-width="1.8"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.8"
                        d="M3 12h18M12 3c2.5 2.5 3.5 5.5 3.5 9S14.5 18.5 12 21c-2.5-2.5-3.5-5.5-3.5-9S9.5 5.5 12 3Z"
                    />
                </svg>

                <div class="min-w-0">
                    <p class="text-xs text-slate-400">
                        Website
                    </p>

                    <a
                        :href="websiteUrl"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="mt-0.5 block truncate text-sm font-semibold
                               text-[#2F6690] hover:underline"
                    >
                        {{ siteWeb }}
                    </a>
                </div>
            </div>
        </div>

        <!-- DESCRIPTION -->
        <div
            v-if="description"
            class="mt-6 border-t border-slate-100 pt-6"
        >
            <h4 class="text-sm font-bold text-[#16425B]">
                About the Company
            </h4>

            <p
                class="mt-3 whitespace-pre-line text-sm leading-7
                       text-slate-600"
            >
                {{ description }}
            </p>
        </div>

        <!-- EMPTY STATE -->
        <div
            v-if="
                !secteur &&
                !ville &&
                !adresse &&
                !email &&
                !telephone &&
                !siteWeb &&
                !description
            "
            class="mt-5 rounded-xl border border-dashed
                   border-slate-200 bg-slate-50
                   px-5 py-6 text-center"
        >
            <p class="text-sm text-slate-400">
                No additional company information is available.
            </p>
        </div>
    </section>
</template>
