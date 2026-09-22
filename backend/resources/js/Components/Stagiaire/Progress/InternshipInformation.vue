<script setup>
defineProps({
    stage: {
        type: Object,
        required: true,
    },

    formatDate: {
        type: Function,
        required: true,
    },

    evaluationGlobal: {
        type: String,
        default: '-',
    },
})
</script>

<template>
    <section
        class="mb-5 overflow-hidden rounded-2xl
        border border-[#E2E8F0]
        bg-white shadow-[0_4px_18px_rgba(22,66,91,0.06)]"
    >
        <!-- TOP -->
        <div
            class="border-b border-[#EEF2F6]
            bg-gradient-to-r from-[#F8FBFD] to-white
            px-5 py-5"
        >
            <div
                class="flex flex-col gap-5
                lg:flex-row lg:items-start lg:justify-between"
            >
                <!-- TITLE -->
                <div class="min-w-0">
                    <div class="flex items-center gap-2">
                        <span
                            class="flex h-7 w-7 shrink-0 items-center
                            justify-center rounded-lg bg-[#E8F1F5]"
                        >
                            <svg
                                class="h-4 w-4 text-[#2F6690]"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <rect
                                    x="3"
                                    y="4"
                                    width="18"
                                    height="16"
                                    rx="2"
                                />
                                <path
                                    d="M8 4V2.5M16 4V2.5M3 9h18"
                                />
                            </svg>
                        </span>

                        <p
                            class="text-[10px] font-bold uppercase
                            tracking-[1.4px] text-[#64748B]"
                        >
                            Current Internship
                        </p>
                    </div>

                    <h2
                        class="mt-3 text-[19px] font-bold leading-6
                        tracking-[-0.2px] text-[#16425B]"
                    >
                        {{ stage.sujet || 'Internship' }}
                    </h2>

                    <p
                        v-if="stage.entreprise?.user?.nom_complet"
                        class="mt-1.5 text-[11px] text-[#64748B]"
                    >
                        {{ stage.entreprise.user.nom_complet }}
                    </p>

                    <p
                        v-else-if="stage.entreprise?.secteur"
                        class="mt-1.5 text-[11px] text-[#64748B]"
                    >
                        {{ stage.entreprise.secteur }}
                    </p>
                </div>

                <!-- DATES / STATUS / EVALUATION -->
                <div
                    class="grid grid-cols-2 gap-x-8 gap-y-4
                    sm:grid-cols-4 lg:min-w-[430px]"
                >
                    <!-- START -->
                    <div>
                        <p
                            class="text-[9px] font-bold uppercase
                            tracking-[0.9px] text-[#94A3B8]"
                        >
                            Start date
                        </p>

                        <p
                            class="mt-1 text-[12px] font-semibold
                            text-[#334155]"
                        >
                            {{ formatDate(stage.date_debut) }}
                        </p>
                    </div>

                    <!-- END -->
                    <div>
                        <p
                            class="text-[9px] font-bold uppercase
                            tracking-[0.9px] text-[#94A3B8]"
                        >
                            End date
                        </p>

                        <p
                            class="mt-1 text-[12px] font-semibold
                            text-[#334155]"
                        >
                            {{ formatDate(stage.date_fin) }}
                        </p>
                    </div>

                    <!-- STATUS -->
                    <div>
                        <p
                            class="text-[9px] font-bold uppercase
                            tracking-[0.9px] text-[#94A3B8]"
                        >
                            Status
                        </p>

                        <span
                            class="mt-1.5 inline-flex items-center
                            rounded-full bg-[#E8F1F5]
                            px-2.5 py-1 text-[10px] font-semibold
                            text-[#2F6690]"
                        >
                            <span
                                class="mr-1.5 h-1.5 w-1.5 rounded-full
                                bg-[#3A7CA5]"
                            ></span>

                            {{ stage.statut || '-' }}
                        </span>
                    </div>

                    <!-- EVALUATION -->
                    <div>
                        <p
                            class="text-[9px] font-bold uppercase
                            tracking-[0.9px] text-[#94A3B8]"
                        >
                            Evaluation
                        </p>

                        <div class="mt-1 flex items-baseline gap-1">
                            <p
                                class="text-[15px] font-bold
                                text-[#16425B]"
                            >
                                {{ evaluationGlobal }}
                            </p>

                            <span
                                v-if="evaluationGlobal !== '-'"
                                class="text-[9px] text-[#94A3B8]"
                            >
                                / 20
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- COMPANY / SUPERVISOR -->
        <div class="grid grid-cols-1 gap-3 p-5 md:grid-cols-2">

            <!-- COMPANY -->
            <div
                class="group rounded-xl border border-[#E2E8F0]
                bg-[#F8FAFC] p-4 transition
                hover:border-[#C8DCE7] hover:bg-[#F5F9FB]"
            >
                <div class="flex items-start gap-3">

                    <!-- ICON -->
                    <div
                        class="flex h-9 w-9 shrink-0 items-center
                        justify-center rounded-lg bg-[#E8F1F5]
                        text-[#2F6690]"
                    >
                        <svg
                            class="h-[18px] w-[18px]"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.7"
                        >
                            <path
                                d="M3 21h18M5 21V5a2 2 0 0 1 2-2h7a2 2 0 0 1 2 2v16M16 9h3a2 2 0 0 1 2 2v10M8 7h4M8 11h4M8 15h4"
                            />
                        </svg>
                    </div>

                    <div class="min-w-0">
                        <p
                            class="text-[9px] font-bold uppercase
                            tracking-[1px] text-[#94A3B8]"
                        >
                            Company
                        </p>

                        <p
                            class="mt-1 text-[13px] font-bold
                            text-[#16425B]"
                        >
                            {{
                                stage.entreprise?.user?.nom_complet
                                || '-'
                            }}
                        </p>

                        <div class="mt-1.5 space-y-0.5">
                            <p
                                v-if="stage.entreprise?.secteur"
                                class="text-[10.5px] text-[#64748B]"
                            >
                                {{ stage.entreprise.secteur }}
                            </p>

                            <p
                                v-if="stage.entreprise?.ville?.nom"
                                class="flex items-center gap-1
                                text-[10.5px] text-[#64748B]"
                            >
                                <svg
                                    class="h-3 w-3 shrink-0 text-[#81C3D7]"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path
                                        d="M12 21s7-6.1 7-12a7 7 0 1 0-14 0c0 5.9 7 12 7 12Z"
                                    />
                                    <circle
                                        cx="12"
                                        cy="9"
                                        r="2.2"
                                    />
                                </svg>

                                {{ stage.entreprise.ville.nom }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SUPERVISOR -->
            <div
                class="group rounded-xl border border-[#E2E8F0]
                bg-[#F8FAFC] p-4 transition
                hover:border-[#C8DCE7] hover:bg-[#F5F9FB]"
            >
                <div class="flex items-start gap-3">

                    <!-- ICON -->
                    <div
                        class="flex h-9 w-9 shrink-0 items-center
                        justify-center rounded-lg bg-[#E8F1F5]
                        text-[#2F6690]"
                    >
                        <svg
                            class="h-[18px] w-[18px]"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.7"
                        >
                            <circle
                                cx="12"
                                cy="8"
                                r="3.2"
                            />
                            <path
                                d="M5.5 20a6.5 6.5 0 0 1 13 0M19 5.5a3 3 0 0 1 0 5.8"
                            />
                        </svg>
                    </div>

                    <div class="min-w-0">
                        <p
                            class="text-[9px] font-bold uppercase
                            tracking-[1px] text-[#94A3B8]"
                        >
                            Supervisor
                        </p>

                        <p
                            class="mt-1 text-[13px] font-bold
                            text-[#16425B]"
                        >
                            {{
                                stage.encadrant?.user?.nom_complet
                                || '-'
                            }}
                        </p>

                        <div class="mt-1.5 space-y-0.5">
                            <p
                                v-if="stage.encadrant?.poste"
                                class="text-[10.5px] text-[#64748B]"
                            >
                                {{ stage.encadrant.poste }}
                            </p>

                            <p
                                v-if="stage.encadrant?.departement"
                                class="text-[10.5px] text-[#64748B]"
                            >
                                {{ stage.encadrant.departement }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>