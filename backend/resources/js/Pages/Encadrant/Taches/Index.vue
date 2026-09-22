<script setup>
import { Head, Link, router } from '@inertiajs/vue3'

import EncadrantLayout from '@/Layouts/EncadrantLayout.vue'

defineProps({
    taches: {
        type: Object,
        required: true,
    },

    stages: {
        type: Array,
        default: () => [],
    },

    filters: {
        type: Object,
        default: () => ({}),
    },
})

const deleteTask = (task) => {
    if (!task?.id) return

    const confirmed = window.confirm(
        `Are you sure you want to delete "${task.titre}"?`
    )

    if (!confirmed) return

    router.delete(
        route('encadrant.taches.destroy', {
            id: task.id,
        }),
        {
            preserveScroll: true,
        }
    )
}

const normalizeValue = (value) => {
    return String(value ?? '')
        .trim()
        .toLowerCase()
}

const statusClass = (status) => {
    const value = normalizeValue(status)

    if (['à faire', 'a faire', 'todo', 'pending'].includes(value)) {
        return 'bg-slate-100 text-slate-700'
    }

    if (['en cours', 'in progress', 'in_progress'].includes(value)) {
        return 'bg-[#eaf4fb] text-[#17629b]'
    }

    if (
        ['terminée', 'terminee', 'completed', 'done'].includes(value)
    ) {
        return 'bg-emerald-50 text-emerald-700'
    }

    if (
        ['annulée', 'annulee', 'cancelled', 'canceled'].includes(value)
    ) {
        return 'bg-red-50 text-red-700'
    }

    return 'bg-slate-100 text-slate-600'
}

const priorityClass = (priority) => {
    const value = normalizeValue(priority)

    if (['urgente', 'urgent'].includes(value)) {
        return 'text-red-600'
    }

    if (['haute', 'high'].includes(value)) {
        return 'text-orange-600'
    }

    if (['moyenne', 'medium'].includes(value)) {
        return 'text-amber-600'
    }

    if (['basse', 'low'].includes(value)) {
        return 'text-emerald-600'
    }

    return 'text-slate-600'
}
</script>

<template>
    <Head title="Assign Tasks" />

    <EncadrantLayout>
        <div class="mx-auto max-w-[1500px] p-6">
            <!-- Header -->
            <div
                class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
            >
                <div>
                    <h1 class="text-2xl font-bold text-[#17629b]">
                        Assign Tasks
                    </h1>

                    <p class="mt-1 text-sm text-slate-500">
                        Create and manage tasks assigned to your interns.
                    </p>
                </div>

                <Link
                    :href="route('encadrant.taches.create')"
                    class="inline-flex w-fit items-center justify-center gap-2 rounded-lg bg-[#17629b] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#124f7d] focus:outline-none focus:ring-2 focus:ring-[#17629b]/30"
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
                            d="M12 5v14M5 12h14"
                        />
                    </svg>

                    Assign New Task
                </Link>
            </div>

            <!-- Empty state -->
            <div
                v-if="!taches.data?.length"
                class="rounded-xl border border-[#d8e8f3] bg-white px-6 py-16 text-center shadow-sm"
            >
                <div
                    class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-[#eaf4fb]"
                >
                    <svg
                        class="h-6 w-6 text-[#17629b]"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.7"
                        aria-hidden="true"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9 11l3 3L22 4M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"
                        />
                    </svg>
                </div>

                <h2 class="font-semibold text-[#17629b]">
                    No tasks assigned yet
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Start by assigning a task to one of your interns.
                </p>

                <Link
                    :href="route('encadrant.taches.create')"
                    class="mt-5 inline-flex items-center justify-center rounded-lg bg-[#17629b] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#124f7d] focus:outline-none focus:ring-2 focus:ring-[#17629b]/30"
                >
                    Assign Task
                </Link>
            </div>

            <!-- Tasks table -->
            <div
                v-else
                class="overflow-hidden rounded-xl border border-[#d8e8f3] bg-white shadow-sm"
            >
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[850px] text-left text-sm">
                        <thead
                            class="border-b border-[#d8e8f3] bg-[#f5faff] text-[#17629b]"
                        >
                            <tr>
                                <th class="px-5 py-3 font-semibold">
                                    Task
                                </th>

                                <th class="px-5 py-3 font-semibold">
                                    Intern
                                </th>

                                <th class="px-5 py-3 font-semibold">
                                    Priority
                                </th>

                                <th class="px-5 py-3 font-semibold">
                                    Due Date
                                </th>

                                <th class="px-5 py-3 font-semibold">
                                    Status
                                </th>

                                <th class="px-5 py-3 text-right font-semibold">
                                    Actions
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-[#eaf4fb]">
                            <tr
                                v-for="task in taches.data"
                                :key="task.id"
                                class="transition hover:bg-[#f8fbfd]"
                            >
                                <td class="px-5 py-4">
                                    <p class="font-semibold text-[#124f7d]">
                                        {{ task.titre }}
                                    </p>

                                    <p
                                        v-if="task.description"
                                        class="mt-1 max-w-xs truncate text-xs text-slate-500"
                                        :title="task.description"
                                    >
                                        {{ task.description }}
                                    </p>
                                </td>

                                <td class="px-5 py-4 text-slate-700">
                                    {{
                                        task.stage?.candidature?.stagiaire
                                            ?.user?.nom_complet ?? '—'
                                    }}
                                </td>

                                <td
                                    class="px-5 py-4 font-semibold"
                                    :class="priorityClass(task.priorite)"
                                >
                                    {{ task.priorite ?? '—' }}
                                </td>

                                <td class="px-5 py-4 text-slate-600">
                                    {{ task.date_echeance ?? '—' }}
                                </td>

                                <td class="px-5 py-4">
                                    <span
                                        class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold"
                                        :class="statusClass(task.statut)"
                                    >
                                        {{ task.statut ?? 'Unknown' }}
                                    </span>
                                </td>

                                <td class="px-5 py-4 text-right">
                                    <button
                                        type="button"
                                        class="inline-flex items-center gap-1.5 rounded-lg border border-red-200 px-3 py-2 text-xs font-semibold text-red-600 transition hover:border-red-600 hover:bg-red-600 hover:text-white focus:outline-none focus:ring-2 focus:ring-red-200"
                                        @click="deleteTask(task)"
                                    >
                                        <svg
                                            class="h-4 w-4"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                            aria-hidden="true"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M3 6h18M8 6V4h8v2m-9 0 1 14h8l1-14M10 11v5M14 11v5"
                                            />
                                        </svg>

                                        Delete
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div
                v-if="taches.links?.length > 3"
                class="mt-6 flex flex-wrap justify-center gap-1.5"
            >
                <Link
                    v-for="(link, index) in taches.links"
                    :key="`${link.label}-${index}`"
                    :href="link.url || '#'"
                    preserve-scroll
                    class="inline-flex min-h-9 min-w-9 items-center justify-center rounded-lg border px-3 py-2 text-sm font-medium transition"
                    :class="[
                        link.active
                            ? 'border-[#17629b] bg-[#17629b] text-white'
                            : 'border-[#d8e8f3] bg-white text-slate-600 hover:border-[#17629b] hover:bg-[#eaf4fb] hover:text-[#17629b]',

                        !link.url
                            ? 'pointer-events-none opacity-40'
                            : '',
                    ]"
                    v-html="link.label"
                />
            </div>
        </div>
    </EncadrantLayout>
</template>
