<script setup>
import { ref } from 'vue'
import { Head, Link, useForm } from '@inertiajs/vue3'

import AdminLayout from '@/Components/Admin/AdminLayout.vue'
import DashboardCard from '@/Components/Admin/DashboardCard.vue'
import UserAvatar from '@/Components/Admin/UserAvatar.vue'

const props = defineProps({
    entreprise: {
        type: Object,
        required: true,
    },

    villes: {
        type: Array,
        default: () => [],
    },
})

const preview = ref(null)

const form = useForm({
    _method: 'PUT',

    nom_complet: props.entreprise.nom_complet ?? '',
    email: props.entreprise.email ?? '',
    telephone: props.entreprise.telephone ?? '',
    ville_id: props.entreprise.ville_id ?? '',
    etat: props.entreprise.etat ?? 'pending',

    secteur: props.entreprise.entreprise?.secteur ?? '',
    adresse: props.entreprise.entreprise?.adresse ?? '',
    site_web: props.entreprise.entreprise?.site_web ?? '',
    description: props.entreprise.entreprise?.description ?? '',

    photo: null,
})

const handlePhoto = (event) => {
    const file = event.target.files?.[0]

    if (!file) return

    form.photo = file
    preview.value = URL.createObjectURL(file)
}

const submit = () => {
    form.post(
        route('admin.entreprises.update', props.entreprise.id),
        {
            forceFormData: true,
            preserveScroll: true,
        }
    )
}
</script>

