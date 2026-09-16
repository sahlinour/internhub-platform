<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import EntrepriseLayout from '@/Layouts/EntrepriseLayout.vue'

const appRoute = (name, params = undefined) => {
    return route(name, params, false)
}

const props = defineProps({
    villes: {
        type: Array,
        default: () => [],
    },
})

const form = useForm({
    nom_complet: '',
    email: '',
    password: '',
    telephone: '',
    poste: '',
    specialite: '',
    departement: '',
    ville_id: '',
})

const submit = () => {
    form.post(
        appRoute('entreprise.encadrants.store'),
        {
            preserveScroll: true,
        }
    )
}
</script>

<template>
    <EntrepriseLayout>
        <Head title="Add Company Supervisor" />

        <div class="mx-auto max-w-5xl">

            <!-- HEADER -->
            <div
                class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
            >
                <div>
                    <h1
                        class="text-2xl font-bold tracking-tight text-slate-900"
                    >
                        Add Company Supervisor
                    </h1>

                    <p class="mt-1 text-sm text-slate-500">
                        Create a supervisor account and login credentials
                    </p>
                </div>

                <Link
                    :href="appRoute('entreprise.encadrants.index')"
                    class="inline-flex items-center justify-center rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50"
                >
                    Back to Supervisors
                </Link>
            </div>

            <!-- FORM CARD -->
            <div
                class="rounded-2xl border border-slate-200 bg-white shadow-sm"
            >

                <!-- ACCOUNT INFO -->
                <div class="border-b border-slate-100 px-6 py-5">
                    <h2 class="text-base font-semibold text-slate-900">
                        Account Information
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        These credentials will be used by the supervisor
                        to log in.
                    </p>
                </div>

                <form
                    @submit.prevent="submit"
                    class="p-6"
                >

                    <div
                        class="grid grid-cols-1 gap-5 md:grid-cols-2"
                    >

                        <!-- FULL NAME -->
                        <div>
                            <label
                                class="mb-2 block text-sm font-medium text-slate-700"
                            >
                                Full Name
                                <span class="text-red-500">*</span>
                            </label>

                            <input
                                v-model="form.nom_complet"
                                type="text"
                                placeholder="Supervisor full name"
                                class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-[#3d8fb5] focus:ring-2 focus:ring-[#3d8fb5]/10"
                            />

                            <p
                                v-if="form.errors.nom_complet"
                                class="mt-1.5 text-xs text-red-500"
                            >
                                {{ form.errors.nom_complet }}
                            </p>
                        </div>

                        <!-- PHONE -->
                        <div>
                            <label
                                class="mb-2 block text-sm font-medium text-slate-700"
                            >
                                Phone
                            </label>

                            <input
                                v-model="form.telephone"
                                type="text"
                                placeholder="Phone number"
                                class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-[#3d8fb5] focus:ring-2 focus:ring-[#3d8fb5]/10"
                            />

                            <p
                                v-if="form.errors.telephone"
                                class="mt-1.5 text-xs text-red-500"
                            >
                                {{ form.errors.telephone }}
                            </p>
                        </div>

                        <!-- LOGIN EMAIL -->
                        <div>
                            <label
                                class="mb-2 block text-sm font-medium text-slate-700"
                            >
                                Login Email
                                <span class="text-red-500">*</span>
                            </label>

                            <input
                                v-model="form.email"
                                type="email"
                                autocomplete="off"
                                placeholder="supervisor@company.com"
                                class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-[#3d8fb5] focus:ring-2 focus:ring-[#3d8fb5]/10"
                            />

                            <p
                                v-if="form.errors.email"
                                class="mt-1.5 text-xs text-red-500"
                            >
                                {{ form.errors.email }}
                            </p>
                        </div>

                        <!-- PASSWORD -->
                        <div>
                            <label
                                class="mb-2 block text-sm font-medium text-slate-700"
                            >
                                Temporary Password
                                <span class="text-red-500">*</span>
                            </label>

                            <input
                                v-model="form.password"
                                type="password"
                                autocomplete="new-password"
                                placeholder="Create a password"
                                class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-[#3d8fb5] focus:ring-2 focus:ring-[#3d8fb5]/10"
                            />

                            <p
                                v-if="form.errors.password"
                                class="mt-1.5 text-xs text-red-500"
                            >
                                {{ form.errors.password }}
                            </p>
                        </div>

                    </div>

                    <!-- PROFESSIONAL INFO -->
                    <div
                        class="mt-8 border-t border-slate-100 pt-6"
                    >
                        <h2
                            class="text-base font-semibold text-slate-900"
                        >
                            Professional Information
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            Supervisor role and company information
                        </p>
                    </div>

                    <div
                        class="mt-5 grid grid-cols-1 gap-5 md:grid-cols-2"
                    >

                        <!-- POSITION -->
                        <div>
                            <label
                                class="mb-2 block text-sm font-medium text-slate-700"
                            >
                                Position
                                <span class="text-red-500">*</span>
                            </label>

                            <input
                                v-model="form.poste"
                                type="text"
                                placeholder="e.g. Engineering Manager"
                                class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-[#3d8fb5] focus:ring-2 focus:ring-[#3d8fb5]/10"
                            />

                            <p
                                v-if="form.errors.poste"
                                class="mt-1.5 text-xs text-red-500"
                            >
                                {{ form.errors.poste }}
                            </p>
                        </div>

                        <!-- SPECIALITY -->
                        <div>
                            <label
                                class="mb-2 block text-sm font-medium text-slate-700"
                            >
                                Speciality
                            </label>

                            <input
                                v-model="form.specialite"
                                type="text"
                                placeholder="e.g. Web Development"
                                class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-[#3d8fb5] focus:ring-2 focus:ring-[#3d8fb5]/10"
                            />

                            <p
                                v-if="form.errors.specialite"
                                class="mt-1.5 text-xs text-red-500"
                            >
                                {{ form.errors.specialite }}
                            </p>
                        </div>

                        <!-- DEPARTMENT -->
                        <div>
                            <label
                                class="mb-2 block text-sm font-medium text-slate-700"
                            >
                                Department
                            </label>

                            <input
                                v-model="form.departement"
                                type="text"
                                placeholder="e.g. Engineering"
                                class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-[#3d8fb5] focus:ring-2 focus:ring-[#3d8fb5]/10"
                            />

                            <p
                                v-if="form.errors.departement"
                                class="mt-1.5 text-xs text-red-500"
                            >
                                {{ form.errors.departement }}
                            </p>
                        </div>

                       <div>
                        <label
                            for="ville_id"
                            class="mb-2 block text-sm font-medium text-slate-700"
                        >
                            City
                            <span class="text-red-500">*</span>
                        </label>

                        <select
                            id="ville_id"
                            v-model="form.ville_id"
                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 outline-none transition focus:border-[#3d8fb5] focus:ring-2 focus:ring-[#3d8fb5]/10"
                        >
                            <option value="" disabled>
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
                            class="mt-1.5 text-xs text-red-500"
                        >
                            {{ form.errors.ville_id }}
                        </p>
                    </div>
                    </div>

                    <!-- ACTIONS -->
                    <div
                        class="mt-8 flex flex-col-reverse gap-3 border-t border-slate-100 pt-6 sm:flex-row sm:justify-end"
                    >

                        <Link
                            :href="appRoute('entreprise.encadrants.index')"
                            class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50"
                        >
                            Cancel
                        </Link>

                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#17253f] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#213451] disabled:cursor-not-allowed disabled:opacity-50"
                        >
                            <svg
                                v-if="!form.processing"
                                class="h-4 w-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 5v14M5 12h14"
                                />
                            </svg>

                            {{
                                form.processing
                                    ? 'Creating...'
                                    : 'Create Company Supervisor'
                            }}
                        </button>

                    </div>

                </form>
            </div>

        </div>
    </EntrepriseLayout>
</template>
