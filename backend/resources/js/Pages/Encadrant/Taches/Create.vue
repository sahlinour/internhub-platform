<script setup>
import { computed } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import EncadrantLayout from '@/Layouts/EncadrantLayout.vue';

const props = defineProps({
    stages: {
        type: Array,
        default: () => [],
    },
    selectedStageId: {
        type: [String, Number],
        default: '',
    },
});

const today = new Date();
const localToday = [
    today.getFullYear(),
    String(today.getMonth() + 1).padStart(2, '0'),
    String(today.getDate()).padStart(2, '0'),
].join('-');

const form = useForm({
    titre: '',
    description: '',
    priorite: 'Moyenne',
    id_Stage: props.selectedStageId || '',
    date_debut: '',
    date_echeance: '',
});

const selectedStage = computed(() =>
    props.stages.find(stage => String(stage.id) === String(form.id_Stage))
);

const internName = stage =>
    stage?.candidature?.stagiaire?.user?.nom_complet ?? 'Unknown intern';

const internshipTitle = stage =>
    stage?.sujet ??
    stage?.candidature?.offre_de_stage?.titre ??
    'Internship';

const submit = () => {
    form.post(route('encadrant.taches.store'));
};
</script>

<template>
    <Head title="Assign Task" />

    <EncadrantLayout>
        <div class="mx-auto w-full max-w-5xl">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-slate-900">Assign Task</h1>
                <p class="mt-1 text-sm text-slate-500">
                    Create a new task and assign it to one of your interns
                </p>
            </div>

            <form
                class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm"
                @submit.prevent="submit"
            >
                <div class="mb-5">
                    <label for="titre" class="mb-2 block text-sm font-semibold text-slate-700">
                        Task title
                    </label>
                    <input
                        id="titre"
                        v-model="form.titre"
                        type="text"
                        required
                        maxlength="255"
                        placeholder="e.g. Add pagination to the dashboard"
                        class="w-full rounded-lg border border-slate-200 px-4 py-3 text-sm text-slate-700 outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-100"
                    />
                    <p v-if="form.errors.titre" class="mt-1 text-sm text-red-500">
                        {{ form.errors.titre }}
                    </p>
                </div>

                <div class="mb-5">
                    <label for="description" class="mb-2 block text-sm font-semibold text-slate-700">
                        Description
                    </label>
                    <textarea
                        id="description"
                        v-model="form.description"
                        rows="5"
                        placeholder="Describe what needs to be done..."
                        class="w-full resize-none rounded-lg border border-slate-200 px-4 py-3 text-sm text-slate-700 outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-100"
                    />
                    <p v-if="form.errors.description" class="mt-1 text-sm text-red-500">
                        {{ form.errors.description }}
                    </p>
                </div>

                <div class="mb-5 grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label for="stage" class="mb-2 block text-sm font-semibold text-slate-700">
                            Assign to
                        </label>
                        <select
                            id="stage"
                            v-model="form.id_Stage"
                            required
                            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-blue-400 focus:ring-2 focus:ring-blue-100"
                        >
                            <option value="" disabled>Select an intern</option>
                            <option v-for="stage in stages" :key="stage.id" :value="stage.id">
                                {{ internName(stage) }} — {{ internshipTitle(stage) }}
                            </option>
                        </select>
                        <p v-if="form.errors.id_Stage" class="mt-1 text-sm text-red-500">
                            {{ form.errors.id_Stage }}
                        </p>
                    </div>

                    <div>
                        <label for="priorite" class="mb-2 block text-sm font-semibold text-slate-700">
                            Priority
                        </label>
                        <select
                            id="priorite"
                            v-model="form.priorite"
                            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-blue-400 focus:ring-2 focus:ring-blue-100"
                        >
                            <option value="Low">Low</option>
                            <option value="Medium">Medium</option>
                            <option value="High">High</option>
                            <option value="Urgent">Urgent</option>
                        </select>
                        <p v-if="form.errors.priorite" class="mt-1 text-sm text-red-500">
                            {{ form.errors.priorite }}
                        </p>
                    </div>
                </div>

                <div class="mb-5 grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label for="date_debut" class="mb-2 block text-sm font-semibold text-slate-700">
                            Starting Date
                        </label>
                        <input
                            id="date_debut"
                            v-model="form.date_debut"
                            type="date"
                            :min="localToday"
                            required
                            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-blue-400 focus:ring-2 focus:ring-blue-100"
                        />
                        <p v-if="form.errors.date_debut" class="mt-1 text-sm text-red-500">
                            {{ form.errors.date_debut }}
                        </p>
                    </div>

                    <div>
                        <label for="date_echeance" class="mb-2 block text-sm font-semibold text-slate-700">
                            Deadline
                        </label>
                        <input
                            id="date_echeance"
                            v-model="form.date_echeance"
                            type="date"
                            :min="form.date_debut || localToday"
                            required
                            class="w-full rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm text-slate-700 focus:border-blue-400 focus:ring-2 focus:ring-blue-100"
                        />
                        <p v-if="form.errors.date_echeance" class="mt-1 text-sm text-red-500">
                            {{ form.errors.date_echeance }}
                        </p>
                    </div>
                </div>

                <div
                    v-if="selectedStage"
                    class="mb-6 rounded-xl border border-slate-100 bg-slate-50 px-4 py-3"
                >
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                        Selected intern
                    </p>
                    <p class="mt-1 text-sm font-semibold text-slate-800">
                        {{ internName(selectedStage) }}
                    </p>
                    <p class="text-xs text-slate-500">
                        {{ internshipTitle(selectedStage) }}
                    </p>
                </div>

                <div class="flex justify-end border-t border-slate-100 pt-5">
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="rounded-lg bg-slate-900 px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800 disabled:cursor-not-allowed disabled:opacity-50"
                    >
                        {{ form.processing ? 'Assigning...' : 'Assign Task' }}
                    </button>
                </div>
            </form>
        </div>
    </EncadrantLayout>
</template>
