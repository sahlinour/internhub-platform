<script setup>
import { ref } from 'vue'
import { Head, Link, useForm } from '@inertiajs/vue3'

import AdminLayout from '@/Components/Admin/AdminLayout.vue'
import DashboardCard from '@/Components/Admin/DashboardCard.vue'
import UserAvatar from '@/Components/Admin/UserAvatar.vue'

const props = defineProps({
    admin: {
        type: Object,
        required: true,
    },

    villes: {
        type: Array,
        default: () => [],
    },
})

const preview = ref(null)

const profileForm = useForm({
    _method: 'put',
    nom_complet: props.admin.nom_complet ?? '',
    email: props.admin.email ?? '',
    telephone: props.admin.telephone ?? '',
    ville_id: props.admin.ville_id ?? '',
    photo: null,
})

const passwordForm = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
})

const handlePhoto = (event) => {
    const file = event.target.files?.[0]

    if (!file) return

    profileForm.photo = file
    preview.value = URL.createObjectURL(file)
}

const submitProfile = () => {
    profileForm
        .transform((data) => ({
            ...data,
            _method: 'PUT',
        }))
        .post(route('admin.profile.update'), {
            forceFormData: true,
            preserveScroll: true,
        })
}

const submitPassword = () => {
    passwordForm.put(
        route('admin.profile.password.update'),
        {
            preserveScroll: true,

            onSuccess: () => {
                passwordForm.reset()
            },
        }
    )
}
</script>

