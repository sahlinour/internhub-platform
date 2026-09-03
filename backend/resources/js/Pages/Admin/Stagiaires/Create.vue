<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import AdminLayout from '@/Components/Admin/AdminLayout.vue'

const props = defineProps({
    villes: {
        type: Array,
        default: () => [],
    },
})

const form = useForm({
    nom_complet: '',
    email: '',
    telephone: '',
    ville_id: '',

    universite: '',
    filiere: '',
    niveau: '',
    date_naissance: '',

    statut_stage: 'recherche',

    linkedin_url: '',
    portfolio_url: '',

    password: '',
    password_confirmation: '',
})

const submit = () => {
    form.post(route('admin.stagiaires.store'), {
        preserveScroll: true,
    })
}
</script>

<template>
    <Head title="Add Intern" />

    <AdminLayout>
        <div class="mx-auto w-full max-w-[1000px]">

            <!-- HEADER -->
            <div
                class="mb-6 flex items-center justify-between gap-4
                       max-[700px]:flex-col
                       max-[700px]:items-start"
            >
                <div>
                    <h1 class="text-[22px] font-bold text-[#20394b]">
                        Add Intern
                    </h1>

                    <p class="mt-1 text-[11px] text-[#8798a6]">
                        Create a new intern account.
                    </p>
                </div>

                <Link
                    :href="route('admin.stagiaires.index')"
                    class="inline-flex min-h-[38px]
                           items-center justify-center
                           rounded-lg border border-[#dce5eb]
                           bg-white px-4
                           text-[10px] font-semibold
                           text-[#536f80]
                           no-underline transition
                           hover:bg-[#f5f8fa]"
                >
                    Back to Interns
                </Link>
            </div>

            <!-- FORM -->
            <form
                class="space-y-5"
                @submit.prevent="submit"
            >
                <!-- PERSONAL INFORMATION -->
                <section
                    class="rounded-xl border border-[#e3eaef]
                           bg-white p-5 shadow-sm"
                >
                    <div class="mb-5">
                        <h2 class="text-[14px] font-bold text-[#294355]">
                            Personal Information
                        </h2>

                        <p class="mt-1 text-[9px] text-[#91a0ab]">
                            Basic account and contact information.
                        </p>
                    </div>

                    <div
                        class="grid grid-cols-2 gap-4
                               max-[700px]:grid-cols-1"
                    >
                        <!-- NAME -->
                        <div>
                            <label
                                class="mb-1.5 block
                                       text-[10px] font-semibold
                                       text-[#4b6576]"
                            >
                                Full Name
                            </label>

                            <input
                                v-model="form.nom_complet"
                                type="text"
                                class="w-full rounded-lg
                                       border border-[#dce5eb]
                                       px-3 py-2.5
                                       text-[11px] text-[#40596b]
                                       outline-none transition
                                       focus:border-[#6694ad]
                                       focus:ring-[3px]
                                       focus:ring-[#326d8b]/10"
                                placeholder="Full name"
                            />

                          
                        </div>

                        <!-- EMAIL -->
                        <div>
                            <label
                                class="mb-1.5 block
                                       text-[10px] font-semibold
                                       text-[#4b6576]"
                            >
                                Email
                            </label>

                            <input
                                v-model="form.email"
                                type="email"
                                class="w-full rounded-lg
                                       border border-[#dce5eb]
                                       px-3 py-2.5
                                       text-[11px] text-[#40596b]
                                       outline-none transition
                                       focus:border-[#6694ad]
                                       focus:ring-[3px]
                                       focus:ring-[#326d8b]/10"
                                placeholder="email@example.com"
                            />

                            <InputError
                                :message="form.errors.email"
                                class="mt-1"
                            />
                        </div>

                        <!-- PHONE -->
                        <div>
                            <label
                                class="mb-1.5 block
                                       text-[10px] font-semibold
                                       text-[#4b6576]"
                            >
                                Phone
                            </label>

                            <input
                                v-model="form.telephone"
                                type="text"
                                class="w-full rounded-lg
                                       border border-[#dce5eb]
                                       px-3 py-2.5
                                       text-[11px] text-[#40596b]
                                       outline-none transition
                                       focus:border-[#6694ad]
                                       focus:ring-[3px]
                                       focus:ring-[#326d8b]/10"
                                placeholder="+212..."
                            />

                            <InputError
                                :message="form.errors.telephone"
                                class="mt-1"
                            />
                        </div>

                        <!-- CITY -->
                        <div>
                            <label
                                class="mb-1.5 block
                                       text-[10px] font-semibold
                                       text-[#4b6576]"
                            >
                                City
                            </label>

                            <select
                                v-model="form.ville_id"
                                class="w-full rounded-lg
                                       border border-[#dce5eb]
                                       bg-white px-3 py-2.5
                                       text-[11px] text-[#40596b]
                                       outline-none transition
                                       focus:border-[#6694ad]
                                       focus:ring-[3px]
                                       focus:ring-[#326d8b]/10"
                            >
                                <option value="">
                                    Select a city
                                </option>

                                <option
                                    v-for="ville in villes"
                                    :key="ville.id"
                                    :value="ville.id"
                                >
                                    {{ ville.nom }}
                                </option>
                            </select>

                            <InputError
                                :message="form.errors.ville_id"
                                class="mt-1"
                            />
                        </div>

                        <!-- BIRTH DATE -->
                        <div>
                            <label
                                class="mb-1.5 block
                                       text-[10px] font-semibold
                                       text-[#4b6576]"
                            >
                                Date of Birth
                            </label>

                            <input
                                v-model="form.date_naissance"
                                type="date"
                                class="w-full rounded-lg
                                       border border-[#dce5eb]
                                       px-3 py-2.5
                                       text-[11px] text-[#40596b]
                                       outline-none transition
                                       focus:border-[#6694ad]
                                       focus:ring-[3px]
                                       focus:ring-[#326d8b]/10"
                            />

                            <InputError
                                :message="form.errors.date_naissance"
                                class="mt-1"
                            />
                        </div>
                    </div>
                </section>

                <!-- ACADEMIC INFORMATION -->
                <section
                    class="rounded-xl border border-[#e3eaef]
                           bg-white p-5 shadow-sm"
                >
                    <div class="mb-5">
                        <h2 class="text-[14px] font-bold text-[#294355]">
                            Academic Information
                        </h2>

                        <p class="mt-1 text-[9px] text-[#91a0ab]">
                            Internship and academic details.
                        </p>
                    </div>

                    <div
                        class="grid grid-cols-2 gap-4
                               max-[700px]:grid-cols-1"
                    >
                        <!-- UNIVERSITY -->
                        <div>
                            <label
                                class="mb-1.5 block
                                       text-[10px] font-semibold
                                       text-[#4b6576]"
                            >
                                University
                            </label>

                            <input
                                v-model="form.universite"
                                type="text"
                                class="w-full rounded-lg
                                       border border-[#dce5eb]
                                       px-3 py-2.5
                                       text-[11px] text-[#40596b]"
                                placeholder="University"
                            />

                            <InputError
                                :message="form.errors.universite"
                                class="mt-1"
                            />
                        </div>

                        <!-- FIELD -->
                        <div>
                            <label
                                class="mb-1.5 block
                                       text-[10px] font-semibold
                                       text-[#4b6576]"
                            >
                                Field of Study
                            </label>

                            <input
                                v-model="form.filiere"
                                type="text"
                                class="w-full rounded-lg
                                       border border-[#dce5eb]
                                       px-3 py-2.5
                                       text-[11px] text-[#40596b]"
                                placeholder="Engineering, Computer Science..."
                            />

                            <InputError
                                :message="form.errors.filiere"
                                class="mt-1"
                            />
                        </div>

                        <!-- LEVEL -->
                        <div>
                            <label
                                class="mb-1.5 block
                                       text-[10px] font-semibold
                                       text-[#4b6576]"
                            >
                                Level
                            </label>

                            <input
                                v-model="form.niveau"
                                type="text"
                                class="w-full rounded-lg
                                       border border-[#dce5eb]
                                       px-3 py-2.5
                                       text-[11px] text-[#40596b]"
                                placeholder="Bac+2, Bac+3, Master..."
                            />

                            <InputError
                                :message="form.errors.niveau"
                                class="mt-1"
                            />
                        </div>

                        <!-- INTERNSHIP STATUS -->
                        <div>
                            <label
                                class="mb-1.5 block
                                       text-[10px] font-semibold
                                       text-[#4b6576]"
                            >
                                Internship Status
                            </label>

                            <select
                                v-model="form.statut_stage"
                                class="w-full rounded-lg
                                       border border-[#dce5eb]
                                       bg-white px-3 py-2.5
                                       text-[11px] text-[#40596b]
                                       outline-none transition
                                       focus:border-[#6694ad]
                                       focus:ring-[3px]
                                       focus:ring-[#326d8b]/10"
                            >
                                <option value="recherche">
                                    En recherche
                                </option>

                                <option value="en_attente">
                                    En attente
                                </option>

                                <option value="en_cours">
                                    En cours
                                </option>

                                <option value="termine">
                                    Terminé
                                </option>

                                <option value="annule">
                                    Annulé
                                </option>
                            </select>

                            <InputError
                                :message="form.errors.statut_stage"
                                class="mt-1"
                            />
                        </div>
                    </div>
                </section>

                <!-- PROFESSIONAL LINKS -->
                <section
                    class="rounded-xl border border-[#e3eaef]
                           bg-white p-5 shadow-sm"
                >
                    <div class="mb-5">
                        <h2 class="text-[14px] font-bold text-[#294355]">
                            Professional Links
                        </h2>
                    </div>

                    <div
                        class="grid grid-cols-2 gap-4
                               max-[700px]:grid-cols-1"
                    >
                        <div>
                            <label
                                class="mb-1.5 block
                                       text-[10px] font-semibold
                                       text-[#4b6576]"
                            >
                                LinkedIn
                            </label>

                            <input
                                v-model="form.linkedin_url"
                                type="url"
                                class="w-full rounded-lg
                                       border border-[#dce5eb]
                                       px-3 py-2.5
                                       text-[11px] text-[#40596b]"
                                placeholder="https://linkedin.com/in/..."
                            />

                            <InputError
                                :message="form.errors.linkedin_url"
                                class="mt-1"
                            />
                        </div>

                        <div>
                            <label
                                class="mb-1.5 block
                                       text-[10px] font-semibold
                                       text-[#4b6576]"
                            >
                                Portfolio
                            </label>

                            <input
                                v-model="form.portfolio_url"
                                type="url"
                                class="w-full rounded-lg
                                       border border-[#dce5eb]
                                       px-3 py-2.5
                                       text-[11px] text-[#40596b]"
                                placeholder="https://..."
                            />

                            <InputError
                                :message="form.errors.portfolio_url"
                                class="mt-1"
                            />
                        </div>
                    </div>
                </section>

                <!-- LOGIN -->
                <section
                    class="rounded-xl border border-[#e3eaef]
                           bg-white p-5 shadow-sm"
                >
                    <div class="mb-5">
                        <h2 class="text-[14px] font-bold text-[#294355]">
                            Login Information
                        </h2>
                    </div>

                    <div
                        class="grid grid-cols-2 gap-4
                               max-[700px]:grid-cols-1"
                    >
                        <div>
                            <label
                                class="mb-1.5 block
                                       text-[10px] font-semibold
                                       text-[#4b6576]"
                            >
                                Password
                            </label>

                            <input
                                v-model="form.password"
                                type="password"
                                class="w-full rounded-lg
                                       border border-[#dce5eb]
                                       px-3 py-2.5
                                       text-[11px] text-[#40596b]"
                            />

                            <InputError
                                :message="form.errors.password"
                                class="mt-1"
                            />
                        </div>

                        <div>
                            <label
                                class="mb-1.5 block
                                       text-[10px] font-semibold
                                       text-[#4b6576]"
                            >
                                Confirm Password
                            </label>

                            <input
                                v-model="form.password_confirmation"
                                type="password"
                                class="w-full rounded-lg
                                       border border-[#dce5eb]
                                       px-3 py-2.5
                                       text-[11px] text-[#40596b]"
                            />
                        </div>
                    </div>
                </section>

                <!-- ACTIONS -->
                <div class="flex justify-end gap-3">
                    <Link
                        :href="route('admin.stagiaires.index')"
                        class="inline-flex min-h-[40px]
                               items-center justify-center
                               rounded-lg border border-[#dce5eb]
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
                               rounded-lg bg-[#174966]
                               px-5
                               text-[10px] font-semibold
                               text-white transition
                               hover:bg-[#123e57]
                               disabled:cursor-not-allowed
                               disabled:opacity-60"
                    >
                        {{ form.processing ? 'Creating...' : 'Create Intern' }}
                    </button>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>
