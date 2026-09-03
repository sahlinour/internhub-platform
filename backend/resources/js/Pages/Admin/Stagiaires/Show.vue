<script setup>
import { Head, Link, router } from '@inertiajs/vue3'

import AdminLayout from '@/Components/Admin/AdminLayout.vue'
import DashboardCard from '@/Components/Admin/DashboardCard.vue'
import UserAvatar from '@/Components/Admin/UserAvatar.vue'
import StatusBadge from '@/Components/Admin/StatusBadge.vue'

const props = defineProps({
    stagiaire: {
        type: Object,
        required: true,
    },
})

const deleteIntern = () => {
    const confirmed = confirm(
        `Are you sure you want to delete ${props.stagiaire.nom_complet}?`
    )

    if (!confirmed) {
        return
    }

    router.delete(
        route(
            'admin.stagiaires.destroy',
            props.stagiaire.id
        )
    )
}
</script>

<template>
    <Head title="Intern Details" />

    <AdminLayout>
        <div class="w-full max-w-[1050px]">

            <!-- HEADER -->
            <header
                class="mb-5 flex items-start justify-between
                       gap-5 max-[700px]:flex-col"
            >
                <div>
                    <!-- BREADCRUMB -->
                    <div
                        class="mb-2 flex items-center gap-[7px]
                               text-[9px] text-[#96a5af]"
                    >
                        <Link
                            :href="route('admin.stagiaires.index')"
                            class="text-[#367594] no-underline
                                   hover:underline"
                        >
                            Interns
                        </Link>

                        <span>/</span>

                        <span>Details</span>
                    </div>

                    <h1
                        class="mb-[5px] text-[22px]
                               font-bold text-[#20394b]"
                    >
                        Intern Details
                    </h1>

                    <p class="text-[10px] text-[#8798a6]">
                        View the intern's account and academic information.
                    </p>
                </div>

                <!-- ACTIONS -->
                <div class="flex items-center gap-2">
                    <Link
                        :href="
                            route(
                                'admin.stagiaires.edit',
                                stagiaire.id
                            )
                        "
                        class="inline-flex min-h-[40px]
                               items-center justify-center
                               rounded-lg bg-[#174966]
                               px-4 text-[10px]
                               font-bold text-white
                               no-underline transition
                               hover:bg-[#123e57]"
                    >
                        Edit Intern
                    </Link>

                    <button
                        type="button"
                        class="inline-flex min-h-[40px]
                               cursor-pointer items-center
                               justify-center rounded-lg
                               border border-[#efcaca]
                               bg-white px-4
                               text-[10px] font-bold
                               text-[#c95858] transition
                               hover:bg-[#fff4f4]"
                        @click="deleteIntern"
                    >
                        Delete
                    </button>
                </div>
            </header>

            <!-- PROFILE -->
            <DashboardCard>
                <div
                    class="mb-[22px] flex items-center gap-[18px]
                           border-b border-[#edf1f4] pb-[22px]"
                >
                    <UserAvatar
                        :name="stagiaire.nom_complet"
                        :photo="stagiaire.photo"
                        :size="76"
                    />

                    <div>
                        <h2
                            class="mb-1 text-[18px]
                                   font-bold text-[#294355]"
                        >
                            {{
                                stagiaire.nom_complet
                                ?? 'Unnamed Intern'
                            }}
                        </h2>

                        <p
                            class="mb-2 text-[10px]
                                   text-[#8d9ca7]"
                        >
                            {{ stagiaire.email ?? 'No email' }}
                        </p>

                        <StatusBadge
                            :status="stagiaire.etat"
                        />
                    </div>
                </div>

                <!-- ACCOUNT INFORMATION -->
                <div class="mb-5">
                    <h3
                        class="mb-4 text-[13px]
                               font-bold text-[#294355]"
                    >
                        Account Information
                    </h3>

                    <div
                        class="grid grid-cols-2 gap-[14px]
                               max-[700px]:grid-cols-1"
                    >
                        <!-- EMAIL -->
                        <div
                            class="rounded-[9px]
                                   border border-[#e3e9ed]
                                   bg-[#f9fbfc] p-[15px]"
                        >
                            <span
                                class="mb-[5px] block
                                       text-[9px] text-[#8c9ca7]"
                            >
                                Email
                            </span>

                            <strong
                                class="break-all text-[11px]
                                       font-bold text-[#40596a]"
                            >
                                {{
                                    stagiaire.email
                                    ?? 'Not provided'
                                }}
                            </strong>
                        </div>

                        <!-- PHONE -->
                        <div
                            class="rounded-[9px]
                                   border border-[#e3e9ed]
                                   bg-[#f9fbfc] p-[15px]"
                        >
                            <span
                                class="mb-[5px] block
                                       text-[9px] text-[#8c9ca7]"
                            >
                                Phone
                            </span>

                            <strong
                                class="text-[11px] font-bold
                                       text-[#40596a]"
                            >
                                {{
                                    stagiaire.telephone
                                    ?? 'Not provided'
                                }}
                            </strong>
                        </div>

                        <!-- CITY -->
                        <div
                            class="rounded-[9px]
                                   border border-[#e3e9ed]
                                   bg-[#f9fbfc] p-[15px]"
                        >
                            <span
                                class="mb-[5px] block
                                       text-[9px] text-[#8c9ca7]"
                            >
                                City
                            </span>

                            <strong
                                class="text-[11px] font-bold
                                       text-[#40596a]"
                            >
                                {{
                                    stagiaire.ville?.nom
                                    ?? 'Not provided'
                                }}
                            </strong>
                        </div>

                        <!-- ACCOUNT STATUS -->
                        <div
                            class="rounded-[9px]
                                   border border-[#e3e9ed]
                                   bg-[#f9fbfc] p-[15px]"
                        >
                            <span
                                class="mb-[7px] block
                                       text-[9px] text-[#8c9ca7]"
                            >
                                Account Status
                            </span>

                            <StatusBadge
                                :status="stagiaire.etat"
                            />
                        </div>
                    </div>
                </div>

                <!-- ACADEMIC INFORMATION -->
                <div
                    class="border-t border-[#edf1f4]
                           pt-5"
                >
                    <h3
                        class="mb-4 text-[13px]
                               font-bold text-[#294355]"
                    >
                        Academic Information
                    </h3>

                    <div
                        class="grid grid-cols-2 gap-[14px]
                               max-[700px]:grid-cols-1"
                    >
                        <!-- UNIVERSITY -->
                        <div
                            class="rounded-[9px]
                                   border border-[#e3e9ed]
                                   bg-[#f9fbfc] p-[15px]"
                        >
                            <span
                                class="mb-[5px] block
                                       text-[9px] text-[#8c9ca7]"
                            >
                                University / School
                            </span>

                            <strong
                                class="text-[11px] font-bold
                                       text-[#40596a]"
                            >
                                {{
                                    stagiaire.stagiaire?.universite
                                    ?? 'Not provided'
                                }}
                            </strong>
                        </div>

                        <!-- FIELD -->
                        <div
                            class="rounded-[9px]
                                   border border-[#e3e9ed]
                                   bg-[#f9fbfc] p-[15px]"
                        >
                            <span
                                class="mb-[5px] block
                                       text-[9px] text-[#8c9ca7]"
                            >
                                Field of Study
                            </span>

                            <strong
                                class="text-[11px] font-bold
                                       text-[#40596a]"
                            >
                                {{
                                    stagiaire.stagiaire?.filiere
                                    ?? 'Not provided'
                                }}
                            </strong>
                        </div>

                        <!-- LEVEL -->
                        <div
                            class="rounded-[9px]
                                   border border-[#e3e9ed]
                                   bg-[#f9fbfc] p-[15px]"
                        >
                            <span
                                class="mb-[5px] block
                                       text-[9px] text-[#8c9ca7]"
                            >
                                Level
                            </span>

                            <strong
                                class="text-[11px] font-bold
                                       text-[#40596a]"
                            >
                                {{
                                    stagiaire.stagiaire?.niveau
                                    ?? 'Not provided'
                                }}
                            </strong>
                        </div>

                        <!-- DATE OF BIRTH -->
                        <div
                            class="rounded-[9px]
                                   border border-[#e3e9ed]
                                   bg-[#f9fbfc] p-[15px]"
                        >
                            <span
                                class="mb-[5px] block
                                       text-[9px] text-[#8c9ca7]"
                            >
                                Date of Birth
                            </span>

                            <strong
                                class="text-[11px] font-bold
                                       text-[#40596a]"
                            >
                                {{
                                    stagiaire.stagiaire?.date_naissance
                                    ?? 'Not provided'
                                }}
                            </strong>
                        </div>

                        <!-- INTERNSHIP STATUS -->
                        <div
                            class="rounded-[9px]
                                   border border-[#e3e9ed]
                                   bg-[#f9fbfc] p-[15px]"
                        >
                            <span
                                class="mb-[5px] block
                                       text-[9px] text-[#8c9ca7]"
                            >
                                Internship Status
                            </span>

                            <strong
                                class="text-[11px] font-bold
                                       text-[#40596a]"
                            >
                                {{
                                    stagiaire.stagiaire?.statut_stage
                                    ?? 'Not provided'
                                }}
                            </strong>
                        </div>
                    </div>
                </div>

                <!-- PROFESSIONAL LINKS -->
                <div
                    class="mt-5 border-t
                           border-[#edf1f4] pt-5"
                >
                    <h3
                        class="mb-4 text-[13px]
                               font-bold text-[#294355]"
                    >
                        Professional Links
                    </h3>

                    <div
                        class="grid grid-cols-2 gap-[14px]
                               max-[700px]:grid-cols-1"
                    >
                        <!-- LINKEDIN -->
                        <div
                            class="rounded-[9px]
                                   border border-[#e3e9ed]
                                   bg-[#f9fbfc] p-[15px]"
                        >
                            <span
                                class="mb-[5px] block
                                       text-[9px] text-[#8c9ca7]"
                            >
                                LinkedIn
                            </span>

                            <a
                                v-if="
                                    stagiaire.stagiaire?.linkedin_url
                                "
                                :href="
                                    stagiaire.stagiaire.linkedin_url
                                "
                                target="_blank"
                                rel="noopener noreferrer"
                                class="break-all text-[11px]
                                       font-semibold text-[#367594]
                                       hover:underline"
                            >
                                {{
                                    stagiaire.stagiaire.linkedin_url
                                }}
                            </a>

                            <strong
                                v-else
                                class="text-[11px] font-bold
                                       text-[#40596a]"
                            >
                                Not provided
                            </strong>
                        </div>

                        <!-- PORTFOLIO -->
                        <div
                            class="rounded-[9px]
                                   border border-[#e3e9ed]
                                   bg-[#f9fbfc] p-[15px]"
                        >
                            <span
                                class="mb-[5px] block
                                       text-[9px] text-[#8c9ca7]"
                            >
                                Portfolio
                            </span>

                            <a
                                v-if="
                                    stagiaire.stagiaire?.portfolio_url
                                "
                                :href="
                                    stagiaire.stagiaire.portfolio_url
                                "
                                target="_blank"
                                rel="noopener noreferrer"
                                class="break-all text-[11px]
                                       font-semibold text-[#367594]
                                       hover:underline"
                            >
                                {{
                                    stagiaire.stagiaire.portfolio_url
                                }}
                            </a>

                            <strong
                                v-else
                                class="text-[11px] font-bold
                                       text-[#40596a]"
                            >
                                Not provided
                            </strong>
                        </div>
                    </div>
                </div>

            </DashboardCard>

            <!-- BACK -->
            <div class="mt-4">
                <Link
                    :href="route('admin.stagiaires.index')"
                    class="inline-flex min-h-[38px]
                           items-center justify-center
                           rounded-lg
                           border border-[#dce5ea]
                           bg-white px-4
                           text-[10px] font-bold
                           text-[#617887]
                           no-underline transition
                           hover:bg-[#f8fafb]"
                >
                    ← Back to Interns
                </Link>
            </div>

        </div>
    </AdminLayout>
</template>
