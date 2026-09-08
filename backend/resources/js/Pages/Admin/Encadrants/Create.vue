<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'

import AdminLayout from '@/Components/Admin/AdminLayout.vue'
import DashboardCard from '@/Components/Admin/DashboardCard.vue'

const props = defineProps({
    entreprises: {
        type: Array,
        default: () => [],
    },
    villes: {
        type: Array,
        default: () => [],
    },
})

const form = useForm({
    nom_complet: '',
    email: '',
    telephone: '',
    ville_id: '',
    password: '',
    password_confirmation: '',

    poste: '',
    specialite: '',
    departement: '',
    entreprise_id: '',
})

const submit = () => {
    form.post(route('admin.encadrants.store'), {
        preserveScroll: true,
    })
}
</script>

<template>
    <Head title="Add Supervisor" />

    <AdminLayout>
        <div class="w-full max-w-[1100px]">

            <!-- HEADER -->
            <header class="mb-5">
                <div>
                    <div class="mb-[10px] flex items-center gap-[7px] text-[10px] text-[#9aa8b2]">
                        <Link
                            :href="route('admin.encadrants.index')"
                            class="text-[#4b819e] no-underline hover:underline"
                        >
                            Company Supervisors
                        </Link>

                        <span>/</span>
                        <span>Add Supervisor</span>
                    </div>

                    <h1 class="mb-[5px] text-[22px] font-bold text-[#20394b]">
                        Add Supervisor
                    </h1>

                    <p class="m-0 text-[11px] text-[#8798a6]">
                        Create a new company supervisor account and assign it
                        to a partner company.
                    </p>
                </div>
            </header>

            <form @submit.prevent="submit">

                <!-- ACCOUNT INFORMATION -->
                <DashboardCard>
                    <div class="mb-[22px] flex items-center gap-3">

                        <div
                            class="flex h-[38px] w-[38px] shrink-0 items-center
                                   justify-center rounded-[9px]
                                   bg-[#edf4f8] text-[#356d8b]"
                        >
                            <svg
                                viewBox="0 0 24 24"
                                width="18"
                                height="18"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <circle cx="12" cy="8" r="4" />
                                <path d="M4 21a8 8 0 0 1 16 0" />
                            </svg>
                        </div>

                        <div>
                            <h2 class="mb-[3px] text-[14px] font-bold text-[#294355]">
                                Account Information
                            </h2>

                            <p class="m-0 text-[10px] text-[#92a1ac]">
                                Basic information used for the supervisor account.
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-[18px] max-[750px]:grid-cols-1">

                        <!-- FULL NAME -->
                        <div class="min-w-0">
                            <label
                                for="nom_complet"
                                class="mb-[7px] block text-[10px] font-bold text-[#455e6e]"
                            >
                                Full Name
                                <span class="text-[#d75c5c]">*</span>
                            </label>

                            <input
                                id="nom_complet"
                                v-model="form.nom_complet"
                                type="text"
                                placeholder="Enter full name"
                                class="h-[42px] w-full rounded-lg border border-[#dce5ea]
                                       bg-white px-3 text-[11px] text-[#344f60]
                                       outline-none transition
                                       placeholder:text-[#a8b4bc]
                                       focus:border-[#5d9cbb]
                                       focus:ring-4 focus:ring-[#5d9cbb]/10"
                            />

                            <p
                                v-if="form.errors.nom_complet"
                                class="mt-[5px] text-[9px] text-[#cf5151]"
                            >
                                {{ form.errors.nom_complet }}
                            </p>
                        </div>

                        <!-- EMAIL -->
                        <div class="min-w-0">
                            <label
                                for="email"
                                class="mb-[7px] block text-[10px] font-bold text-[#455e6e]"
                            >
                                Email Address
                                <span class="text-[#d75c5c]">*</span>
                            </label>

                            <input
                                id="email"
                                v-model="form.email"
                                type="email"
                                placeholder="supervisor@company.com"
                                class="h-[42px] w-full rounded-lg border border-[#dce5ea]
                                       bg-white px-3 text-[11px] text-[#344f60]
                                       outline-none transition
                                       placeholder:text-[#a8b4bc]
                                       focus:border-[#5d9cbb]
                                       focus:ring-4 focus:ring-[#5d9cbb]/10"
                            />

                            <p
                                v-if="form.errors.email"
                                class="mt-[5px] text-[9px] text-[#cf5151]"
                            >
                                {{ form.errors.email }}
                            </p>
                        </div>

                        <!-- PHONE -->
                        <div class="min-w-0">
                            <label
                                for="telephone"
                                class="mb-[7px] block text-[10px] font-bold text-[#455e6e]"
                            >
                                Phone Number
                            </label>

                            <input
                                id="telephone"
                                v-model="form.telephone"
                                type="text"
                                placeholder="+212 6..."
                                class="h-[42px] w-full rounded-lg border border-[#dce5ea]
                                       bg-white px-3 text-[11px] text-[#344f60]
                                       outline-none transition
                                       placeholder:text-[#a8b4bc]
                                       focus:border-[#5d9cbb]
                                       focus:ring-4 focus:ring-[#5d9cbb]/10"
                            />

                            <p
                                v-if="form.errors.telephone"
                                class="mt-[5px] text-[9px] text-[#cf5151]"
                            >
                                {{ form.errors.telephone }}
                            </p>
                        </div>

                        <!-- CITY -->
                        <div class="min-w-0">
                            <label
                                for="ville_id"
                                class="mb-[7px] block text-[10px] font-bold text-[#455e6e]"
                            >
                                City
                            </label>

                            <select
                                id="ville_id"
                                v-model="form.ville_id"
                                class="h-[42px] w-full rounded-lg border border-[#dce5ea]
                                       bg-white px-3 text-[11px] text-[#344f60]
                                       outline-none transition
                                       focus:border-[#5d9cbb]
                                       focus:ring-4 focus:ring-[#5d9cbb]/10"
                            >
                                <option value="">
                                    Select a city
                                </option>

                                <option
                                    v-for="ville in villes"
                                    :key="ville.id"
                                    :value="ville.id"
                                >
                                    {{ ville.nom }}
                                </option>
                            </select>

                            <p
                                v-if="form.errors.ville_id"
                                class="mt-[5px] text-[9px] text-[#cf5151]"
                            >
                                {{ form.errors.ville_id }}
                            </p>
                        </div>

                        <!-- PASSWORD -->
                        <div class="min-w-0">
                            <label
                                for="password"
                                class="mb-[7px] block text-[10px] font-bold text-[#455e6e]"
                            >
                                Password
                                <span class="text-[#d75c5c]">*</span>
                            </label>

                            <input
                                id="password"
                                v-model="form.password"
                                type="password"
                                placeholder="Minimum 8 characters"
                                class="h-[42px] w-full rounded-lg border border-[#dce5ea]
                                       bg-white px-3 text-[11px] text-[#344f60]
                                       outline-none transition
                                       placeholder:text-[#a8b4bc]
                                       focus:border-[#5d9cbb]
                                       focus:ring-4 focus:ring-[#5d9cbb]/10"
                            />

                            <p
                                v-if="form.errors.password"
                                class="mt-[5px] text-[9px] text-[#cf5151]"
                            >
                                {{ form.errors.password }}
                            </p>
                        </div>

                        <!-- CONFIRM PASSWORD -->
                        <div class="min-w-0">
                            <label
                                for="password_confirmation"
                                class="mb-[7px] block text-[10px] font-bold text-[#455e6e]"
                            >
                                Confirm Password
                                <span class="text-[#d75c5c]">*</span>
                            </label>

                            <input
                                id="password_confirmation"
                                v-model="form.password_confirmation"
                                type="password"
                                placeholder="Repeat password"
                                class="h-[42px] w-full rounded-lg border border-[#dce5ea]
                                       bg-white px-3 text-[11px] text-[#344f60]
                                       outline-none transition
                                       placeholder:text-[#a8b4bc]
                                       focus:border-[#5d9cbb]
                                       focus:ring-4 focus:ring-[#5d9cbb]/10"
                            />
                        </div>

                    </div>
                </DashboardCard>

                <!-- PROFESSIONAL INFORMATION -->
                <DashboardCard class="mt-[18px]">
                    <div class="mb-[22px] flex items-center gap-3">

                        <div
                            class="flex h-[38px] w-[38px] shrink-0 items-center
                                   justify-center rounded-[9px]
                                   bg-[#edf4f8] text-[#356d8b]"
                        >
                            <svg
                                viewBox="0 0 24 24"
                                width="18"
                                height="18"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <rect
                                    x="3"
                                    y="7"
                                    width="18"
                                    height="13"
                                    rx="2"
                                />

                                <path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                <path d="M3 12h18" />
                            </svg>
                        </div>

                        <div>
                            <h2 class="mb-[3px] text-[14px] font-bold text-[#294355]">
                                Professional Information
                            </h2>

                            <p class="m-0 text-[10px] text-[#92a1ac]">
                                Supervisor position and company assignment.
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-[18px] max-[750px]:grid-cols-1">

                        <!-- COMPANY -->
                        <div class="min-w-0">
                            <label
                                for="entreprise_id"
                                class="mb-[7px] block text-[10px] font-bold text-[#455e6e]"
                            >
                                Company
                                <span class="text-[#d75c5c]">*</span>
                            </label>

                            <select
                                id="entreprise_id"
                                v-model="form.entreprise_id"
                                class="h-[42px] w-full rounded-lg border border-[#dce5ea]
                                       bg-white px-3 text-[11px] text-[#344f60]
                                       outline-none transition
                                       focus:border-[#5d9cbb]
                                       focus:ring-4 focus:ring-[#5d9cbb]/10"
                            >
                                <option value="">
                                    Select a company
                                </option>

                                <option
                                    v-for="entreprise in entreprises"
                                    :key="entreprise.user_id"
                                    :value="entreprise.user_id"
                                >
                                    {{
                                        entreprise.user?.nom_complet
                                        ?? 'Unnamed company'
                                    }}
                                </option>
                            </select>

                            <p
                                v-if="form.errors.entreprise_id"
                                class="mt-[5px] text-[9px] text-[#cf5151]"
                            >
                                {{ form.errors.entreprise_id }}
                            </p>
                        </div>

                        <!-- POSITION -->
                        <div class="min-w-0">
                            <label
                                for="poste"
                                class="mb-[7px] block text-[10px] font-bold text-[#455e6e]"
                            >
                                Position
                            </label>

                            <input
                                id="poste"
                                v-model="form.poste"
                                type="text"
                                placeholder="e.g. Senior Developer"
                                class="h-[42px] w-full rounded-lg border border-[#dce5ea]
                                       bg-white px-3 text-[11px] text-[#344f60]
                                       outline-none transition
                                       placeholder:text-[#a8b4bc]
                                       focus:border-[#5d9cbb]
                                       focus:ring-4 focus:ring-[#5d9cbb]/10"
                            />

                            <p
                                v-if="form.errors.poste"
                                class="mt-[5px] text-[9px] text-[#cf5151]"
                            >
                                {{ form.errors.poste }}
                            </p>
                        </div>

                        <!-- SPECIALTY -->
                        <div class="min-w-0">
                            <label
                                for="specialite"
                                class="mb-[7px] block text-[10px] font-bold text-[#455e6e]"
                            >
                                Specialty
                            </label>

                            <input
                                id="specialite"
                                v-model="form.specialite"
                                type="text"
                                placeholder="e.g. Web Development"
                                class="h-[42px] w-full rounded-lg border border-[#dce5ea]
                                       bg-white px-3 text-[11px] text-[#344f60]
                                       outline-none transition
                                       placeholder:text-[#a8b4bc]
                                       focus:border-[#5d9cbb]
                                       focus:ring-4 focus:ring-[#5d9cbb]/10"
                            />

                            <p
                                v-if="form.errors.specialite"
                                class="mt-[5px] text-[9px] text-[#cf5151]"
                            >
                                {{ form.errors.specialite }}
                            </p>
                        </div>

                        <!-- DEPARTMENT -->
                        <div class="min-w-0">
                            <label
                                for="departement"
                                class="mb-[7px] block text-[10px] font-bold text-[#455e6e]"
                            >
                                Department
                            </label>

                            <input
                                id="departement"
                                v-model="form.departement"
                                type="text"
                                placeholder="e.g. IT Department"
                                class="h-[42px] w-full rounded-lg border border-[#dce5ea]
                                       bg-white px-3 text-[11px] text-[#344f60]
                                       outline-none transition
                                       placeholder:text-[#a8b4bc]
                                       focus:border-[#5d9cbb]
                                       focus:ring-4 focus:ring-[#5d9cbb]/10"
                            />

                            <p
                                v-if="form.errors.departement"
                                class="mt-[5px] text-[9px] text-[#cf5151]"
                            >
                                {{ form.errors.departement }}
                            </p>
                        </div>

                    </div>
                </DashboardCard>

                <!-- ACTIONS -->
                <div
                    class="mt-5 flex items-center justify-end gap-[10px]
                           max-[750px]:flex-col-reverse
                           max-[750px]:items-stretch"
                >
                    <Link
                        :href="route('admin.encadrants.index')"
                        class="inline-flex min-h-[42px] items-center justify-center
                               gap-[7px] rounded-lg border border-[#dce5ea]
                               bg-white px-[17px] text-[10px] font-bold
                               text-[#647987] no-underline transition
                               hover:bg-[#f8fafb]
                               max-[750px]:w-full"
                    >
                        Cancel
                    </Link>

                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="inline-flex min-h-[42px] items-center justify-center
                               gap-[7px] rounded-lg border-0
                               bg-[#174966] px-[17px]
                               text-[10px] font-bold text-white
                               shadow-[0_4px_12px_rgba(23,73,102,0.14)]
                               transition hover:bg-[#123e57]
                               disabled:cursor-not-allowed
                               disabled:opacity-60
                               max-[750px]:w-full"
                    >
                        <svg
                            v-if="!form.processing"
                            viewBox="0 0 24 24"
                            width="16"
                            height="16"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path d="M12 5v14" />
                            <path d="M5 12h14" />
                        </svg>

                        {{
                            form.processing
                                ? 'Creating...'
                                : 'Create Supervisor'
                        }}
                    </button>
                </div>

            </form>
        </div>
    </AdminLayout>
</template>
