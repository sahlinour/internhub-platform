<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import EncadrantLayout from '@/Layouts/EncadrantLayout.vue';

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
});

const deleteTask = (task) => {
    if (!task?.id) return;

    if (!window.confirm(`Are you sure you want to delete "${task.titre}"?`)) {
        return;
    }

    router.delete(route('encadrant.taches.destroy', { id: task.id }), {
        preserveScroll: true,
    });
};

const normalizeValue = (value) => String(value ?? '').trim().toLowerCase();

const formatDate = (value) => {
    if (!value) return '—';

    const [year, month, day] = String(value).slice(0, 10).split('-');

    return year && month && day ? `${day}/${month}/${year}` : '—';
};

const statusLabel = (status) => {
    const labels = {
        todo: 'To do',
        in_progress: 'In progress',
        completed: 'Completed',
        cancelled: 'Cancelled',

        // Anciennes tâches enregistrées en français
        a_faire: 'To do',
        en_cours: 'In progress',
        terminee: 'Completed',
        annulee: 'Cancelled',
    };

    return labels[normalizeValue(status)] ?? status ?? 'Unknown';
};

const statusClass = (status) => {
    switch (normalizeValue(status)) {
        case 'todo':
        case 'a_faire':
            return 'bg-slate-100 text-slate-700';

        case 'in_progress':
        case 'en_cours':
            return 'bg-[#eaf4fb] text-[#17629b]';

        case 'completed':
        case 'terminee':
            return 'bg-emerald-50 text-emerald-700';

        case 'cancelled':
        case 'annulee':
            return 'bg-red-50 text-red-700';

        default:
            return 'bg-slate-100 text-slate-600';
    }
};

const priorityLabel = (priority) => {
    const labels = {
        low: 'Low',
        medium: 'Medium',
        high: 'High',
        urgent: 'Urgent',

        // Anciennes tâches enregistrées en français
        basse: 'Low',
        moyenne: 'Medium',
        haute: 'High',
        urgente: 'Urgent',
    };

    return labels[normalizeValue(priority)] ?? priority ?? '—';
};

const priorityClass = (priority) => {
    switch (normalizeValue(priority)) {
        case 'urgent':
        case 'urgente':
            return 'text-red-600';

        case 'high':
        case 'haute':
            return 'text-orange-600';

        case 'medium':
        case 'moyenne':
            return 'text-amber-600';

        case 'low':
        case 'basse':
            return 'text-emerald-600';

        default:
            return 'text-slate-600';
    }
};
</script>

<template>
    <Head title="Assign Tasks" />

    <EncadrantLayout>
        <div class="mx-auto max-w-[1500px] p-6">
            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
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
                    class="inline-flex w-fit items-center justify-center gap-2 rounded-lg bg-[#17629b] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#124f7d]"
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

            <div
                v-if="!taches.data?.length"
                class="rounded-xl border border-[#d8e8f3] bg-white px-6 py-16 text-center shadow-sm"
            >
                <h2 class="font-semibold text-[#17629b]">
                    No tasks assigned yet
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Start by assigning a task to one of your interns.
                </p>

                <Link
                    :href="route('encadrant.taches.create')"
                    class="mt-5 inline-flex items-center justify-center rounded-lg bg-[#17629b] px-4 py-2.5 text-sm font-semibold text-white hover:bg-[#124f7d]"
                >
                    Assign Task
                </Link>
            </div>

            <div
                v-else
                class="overflow-hidden rounded-xl border border-[#d8e8f3] bg-white shadow-sm"
            >
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[950px] text-left text-sm">
                        <thead class="border-b border-[#d8e8f3] bg-[#f5faff] text-[#17629b]">
                            <tr>
                                <th class="px-5 py-3 font-semibold">Task</th>
                                <th class="px-5 py-3 font-semibold">Intern</th>
                                <th class="px-5 py-3 font-semibold">Priority</th>
                                <th class="px-5 py-3 font-semibold">Starting Date</th>
                                <th class="px-5 py-3 font-semibold">Due Date</th>
                                <th class="px-5 py-3 font-semibold">Status</th>
                                <th class="px-5 py-3 text-right font-semibold">Actions</th>
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
                                    {{ priorityLabel(task.priorite) }}
                                </td>

                                <td class="px-5 py-4 text-slate-600">
                                    {{ formatDate(task.date_debut) }}
                                </td>

                                <td class="px-5 py-4 text-slate-600">
                                    {{ formatDate(task.date_echeance) }}
                                </td>

                                <td class="px-5 py-4">
                                    <span
                                        class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold"
                                        :class="statusClass(task.statut)"
                                    >
                                        {{ statusLabel(task.statut) }}
                                    </span>
                                </td>

                                <td class="px-5 py-4 text-right">
                                    <button
                                        type="button"
                                        class="inline-flex items-center rounded-lg border border-red-200 px-3 py-2 text-xs font-semibold text-red-600 transition hover:border-red-600 hover:bg-red-600 hover:text-white"
                                        @click="deleteTask(task)"
                                    >
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

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
                        !link.url ? 'pointer-events-none opacity-40' : '',
                    ]"
                    v-html="link.label"
                />
            </div>
        </div>
    </EncadrantLayout>
</template>
