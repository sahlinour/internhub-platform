<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'

import AdminLayout from '@/Components/Admin/AdminLayout.vue'
import DashboardCard from '@/Components/Admin/DashboardCard.vue'

const props = defineProps({
    stagiaire: {
        type: Object,
        required: true,
    },

    villes: {
        type: Array,
        default: () => [],
    },
})

const form = useForm({
    nom_complet: props.stagiaire.nom_complet ?? '',
    email: props.stagiaire.email ?? '',
    telephone: props.stagiaire.telephone ?? '',
    ville_id: props.stagiaire.ville_id ?? '',
    etat: props.stagiaire.etat ?? 'active',

    universite:
        props.stagiaire.stagiaire?.universite ?? '',

    filiere:
        props.stagiaire.stagiaire?.filiere ?? '',

    niveau:
        props.stagiaire.stagiaire?.niveau ?? '',

    date_naissance:
        props.stagiaire.stagiaire?.date_naissance ?? '',

    statut_stage:
        props.stagiaire.stagiaire?.statut_stage ?? '',

    linkedin_url:
        props.stagiaire.stagiaire?.linkedin_url ?? '',

    portfolio_url:
        props.stagiaire.stagiaire?.portfolio_url ?? '',
})

const submit = () => {
    form.put(
        route(
            'admin.stagiaires.update',
            props.stagiaire.id
        ),
        {
            preserveScroll: true,
        }
    )
}
</script>

