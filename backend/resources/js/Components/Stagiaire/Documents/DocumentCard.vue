<script setup>
import Icon from '@/Components/Stagiaire/Icon.vue'

const props = defineProps({
    document: {
        type: Object,
        required: true,
    },
})

const formatDate = (date) => {
    if (!date) return '-'

    return new Date(date).toLocaleDateString('en-GB', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
    })
}

const displayStatus = (status) => {
    switch (status) {
        case 'en_attente':
            return 'Pending'
        case 'valide':
            return 'Validated'
        case 'rejete':
            return 'Rejected'
        default:
            return status
    }
}

const statusClass = (status) => {
    switch (status) {
        case 'valide':
            return 'bg-[#e9f7ef] text-[#459d69]'
        case 'rejete':
            return 'bg-[#fdecef] text-[#d80536]'
        case 'en_attente':
            return 'bg-[#fff6e5] text-[#c79030]'
        default:
            return 'bg-[#eef5f8] text-[#64748b]'
    }
}

const encadrantName = () => {
    return props.document.encadrant?.user?.nom_complet ?? '—'
}

const fileUrl = () => {
    if (!props.document.fichier_url) return null

    return `/storage/${props.document.fichier_url}`
}
</script>

<template>
    <div
        class="group
               rounded-xl
               border border-slate-100
               bg-white
               px-4 py-3.5
               shadow-[0_2px_10px_rgba(16,46,65,0.025)]
               transition-all duration-200
               hover:border-[#cbdde6]
               hover:shadow-[0_5px_18px_rgba(16,46,65,0.06)]"
    >
        <div
            class="flex flex-col gap-4
                   sm:flex-row sm:items-center"
        >

            <!-- DOCUMENT ICON -->
            <div
                class="flex h-11 w-11
                       shrink-0
                       items-center justify-center
                       rounded-xl
                       bg-[#e8f1f5]
                       text-[#2f6690]
                       transition
                       group-hover:bg-[#dcecf3]"
            >
                <Icon
                    name="documents"
                    :size="19"
                />
            </div>

            <!-- MAIN INFORMATION -->
            <div class="min-w-0 flex-1">

                <div
                    class="flex flex-col gap-1
                           sm:flex-row sm:items-center
                           sm:gap-3"
                >
                    <h3
                        class="truncate
                               text-[12px]
                               font-bold
                               text-[#16425B]"
                    >
                        {{ document.nom }}
                    </h3>

                    <span
                        class="w-fit
                               rounded-md
                               bg-[#f4f7f9]
                               px-2 py-0.5
                               text-[8px]
                               font-medium
                               text-[#64748b]"
                    >
                        {{ document.version || '-' }}
                    </span>
                </div>

                <!-- META -->
                <div
                    class="mt-2.5
                           flex flex-wrap
                           items-center
                           gap-x-5 gap-y-1.5"
                >
                    <div class="flex items-center gap-1.5">
                        <span
                            class="text-[8px]
                                   font-semibold
                                   uppercase
                                   tracking-wide
                                   text-[#94a3ad]"
                        >
                            Uploaded
                        </span>

                        <span
                            class="text-[9px]
                                   text-[#64748b]"
                        >
                            {{ formatDate(document.created_at) }}
                        </span>
                    </div>

                    <div
                        class="hidden h-3 w-px
                               bg-slate-200
                               sm:block"
                    ></div>

                    <div class="flex items-center gap-1.5">
                        <span
                            class="text-[8px]
                                   font-semibold
                                   uppercase
                                   tracking-wide
                                   text-[#94a3ad]"
                        >
                            Supervisor
                        </span>

                        <span
                            class="max-w-[180px]
                                   truncate
                                   text-[9px]
                                   text-[#64748b]"
                        >
                            {{ encadrantName() }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- STATUS + ACTION -->
            <div
                class="flex
                       shrink-0
                       items-center
                       justify-between
                       gap-3
                       sm:flex-col
                       sm:items-end
                       sm:justify-center"
            >
                <span
                    class="rounded-full
                           px-2.5 py-1
                           text-[8px]
                           font-semibold"
                    :class="statusClass(document.statut)"
                >
                    {{ displayStatus(document.statut) }}
                </span>

                <a
                    v-if="fileUrl()"
                    :href="fileUrl()"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="inline-flex
                           items-center
                           gap-1
                           rounded-md
                           border border-[#dce8ee]
                           bg-[#fafcfd]
                           px-2.5 py-1.5
                           text-[8px]
                           font-semibold
                           text-[#286d93]
                           no-underline
                           transition
                           hover:border-[#b9d2df]
                           hover:bg-[#eef5f8]"
                >
                    Open
                    <svg
                        width="11"
                        height="11"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path d="M7 17L17 7" />
                        <path d="M7 7h10v10" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</template>