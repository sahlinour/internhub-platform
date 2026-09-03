<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import AdminLayout from '@/Components/Admin/AdminLayout.vue'

defineProps({
    entreprises: {
        type: Array,
        default: () => [],
    },
})

const form = useForm({
    titre: '',
    description: '',
    duree: '',
    date_limite: '',
    statut: 'active',
    idUtilisateur_Entreprise: '',
})

const submit = () => {
    form.post(route('admin.offres.store'), {
        preserveScroll: true,
    })
}
</script>

<template>
    <Head title="Post Internship Offer" />

    <AdminLayout>
        <div class="mx-auto w-full max-w-[950px]">

            <header
                class="mb-6 flex items-center justify-between gap-4
                       max-[700px]:flex-col
                       max-[700px]:items-start"
            >
                <div>
                    <h1 class="text-[22px] font-bold text-[#20394b]">
                        Post Internship Offer
                    </h1>

                    <p class="mt-1 text-[11px] text-[#8798a6]">
                        Create a new internship opportunity.
                    </p>
                </div>

                <Link
                    :href="route('admin.offres.index')"
                    class="inline-flex min-h-[38px]
                           items-center justify-center
                           rounded-lg
                           border border-[#dce5eb]
                           bg-white px-4
                           text-[10px] font-semibold
                           text-[#536f80]
                           no-underline
                           transition
                           hover:bg-[#f5f8fa]"
                >
                    Back
                </Link>
            </header>

            <form
                class="space-y-5"
                @submit.prevent="submit"
            >
                <section
                    class="rounded-xl
                           border border-[#e3eaef]
                           bg-white p-5
                           shadow-sm"
                >
                    <div class="mb-5">
                        <h2
                            class="text-[14px]
                                   font-bold text-[#294355]"
                        >
                            Offer Information
                        </h2>

                        <p class="mt-1 text-[9px] text-[#91a0ab]">
                            Fill in the internship offer details.
                        </p>
                    </div>

                    <div
                        class="grid grid-cols-2 gap-4
                               max-[700px]:grid-cols-1"
                    >
                        <!-- TITLE -->
                        <div
                            class="col-span-2
                                   max-[700px]:col-span-1"
                        >
                            <label
                                class="mb-1.5 block
                                       text-[10px] font-semibold
                                       text-[#4b6576]"
                            >
                                Offer Title
                            </label>

                            <input
                                v-model="form.titre"
                                type="text"
                                placeholder="Full Stack Developer Internship"
                                class="w-full rounded-lg
                                       border border-[#dce5eb]
                                       px-3 py-2.5
                                       text-[11px]
                                       text-[#40596b]
                                       outline-none
                                       focus:border-[#6694ad]
                                       focus:ring-[3px]
                                       focus:ring-[#326d8b]/10"
                            />

                            <p
                                v-if="form.errors.titre"
                                class="mt-1 text-[9px] text-red-500"
                            >
                                {{ form.errors.titre }}
                            </p>
                        </div>

                        <!-- COMPANY -->
                        <div>
                            <label
                                class="mb-1.5 block
                                       text-[10px] font-semibold
                                       text-[#4b6576]"
                            >
                                Company
                            </label>

                            <select
                                v-model="form.idUtilisateur_Entreprise"
                                class="w-full rounded-lg
                                       border border-[#dce5eb]
                                       bg-white px-3 py-2.5
                                       text-[11px]
                                       text-[#40596b]"
                            >
                                <option value="">
                                    Select a company
                                </option>

                                <option
                                    v-for="entreprise in entreprises"
                                    :key="entreprise.user_id"
                                    :value="entreprise.user_id"
                                >
                                    {{
                                        entreprise.user?.nom_complet
                                        ?? 'Company'
                                    }}
                                </option>
                            </select>

                            <p
                                v-if="form.errors.idUtilisateur_Entreprise"
                                class="mt-1 text-[9px] text-red-500"
                            >
                                {{ form.errors.idUtilisateur_Entreprise }}
                            </p>
                        </div>

                        <div>
                                <label
                                    class="mb-1.5 block text-[10px] font-semibold text-[#4b6576]"
                                >
                                    Duration
                                </label>

                                <input
                                    v-model="form.duree"
                                    type="text"
                                    required
                                    placeholder="Example: 3 months"
                                    class="w-full rounded-lg
                                        border border-[#dce5eb]
                                        px-3 py-2.5
                                        text-[11px]
                                        text-[#40596b]"
                                />

                                <p
                                    v-if="form.errors.duree"
                                    class="mt-1 text-[9px] text-red-500"
                                >
                                    {{ form.errors.duree }}
                                </p>
                            </div>

                        <!-- DEADLINE -->
                        <div>
                            <label
                                class="mb-1.5 block
                                       text-[10px] font-semibold
                                       text-[#4b6576]"
                            >
                                Application Deadline
                            </label>

                            <input
                                v-model="form.date_limite"
                                type="date"
                                class="w-full rounded-lg
                                       border border-[#dce5eb]
                                       px-3 py-2.5
                                       text-[11px]
                                       text-[#40596b]"
                            />

                            <p
                                v-if="form.errors.date_limite"
                                class="mt-1 text-[9px] text-red-500"
                            >
                                {{ form.errors.date_limite }}
                            </p>
                        </div>

                        <!-- STATUS -->
                        <div>
                            <label
                                class="mb-1.5 block
                                       text-[10px] font-semibold
                                       text-[#4b6576]"
                            >
                                Status
                            </label>

                            <select
                                v-model="form.statut"
                                class="w-full rounded-lg
                                       border border-[#dce5eb]
                                       bg-white px-3 py-2.5
                                       text-[11px]
                                       text-[#40596b]"
                            >
                                <option value="active">
                                    Active
                                </option>

                                <option value="inactive">
                                    Inactive
                                </option>

                                <option value="closed">
                                    Closed
                                </option>
                            </select>

                            <p
                                v-if="form.errors.statut"
                                class="mt-1 text-[9px] text-red-500"
                            >
                                {{ form.errors.statut }}
                            </p>
                        </div>

                        <!-- DESCRIPTION -->
                        <div
                            class="col-span-2
                                   max-[700px]:col-span-1"
                        >
                            <label
                                class="mb-1.5 block
                                       text-[10px] font-semibold
                                       text-[#4b6576]"
                            >
                                Description
                            </label>

                            <textarea
                                v-model="form.description"
                                rows="6"
                                placeholder="Describe the internship opportunity..."
                                class="w-full resize-none
                                       rounded-lg
                                       border border-[#dce5eb]
                                       px-3 py-2.5
                                       text-[11px]
                                       text-[#40596b]
                                       outline-none
                                       focus:border-[#6694ad]
                                       focus:ring-[3px]
                                       focus:ring-[#326d8b]/10"
                            />

                            <p
                                v-if="form.errors.description"
                                class="mt-1 text-[9px] text-red-500"
                            >
                                {{ form.errors.description }}
                            </p>
                        </div>
                    </div>
                </section>

                <div class="flex justify-end gap-3">
                    <Link
                        :href="route('admin.offres.index')"
                        class="inline-flex min-h-[40px]
                               items-center justify-center
                               rounded-lg
                               border border-[#dce5eb]
                               bg-white px-5
                               text-[10px] font-semibold
                               text-[#536f80]
                               no-underline"
                    >
                        Cancel
                    </Link>

                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="inline-flex min-h-[40px]
                               items-center justify-center
                               rounded-lg
                               bg-[#174966] px-5
                               text-[10px] font-semibold
                               text-white
                               transition
                               hover:bg-[#123e57]
                               disabled:opacity-60"
                    >
                        {{
                            form.processing
                                ? 'Posting...'
                                : 'Post Offer'
                        }}
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
