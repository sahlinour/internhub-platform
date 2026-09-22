<script setup>
import { computed } from 'vue'
import { Head, useForm } from '@inertiajs/vue3'
import EncadrantLayout from '@/Layouts/EncadrantLayout.vue'

const props = defineProps({
    stages: {
        type: Array,
        default: () => [],
    },

    selectedStageId: {
        type: [String, Number],
        default: '',
    },
})

const form = useForm({
    titre: '',
    description: '',
    priorite: 'Moyenne',
    date_echeance: '',
    id_Stage: props.selectedStageId || '',
})

const selectedStage = computed(() => {
    return props.stages.find(
        stage => String(stage.id) === String(form.id_Stage)
    )
})

const internName = (stage) => {
    return stage?.candidature
        ?.stagiaire
        ?.user
        ?.nom_complet ?? 'Unknown Intern'
}

const internshipTitle = (stage) => {
    return (
        stage?.sujet ??
        stage?.candidature?.offre_de_stage?.titre ??
        'Internship'
    )
}

const submit = () => {
    form.post(route('encadrant.taches.store'))
}

const saveDraft = () => {
    // We can connect this later if your DB supports a draft status.
    console.log('Save draft')
}
</script>

<template>
    <Head title="Assign Task" />

    <!--
        EncadrantLayout already contains:
        - sidebar
        - header
        - main content area
    -->
    <EncadrantLayout>

        <div class="mx-auto w-full max-w-5xl">

            <!-- PAGE HEADER -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-slate-900">
                    Assign Task
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Create a new task and assign it to one of your interns
                </p>
            </div>


            <!-- FORM CARD -->
            <form
                @submit.prevent="submit"
                class="rounded-2xl border border-slate-200
                       bg-white p-6 shadow-sm"
            >

                <!-- TASK TITLE -->
                <div class="mb-5">
                    <label
                        for="titre"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Task title
                    </label>

                    <input
                        id="titre"
                        v-model="form.titre"
                        type="text"
                        placeholder="e.g. Add pagination to the disputes dashboard"
                        class="w-full rounded-lg border border-slate-200
                               px-4 py-3 text-sm text-slate-700
                               outline-none transition
                               placeholder:text-slate-400
                               focus:border-blue-400
                               focus:ring-2 focus:ring-blue-100"
                    />

                    <p
                        v-if="form.errors.titre"
                        class="mt-1 text-sm text-red-500"
                    >
                        {{ form.errors.titre }}
                    </p>
                </div>


                <!-- DESCRIPTION -->
                <div class="mb-5">
                    <label
                        for="description"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Description
                    </label>

                    <textarea
                        id="description"
                        v-model="form.description"
                        rows="5"
                        placeholder="Describe what needs to be done, acceptance criteria, and any relevant context..."
                        class="w-full resize-none rounded-lg
                               border border-slate-200
                               px-4 py-3 text-sm text-slate-700
                               outline-none transition
                               placeholder:text-slate-400
                               focus:border-blue-400
                               focus:ring-2 focus:ring-blue-100"
                    />

                    <p
                        v-if="form.errors.description"
                        class="mt-1 text-sm text-red-500"
                    >
                        {{ form.errors.description }}
                    </p>
                </div>


                <!-- ASSIGN TO + PRIORITY -->
                <div class="mb-5 grid grid-cols-1 gap-4 md:grid-cols-2">

                    <!-- ASSIGN TO -->
                    <div>
                        <label
                            for="stage"
                            class="mb-2 block text-sm font-semibold text-slate-700"
                        >
                            Assign to
                        </label>

                        <select
                            id="stage"
                            v-model="form.id_Stage"
                            class="w-full rounded-lg border border-slate-200
                                   bg-white px-4 py-3 text-sm
                                   text-slate-700 outline-none
                                   focus:border-blue-400
                                   focus:ring-2 focus:ring-blue-100"
                        >
                            <option value="" disabled>
                                Select an intern
                            </option>

                            <option
                                v-for="stage in stages"
                                :key="stage.id"
                                :value="stage.id"
                            >
                                {{ internName(stage) }}
                                — {{ internshipTitle(stage) }}
                            </option>
                        </select>

                        <p
                            v-if="form.errors.id_Stage"
                            class="mt-1 text-sm text-red-500"
                        >
                            {{ form.errors.id_Stage }}
                        </p>
                    </div>


                    <!-- PRIORITY -->
                    <div>
                        <label
                            for="priorite"
                            class="mb-2 block text-sm font-semibold text-slate-700"
                        >
                            Priority
                        </label>

                        <select
                            id="priorite"
                            v-model="form.priorite"
                            class="w-full rounded-lg border border-slate-200
                                   bg-white px-4 py-3 text-sm
                                   text-slate-700 outline-none
                                   focus:border-blue-400
                                   focus:ring-2 focus:ring-blue-100"
                        >
                            <option value="Basse">
                                Low
                            </option>

                            <option value="Moyenne">
                                Medium
                            </option>

                            <option value="Haute">
                                High
                            </option>
                        </select>

                        <p
                            v-if="form.errors.priorite"
                            class="mt-1 text-sm text-red-500"
                        >
                            {{ form.errors.priorite }}
                        </p>
                    </div>

                </div>


                <!-- START DATE + DEADLINE -->
                <div class="mb-5 grid grid-cols-1 gap-4 md:grid-cols-2">

                    <div>
                        <label
                            class="mb-2 block text-sm font-semibold text-slate-700"
                        >
                            Starting Date
                        </label>

                        <div
                            class="flex h-[46px] items-center
                                   rounded-lg border border-slate-200
                                   bg-slate-50 px-4 text-sm text-slate-600"
                        >
                            {{
                                selectedStage?.date_debut
                                    ?? 'Select an intern'
                            }}
                        </div>
                    </div>


                    <div>
                        <label
                            for="date_echeance"
                            class="mb-2 block text-sm font-semibold text-slate-700"
                        >
                            Deadline
                        </label>

                        <input
                            id="date_echeance"
                            v-model="form.date_echeance"
                            type="date"
                            class="w-full rounded-lg border border-slate-200
                                   bg-white px-4 py-3 text-sm
                                   text-slate-700 outline-none
                                   focus:border-blue-400
                                   focus:ring-2 focus:ring-blue-100"
                        />

                        <p
                            v-if="form.errors.date_echeance"
                            class="mt-1 text-sm text-red-500"
                        >
                            {{ form.errors.date_echeance }}
                        </p>
                    </div>

                </div>


                <!-- SELECTED INTERN -->
                <div
                    v-if="selectedStage"
                    class="mb-5 rounded-xl border border-slate-100
                           bg-slate-50 px-4 py-3"
                >
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                        Selected intern
                    </p>

                    <p class="mt-1 text-sm font-semibold text-slate-800">
                        {{ internName(selectedStage) }}
                    </p>

                    <p class="mt-0.5 text-xs text-slate-500">
                        {{ internshipTitle(selectedStage) }}
                    </p>
                </div>


                <!-- ATTACHMENTS -->
                <div class="mb-6">
                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Attachments
                    </label>

                    <div
                        class="flex min-h-[110px] cursor-pointer
                               flex-col items-center justify-center
                               rounded-xl border border-dashed
                               border-slate-300 bg-slate-50/50
                               px-5 text-center
                               transition hover:bg-slate-50"
                    >
                        <p class="text-sm font-semibold text-slate-700">
                            Drag & drop files, or
                            <span class="text-blue-600">
                                browse
                            </span>
                        </p>

                        <p class="mt-1 text-xs text-slate-400">
                            Specs, mockups, reference docs — max 10MB each
                        </p>
                    </div>
                </div>


                <!-- ACTIONS -->
                <div
                    class="flex items-center justify-end gap-3
                           border-t border-slate-100 pt-5"
                >
                    <button
                        type="button"
                        @click="saveDraft"
                        class="rounded-lg border border-slate-200
                               bg-white px-5 py-2.5
                               text-sm font-semibold text-slate-700
                               transition hover:bg-slate-50"
                    >
                        Save as Draft
                    </button>

                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="rounded-lg bg-slate-900
                               px-6 py-2.5 text-sm font-semibold
                               text-white transition
                               hover:bg-slate-800
                               disabled:cursor-not-allowed
                               disabled:opacity-50"
                    >
                        <span v-if="form.processing">
                            Assigning...
                        </span>

                        <span v-else>
                            Assign Task
                        </span>
                    </button>
                </div>

            </form>

        </div>

    </EncadrantLayout>
</template>
