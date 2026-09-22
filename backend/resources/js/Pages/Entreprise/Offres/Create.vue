<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import EntrepriseLayout from '@/Layouts/EntrepriseLayout.vue'

const appRoute = (name, params = undefined) => {
    return route(name, params, false)
}

const form = useForm({
    titre: '',
    description: '',
    duree: '',
    date_limite: '',
    statut: 'ouverte',
})

const submit = () => {
    form.post(
        appRoute('entreprise.offres.store'),
        {
            preserveScroll: true,
        }
    )
}
</script>

<template>
    <Head title="Post Internship" />

    <EntrepriseLayout>
        <div class="mx-auto max-w-5xl">

            <!-- HEADER -->
            <div
                class="mb-6 flex flex-col gap-4
                       sm:flex-row
                       sm:items-center
                       sm:justify-between"
            >
                <div>
                    <h1
                        class="text-2xl
                               font-bold
                               text-slate-800"
                    >
                        Post New Internship
                    </h1>

                    <p
                        class="mt-1
                               text-sm
                               text-slate-400"
                    >
                        Create a new internship opportunity for students.
                    </p>
                </div>

                <Link
                    :href="
                        appRoute(
                            'entreprise.offres.index'
                        )
                    "
                    class="inline-flex
                           items-center
                           justify-center
                           rounded-lg
                           border
                           border-slate-200
                           bg-white
                           px-4 py-2.5
                           text-sm
                           font-semibold
                           text-slate-600
                           transition
                           hover:bg-slate-50"
                >
                    Back to Internships
                </Link>
            </div>

            <!-- FORM CARD -->
            <div
                class="rounded-2xl
                       border
                       border-slate-100
                       bg-white
                       p-6
                       shadow-sm
                       md:p-8"
            >
                <form
                    class="space-y-6"
                    @submit.prevent="submit"
                >

                    <!-- TITLE -->
                    <div>
                        <label
                            for="titre"
                            class="mb-2 block
                                   text-sm
                                   font-semibold
                                   text-slate-700"
                        >
                            Internship Title
                        </label>

                        <input
                            id="titre"
                            v-model="form.titre"
                            type="text"
                            placeholder="e.g. Frontend Developer Internship"
                            class="w-full
                                   rounded-xl
                                   border
                                   border-slate-200
                                   px-4 py-3
                                   text-sm
                                   text-slate-700
                                   outline-none
                                   transition
                                   focus:border-[#63A9C6]
                                   focus:ring-2
                                   focus:ring-[#63A9C6]/10"
                        />

                        <p
                            v-if="form.errors.titre"
                            class="mt-1.5
                                   text-xs
                                   text-red-500"
                        >
                            {{ form.errors.titre }}
                        </p>
                    </div>

                    <!-- DESCRIPTION -->
                    <div>
                        <label
                            for="description"
                            class="mb-2 block
                                   text-sm
                                   font-semibold
                                   text-slate-700"
                        >
                            Description
                        </label>

                        <textarea
                            id="description"
                            v-model="form.description"
                            rows="7"
                            placeholder="Describe the internship responsibilities, requirements and objectives..."
                            class="w-full
                                   resize-none
                                   rounded-xl
                                   border
                                   border-slate-200
                                   px-4 py-3
                                   text-sm
                                   text-slate-700
                                   outline-none
                                   transition
                                   focus:border-[#63A9C6]
                                   focus:ring-2
                                   focus:ring-[#63A9C6]/10"
                        />

                        <p
                            v-if="form.errors.description"
                            class="mt-1.5
                                   text-xs
                                   text-red-500"
                        >
                            {{ form.errors.description }}
                        </p>
                    </div>

                    <div
                        class="grid
                               grid-cols-1
                               gap-5
                               md:grid-cols-2"
                    >
                        <!-- DURATION -->
                        <div>
                            <label
                                for="duree"
                                class="mb-2 block
                                       text-sm
                                       font-semibold
                                       text-slate-700"
                            >
                                Duration
                            </label>

                            <input
                                id="duree"
                                v-model="form.duree"
                                type="text"
                                placeholder="e.g. 3 months"
                                class="w-full
                                       rounded-xl
                                       border
                                       border-slate-200
                                       px-4 py-3
                                       text-sm
                                       text-slate-700
                                       outline-none
                                       transition
                                       focus:border-[#63A9C6]
                                       focus:ring-2
                                       focus:ring-[#63A9C6]/10"
                            />

                            <p
                                v-if="form.errors.duree"
                                class="mt-1.5
                                       text-xs
                                       text-red-500"
                            >
                                {{ form.errors.duree }}
                            </p>
                        </div>

                        <!-- DEADLINE -->
                        <div>
                            <label
                                for="date_limite"
                                class="mb-2 block
                                       text-sm
                                       font-semibold
                                       text-slate-700"
                            >
                                Application Deadline
                            </label>

                            <input
                                id="date_limite"
                                v-model="form.date_limite"
                                type="date"
                                class="w-full
                                       rounded-xl
                                       border
                                       border-slate-200
                                       px-4 py-3
                                       text-sm
                                       text-slate-700
                                       outline-none
                                       transition
                                       focus:border-[#63A9C6]
                                       focus:ring-2
                                       focus:ring-[#63A9C6]/10"
                            />

                            <p
                                v-if="form.errors.date_limite"
                                class="mt-1.5
                                       text-xs
                                       text-red-500"
                            >
                                {{ form.errors.date_limite }}
                            </p>
                        </div>
                    </div>

                    <!-- STATUS -->
                    <div>
                        <label
                            for="statut"
                            class="mb-2 block
                                   text-sm
                                   font-semibold
                                   text-slate-700"
                        >
                            Status
                        </label>

                        <select
                            id="statut"
                            v-model="form.statut"
                            class="w-full
                                   rounded-xl
                                   border
                                   border-slate-200
                                   bg-white
                                   px-4 py-3
                                   text-sm
                                   text-slate-700
                                   outline-none
                                   transition
                                   focus:border-[#63A9C6]
                                   focus:ring-2
                                   focus:ring-[#63A9C6]/10"
                        >
                            <option value="ouverte">
                                Open
                            </option>
                            <option value="en_attente">
                                Pending
                            </option>
                            <option value="fermee">
                                Closed
                            </option>
                        </select>

                        <p
                            v-if="form.errors.statut"
                            class="mt-1.5
                                   text-xs
                                   text-red-500"
                        >
                            {{ form.errors.statut }}
                        </p>
                    </div>

                    <!-- ACTIONS -->
                    <div
                        class="flex
                               items-center
                               justify-end
                               gap-3
                               border-t
                               border-slate-100
                               pt-6"
                    >
                        <Link
                            :href="
                                appRoute(
                                    'entreprise.offres.index'
                                )
                            "
                            class="rounded-lg
                                   border
                                   border-slate-200
                                   px-5 py-2.5
                                   text-sm
                                   font-semibold
                                   text-slate-600
                                   transition
                                   hover:bg-slate-50"
                        >
                            Cancel
                        </Link>

                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="rounded-lg
                                   bg-[#102F42]
                                   px-6 py-2.5
                                   text-sm
                                   font-semibold
                                   text-white
                                   transition
                                   hover:bg-[#174E6D]
                                   disabled:cursor-not-allowed
                                   disabled:opacity-50"
                        >
                            {{
                                form.processing
                                    ? 'Posting...'
                                    : 'Post Internship'
                            }}
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </EntrepriseLayout>
</template>
