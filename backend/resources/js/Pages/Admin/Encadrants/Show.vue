<script setup>
import { Head, Link } from '@inertiajs/vue3'

import AdminLayout from '@/Components/Admin/AdminLayout.vue'
import DashboardCard from '@/Components/Admin/DashboardCard.vue'
import UserAvatar from '@/Components/Admin/UserAvatar.vue'
import StatusBadge from '@/Components/Admin/StatusBadge.vue'

defineProps({
    encadrant: {
        type: Object,
        required: true,
    },
})
</script>

<template>
    <Head title="Supervisor Details" />

    <AdminLayout>
        <div class="w-full max-w-5xl">

            <!-- HEADER -->
            <header
                class="mb-5 flex items-start justify-between gap-5 max-md:flex-col"
            >
                <div>
                    <div
                        class="mb-2 flex items-center gap-2 text-[9px] text-slate-400"
                    >
                        <Link
                            :href="route('admin.encadrants.index')"
                            class="text-sky-700 hover:underline"
                        >
                            Supervisors
                        </Link>

                        <span>/</span>
                        <span>Details</span>
                    </div>

                    <h1
                        class="mb-1 text-[22px] font-bold text-slate-800"
                    >
                        Supervisor Details
                    </h1>

                    <p class="text-[10px] text-slate-400">
                        View supervisor account and professional information.
                    </p>
                </div>

                <Link
                    :href="route('admin.encadrants.edit', encadrant.id)"
                    class="inline-flex min-h-[39px] items-center justify-center rounded-lg bg-sky-900 px-4 text-[10px] font-bold text-white transition hover:bg-sky-950"
                >
                    Edit Supervisor
                </Link>
            </header>

            <DashboardCard>

                <!-- PROFILE HEADER -->
                <div
                    class="mb-6 flex items-center gap-4 border-b border-slate-100 pb-5"
                >
                    <UserAvatar
                        :name="encadrant.nom_complet"
                        :photo="encadrant.photo"
                        :size="72"
                    />

                    <div>
                        <h2
                            class="mb-1 text-[17px] font-bold text-slate-700"
                        >
                            {{
                                encadrant.nom_complet
                                ?? 'Unnamed supervisor'
                            }}
                        </h2>

                        <p
                            class="mb-2 text-[10px] text-slate-400"
                        >
                            {{
                                encadrant.email
                                ?? 'No email'
                            }}
                        </p>

                        <StatusBadge
                            :status="encadrant.etat"
                        />
                    </div>
                </div>

                <!-- DETAILS -->
                <div
                    class="grid grid-cols-2 gap-5 max-md:grid-cols-1"
                >

                    <div
                        class="flex flex-col gap-1.5 rounded-lg border border-slate-100 bg-slate-50/60 p-4"
                    >
                        <span
                            class="text-[9px] font-semibold uppercase tracking-wide text-slate-400"
                        >
                            Phone
                        </span>

                        <strong
                            class="text-[11px] font-bold text-slate-600"
                        >
                            {{
                                encadrant.telephone
                                ?? 'Not specified'
                            }}
                        </strong>
                    </div>

                    <div
                        class="flex flex-col gap-1.5 rounded-lg border border-slate-100 bg-slate-50/60 p-4"
                    >
                        <span
                            class="text-[9px] font-semibold uppercase tracking-wide text-slate-400"
                        >
                            City
                        </span>

                        <strong
                            class="text-[11px] font-bold text-slate-600"
                        >
                            {{
                                encadrant.ville?.nom
                                ?? 'Not specified'
                            }}
                        </strong>
                    </div>

                    <div
                        class="flex flex-col gap-1.5 rounded-lg border border-slate-100 bg-slate-50/60 p-4"
                    >
                        <span
                            class="text-[9px] font-semibold uppercase tracking-wide text-slate-400"
                        >
                            Company
                        </span>

                        <strong
                            class="text-[11px] font-bold text-slate-600"
                        >
                            {{
                                encadrant.encadrant
                                    ?.entreprise
                                    ?.user
                                    ?.nom_complet
                                ?? 'Not assigned'
                            }}
                        </strong>
                    </div>

                    <div
                        class="flex flex-col gap-1.5 rounded-lg border border-slate-100 bg-slate-50/60 p-4"
                    >
                        <span
                            class="text-[9px] font-semibold uppercase tracking-wide text-slate-400"
                        >
                            Position
                        </span>

                        <strong
                            class="text-[11px] font-bold text-slate-600"
                        >
                            {{
                                encadrant.encadrant?.poste
                                ?? 'Not specified'
                            }}
                        </strong>
                    </div>

                    <div
                        class="flex flex-col gap-1.5 rounded-lg border border-slate-100 bg-slate-50/60 p-4"
                    >
                        <span
                            class="text-[9px] font-semibold uppercase tracking-wide text-slate-400"
                        >
                            Specialty
                        </span>

                        <strong
                            class="text-[11px] font-bold text-slate-600"
                        >
                            {{
                                encadrant.encadrant?.specialite
                                ?? 'Not specified'
                            }}
                        </strong>
                    </div>

                    <div
                        class="flex flex-col gap-1.5 rounded-lg border border-slate-100 bg-slate-50/60 p-4"
                    >
                        <span
                            class="text-[9px] font-semibold uppercase tracking-wide text-slate-400"
                        >
                            Department
                        </span>

                        <strong
                            class="text-[11px] font-bold text-slate-600"
                        >
                            {{
                                encadrant.encadrant?.departement
                                ?? 'Not specified'
                            }}
                        </strong>
                    </div>

                    <div
                        class="flex flex-col gap-1.5 rounded-lg border border-slate-100 bg-slate-50/60 p-4"
                    >
                        <span
                            class="text-[9px] font-semibold uppercase tracking-wide text-slate-400"
                        >
                            Status
                        </span>

                        <div>
                            <StatusBadge
                                :status="encadrant.etat"
                            />
                        </div>
                    </div>

                </div>

                <!-- ACTIONS -->
                <div
                    class="mt-6 flex justify-end gap-2 border-t border-slate-100 pt-5 max-sm:flex-col-reverse"
                >
                    <Link
                        :href="route('admin.encadrants.index')"
                        class="inline-flex min-h-[39px] items-center justify-center rounded-lg border border-slate-200 bg-white px-4 text-[10px] font-bold text-slate-500 transition hover:bg-slate-50"
                    >
                        Back
                    </Link>

                    <Link
                        :href="route('admin.encadrants.edit', encadrant.id)"
                        class="inline-flex min-h-[39px] items-center justify-center rounded-lg bg-sky-900 px-4 text-[10px] font-bold text-white transition hover:bg-sky-950"
                    >
                        Edit Supervisor
                    </Link>
                </div>

            </DashboardCard>

        </div>
    </AdminLayout>
</template>
