<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'

import AdminLayout from '@/Components/Admin/AdminLayout.vue'
import DashboardCard from '@/Components/Admin/DashboardCard.vue'

const props = defineProps({
    encadrant: {
        type: Object,
        required: true,
    },

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
    _method: 'PUT',

    nom_complet: props.encadrant.nom_complet ?? '',
    email: props.encadrant.email ?? '',
    telephone: props.encadrant.telephone ?? '',
    ville_id: props.encadrant.ville_id ?? '',
    etat: props.encadrant.etat ?? 'active',

    poste: props.encadrant.encadrant?.poste ?? '',
    specialite: props.encadrant.encadrant?.specialite ?? '',
    departement: props.encadrant.encadrant?.departement ?? '',
    entreprise_id: props.encadrant.encadrant?.entreprise_id ?? '',
})

const submit = () => {
    form.post(
        route('admin.encadrants.update', props.encadrant.id),
        {
            preserveScroll: true,
        }
    )
}
</script>

<template>
    <Head title="Edit Supervisor" />

    <AdminLayout>
        <div class="w-full max-w-[1050px]">

            <!-- HEADER -->
            <header class="mb-5">
                <div>
                    <div
                        class="mb-2 flex items-center gap-[7px]
                               text-[9px] text-[#96a5af]"
                    >
                        <Link
                            :href="route('admin.encadrants.index')"
                            class="text-[#367594] no-underline hover:underline"
                        >
                            Supervisors
                        </Link>

                        <span>/</span>
                        <span>Edit</span>
                    </div>

                    <h1 class="mb-[5px] text-[22px] font-bold text-[#20394b]">
                        Edit Supervisor
                    </h1>

                    <p class="m-0 text-[10px] text-[#8798a6]">
                        Update supervisor account and company information.
                    </p>
                </div>
            </header>

            <form @submit.prevent="submit">
                <DashboardCard>

                    <!-- ACCOUNT INFO -->
                    <div class="mb-5">
                        <h2 class="mb-1 text-[14px] font-bold text-[#294355]">
                            Account Information
                        </h2>

                        <p class="m-0 text-[10px] text-[#8798a6]">
                            Update personal and account details.
                        </p>
                    </div>

                    <div
                        class="grid grid-cols-2 gap-[18px]
                               max-[700px]:grid-cols-1"
                    >

                        <!-- FULL NAME -->
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
                                       outline-none transition
                                       focus:border-[#6694ad]
                                       focus:ring-4
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
                                       outline-none transition
                                       focus:border-[#6694ad]
                                       focus:ring-4
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
                                       outline-none transition
                                       focus:border-[#6694ad]
                                       focus:ring-4
                                       focus:ring-[#326d8b]/10"
                            />
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
                                       outline-none transition
                                       focus:border-[#6694ad]
                                       focus:ring-4
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
                        </div>

                        <!-- STATUS -->
                        <div class="flex flex-col gap-[7px]">
                            <label
                                class="text-[10px] font-bold text-[#4c6474]"
                            >
                                Status *
                            </label>

                            <select
                                v-model="form.etat"
                                class="h-[41px] w-full rounded-lg
                                       border border-[#dce5ea]
                                       bg-white px-3
                                       text-[10px] text-[#40596a]
                                       outline-none transition
                                       focus:border-[#6694ad]
                                       focus:ring-4
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
                        </div>
                    </div>

                    <!-- DIVIDER -->
                    <div class="my-[25px] border-t border-[#edf1f4]"></div>

                    <!-- SUPERVISOR INFO -->
                    <div class="mb-5">
                        <h2 class="mb-1 text-[14px] font-bold text-[#294355]">
                            Supervisor Information
                        </h2>

                        <p class="m-0 text-[10px] text-[#8798a6]">
                            Update professional and company assignment details.
                        </p>
                    </div>

                    <div
                        class="grid grid-cols-2 gap-[18px]
                               max-[700px]:grid-cols-1"
                    >

                        <!-- COMPANY -->
                        <div class="flex flex-col gap-[7px]">
                            <label
                                class="text-[10px] font-bold text-[#4c6474]"
                            >
                                Company
                            </label>

                            <select
                                v-model="form.entreprise_id"
                                class="h-[41px] w-full rounded-lg
                                       border border-[#dce5ea]
                                       bg-white px-3
                                       text-[10px] text-[#40596a]
                                       outline-none transition
                                       focus:border-[#6694ad]
                                       focus:ring-4
                                       focus:ring-[#326d8b]/10"
                            >
                                <option value="">
                                    No company assigned
                                </option>

                                <option
                                    v-for="company in entreprises"
                                    :key="company.user_id"
                                    :value="company.user_id"
                                >
                                    {{
                                        company.user?.nom_complet
                                        ?? 'Unnamed company'
                                    }}
                                </option>
                            </select>

                            <span
                                v-if="form.errors.entreprise_id"
                                class="text-[9px] text-[#c95858]"
                            >
                                {{ form.errors.entreprise_id }}
                            </span>
                        </div>

                        <!-- POSITION -->
                        <div class="flex flex-col gap-[7px]">
                            <label
                                class="text-[10px] font-bold text-[#4c6474]"
                            >
                                Position
                            </label>

                            <input
                                v-model="form.poste"
                                type="text"
                                class="h-[41px] w-full rounded-lg
                                       border border-[#dce5ea]
                                       bg-white px-3
                                       text-[10px] text-[#40596a]
                                       outline-none transition
                                       focus:border-[#6694ad]
                                       focus:ring-4
                                       focus:ring-[#326d8b]/10"
                            />
                        </div>

                        <!-- SPECIALTY -->
                        <div class="flex flex-col gap-[7px]">
                            <label
                                class="text-[10px] font-bold text-[#4c6474]"
                            >
                                Specialty
                            </label>

                            <input
                                v-model="form.specialite"
                                type="text"
                                class="h-[41px] w-full rounded-lg
                                       border border-[#dce5ea]
                                       bg-white px-3
                                       text-[10px] text-[#40596a]
                                       outline-none transition
                                       focus:border-[#6694ad]
                                       focus:ring-4
                                       focus:ring-[#326d8b]/10"
                            />
                        </div>

                        <!-- DEPARTMENT -->
                        <div class="flex flex-col gap-[7px]">
                            <label
                                class="text-[10px] font-bold text-[#4c6474]"
                            >
                                Department
                            </label>

                            <input
                                v-model="form.departement"
                                type="text"
                                class="h-[41px] w-full rounded-lg
                                       border border-[#dce5ea]
                                       bg-white px-3
                                       text-[10px] text-[#40596a]
                                       outline-none transition
                                       focus:border-[#6694ad]
                                       focus:ring-4
                                       focus:ring-[#326d8b]/10"
                            />
                        </div>

                    </div>

                    <!-- ACTIONS -->
                    <div
                        class="mt-6 flex justify-end gap-[9px]
                               max-[700px]:flex-col-reverse"
                    >
                        <Link
                            :href="route('admin.encadrants.index')"
                            class="inline-flex min-h-[39px] items-center
                                   justify-center rounded-lg
                                   border border-[#dce5ea]
                                   bg-white px-[15px]
                                   text-[10px] font-bold text-[#617887]
                                   no-underline transition
                                   hover:bg-[#f8fafb]"
                        >
                            Cancel
                        </Link>

                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="inline-flex min-h-[39px] items-center
                                   justify-center rounded-lg
                                   border-0 bg-[#174966]
                                   px-[15px]
                                   text-[10px] font-bold text-white
                                   transition hover:bg-[#123e57]
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

                </DashboardCard>
            </form>

        </div>
    </AdminLayout>
</template>