<template>
    <Head title="Edit Company" />

    <AdminLayout>
        <div class="w-full max-w-[1050px]">

            <!-- HEADER -->
            <header class="mb-5">
                <div>
                    <div
                        class="mb-2 flex items-center gap-[7px]
                               text-[9px] text-[#96a5af]"
                    >
                        <Link
                            :href="route('admin.entreprises.index')"
                            class="text-[#367594] no-underline hover:underline"
                        >
                            Companies
                        </Link>

                        <span>/</span>

                        <Link
                            :href="route('admin.entreprises.show', entreprise.id)"
                            class="text-[#367594] no-underline hover:underline"
                        >
                            {{ entreprise.nom_complet }}
                        </Link>

                        <span>/</span>
                        <span>Edit</span>
                    </div>

                    <h1 class="mb-[5px] text-[22px] font-bold text-[#20394b]">
                        Edit Company
                    </h1>

                    <p class="m-0 text-[10px] text-[#8798a6]">
                        Update company information and account details.
                    </p>
                </div>
            </header>

            <form @submit.prevent="submit">
                <DashboardCard>

                    <!-- PHOTO -->
                    <div
                        class="mb-5 flex items-center gap-[18px]
                               border-b border-[#edf1f4] pb-5
                               max-[700px]:flex-col
                               max-[700px]:items-start"
                    >
                        <UserAvatar
                            :name="form.nom_complet"
                            :photo="preview || entreprise.photo"
                            :size="76"
                        />

                        <div>
                            <label
                                for="company-photo"
                                class="mb-1.5 inline-flex min-h-[35px]
                                       cursor-pointer items-center justify-center
                                       rounded-[7px] border border-[#dce5ea]
                                       px-3 text-[9px] font-bold text-[#496c80]
                                       transition hover:bg-[#f8fafb]"
                            >
                                Change Photo
                            </label>

                            <input
                                id="company-photo"
                                type="file"
                                accept="image/jpeg,image/png,image/jpg,image/webp"
                                class="hidden"
                                @change="handlePhoto"
                            />

                            <p class="m-0 text-[10px] text-[#8798a6]">
                                JPG, PNG or WEBP. Max 2 MB.
                            </p>

                            <span
                                v-if="form.errors.photo"
                                class="mt-1 block text-[9px] text-[#c95858]"
                            >
                                {{ form.errors.photo }}
                            </span>
                        </div>
                    </div>

                    <!-- ACCOUNT -->
                    <div class="mb-5">
                        <h2 class="mb-1 text-[14px] font-bold text-[#294355]">
                            Account Information
                        </h2>

                        <p class="m-0 text-[10px] text-[#8798a6]">
                            Update the company's general account details.
                        </p>
                    </div>

                    <div
                        class="grid grid-cols-2 gap-[18px]
                               max-[700px]:grid-cols-1"
                    >

                        <!-- COMPANY NAME -->
                        <div class="flex flex-col gap-[7px]">
                            <label class="text-[10px] font-bold text-[#4c6474]">
                                Company Name *
                            </label>

                            <input
                                v-model="form.nom_complet"
                                type="text"
                                class="h-[41px] w-full rounded-lg
                                       border border-[#dce5ea]
                                       bg-white px-3 text-[10px]
                                       text-[#40596a] outline-none
                                       transition
                                       focus:border-[#6694ad]
                                       focus:ring-[3px]
                                       focus:ring-[#326d8b]/10"
                            />

                            <span
                                v-if="form.errors.nom_complet"
                                class="text-[9px] text-[#c95858]"
                            >
                                {{ form.errors.nom_complet }}
                            </span>
                        </div>

                        <!-- EMAIL -->
                        <div class="flex flex-col gap-[7px]">
                            <label class="text-[10px] font-bold text-[#4c6474]">
                                Email *
                            </label>

                            <input
                                v-model="form.email"
                                type="email"
                                class="h-[41px] w-full rounded-lg
                                       border border-[#dce5ea]
                                       bg-white px-3 text-[10px]
                                       text-[#40596a] outline-none
                                       transition
                                       focus:border-[#6694ad]
                                       focus:ring-[3px]
                                       focus:ring-[#326d8b]/10"
                            />

                            <span
                                v-if="form.errors.email"
                                class="text-[9px] text-[#c95858]"
                            >
                                {{ form.errors.email }}
                            </span>
                        </div>

                        <!-- PHONE -->
                        <div class="flex flex-col gap-[7px]">
                            <label class="text-[10px] font-bold text-[#4c6474]">
                                Phone
                            </label>

                            <input
                                v-model="form.telephone"
                                type="text"
                                class="h-[41px] w-full rounded-lg
                                       border border-[#dce5ea]
                                       bg-white px-3 text-[10px]
                                       text-[#40596a] outline-none
                                       transition
                                       focus:border-[#6694ad]
                                       focus:ring-[3px]
                                       focus:ring-[#326d8b]/10"
                            />

                            <span
                                v-if="form.errors.telephone"
                                class="text-[9px] text-[#c95858]"
                            >
                                {{ form.errors.telephone }}
                            </span>
                        </div>

                        <!-- CITY -->
                        <div class="flex flex-col gap-[7px]">
                            <label class="text-[10px] font-bold text-[#4c6474]">
                                City *
                            </label>

                            <select
                                v-model="form.ville_id"
                                class="h-[41px] w-full rounded-lg
                                       border border-[#dce5ea]
                                       bg-white px-3 text-[10px]
                                       text-[#40596a] outline-none
                                       transition
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

                            <span
                                v-if="form.errors.ville_id"
                                class="text-[9px] text-[#c95858]"
                            >
                                {{ form.errors.ville_id }}
                            </span>
                        </div>

                        <!-- STATUS -->
                        <div class="flex flex-col gap-[7px]">
                            <label class="text-[10px] font-bold text-[#4c6474]">
                                Status *
                            </label>

                            <select
                                v-model="form.etat"
                                class="h-[41px] w-full rounded-lg
                                       border border-[#dce5ea]
                                       bg-white px-3 text-[10px]
                                       text-[#40596a] outline-none
                                       transition
                                       focus:border-[#6694ad]
                                       focus:ring-[3px]
                                       focus:ring-[#326d8b]/10"
                            >
                                <option value="pending">
                                    Pending
                                </option>

                                <option value="active">
                                    Active
                                </option>

                                <option value="block">
                                    Suspended
                                </option>
                            </select>

                            <span
                                v-if="form.errors.etat"
                                class="text-[9px] text-[#c95858]"
                            >
                                {{ form.errors.etat }}
                            </span>
                        </div>
                    </div>

                    <!-- DIVIDER -->
                    <div class="my-6 border-t border-[#edf1f4]"></div>

                    <!-- COMPANY INFO -->
                    <div class="mb-5">
                        <h2 class="mb-1 text-[14px] font-bold text-[#294355]">
                            Company Information
                        </h2>

                        <p class="m-0 text-[10px] text-[#8798a6]">
                            Update business and public profile information.
                        </p>
                    </div>

                    <div
                        class="grid grid-cols-2 gap-[18px]
                               max-[700px]:grid-cols-1"
                    >

                        <!-- SECTOR -->
                        <div class="flex flex-col gap-[7px]">
                            <label class="text-[10px] font-bold text-[#4c6474]">
                                Sector *
                            </label>

                            <input
                                v-model="form.secteur"
                                type="text"
                                class="h-[41px] w-full rounded-lg
                                       border border-[#dce5ea]
                                       bg-white px-3 text-[10px]
                                       text-[#40596a] outline-none
                                       transition
                                       focus:border-[#6694ad]
                                       focus:ring-[3px]
                                       focus:ring-[#326d8b]/10"
                            />

                            <span
                                v-if="form.errors.secteur"
                                class="text-[9px] text-[#c95858]"
                            >
                                {{ form.errors.secteur }}
                            </span>
                        </div>

                        <!-- ADDRESS -->
                        <div class="flex flex-col gap-[7px]">
                            <label class="text-[10px] font-bold text-[#4c6474]">
                                Address *
                            </label>

                            <input
                                v-model="form.adresse"
                                type="text"
                                class="h-[41px] w-full rounded-lg
                                       border border-[#dce5ea]
                                       bg-white px-3 text-[10px]
                                       text-[#40596a] outline-none
                                       transition
                                       focus:border-[#6694ad]
                                       focus:ring-[3px]
                                       focus:ring-[#326d8b]/10"
                            />

                            <span
                                v-if="form.errors.adresse"
                                class="text-[9px] text-[#c95858]"
                            >
                                {{ form.errors.adresse }}
                            </span>
                        </div>

                        <!-- WEBSITE -->
                        <div
                            class="col-span-2 flex flex-col gap-[7px]
                                   max-[700px]:col-span-1"
                        >
                            <label class="text-[10px] font-bold text-[#4c6474]">
                                Website
                            </label>

                            <input
                                v-model="form.site_web"
                                type="url"
                                placeholder="https://example.com"
                                class="h-[41px] w-full rounded-lg
                                       border border-[#dce5ea]
                                       bg-white px-3 text-[10px]
                                       text-[#40596a] outline-none
                                       transition
                                       placeholder:text-[#a2afb8]
                                       focus:border-[#6694ad]
                                       focus:ring-[3px]
                                       focus:ring-[#326d8b]/10"
                            />

                            <span
                                v-if="form.errors.site_web"
                                class="text-[9px] text-[#c95858]"
                            >
                                {{ form.errors.site_web }}
                            </span>
                        </div>

                        <!-- DESCRIPTION -->
                        <div
                            class="col-span-2 flex flex-col gap-[7px]
                                   max-[700px]:col-span-1"
                        >
                            <label class="text-[10px] font-bold text-[#4c6474]">
                                Description
                            </label>

                            <textarea
                                v-model="form.description"
                                rows="5"
                                class="w-full resize-y rounded-lg
                                       border border-[#dce5ea]
                                       bg-white px-3 py-[10px]
                                       text-[10px] text-[#40596a]
                                       outline-none transition
                                       focus:border-[#6694ad]
                                       focus:ring-[3px]
                                       focus:ring-[#326d8b]/10"
                            ></textarea>

                            <span
                                v-if="form.errors.description"
                                class="text-[9px] text-[#c95858]"
                            >
                                {{ form.errors.description }}
                            </span>
                        </div>

                    </div>

                    <!-- ACTIONS -->
                    <div
                        class="mt-6 flex justify-end gap-[9px]
                               max-[700px]:flex-col-reverse"
                    >
                        <Link
                            :href="route('admin.entreprises.show', entreprise.id)"
                            class="inline-flex min-h-[39px]
                                   items-center justify-center
                                   rounded-lg border border-[#dce5ea]
                                   bg-white px-[15px]
                                   text-[10px] font-bold text-[#617887]
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
                                   rounded-lg border-0
                                   bg-[#174966] px-[15px]
                                   text-[10px] font-bold text-white
                                   transition hover:bg-[#123e57]
                                   disabled:cursor-not-allowed
                                   disabled:opacity-60"
                        >
                            {{
                                form.processing
                                    ? 'Saving...'
                                    : 'Save Changes'
                            }}
                        </button>
                    </div>

                </DashboardCard>
            </form>

        </div>
    </AdminLayout>
</template>
