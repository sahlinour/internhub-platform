<script setup>
import { ref } from 'vue'
import { Head, Link, useForm } from '@inertiajs/vue3'

import AdminLayout from '@/Components/Admin/AdminLayout.vue'

defineProps({
    villes: {
        type: Array,
        default: () => [],
    },
})

const photoPreview = ref(null)

const form = useForm({
    nom_complet: '',
    email: '',
    telephone: '',
    ville_id: '',
    secteur: '',
    adresse: '',
    site_web: '',
    description: '',
    photo: null,
    password: '',
    password_confirmation: '',
})

const handlePhoto = (event) => {
    const file = event.target.files?.[0]

    if (!file) {
        form.photo = null
        photoPreview.value = null
        return
    }

    form.photo = file
    photoPreview.value = URL.createObjectURL(file)
}

const removePhoto = () => {
    form.photo = null
    photoPreview.value = null

    const input = document.getElementById('photo')

    if (input) {
        input.value = ''
    }
}

const submit = () => {
    form.post(route('admin.entreprises.store'), {
        forceFormData: true,

        onFinish: () => {
            form.reset(
                'password',
                'password_confirmation'
            )
        },
    })
}
</script>

<template>
    <Head title="Add Company" />

    <AdminLayout>
        <div class="w-full max-w-[1050px]">

            <!-- ================= HEADER ================= -->

            <header
                class="mb-5 flex items-end justify-between gap-5
                       max-[700px]:flex-col max-[700px]:items-start"
            >
                <div>
                    <!-- BREADCRUMB -->
                    <div
                        class="mb-2 flex items-center gap-[7px]
                               text-[9px] text-[#94a3ad]"
                    >
                        <Link
                            :href="route('admin.entreprises.index')"
                            class="text-[#367594] no-underline hover:underline"
                        >
                            Companies
                        </Link>

                        <span>/</span>
                        <span>New Company</span>
                    </div>

                    <h1 class="mb-[5px] text-[22px] font-bold text-[#20394b]">
                        Add Company
                    </h1>

                    <p class="m-0 text-[11px] text-[#8799a7]">
                        Create a new company account on InternHub.
                    </p>
                </div>

                <Link
                    :href="route('admin.entreprises.index')"
                    class="rounded-lg border border-[#dce5eb]
                           bg-white px-[14px] py-[10px]
                           text-[10px] font-semibold text-[#526c7d]
                           no-underline transition hover:bg-[#f8fafb]"
                >
                    Back to Companies
                </Link>
            </header>

            <!-- ================= FORM ================= -->

            <form
                class="overflow-hidden rounded-xl border border-[#e2e9ee]
                       bg-white
                       shadow-[0_3px_14px_rgba(29,62,82,0.04)]"
                @submit.prevent="submit"
            >

                <!-- ================= LOGO ================= -->

                <section class="border-b border-[#edf1f4] p-[22px]">

                    <div class="mb-[18px]">
                        <h2 class="mb-1 text-[14px] font-bold text-[#294355]">
                            Company Logo
                        </h2>

                        <p class="m-0 text-[9px] text-[#91a0ab]">
                            Add a logo or profile picture for the company.
                        </p>
                    </div>

                    <div
                        class="flex items-center gap-[18px]
                               max-[700px]:flex-col
                               max-[700px]:items-start"
                    >

                        <!-- PREVIEW -->

                        <div
                            class="flex h-[82px] w-[82px] shrink-0
                                   items-center justify-center overflow-hidden
                                   rounded-xl border border-[#dce5eb]
                                   bg-[#f5f8fa] text-[#77909f]"
                        >
                            <img
                                v-if="photoPreview"
                                :src="photoPreview"
                                alt="Company logo preview"
                                class="h-full w-full object-cover"
                            />

                            <svg
                                v-else
                                viewBox="0 0 24 24"
                                width="28"
                                height="28"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.6"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <rect
                                    x="3"
                                    y="3"
                                    width="18"
                                    height="18"
                                    rx="3"
                                />

                                <circle
                                    cx="8.5"
                                    cy="8.5"
                                    r="1.5"
                                />

                                <path d="m21 15-5-5L5 21" />
                            </svg>
                        </div>

                        <!-- UPLOAD -->

                        <div class="flex flex-col gap-[7px]">

                            <div class="flex items-center gap-2">

                                <label
                                    for="photo"
                                    class="inline-flex min-h-9 cursor-pointer
                                           items-center justify-center
                                           rounded-[7px] border
                                           border-[#174966]
                                           bg-[#174966] px-[13px]
                                           text-[9px] font-semibold text-white
                                           transition hover:bg-[#123e57]"
                                >
                                    Choose Image
                                </label>

                                <input
                                    id="photo"
                                    type="file"
                                    accept=".jpg,.jpeg,.png,.webp"
                                    class="hidden"
                                    @change="handlePhoto"
                                />

                                <button
                                    v-if="photoPreview"
                                    type="button"
                                    class="min-h-9 rounded-[7px]
                                           border border-[#dce5eb]
                                           bg-white px-3
                                           text-[9px] font-semibold
                                           text-[#687f8e]
                                           transition hover:bg-[#f6f8fa]"
                                    @click="removePhoto"
                                >
                                    Remove
                                </button>
                            </div>

                            <p class="m-0 text-[8px] text-[#96a5af]">
                                JPG, JPEG, PNG or WEBP. Maximum size 2 MB.
                            </p>

                            <span
                                v-if="form.errors.photo"
                                class="text-[9px] text-[#bd5e5e]"
                            >
                                {{ form.errors.photo }}
                            </span>

                        </div>
                    </div>
                </section>

                <!-- ================= ACCOUNT ================= -->

                <section class="border-b border-[#edf1f4] p-[22px]">

                    <div class="mb-[18px]">
                        <h2 class="mb-1 text-[14px] font-bold text-[#294355]">
                            Company Account
                        </h2>

                        <p class="m-0 text-[9px] text-[#91a0ab]">
                            Main account information used by the company.
                        </p>
                    </div>

                    <div
                        class="grid grid-cols-2 gap-[18px]
                               max-[700px]:grid-cols-1"
                    >

                        <!-- NAME -->

                        <div class="min-w-0">
                            <label
                                for="nom_complet"
                                class="mb-[7px] block text-[10px]
                                       font-semibold text-[#40596a]"
                            >
                                Company Name *
                            </label>

                            <input
                                id="nom_complet"
                                v-model="form.nom_complet"
                                type="text"
                                placeholder="e.g. Atlas Digital"
                                class="h-[42px] w-full rounded-lg
                                       border border-[#dce5eb]
                                       bg-white px-3 text-[10px]
                                       text-[#3e5869] outline-none
                                       transition
                                       placeholder:text-[#a2afb8]
                                       focus:border-[#5d91ad]
                                       focus:ring-[3px]
                                       focus:ring-[#407d9e]/10"
                            />

                            <span
                                v-if="form.errors.nom_complet"
                                class="mt-[5px] block text-[9px] text-[#bd5e5e]"
                            >
                                {{ form.errors.nom_complet }}
                            </span>
                        </div>

                        <!-- EMAIL -->

                        <div class="min-w-0">
                            <label
                                for="email"
                                class="mb-[7px] block text-[10px]
                                       font-semibold text-[#40596a]"
                            >
                                Email *
                            </label>

                            <input
                                id="email"
                                v-model="form.email"
                                type="email"
                                placeholder="contact@company.com"
                                class="h-[42px] w-full rounded-lg
                                       border border-[#dce5eb]
                                       bg-white px-3 text-[10px]
                                       text-[#3e5869] outline-none
                                       transition
                                       placeholder:text-[#a2afb8]
                                       focus:border-[#5d91ad]
                                       focus:ring-[3px]
                                       focus:ring-[#407d9e]/10"
                            />

                            <span
                                v-if="form.errors.email"
                                class="mt-[5px] block text-[9px] text-[#bd5e5e]"
                            >
                                {{ form.errors.email }}
                            </span>
                        </div>

                        <!-- PHONE -->

                        <div class="min-w-0">
                            <label
                                for="telephone"
                                class="mb-[7px] block text-[10px]
                                       font-semibold text-[#40596a]"
                            >
                                Phone
                            </label>

                            <input
                                id="telephone"
                                v-model="form.telephone"
                                type="text"
                                placeholder="+212 ..."
                                class="h-[42px] w-full rounded-lg
                                       border border-[#dce5eb]
                                       bg-white px-3 text-[10px]
                                       text-[#3e5869] outline-none
                                       transition
                                       placeholder:text-[#a2afb8]
                                       focus:border-[#5d91ad]
                                       focus:ring-[3px]
                                       focus:ring-[#407d9e]/10"
                            />

                            <span
                                v-if="form.errors.telephone"
                                class="mt-[5px] block text-[9px] text-[#bd5e5e]"
                            >
                                {{ form.errors.telephone }}
                            </span>
                        </div>

                        <!-- CITY -->

                        <div class="min-w-0">
                            <label
                                for="ville_id"
                                class="mb-[7px] block text-[10px]
                                       font-semibold text-[#40596a]"
                            >
                                City
                            </label>

                            <select
                                id="ville_id"
                                v-model="form.ville_id"
                                class="h-[42px] w-full rounded-lg
                                       border border-[#dce5eb]
                                       bg-white px-3 text-[10px]
                                       text-[#3e5869] outline-none
                                       transition
                                       focus:border-[#5d91ad]
                                       focus:ring-[3px]
                                       focus:ring-[#407d9e]/10"
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

                            <span
                                v-if="form.errors.ville_id"
                                class="mt-[5px] block text-[9px] text-[#bd5e5e]"
                            >
                                {{ form.errors.ville_id }}
                            </span>
                        </div>

                    </div>
                </section>

                <!-- ================= COMPANY INFO ================= -->

                <section class="border-b border-[#edf1f4] p-[22px]">

                    <div class="mb-[18px]">
                        <h2 class="mb-1 text-[14px] font-bold text-[#294355]">
                            Company Information
                        </h2>

                        <p class="m-0 text-[9px] text-[#91a0ab]">
                            Add the business profile details.
                        </p>
                    </div>

                    <div
                        class="grid grid-cols-2 gap-[18px]
                               max-[700px]:grid-cols-1"
                    >

                        <!-- SECTOR -->

                        <div class="min-w-0">
                            <label
                                for="secteur"
                                class="mb-[7px] block text-[10px]
                                       font-semibold text-[#40596a]"
                            >
                                Sector
                            </label>

                            <input
                                id="secteur"
                                v-model="form.secteur"
                                type="text"
                                placeholder="e.g. Technology"
                                class="h-[42px] w-full rounded-lg
                                       border border-[#dce5eb]
                                       bg-white px-3 text-[10px]
                                       text-[#3e5869] outline-none
                                       transition
                                       placeholder:text-[#a2afb8]
                                       focus:border-[#5d91ad]
                                       focus:ring-[3px]
                                       focus:ring-[#407d9e]/10"
                            />

                            <span
                                v-if="form.errors.secteur"
                                class="mt-[5px] block text-[9px] text-[#bd5e5e]"
                            >
                                {{ form.errors.secteur }}
                            </span>
                        </div>

                        <!-- WEBSITE -->

                        <div class="min-w-0">
                            <label
                                for="site_web"
                                class="mb-[7px] block text-[10px]
                                       font-semibold text-[#40596a]"
                            >
                                Website
                            </label>

                            <input
                                id="site_web"
                                v-model="form.site_web"
                                type="url"
                                placeholder="https://company.com"
                                class="h-[42px] w-full rounded-lg
                                       border border-[#dce5eb]
                                       bg-white px-3 text-[10px]
                                       text-[#3e5869] outline-none
                                       transition
                                       placeholder:text-[#a2afb8]
                                       focus:border-[#5d91ad]
                                       focus:ring-[3px]
                                       focus:ring-[#407d9e]/10"
                            />

                            <span
                                v-if="form.errors.site_web"
                                class="mt-[5px] block text-[9px] text-[#bd5e5e]"
                            >
                                {{ form.errors.site_web }}
                            </span>
                        </div>

                    </div>

                    <!-- ADDRESS -->

                    <div class="mt-[18px] min-w-0">
                        <label
                            for="adresse"
                            class="mb-[7px] block text-[10px]
                                   font-semibold text-[#40596a]"
                        >
                            Address
                        </label>

                        <input
                            id="adresse"
                            v-model="form.adresse"
                            type="text"
                            placeholder="Company address"
                            class="h-[42px] w-full rounded-lg
                                   border border-[#dce5eb]
                                   bg-white px-3 text-[10px]
                                   text-[#3e5869] outline-none
                                   transition
                                   placeholder:text-[#a2afb8]
                                   focus:border-[#5d91ad]
                                   focus:ring-[3px]
                                   focus:ring-[#407d9e]/10"
                        />

                        <span
                            v-if="form.errors.adresse"
                            class="mt-[5px] block text-[9px] text-[#bd5e5e]"
                        >
                            {{ form.errors.adresse }}
                        </span>
                    </div>

                    <!-- DESCRIPTION -->

                    <div class="mt-[18px] min-w-0">
                        <label
                            for="description"
                            class="mb-[7px] block text-[10px]
                                   font-semibold text-[#40596a]"
                        >
                            Description
                        </label>

                        <textarea
                            id="description"
                            v-model="form.description"
                            rows="5"
                            placeholder="Brief description of the company..."
                            class="w-full resize-y rounded-lg
                                   border border-[#dce5eb]
                                   bg-white p-3 text-[10px]
                                   text-[#3e5869] outline-none
                                   transition
                                   placeholder:text-[#a2afb8]
                                   focus:border-[#5d91ad]
                                   focus:ring-[3px]
                                   focus:ring-[#407d9e]/10"
                        ></textarea>

                        <span
                            v-if="form.errors.description"
                            class="mt-[5px] block text-[9px] text-[#bd5e5e]"
                        >
                            {{ form.errors.description }}
                        </span>
                    </div>

                </section>

                <!-- ================= CREDENTIALS ================= -->

                <section class="border-b border-[#edf1f4] p-[22px]">

                    <div class="mb-[18px]">
                        <h2 class="mb-1 text-[14px] font-bold text-[#294355]">
                            Login Credentials
                        </h2>

                        <p class="m-0 text-[9px] text-[#91a0ab]">
                            Credentials the company will use to access InternHub.
                        </p>
                    </div>

                    <div
                        class="grid grid-cols-2 gap-[18px]
                               max-[700px]:grid-cols-1"
                    >

                        <!-- PASSWORD -->

                        <div class="min-w-0">
                            <label
                                for="password"
                                class="mb-[7px] block text-[10px]
                                       font-semibold text-[#40596a]"
                            >
                                Password *
                            </label>

                            <input
                                id="password"
                                v-model="form.password"
                                type="password"
                                autocomplete="new-password"
                                class="h-[42px] w-full rounded-lg
                                       border border-[#dce5eb]
                                       bg-white px-3 text-[10px]
                                       text-[#3e5869] outline-none
                                       transition
                                       focus:border-[#5d91ad]
                                       focus:ring-[3px]
                                       focus:ring-[#407d9e]/10"
                            />

                            <span
                                v-if="form.errors.password"
                                class="mt-[5px] block text-[9px] text-[#bd5e5e]"
                            >
                                {{ form.errors.password }}
                            </span>
                        </div>

                        <!-- CONFIRM PASSWORD -->

                        <div class="min-w-0">
                            <label
                                for="password_confirmation"
                                class="mb-[7px] block text-[10px]
                                       font-semibold text-[#40596a]"
                            >
                                Confirm Password *
                            </label>

                            <input
                                id="password_confirmation"
                                v-model="form.password_confirmation"
                                type="password"
                                autocomplete="new-password"
                                class="h-[42px] w-full rounded-lg
                                       border border-[#dce5eb]
                                       bg-white px-3 text-[10px]
                                       text-[#3e5869] outline-none
                                       transition
                                       focus:border-[#5d91ad]
                                       focus:ring-[3px]
                                       focus:ring-[#407d9e]/10"
                            />
                        </div>

                    </div>
                </section>

                <!-- ================= ACTIONS ================= -->

                <div
                    class="flex items-center justify-end gap-[9px]
                           px-[22px] py-[18px]
                           max-[700px]:flex-col-reverse
                           max-[700px]:items-stretch"
                >
                    <Link
                        :href="route('admin.entreprises.index')"
                        class="inline-flex min-h-[39px]
                               items-center justify-center
                               rounded-lg border border-[#dce5eb]
                               bg-white px-4 text-[10px]
                               font-semibold text-[#607887]
                               no-underline transition
                               hover:bg-[#f8fafb]"
                    >
                        Cancel
                    </Link>

                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="inline-flex min-h-[39px]
                               items-center justify-center
                               rounded-lg border border-[#174966]
                               bg-[#174966] px-4
                               text-[10px] font-semibold text-white
                               transition
                               hover:bg-[#123e57]
                               disabled:cursor-not-allowed
                               disabled:opacity-60"
                    >
                        {{
                            form.processing
                                ? 'Creating...'
                                : 'Add Company'
                        }}
                    </button>
                </div>

            </form>
        </div>
    </AdminLayout>
</template>
