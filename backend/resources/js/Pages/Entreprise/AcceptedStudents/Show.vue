<script setup>
import { computed } from 'vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import EntrepriseLayout from '@/Layouts/EntrepriseLayout.vue'

const props = defineProps({
    candidature: {
        type: Object,
        required: true,
    },

    encadrants: {
        type: Array,
        default: () => [],
    },
})

const appRoute = (name, params = undefined) =>
    route(name, params, false)

const student = computed(() =>
    props.candidature?.stagiaire?.user ?? {}
)

const stagiaire = computed(() =>
    props.candidature?.stagiaire ?? {}
)

const offer = computed(() =>
    props.candidature?.offre_de_stage ?? {}
)

const stage = computed(() =>
    props.candidature?.stage ?? null
)

const hasStage = computed(() => !!stage.value)

const stageForm = useForm({
    sujet: props.candidature?.offre_de_stage?.titre ?? '',
    date_debut: '',
    date_fin: '',
    id_Candidature: props.candidature.id,
    idUtilisateur_Encadrant: '',
})

const supervisorForm = useForm({
    idUtilisateur_Encadrant:
        props.candidature?.stage?.idUtilisateur_Encadrant ?? '',
})

const createStage = () => {
    stageForm.post(appRoute('entreprise.stages.store'), {
        preserveScroll: true,
    })
}

const assignSupervisor = () => {
    if (!stage.value) return

    supervisorForm.patch(
        appRoute('entreprise.stages.assignEncadrant', stage.value.id),
        {
            preserveScroll: true,
        }
    )
}
</script>

