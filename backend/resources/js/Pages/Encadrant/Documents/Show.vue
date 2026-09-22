```vue
<script setup>
import { Head, Link, router } from '@inertiajs/vue3'
import EncadrantLayout from '@/Layouts/EncadrantLayout.vue'

const props = defineProps({
    document: {
        type: Object,
        required: true,
    },
})

const internName = () => {
    return (
        props.document.stage?.candidature?.stagiaire?.user?.nom_complet ??
        'Unknown intern'
    )
}

const internEmail = () => {
    return (
        props.document.stage?.candidature?.stagiaire?.user?.email ??
        null
    )
}

const formatDate = (date) => {
    if (!date) return '—'

    return new Intl.DateTimeFormat('en', {
        day: 'numeric',
        month: 'short',
        year: 'numeric',
    }).format(new Date(date))
}

const statusLabel = (status) => {
    switch (status) {
        case 'valide':
            return 'Approved'

        case 'rejete':
            return 'Rejected'

        case 'en_attente':
            return 'Pending Review'

        default:
            return status ?? 'Unknown'
    }
}

const statusClass = (status) => {
    switch (status) {
        case 'valide':
            return 'border-emerald-200 bg-emerald-50 text-emerald-700'

        case 'rejete':
            return 'border-red-200 bg-red-50 text-red-700'

        case 'en_attente':
            return 'border-amber-200 bg-amber-50 text-amber-700'

        default:
            return 'border-[#A9CEDB] bg-[#F2F8FA] text-[#39719F]'
    }
}

const reviewedMessageClass = (status) => {
    switch (status) {
        case 'valide':
            return 'border-emerald-200 bg-emerald-50 text-emerald-700'

        case 'rejete':
            return 'border-red-200 bg-red-50 text-red-700'

        default:
            return 'border-[#A9CEDB] bg-[#F2F8FA] text-[#39719F]'
    }
}

const updateStatus = (status) => {
    if (!props.document?.id) return

    router.patch(
        route('encadrant.documents.updateStatus', {
            id: props.document.id,
        }),
        {
            statut: status,
        },
        {
            preserveScroll: true,
        }
    )
}
</script>

<template>
    <Head title="Review Document" />

    <EncadrantLayout>
        <div class="mx-auto max-w-[1500px] p-6">
            <!-- Back link -->
            <Link
                :href="route('encadrant.documents.index')"
                class="inline-flex items-center gap-2 text-sm font-semibold text-[#39719F] transition hover:text-[#072B4E]"
            >
                <svg
                    class="h-4 w-4"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15 19l-7-7 7-7"
                    />
                </svg>

                Back to Documents
            </Link>

            <!-- Header -->
            <div
                class="mt-6 rounded-xl border border-[#A9CEDB]/70 bg-gradient-to-r from-[#F2F8FA] to-white p-5"
            >
                <div
                    class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
                >
                    <div>
                        <h1 class="text-2xl font-bold text-[#072B4E]">
                            Review Document
                        </h1>

                        <p class="mt-1 text-sm text-[#507291]">
                            Review the document submitted by your intern.
                        </p>
                    </div>

                    <span
                        class="inline-flex w-fit rounded-full border px-3 py-1 text-xs font-semibold"
                        :class="statusClass(document.statut)"
                    >
                        {{ statusLabel(document.statut) }}
                    </span>
                </div>
            </div>

            <!-- Main content -->
            <div class="mt-6 grid gap-6 lg:grid-cols-3">
                <!-- Left column -->
                <div class="space-y-6 lg:col-span-2">
                    <!-- Document information -->
                    <section
                        class="overflow-hidden rounded-xl border border-[#A9CEDB]/80 bg-white shadow-sm"
                    >
                        <div
                            class="h-1 bg-gradient-to-r from-[#072B4E] via-[#39719F] to-[#60ADC6]"
                        ></div>

                        <div class="p-6">
                            <h2
                                class="text-base font-semibold text-[#072B4E]"
                            >
                                Document Information
                            </h2>

                            <!-- File -->
                            <div
                                class="mt-5 flex flex-col gap-4 rounded-xl border border-[#A9CEDB]/80 bg-[#F2F8FA] p-4 sm:flex-row sm:items-center"
                            >
                                <div class="min-w-0 flex-1">
                                    <p
                                        class="truncate text-sm font-semibold text-[#072B4E]"
                                    >
                                        {{ document.nom }}
                                    </p>

                                    <p class="mt-1 text-xs text-[#507291]">
                                        Version
                                        {{ document.version || '—' }}
                                    </p>
                                </div>

                                <a
                                    v-if="document.fichier_url"
                                    :href="
                                        route(
                                            'encadrant.documents.download',
                                            {
                                                id: document.id,
                                            }
                                        )
                                    "
                                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#39719F] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#072B4E] focus:outline-none focus:ring-2 focus:ring-[#60ADC6]/40"
                                >
                                    <svg
                                        class="h-4 w-4"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        aria-hidden="true"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M12 3v12m0 0l-4-4m4 4l4-4M5 21h14"
                                        />
                                    </svg>

                                    Download
                                </a>

                                <span
                                    v-else
                                    class="inline-flex items-center justify-center rounded-lg border border-[#A9CEDB] bg-white px-4 py-2.5 text-sm font-medium text-[#6695AF]"
                                >
                                    File unavailable
                                </span>
                            </div>

                            <!-- Document details -->
                            <div
                                class="mt-6 grid gap-4 sm:grid-cols-2"
                            >
                                <div
                                    class="rounded-lg border border-[#A9CEDB]/60 bg-white p-4"
                                >
                                    <p
                                        class="text-xs font-semibold uppercase tracking-wide text-[#60ADC6]"
                                    >
                                        Document Name
                                    </p>

                                    <p
                                        class="mt-1 break-words text-sm font-medium text-[#072B4E]"
                                    >
                                        {{ document.nom }}
                                    </p>
                                </div>

                                <div
                                    class="rounded-lg border border-[#A9CEDB]/60 bg-white p-4"
                                >
                                    <p
                                        class="text-xs font-semibold uppercase tracking-wide text-[#60ADC6]"
                                    >
                                        Version
                                    </p>

                                    <p
                                        class="mt-1 text-sm font-medium text-[#072B4E]"
                                    >
                                        {{ document.version || '—' }}
                                    </p>
                                </div>

                                <div
                                    class="rounded-lg border border-[#A9CEDB]/60 bg-white p-4"
                                >
                                    <p
                                        class="text-xs font-semibold uppercase tracking-wide text-[#60ADC6]"
                                    >
                                        Submitted
                                    </p>

                                    <p
                                        class="mt-1 text-sm font-medium text-[#072B4E]"
                                    >
                                        {{ formatDate(document.created_at) }}
                                    </p>
                                </div>

                                <div
                                    class="rounded-lg border border-[#A9CEDB]/60 bg-white p-4"
                                >
                                    <p
                                        class="text-xs font-semibold uppercase tracking-wide text-[#60ADC6]"
                                    >
                                        Internship
                                    </p>

                                    <p
                                        class="mt-1 text-sm font-medium text-[#072B4E]"
                                    >
                                        {{ document.stage?.sujet ?? '—' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Review actions -->
                    <section
                        class="rounded-xl border border-[#A9CEDB]/80 bg-white p-6 shadow-sm"
                    >
                        <h2
                            class="text-base font-semibold text-[#072B4E]"
                        >
                            Review
                        </h2>

                        <p class="mt-1 text-sm text-[#507291]">
                            Approve or reject this submitted document.
                        </p>

                        <div
                            v-if="document.statut === 'en_attente'"
                            class="mt-5 flex flex-wrap gap-3"
                        >
                            <button
                                type="button"
                                class="inline-flex items-center gap-2 rounded-lg bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-200"
                                @click="updateStatus('valide')"
                            >
                                <svg
                                    class="h-4 w-4"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    aria-hidden="true"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M5 13l4 4L19 7"
                                    />
                                </svg>

                                Approve
                            </button>

                            <button
                                type="button"
                                class="inline-flex items-center gap-2 rounded-lg border border-red-200 bg-white px-5 py-2.5 text-sm font-semibold text-red-600 transition hover:border-red-600 hover:bg-red-600 hover:text-white focus:outline-none focus:ring-2 focus:ring-red-200"
                                @click="updateStatus('rejete')"
                            >
                                <svg
                                    class="h-4 w-4"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    aria-hidden="true"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>

                                Reject
                            </button>
                        </div>

                        <div
                            v-else
                            class="mt-5 rounded-lg border px-4 py-3 text-sm"
                            :class="reviewedMessageClass(document.statut)"
                        >
                            This document has already been reviewed.
                            Current status:

                            <strong>
                                {{ statusLabel(document.statut) }}
                            </strong>
                        </div>
                    </section>
                </div>

                <!-- Intern information -->
                <aside>
                    <section
                        class="overflow-hidden rounded-xl border border-[#A9CEDB]/80 bg-white shadow-sm"
                    >
                        <div
                            class="h-1 bg-gradient-to-r from-[#39719F] to-[#60ADC6]"
                        ></div>

                        <div class="p-6">
                            <h2
                                class="text-base font-semibold text-[#072B4E]"
                            >
                                Intern
                            </h2>

                            <div class="mt-5">
                                <div
                                    class="flex h-12 w-12 items-center justify-center rounded-full bg-[#39719F] text-lg font-bold text-white"
                                >
                                    {{
                                        internName()
                                            .charAt(0)
                                            .toUpperCase()
                                    }}
                                </div>

                                <p
                                    class="mt-3 text-sm font-semibold text-[#072B4E]"
                                >
                                    {{ internName() }}
                                </p>

                                <a
                                    v-if="internEmail()"
                                    :href="`mailto:${internEmail()}`"
                                    class="mt-1 block break-all text-xs text-[#39719F] transition hover:text-[#072B4E] hover:underline"
                                >
                                    {{ internEmail() }}
                                </a>
                            </div>

                            <div
                                class="mt-5 border-t border-[#A9CEDB]/60 pt-5"
                            >
                                <p
                                    class="text-xs font-semibold uppercase tracking-wide text-[#60ADC6]"
                                >
                                    Internship
                                </p>

                                <p class="mt-1 text-sm text-[#507291]">
                                    {{ document.stage?.sujet ?? '—' }}
                                </p>
                            </div>
                        </div>
                    </section>
                </aside>
            </div>
        </div>
    </EncadrantLayout>
</template>
```