<template>
    <Head title="Edit Intern" />

    <AdminLayout>
        <div class="w-full max-w-[1050px]">

            <!-- HEADER -->
            <header class="mb-5">
                <div
                    class="mb-2 flex items-center gap-[7px]
                           text-[9px] text-[#96a5af]"
                >
                    <Link
                        :href="route('admin.stagiaires.index')"
                        class="text-[#367594] no-underline hover:underline"
                    >
                        Interns
                    </Link>

                    <span>/</span>
                    <span>Edit</span>
                </div>

                <h1
                    class="mb-[5px] text-[22px]
                           font-bold text-[#20394b]"
                >
                    Edit Intern
                </h1>

                <p class="m-0 text-[10px] text-[#8798a6]">
                    Update the intern's account and academic information.
                </p>
            </header>

            <form
                class="space-y-[18px]"
                @submit.prevent="submit"
            >

                <!-- ACCOUNT INFO -->
                <DashboardCard
                    title="Account Information"
                    subtitle="Update the intern's personal account details."
                >
                    <div
                        class="grid grid-cols-2 gap-[18px]
                               max-[700px]:grid-cols-1"
                    >
                        <!-- NAME -->
                        <div class="flex flex-col gap-[7px]">
                            <label
                                class="text-[10px] font-bold text-[#4c6474]"
                            >
                                Full Name *
                            </label>

                            <input
                                v-model="form.nom_complet"
                                type="text"
                                class="h-[41px] w-full rounded-lg
                                       border border-[#dce5ea]
                                       bg-white px-3
                                       text-[10px] text-[#40596a]
                                       outline-none
                                       focus:border-[#6694ad]
                                       focus:ring-[3px]
                                       focus:ring-[#326d8b]/10"
                            />

                            <span
                                v-if="form.errors.nom_complet"
                                class="text-[9px] text-[#c95858]"
                            >
                                {{ form.errors.nom_complet }}
                            </span>
                        </div>

                        <!-- EMAIL -->
                        <div class="flex flex-col gap-[7px]">
                            <label
                                class="text-[10px] font-bold text-[#4c6474]"
                            >
                                Email *
                            </label>

                            <input
                                v-model="form.email"
                                type="email"
                                class="h-[41px] w-full rounded-lg
                                       border border-[#dce5ea]
                                       bg-white px-3
                                       text-[10px] text-[#40596a]
                                       outline-none
                                       focus:border-[#6694ad]
                                       focus:ring-[3px]
                                       focus:ring-[#326d8b]/10"
                            />

                            <span
                                v-if="form.errors.email"
                                class="text-[9px] text-[#c95858]"
                            >
                                {{ form.errors.email }}
                            </span>
                        </div>

                        <!-- PHONE -->
                        <div class="flex flex-col gap-[7px]">
                            <label
                                class="text-[10px] font-bold text-[#4c6474]"
                            >
                                Phone
                            </label>

                            <input
                                v-model="form.telephone"
                                type="text"
                                class="h-[41px] w-full rounded-lg
                                       border border-[#dce5ea]
                                       bg-white px-3
                                       text-[10px] text-[#40596a]
                                       outline-none
                                       focus:border-[#6694ad]
                                       focus:ring-[3px]
                                       focus:ring-[#326d8b]/10"
                            />

                            <span
                                v-if="form.errors.telephone"
                                class="text-[9px] text-[#c95858]"
                            >
                                {{ form.errors.telephone }}
                            </span>
                        </div>

                        <!-- CITY -->
                        <div class="flex flex-col gap-[7px]">
                            <label
                                class="text-[10px] font-bold text-[#4c6474]"
                            >
                                City
                            </label>

                            <select
                                v-model="form.ville_id"
                                class="h-[41px] w-full rounded-lg
                                       border border-[#dce5ea]
                                       bg-white px-3
                                       text-[10px] text-[#40596a]
                                       outline-none
                                       focus:border-[#6694ad]
                                       focus:ring-[3px]
                                       focus:ring-[#326d8b]/10"
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

                            <span
                                v-if="form.errors.ville_id"
                                class="text-[9px] text-[#c95858]"
                            >
                                {{ form.errors.ville_id }}
                            </span>
                        </div>

                        <!-- ACCOUNT STATUS -->
                        <div class="flex flex-col gap-[7px]">
                            <label
                                class="text-[10px] font-bold text-[#4c6474]"
                            >
                                Account Status *
                            </label>

                            <select
                                v-model="form.etat"
                                class="h-[41px] w-full rounded-lg
                                       border border-[#dce5ea]
                                       bg-white px-3
                                       text-[10px] text-[#40596a]
                                       outline-none
                                       focus:border-[#6694ad]
                                       focus:ring-[3px]
                                       focus:ring-[#326d8b]/10"
                            >
                                <option value="active">
                                    Active
                                </option>

                                <option value="pending">
                                    Pending
                                </option>

                                <option value="block">
                                    Suspended
                                </option>
                            </select>

                            <span
                                v-if="form.errors.etat"
                                class="text-[9px] text-[#c95858]"
                            >
                                {{ form.errors.etat }}
                            </span>
                        </div>

                        <!-- DATE OF BIRTH -->
                        <div class="flex flex-col gap-[7px]">
                            <label
                                class="text-[10px] font-bold text-[#4c6474]"
                            >
                                Date of Birth
                            </label>

                            <input
                                v-model="form.date_naissance"
                                type="date"
                                class="h-[41px] w-full rounded-lg
                                       border border-[#dce5ea]
                                       bg-white px-3
                                       text-[10px] text-[#40596a]
                                       outline-none
                                       focus:border-[#6694ad]
                                       focus:ring-[3px]
                                       focus:ring-[#326d8b]/10"
                            />

                            <span
                                v-if="form.errors.date_naissance"
                                class="text-[9px] text-[#c95858]"
                            >
                                {{ form.errors.date_naissance }}
                            </span>
                        </div>
                    </div>
                </DashboardCard>

                <!-- ACADEMIC INFO -->
                <DashboardCard
                    title="Academic Information"
                    subtitle="Update university and internship information."
                >
                    <div
                        class="grid grid-cols-2 gap-[18px]
                               max-[700px]:grid-cols-1"
                    >
                        <!-- UNIVERSITY -->
                        <div class="flex flex-col gap-[7px]">
                            <label
                                class="text-[10px] font-bold text-[#4c6474]"
                            >
                                University / School
                            </label>

                            <input
                                v-model="form.universite"
                                type="text"
                                class="h-[41px] w-full rounded-lg
                                       border border-[#dce5ea]
                                       bg-white px-3
                                       text-[10px] text-[#40596a]
                                       outline-none
                                       focus:border-[#6694ad]
                                       focus:ring-[3px]
                                       focus:ring-[#326d8b]/10"
                            />

                            <span
                                v-if="form.errors.universite"
                                class="text-[9px] text-[#c95858]"
                            >
                                {{ form.errors.universite }}
                            </span>
                        </div>

                        <!-- FIELD -->
                        <div class="flex flex-col gap-[7px]">
                            <label
                                class="text-[10px] font-bold text-[#4c6474]"
                            >
                                Field
                            </label>

                            <input
                                v-model="form.filiere"
                                type="text"
                                class="h-[41px] w-full rounded-lg
                                       border border-[#dce5ea]
                                       bg-white px-3
                                       text-[10px] text-[#40596a]
                                       outline-none
                                       focus:border-[#6694ad]
                                       focus:ring-[3px]
                                       focus:ring-[#326d8b]/10"
                            />

                            <span
                                v-if="form.errors.filiere"
                                class="text-[9px] text-[#c95858]"
                            >
                                {{ form.errors.filiere }}
                            </span>
                        </div>

                        <!-- LEVEL -->
                        <div class="flex flex-col gap-[7px]">
                            <label
                                class="text-[10px] font-bold text-[#4c6474]"
                            >
                                Level
                            </label>

                            <input
                                v-model="form.niveau"
                                type="text"
                                class="h-[41px] w-full rounded-lg
                                       border border-[#dce5ea]
                                       bg-white px-3
                                       text-[10px] text-[#40596a]
                                       outline-none
                                       focus:border-[#6694ad]
                                       focus:ring-[3px]
                                       focus:ring-[#326d8b]/10"
                            />

                            <span
                                v-if="form.errors.niveau"
                                class="text-[9px] text-[#c95858]"
                            >
                                {{ form.errors.niveau }}
                            </span>
                        </div>

                        <!-- INTERNSHIP STATUS -->
                        <div class="flex flex-col gap-[7px]">
                            <label
                                class="text-[10px] font-bold text-[#4c6474]"
                            >
                                Internship Status
                            </label>

                            <select
                                v-model="form.statut_stage"
                                class="h-[41px] w-full rounded-lg
                                       border border-[#dce5ea]
                                       bg-white px-3
                                       text-[10px] text-[#40596a]
                                       outline-none
                                       focus:border-[#6694ad]
                                       focus:ring-[3px]
                                       focus:ring-[#326d8b]/10"
                            >
                                <option value="">
                                    Select a status
                                </option>

                                <option value="En recherche">
                                    Looking for internship
                                </option>

                                <option value="En cours">
                                    Internship in progress
                                </option>

                                <option value="Terminée">
                                    Internship completed
                                </option>
                            </select>

                            <span
                                v-if="form.errors.statut_stage"
                                class="text-[9px] text-[#c95858]"
                            >
                                {{ form.errors.statut_stage }}
                            </span>
                        </div>
                    </div>
                </DashboardCard>

                <!-- PROFESSIONAL LINKS -->
                <DashboardCard
                    title="Professional Links"
                    subtitle="Update optional professional profiles."
                >
                    <div
                        class="grid grid-cols-2 gap-[18px]
                               max-[700px]:grid-cols-1"
                    >
                        <!-- LINKEDIN -->
                        <div class="flex flex-col gap-[7px]">
                            <label
                                class="text-[10px] font-bold text-[#4c6474]"
                            >
                                LinkedIn
                            </label>

                            <input
                                v-model="form.linkedin_url"
                                type="url"
                                placeholder="https://linkedin.com/in/..."
                                class="h-[41px] w-full rounded-lg
                                       border border-[#dce5ea]
                                       bg-white px-3
                                       text-[10px] text-[#40596a]
                                       outline-none
                                       focus:border-[#6694ad]
                                       focus:ring-[3px]
                                       focus:ring-[#326d8b]/10"
                            />

                            <span
                                v-if="form.errors.linkedin_url"
                                class="text-[9px] text-[#c95858]"
                            >
                                {{ form.errors.linkedin_url }}
                            </span>
                        </div>

                        <!-- PORTFOLIO -->
                        <div class="flex flex-col gap-[7px]">
                            <label
                                class="text-[10px] font-bold text-[#4c6474]"
                            >
                                Portfolio
                            </label>

                            <input
                                v-model="form.portfolio_url"
                                type="url"
                                placeholder="https://..."
                                class="h-[41px] w-full rounded-lg
                                       border border-[#dce5ea]
                                       bg-white px-3
                                       text-[10px] text-[#40596a]
                                       outline-none
                                       focus:border-[#6694ad]
                                       focus:ring-[3px]
                                       focus:ring-[#326d8b]/10"
                            />

                            <span
                                v-if="form.errors.portfolio_url"
                                class="text-[9px] text-[#c95858]"
                            >
                                {{ form.errors.portfolio_url }}
                            </span>
                        </div>
                    </div>
                </DashboardCard>

                <!-- ACTIONS -->
                <div
                    class="flex justify-end gap-[9px]
                           max-[700px]:flex-col-reverse"
                >
                    <Link
                        :href="route('admin.stagiaires.index')"
                        class="inline-flex min-h-[40px]
                               items-center justify-center
                               rounded-lg
                               border border-[#dce5ea]
                               bg-white px-4
                               text-[10px] font-bold
                               text-[#617887]
                               no-underline transition
                               hover:bg-[#f8fafb]"
                    >
                        Cancel
                    </Link>

                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="inline-flex min-h-[40px]
                               items-center justify-center
                               rounded-lg
                               bg-[#174966] px-4
                               text-[10px] font-bold
                               text-white transition
                               hover:bg-[#123e57]
                               disabled:cursor-not-allowed
                               disabled:opacity-60"
                    >
                        {{
                            form.processing
                                ? 'Saving...'
                                : 'Save Changes'
                        }}
                    </button>
                </div>

            </form>

        </div>
    </AdminLayout>
</template>
