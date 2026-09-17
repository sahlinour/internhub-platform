<script setup>
import { Head, Link, router } from '@inertiajs/vue3'
import EncadrantLayout from '@/Layouts/EncadrantLayout.vue'

const props = defineProps({
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

const deleteTask = (id) => {
    if (confirm('Are you sure you want to delete this task?')) {
        router.delete(`/encadrant/taches/${id}`, {
            preserveScroll: true,
        })
    }
}

const statusClass = (status) => {
    switch (status) {
        case 'À faire':
            return 'bg-gray-100 text-gray-700'
        case 'En cours':
            return 'bg-blue-100 text-blue-700'
        case 'Terminée':
            return 'bg-green-100 text-green-700'
        case 'Annulée':
            return 'bg-red-100 text-red-700'
        default:
            return 'bg-gray-100 text-gray-700'
    }
}

const priorityClass = (priority) => {
    switch (priority) {
        case 'Urgente':
            return 'text-red-600'
        case 'Haute':
            return 'text-orange-600'
        case 'Moyenne':
            return 'text-yellow-600'
        case 'Basse':
            return 'text-green-600'
        default:
            return 'text-gray-600'
    }
}
</script>

<template>
    <Head title="Assign Tasks" />

    <EncadrantLayout>
        <div class="p-6">

            <!-- Header -->
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">
                        Assign Tasks
                    </h1>

                    <p class="mt-1 text-sm text-gray-500">
                        Create and manage tasks assigned to your interns.
                    </p>
                </div>

                <Link
                    href="/encadrant/taches/create"
                    class="rounded-lg bg-[#17629b] px-4 py-2.5
                           text-sm font-medium text-white
                           transition hover:bg-[#0f4f7e]"
                >
                    + Assign New Task
                </Link>
            </div>

            <!-- Empty state -->
            <div
                v-if="!taches.data || taches.data.length === 0"
                class="rounded-xl border border-gray-200 bg-white
                       px-6 py-16 text-center shadow-sm"
            >
                <div
                    class="mx-auto mb-4 flex h-12 w-12 items-center
                           justify-center rounded-full bg-blue-50"
                >
                    <svg
                        class="h-6 w-6 text-[#17629b]"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="1.7"
                            d="M9 11l3 3L22 4
                               M21 12v7a2 2 0 01-2 2H5
                               a2 2 0 01-2-2V5
                               a2 2 0 012-2h11"
                        />
                    </svg>
                </div>

                <h2 class="font-semibold text-gray-900">
                    No tasks assigned yet
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Start by assigning a task to one of your interns.
                </p>

                <Link
                    href="/encadrant/taches/create"
                    class="mt-5 inline-block rounded-lg bg-[#17629b]
                           px-4 py-2 text-sm font-medium text-white
                           hover:bg-[#0f4f7e]"
                >
                    Assign Task
                </Link>
            </div>

            <!-- Tasks -->
            <div
                v-else
                class="overflow-hidden rounded-xl border
                       border-gray-200 bg-white shadow-sm"
            >
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">

                        <thead class="border-b bg-gray-50 text-gray-600">
                            <tr>
                                <th class="px-5 py-3 font-medium">Task</th>
                                <th class="px-5 py-3 font-medium">Intern</th>
                                <th class="px-5 py-3 font-medium">Priority</th>
                                <th class="px-5 py-3 font-medium">Due Date</th>
                                <th class="px-5 py-3 font-medium">Status</th>
                                <th class="px-5 py-3 text-right font-medium">
                                    Actions
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">
                            <tr
                                v-for="task in taches.data"
                                :key="task.id"
                                class="hover:bg-gray-50"
                            >
                                <td class="px-5 py-4">
                                    <p class="font-medium text-gray-900">
                                        {{ task.titre }}
                                    </p>

                                    <p
                                        v-if="task.description"
                                        class="mt-1 max-w-xs truncate
                                               text-xs text-gray-500"
                                    >
                                        {{ task.description }}
                                    </p>
                                </td>

                                <td class="px-5 py-4 text-gray-700">
                                    {{
                                        task.stage?.candidature?.stagiaire
                                            ?.user?.nom_complet ?? '—'
                                    }}
                                </td>

                                <td
                                    class="px-5 py-4 font-medium"
                                    :class="priorityClass(task.priorite)"
                                >
                                    {{ task.priorite }}
                                </td>

                                <td class="px-5 py-4 text-gray-600">
                                    {{ task.date_echeance ?? '—' }}
                                </td>

                                <td class="px-5 py-4">
                                    <span
                                        class="rounded-full px-2.5 py-1
                                               text-xs font-medium"
                                        :class="statusClass(task.statut)"
                                    >
                                        {{ task.statut }}
                                    </span>
                                </td>

                                <td class="px-5 py-4 text-right">
                                    <button
                                        type="button"
                                        class="text-sm font-medium
                                               text-red-600 hover:text-red-800"
                                        @click="deleteTask(task.id)"
                                    >
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
                v-if="taches.links && taches.links.length > 3"
                class="mt-6 flex flex-wrap justify-center gap-1"
            >
                <Link
                    v-for="link in taches.links"
                    :key="link.label"
                    :href="link.url || '#'"
                    v-html="link.label"
                    class="rounded border px-3 py-2 text-sm"
                    :class="[
                        link.active
                            ? 'border-[#17629b] bg-[#17629b] text-white'
                            : 'border-gray-200 bg-white text-gray-600',
                        !link.url
                            ? 'pointer-events-none opacity-50'
                            : 'hover:bg-gray-50',
                    ]"
                />
            </div>

        </div>
    </EncadrantLayout>
</template>