<template>
    <EntrepriseLayout>
        <Head title="Accepted Student" />

        <div class="min-h-screen bg-gray-50 p-8">

            <!-- Back -->
            <Link
                :href="appRoute('entreprise.acceptedStudents.index')"
                class="mb-6 inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-gray-900"
            >
                ← Back to Accepted Students
            </Link>

            <!-- Header -->
            <div class="mb-8 flex items-start justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">
                        {{ student.nom_complet }}
                    </h1>

                    <p class="mt-1 text-gray-500">
                        {{ student.email }}
                    </p>
                </div>

                <span
                    class="rounded-full px-4 py-2 text-sm font-medium"
                    :class="
                        hasStage
                            ? 'bg-emerald-50 text-emerald-700'
                            : 'bg-amber-50 text-amber-700'
                    "
                >
                    {{ hasStage ? 'Internship started' : 'Pending setup' }}
                </span>
            </div>

            <div class="grid gap-6 xl:grid-cols-3">

                <!-- LEFT -->
                <div class="space-y-6 xl:col-span-2">

                    <!-- Student -->
                    <section
                        class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm"
                    >
                        <h2 class="text-lg font-semibold text-gray-900">
                            Student Information
                        </h2>

                        <div class="mt-6 grid gap-6 md:grid-cols-2">
                            <div>
                                <p class="text-sm text-gray-500">
                                    Full name
                                </p>

                                <p class="mt-1 font-medium text-gray-900">
                                    {{ student.nom_complet || '—' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-500">
                                    Email
                                </p>

                                <p class="mt-1 font-medium text-gray-900">
                                    {{ student.email || '—' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-500">
                                    Phone
                                </p>

                                <p class="mt-1 font-medium text-gray-900">
                                    {{ student.telephone || '—' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-500">
                                    Internship offer
                                </p>

                                <p class="mt-1 font-medium text-gray-900">
                                    {{ offer.titre || '—' }}
                                </p>
                            </div>
                        </div>

                        <!-- Skills -->
                        <div class="mt-6">
                            <p class="mb-3 text-sm text-gray-500">
                                Skills
                            </p>

                            <div
                                v-if="stagiaire.competences?.length"
                                class="flex flex-wrap gap-2"
                            >
                                <span
                                    v-for="skill in stagiaire.competences"
                                    :key="skill.id"
                                    class="rounded-full bg-blue-50 px-3 py-1 text-sm font-medium text-blue-700"
                                >
                                    {{ skill.nom }}
                                </span>
                            </div>

                            <p
                                v-else
                                class="text-sm text-gray-400"
                            >
                                No skills added.
                            </p>
                        </div>
                    </section>

                    <!-- CREATE STAGE -->
                    <section
                        v-if="!hasStage"
                        class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm"
                    >
                        <h2 class="text-lg font-semibold text-gray-900">
                            Internship Setup
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            Configure the internship before starting it.
                        </p>

                        <form
                            class="mt-6 space-y-5"
                            @submit.prevent="createStage"
                        >
                            <!-- Subject -->
                            <div>
                                <label class="text-sm font-medium text-gray-700">
                                    Internship subject
                                </label>

                                <input
                                    v-model="stageForm.sujet"
                                    type="text"
                                    class="mt-2 w-full rounded-xl border-gray-300"
                                />

                                <p
                                    v-if="stageForm.errors.sujet"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ stageForm.errors.sujet }}
                                </p>
                            </div>

                            <!-- Dates -->
                            <div class="grid gap-5 md:grid-cols-2">
                                <div>
                                    <label class="text-sm font-medium text-gray-700">
                                        Start date
                                    </label>

                                    <input
                                        v-model="stageForm.date_debut"
                                        type="date"
                                        class="mt-2 w-full rounded-xl border-gray-300"
                                    />

                                    <p
                                        v-if="stageForm.errors.date_debut"
                                        class="mt-1 text-sm text-red-600"
                                    >
                                        {{ stageForm.errors.date_debut }}
                                    </p>
                                </div>

                                <div>
                                    <label class="text-sm font-medium text-gray-700">
                                        End date
                                    </label>

                                    <input
                                        v-model="stageForm.date_fin"
                                        type="date"
                                        class="mt-2 w-full rounded-xl border-gray-300"
                                    />

                                    <p
                                        v-if="stageForm.errors.date_fin"
                                        class="mt-1 text-sm text-red-600"
                                    >
                                        {{ stageForm.errors.date_fin }}
                                    </p>
                                </div>
                            </div>

                            <!-- Supervisor -->
                            <div>
                                <label class="text-sm font-medium text-gray-700">
                                    Company Supervisor
                                </label>

                                <select
                                    v-model="stageForm.idUtilisateur_Encadrant"
                                    class="mt-2 w-full rounded-xl border-gray-300"
                                >
                                    <option value="">
                                        No supervisor yet
                                    </option>

                                    <option
                                        v-for="encadrant in encadrants"
                                        :key="encadrant.user_id"
                                        :value="encadrant.user_id"
                                    >
                                        {{
                                            encadrant.user?.nom_complet
                                                ?? `Supervisor #${encadrant.user_id}`
                                        }}
                                    </option>
                                </select>

                                <p
                                    v-if="stageForm.errors.idUtilisateur_Encadrant"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{
                                        stageForm.errors
                                            .idUtilisateur_Encadrant
                                    }}
                                </p>
                            </div>

                            <div class="flex justify-end">
                                <button
                                    type="submit"
                                    :disabled="stageForm.processing"
                                    class="rounded-xl bg-[#153d55] px-5 py-3 text-sm font-semibold text-white hover:bg-[#102f42] disabled:opacity-50"
                                >
                                    {{
                                        stageForm.processing
                                            ? 'Starting...'
                                            : 'Start Internship'
                                    }}
                                </button>
                            </div>
                        </form>
                    </section>

                    <!-- EXISTING STAGE -->
                    <section
                        v-else
                        class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm"
                    >
                        <h2 class="text-lg font-semibold text-gray-900">
                            Internship
                        </h2>

                        <div class="mt-6 grid gap-6 md:grid-cols-3">
                            <div>
                                <p class="text-sm text-gray-500">
                                    Subject
                                </p>

                                <p class="mt-1 font-medium">
                                    {{ stage.sujet }}
                                </p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-500">
                                    Start date
                                </p>

                                <p class="mt-1 font-medium">
                                    {{ stage.date_debut }}
                                </p>
                            </div>

                            <div>
                                <p class="text-sm text-gray-500">
                                    End date
                                </p>

                                <p class="mt-1 font-medium">
                                    {{ stage.date_fin || 'Not set' }}
                                </p>
                            </div>
                        </div>

                        <form
                            class="mt-8"
                            @submit.prevent="assignSupervisor"
                        >
                            <label class="text-sm font-medium text-gray-700">
                                Assigned Supervisor
                            </label>

                            <div class="mt-2 flex gap-3">
                                <select
                                    v-model="supervisorForm.idUtilisateur_Encadrant"
                                    class="flex-1 rounded-xl border-gray-300"
                                >
                                    <option value="" disabled>
                                        Select a supervisor
                                    </option>

                                    <option
                                        v-for="encadrant in encadrants"
                                        :key="encadrant.user_id"
                                        :value="encadrant.user_id"
                                    >
                                        {{
                                            encadrant.user?.nom_complet
                                                ?? `Supervisor #${encadrant.user_id}`
                                        }}
                                    </option>
                                </select>

                                <button
                                    type="submit"
                                    :disabled="supervisorForm.processing"
                                    class="rounded-xl bg-[#153d55] px-5 py-2 font-medium text-white disabled:opacity-50"
                                >
                                    Update Supervisor
                                </button>
                            </div>

                            <p
                                v-if="
                                    supervisorForm.errors
                                        .idUtilisateur_Encadrant
                                "
                                class="mt-1 text-sm text-red-600"
                            >
                                {{
                                    supervisorForm.errors
                                        .idUtilisateur_Encadrant
                                }}
                            </p>
                        </form>
                    </section>
                </div>

                <!-- RIGHT -->
                <aside class="space-y-6">
                    <div
                        class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm"
                    >
                        <h3 class="font-semibold text-gray-900">
                            Application
                        </h3>

                        <div class="mt-5 space-y-4 text-sm">
                            <div>
                                <p class="text-gray-500">
                                    Status
                                </p>

                                <p class="mt-1 font-medium text-emerald-600">
                                    Accepted
                                </p>
                            </div>

                            <div>
                                <p class="text-gray-500">
                                    Applied on
                                </p>

                                <p class="mt-1 font-medium text-gray-900">
                                    {{
                                        candidature.date_postulation
                                            || '—'
                                    }}
                                </p>
                            </div>
                        </div>
                    </div>
                </aside>

            </div>
        </div>
    </EntrepriseLayout>
</template>
