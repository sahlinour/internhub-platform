<script setup>
import { Head, Link } from '@inertiajs/vue3'
import AdminLayout from '@/Components/Admin/AdminLayout.vue'
import Icon from '@/Components/Admin/Icon.vue'

const props = defineProps({
    stage: {
        type: Object,
        required: true,
    },
})

const formatDate = (date) => {
    if (!date) return 'Not specified'

    return new Intl.DateTimeFormat('en-US', {
        month: 'long',
        day: '2-digit',
        year: 'numeric',
    }).format(new Date(date))
}

const internName = () => {
    return (
        props.stage?.candidature?.stagiaire?.user?.nom_complet
        ?? 'Not assigned'
    )
}

const internEmail = () => {
    return (
        props.stage?.candidature?.stagiaire?.user?.email
        ?? 'Not available'
    )
}

const companyName = () => {
    return (
        props.stage?.candidature?.offre_de_stage?.entreprise?.user?.nom_complet
        ?? props.stage?.candidature?.offreDeStage?.entreprise?.user?.nom_complet
        ?? 'Not available'
    )
}

const supervisorName = () => {
    return (
        props.stage?.encadrant?.user?.nom_complet
        ?? 'Not assigned'
    )
}

const statusClasses = (status) => {
    if (status === 'En cours') {
        return 'bg-[#e8f6ee] text-[#3e9663]'
    }

    if (status === 'Terminée') {
        return 'bg-[#e9f1f8] text-[#3e7195]'
    }

    if (status === 'Annulée') {
        return 'bg-[#fbecec] text-[#bd5b5b]'
    }

    return 'bg-[#eef2f5] text-[#718491]'
}

const statusLabel = (status) => {
    if (status === 'En cours') return 'Active'
    if (status === 'Terminée') return 'Completed'
    if (status === 'Annulée') return 'Cancelled'

    return status || 'Unknown'
}
</script>