<template>
    <Head title="Edit Profile" />

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
                            :href="route('admin.profile.show')"
                            class="text-[#367594] no-underline hover:underline"
                        >
                            Profile
                        </Link>

                        <span>/</span>
                        <span>Edit</span>
                    </div>

                    <h1 class="mb-[5px] text-[22px] font-bold text-[#20394b]">
                        Edit Profile
                    </h1>

                    <p class="m-0 text-[10px] text-[#8798a6]">
                        Update your personal information and account security.
                    </p>
                </div>
            </header>

            <!-- PROFILE FORM -->
            <form @submit.prevent="submitProfile">
                <DashboardCard>

                    <!-- SECTION HEADER -->
                    <div class="mb-5">
                        <h2 class="mb-1 text-[14px] font-bold text-[#294355]">
                            Profile Information
                        </h2>

                        <p class="m-0 text-[10px] text-[#8798a6]">
                            Update your administrator account details.
                        </p>
                    </div>

                    <!-- PHOTO -->
                    <div
                        class="mb-5 flex items-center gap-[18px]
                               border-b border-[#edf1f4] pb-5
                               max-[700px]:flex-col
                               max-[700px]:items-start"
                    >
                        <img
                            v-if="preview"
                            :src="preview"
                            alt="Preview"
                            class="h-[76px] w-[76px]
                                   rounded-full object-cover"
                        />

                        <UserAvatar
                            v-else
                            :name="profileForm.nom_complet"
                            :photo="admin.photo"
                            :size="76"
                        />

                        <div>
                            <label
                                for="photo"
                                class="mb-1.5 inline-flex min-h-[35px]
                                       cursor-pointer items-center justify-center
                                       rounded-[7px] border border-[#dce5ea]
                                       px-3 text-[9px] font-bold
                                       text-[#496c80]
                                       transition hover:bg-[#f8fafb]"
                            >
                                Change Photo
                            </label>

                            <input
                                id="photo"
                                type="file"
                                accept="image/jpeg,image/png,image/jpg,image/webp"
                                class="hidden"
                                @change="handlePhoto"
                            />

                            <p class="m-0 text-[10px] text-[#8798a6]">
                                JPG, PNG or WEBP. Max 2 MB.
                            </p>

                            <span
                                v-if="profileForm.errors.photo"
                                class="mt-1 block text-[9px] text-[#c95858]"
                            >
                                {{ profileForm.errors.photo }}
                            </span>
                        </div>
                    </div>

                    <!-- PROFILE FIELDS -->
                    <div
                        class="grid grid-cols-2 gap-[18px]
                               max-[700px]:grid-cols-1"
                    >
                        <!-- FULL NAME -->
                        <div class="flex flex-col gap-[7px]">
                            <label class="text-[10px] font-bold text-[#4c6474]">
                                Full Name *
                            </label>

                            <input
                                v-model="profileForm.nom_complet"
                                type="text"
                                class="h-[41px] w-full rounded-lg
                                       border border-[#dce5ea]
                                       bg-white px-3
                                       text-[10px] text-[#40596a]
                                       outline-none transition
                                       focus:border-[#6694ad]
                                       focus:ring-[3px]
                                       focus:ring-[#326d8b]/10"
                            />

                            <span
                                v-if="profileForm.errors.nom_complet"
                                class="text-[9px] text-[#c95858]"
                            >
                                {{ profileForm.errors.nom_complet }}
                            </span>
                        </div>

                        <!-- EMAIL -->
                        <div class="flex flex-col gap-[7px]">
                            <label class="text-[10px] font-bold text-[#4c6474]">
                                Email *
                            </label>

                            <input
                                v-model="profileForm.email"
                                type="email"
                                class="h-[41px] w-full rounded-lg
                                       border border-[#dce5ea]
                                       bg-white px-3
                                       text-[10px] text-[#40596a]
                                       outline-none transition
                                       focus:border-[#6694ad]
                                       focus:ring-[3px]
                                       focus:ring-[#326d8b]/10"
                            />

                            <span
                                v-if="profileForm.errors.email"
                                class="text-[9px] text-[#c95858]"
                            >
                                {{ profileForm.errors.email }}
                            </span>
                        </div>

                        <!-- PHONE -->
                        <div class="flex flex-col gap-[7px]">
                            <label class="text-[10px] font-bold text-[#4c6474]">
                                Phone
                            </label>

                            <input
                                v-model="profileForm.telephone"
                                type="text"
                                class="h-[41px] w-full rounded-lg
                                       border border-[#dce5ea]
                                       bg-white px-3
                                       text-[10px] text-[#40596a]
                                       outline-none transition
                                       focus:border-[#6694ad]
                                       focus:ring-[3px]
                                       focus:ring-[#326d8b]/10"
                            />

                            <span
                                v-if="profileForm.errors.telephone"
                                class="text-[9px] text-[#c95858]"
                            >
                                {{ profileForm.errors.telephone }}
                            </span>
                        </div>

                        <!-- CITY -->
                        <div class="flex flex-col gap-[7px]">
                            <label class="text-[10px] font-bold text-[#4c6474]">
                                City *
                            </label>

                            <select
                                v-model="profileForm.ville_id"
                                class="h-[41px] w-full rounded-lg
                                       border border-[#dce5ea]
                                       bg-white px-3
                                       text-[10px] text-[#40596a]
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

                            <span
                                v-if="profileForm.errors.ville_id"
                                class="text-[9px] text-[#c95858]"
                            >
                                {{ profileForm.errors.ville_id }}
                            </span>
                        </div>
                    </div>

                    <!-- PROFILE ACTIONS -->
                    <div class="mt-5 flex justify-end gap-[9px]">
                        <Link
                            :href="route('admin.profile.show')"
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
                            :disabled="profileForm.processing"
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
                                profileForm.processing
                                    ? 'Saving...'
                                    : 'Save Changes'
                            }}
                        </button>
                    </div>

                </DashboardCard>
            </form>

            <!-- PASSWORD FORM -->
            <form
                class="mt-[18px]"
                @submit.prevent="submitPassword"
            >
                <DashboardCard>

                    <!-- SECTION HEADER -->
                    <div class="mb-5">
                        <h2 class="mb-1 text-[14px] font-bold text-[#294355]">
                            Change Password
                        </h2>

                        <p class="m-0 text-[10px] text-[#8798a6]">
                            Update your administrator login password.
                        </p>
                    </div>

                    <!-- CURRENT PASSWORD -->
                    <div
                        class="mb-[18px] flex max-w-[50%]
                               flex-col gap-[7px]
                               max-[700px]:max-w-none"
                    >
                        <label class="text-[10px] font-bold text-[#4c6474]">
                            Current Password *
                        </label>

                        <input
                            v-model="passwordForm.current_password"
                            type="password"
                            class="h-[41px] w-full rounded-lg
                                   border border-[#dce5ea]
                                   bg-white px-3
                                   text-[10px] text-[#40596a]
                                   outline-none transition
                                   focus:border-[#6694ad]
                                   focus:ring-[3px]
                                   focus:ring-[#326d8b]/10"
                        />

                        <span
                            v-if="passwordForm.errors.current_password"
                            class="text-[9px] text-[#c95858]"
                        >
                            {{ passwordForm.errors.current_password }}
                        </span>
                    </div>

                    <!-- NEW PASSWORDS -->
                    <div
                        class="grid grid-cols-2 gap-[18px]
                               max-[700px]:grid-cols-1"
                    >
                        <!-- NEW PASSWORD -->
                        <div class="flex flex-col gap-[7px]">
                            <label class="text-[10px] font-bold text-[#4c6474]">
                                New Password *
                            </label>

                            <input
                                v-model="passwordForm.password"
                                type="password"
                                class="h-[41px] w-full rounded-lg
                                       border border-[#dce5ea]
                                       bg-white px-3
                                       text-[10px] text-[#40596a]
                                       outline-none transition
                                       focus:border-[#6694ad]
                                       focus:ring-[3px]
                                       focus:ring-[#326d8b]/10"
                            />

                            <span
                                v-if="passwordForm.errors.password"
                                class="text-[9px] text-[#c95858]"
                            >
                                {{ passwordForm.errors.password }}
                            </span>
                        </div>

                        <!-- CONFIRM PASSWORD -->
                        <div class="flex flex-col gap-[7px]">
                            <label class="text-[10px] font-bold text-[#4c6474]">
                                Confirm Password *
                            </label>

                            <input
                                v-model="passwordForm.password_confirmation"
                                type="password"
                                class="h-[41px] w-full rounded-lg
                                       border border-[#dce5ea]
                                       bg-white px-3
                                       text-[10px] text-[#40596a]
                                       outline-none transition
                                       focus:border-[#6694ad]
                                       focus:ring-[3px]
                                       focus:ring-[#326d8b]/10"
                            />
                        </div>
                    </div>

                    <!-- PASSWORD ACTION -->
                    <div class="mt-5 flex justify-end">
                        <button
                            type="submit"
                            :disabled="passwordForm.processing"
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
                                passwordForm.processing
                                    ? 'Updating...'
                                    : 'Update Password'
                            }}
                        </button>
                    </div>

                </DashboardCard>
            </form>

        </div>
    </AdminLayout>
</template>