<template>
    <Head :title="stage.sujet || 'Internship'" />

    <AdminLayout>
        <div class="mx-auto w-full max-w-[1050px]">

            <!-- HEADER -->
            <div
                class="mb-6 flex items-start
                       justify-between gap-5
                       max-[700px]:flex-col"
            >
                <div>
                    <div class="mb-2 flex items-center gap-2">
                        <Link
                            :href="route('admin.stages.index')"
                            class="text-[10px]
                                   font-semibold
                                   text-[#668091]
                                   no-underline
                                   hover:text-[#174966]"
                        >
                            Internships
                        </Link>

                        <span class="text-[#a7b2ba]">
                            /
                        </span>

                        <span class="text-[10px] text-[#8b9aa5]">
                            View
                        </span>
                    </div>

                    <h1 class="text-[22px] font-bold text-[#20394b]">
                        {{ stage.sujet || 'Untitled Internship' }}
                    </h1>

                    <p class="mt-1 text-[11px] text-[#8798a6]">
                        Internship #{{ stage.id }}
                    </p>
                </div>

                <div
                    class="flex items-center gap-2
                           max-[500px]:w-full"
                >
                    <Link
                        :href="route('admin.stages.edit', stage.id)"
                        class="inline-flex min-h-[38px]
                               items-center justify-center
                               rounded-lg bg-[#174966]
                               px-4 text-[10px]
                               font-semibold text-white
                               no-underline
                               hover:bg-[#123e57]
                               max-[500px]:flex-1"
                    >
                        Edit Internship
                    </Link>
                </div>
            </div>

            <!-- STATUS -->
            <section
                class="mb-5 rounded-xl
                       border border-[#e3eaef]
                       bg-white p-5 shadow-sm"
            >
                <div
                    class="flex items-center
                           justify-between gap-5
                           max-[600px]:flex-col
                           max-[600px]:items-start"
                >
                    <div class="flex items-center gap-3">
                        <div
                            class="flex h-[42px] w-[42px]
                                   items-center justify-center
                                   rounded-lg bg-[#e8f2f7]
                                   text-[#276b90]"
                        >
                            <Icon
                                name="briefcase"
                                :size="20"
                            />
                        </div>

                        <div>
                            <p
                                class="text-[9px]
                                       font-semibold uppercase
                                       tracking-wide
                                       text-[#91a0ab]"
                            >
                                Internship Status
                            </p>

                            <p
                                class="mt-1 text-[12px]
                                       font-bold text-[#294355]"
                            >
                                {{ stage.sujet }}
                            </p>
                        </div>
                    </div>

                    <span
                        class="inline-flex items-center
                               gap-[5px] rounded-full
                               px-3 py-1.5
                               text-[9px] font-bold"
                        :class="statusClasses(stage.statut)"
                    >
                        <span
                            class="h-[5px] w-[5px]
                                   rounded-full bg-current"
                        ></span>

                        {{ statusLabel(stage.statut) }}
                    </span>
                </div>
            </section>

            <!-- INFORMATION GRID -->
            <div
                class="grid grid-cols-2 gap-5
                       max-[800px]:grid-cols-1"
            >
                <!-- INTERNSHIP DETAILS -->
                <section
                    class="rounded-xl
                           border border-[#e3eaef]
                           bg-white p-5 shadow-sm"
                >
                    <h2
                        class="mb-5 text-[14px]
                               font-bold text-[#294355]"
                    >
                        Internship Details
                    </h2>

                    <div class="space-y-5">
                        <div>
                            <span
                                class="block text-[9px]
                                       font-semibold uppercase
                                       text-[#91a0ab]"
                            >
                                Subject
                            </span>

                            <p
                                class="mt-1 text-[11px]
                                       font-semibold text-[#40596b]"
                            >
                                {{ stage.sujet || 'Not specified' }}
                            </p>
                        </div>

                        <div>
                            <span
                                class="block text-[9px]
                                       font-semibold uppercase
                                       text-[#91a0ab]"
                            >
                                Start Date
                            </span>

                            <p
                                class="mt-1 text-[11px]
                                       font-semibold text-[#40596b]"
                            >
                                {{ formatDate(stage.date_debut) }}
                            </p>
                        </div>

                        <div>
                            <span
                                class="block text-[9px]
                                       font-semibold uppercase
                                       text-[#91a0ab]"
                            >
                                End Date
                            </span>

                            <p
                                class="mt-1 text-[11px]
                                       font-semibold text-[#40596b]"
                            >
                                {{ formatDate(stage.date_fin) }}
                            </p>
                        </div>
                    </div>
                </section>

                <!-- PEOPLE -->
                <section
                    class="rounded-xl
                           border border-[#e3eaef]
                           bg-white p-5 shadow-sm"
                >
                    <h2
                        class="mb-5 text-[14px]
                               font-bold text-[#294355]"
                    >
                        Assignment
                    </h2>

                    <div class="space-y-5">
                        <div>
                            <span
                                class="block text-[9px]
                                       font-semibold uppercase
                                       text-[#91a0ab]"
                            >
                                Intern
                            </span>

                            <p
                                class="mt-1 text-[11px]
                                       font-semibold text-[#40596b]"
                            >
                                {{ internName() }}
                            </p>

                            <p
                                class="mt-0.5 text-[9px]
                                       text-[#91a0ab]"
                            >
                                {{ internEmail() }}
                            </p>
                        </div>

                        <div>
                            <span
                                class="block text-[9px]
                                       font-semibold uppercase
                                       text-[#91a0ab]"
                            >
                                Company
                            </span>

                            <p
                                class="mt-1 text-[11px]
                                       font-semibold text-[#40596b]"
                            >
                                {{ companyName() }}
                            </p>
                        </div>

                        <div>
                            <span
                                class="block text-[9px]
                                       font-semibold uppercase
                                       text-[#91a0ab]"
                            >
                                Supervisor
                            </span>

                            <p
                                class="mt-1 text-[11px]
                                       font-semibold text-[#40596b]"
                            >
                                {{ supervisorName() }}
                            </p>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </AdminLayout>
</template>
