<script setup>
import { computed, nextTick, ref } from 'vue'
import { Head, useForm, usePage } from '@inertiajs/vue3'
import EntrepriseLayout from '@/Layouts/EntrepriseLayout.vue'

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

const page = usePage()

const appRoute = (name, params = undefined) => {
    return route(name, params, false)
}

/*
|--------------------------------------------------------------------------
| Company data
|--------------------------------------------------------------------------
*/

const company = computed(() => {
    return props.entreprise?.entreprise ?? {}
})

const initials = computed(() => {
    const name = props.entreprise?.nom_complet ?? 'Company'

    return name
        .split(' ')
        .filter(Boolean)
        .map((word) => word[0])
        .join('')
        .slice(0, 2)
        .toUpperCase()
})

const currentPhoto = computed(() => {
    const photo = props.entreprise?.photo

    if (!photo) {
        return null
    }

    if (photo.startsWith('http://') || photo.startsWith('https://')) {
        return photo
    }

    return `/storage/${photo.replace(/^\/+/, '')}`
})

const flashMessage = computed(() => {
    return page.props.flash?.message ?? null
})

/*
|--------------------------------------------------------------------------
| Profile form
|--------------------------------------------------------------------------
*/

const photoPreview = ref(null)

const profileForm = useForm({
    nom_complet: props.entreprise?.nom_complet ?? '',
    email: props.entreprise?.email ?? '',
    telephone: props.entreprise?.telephone ?? '',
    ville_id: props.entreprise?.ville_id ?? '',

    secteur: company.value?.secteur ?? '',
    adresse: company.value?.adresse ?? '',
    site_web: company.value?.site_web ?? '',
    description: company.value?.description ?? '',

    photo: null,
})

const handlePhoto = (event) => {
    const file = event.target.files?.[0]

    if (!file) {
        return
    }

    profileForm.photo = file

    if (photoPreview.value) {
        URL.revokeObjectURL(photoPreview.value)
    }

    photoPreview.value = URL.createObjectURL(file)
}

const updateProfile = () => {
    profileForm
        .transform((data) => ({
            ...data,
            _method: 'put',
        }))
        .post(
            appRoute('entreprise.profile.update'),
            {
                preserveScroll: true,
                forceFormData: true,

                onSuccess: () => {
                    profileForm.photo = null

                    if (photoPreview.value) {
                        URL.revokeObjectURL(photoPreview.value)
                        photoPreview.value = null
                    }
                },
            }
        )
}

/*
|--------------------------------------------------------------------------
| Password form
|--------------------------------------------------------------------------
*/

const currentPasswordInput = ref(null)
const newPasswordInput = ref(null)

const passwordForm = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
})

const updatePassword = () => {
    passwordForm.put(
        appRoute('entreprise.profile.password.update'),
        {
            preserveScroll: true,

            onSuccess: () => {
                passwordForm.reset()
            },

            onError: () => {
                if (passwordForm.errors.current_password) {
                    passwordForm.reset('current_password')

                    nextTick(() => {
                        currentPasswordInput.value?.focus()
                    })
                }

                if (passwordForm.errors.password) {
                    passwordForm.reset(
                        'password',
                        'password_confirmation'
                    )

                    nextTick(() => {
                        newPasswordInput.value?.focus()
                    })
                }
            },
        }
    )
}

/*
|--------------------------------------------------------------------------
| Delete account
|--------------------------------------------------------------------------
*/

const showDeleteModal = ref(false)
const deletePasswordInput = ref(null)

const deleteForm = useForm({
    password: '',
})

const openDeleteModal = () => {
    showDeleteModal.value = true

    nextTick(() => {
        deletePasswordInput.value?.focus()
    })
}

const closeDeleteModal = () => {
    showDeleteModal.value = false
    deleteForm.clearErrors()
    deleteForm.reset()
}

const deleteAccount = () => {
    deleteForm.delete(
        appRoute('entreprise.profile.destroy'),
        {
            preserveScroll: true,

            onError: () => {
                nextTick(() => {
                    deletePasswordInput.value?.focus()
                })
            },
        }
    )
}
</script>

<template>
    <Head title="Company Settings" />

    <EntrepriseLayout>
        <div class="mx-auto max-w-6xl">

            <!-- ======================================================
                 PAGE HEADER
            ======================================================= -->

            <div class="mb-7">
                <h1 class="text-2xl font-bold text-gray-900">
                    Settings
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Manage your company information, password and account.
                </p>
            </div>

            <!-- ======================================================
                 FLASH MESSAGE
            ======================================================= -->

            <div
                v-if="flashMessage"
                class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700"
            >
                {{ flashMessage }}
            </div>

            <!-- ======================================================
                 COMPANY PROFILE
            ======================================================= -->

            <section
                class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm"
            >
                <div class="border-b border-gray-100 px-6 py-5">
                    <h2 class="text-base font-semibold text-gray-900">
                        Company Profile
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Update your company and contact information.
                    </p>
                </div>

                <form
                    class="p-6"
                    @submit.prevent="updateProfile"
                >
                    <!-- PHOTO -->
                    <div
                        class="flex flex-col gap-5 border-b border-gray-100 pb-6 sm:flex-row sm:items-center"
                    >
                        <div
                            class="flex h-24 w-24 shrink-0 items-center justify-center overflow-hidden rounded-2xl border border-gray-100 bg-[#e8f3f7]"
                        >
                            <img
                                v-if="photoPreview || currentPhoto"
                                :src="photoPreview || currentPhoto"
                                alt="Company"
                                class="h-full w-full object-cover"
                            />

                            <span
                                v-else
                                class="text-2xl font-bold text-[#286f8e]"
                            >
                                {{ initials }}
                            </span>
                        </div>

                        <div>
                            <p class="text-sm font-semibold text-gray-800">
                                Company photo
                            </p>

                            <p class="mt-1 text-xs text-gray-400">
                                JPG, PNG or WEBP. Maximum 2 MB.
                            </p>

                            <label
                                for="photo"
                                class="mt-3 inline-flex cursor-pointer items-center rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50"
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

                            <p
                                v-if="profileForm.errors.photo"
                                class="mt-2 text-xs text-red-500"
                            >
                                {{ profileForm.errors.photo }}
                            </p>
                        </div>
                    </div>

                    <!-- BASIC INFORMATION -->

                    <div
                        class="mt-6 grid grid-cols-1 gap-5 md:grid-cols-2"
                    >
                        <!-- NAME -->
                        <div>
                            <label
                                for="nom_complet"
                                class="mb-2 block text-sm font-medium text-gray-700"
                            >
                                Company Name
                            </label>

                            <input
                                id="nom_complet"
                                v-model="profileForm.nom_complet"
                                type="text"
                                required
                                class="w-full rounded-lg border border-gray-200 px-3.5 py-2.5 text-sm text-gray-700 outline-none transition focus:border-[#63a9c6] focus:ring-2 focus:ring-[#63a9c6]/10"
                            />

                            <p
                                v-if="profileForm.errors.nom_complet"
                                class="mt-1.5 text-xs text-red-500"
                            >
                                {{ profileForm.errors.nom_complet }}
                            </p>
                        </div>

                        <!-- EMAIL -->
                        <div>
                            <label
                                for="email"
                                class="mb-2 block text-sm font-medium text-gray-700"
                            >
                                Email Address
                            </label>

                            <input
                                id="email"
                                v-model="profileForm.email"
                                type="email"
                                required
                                class="w-full rounded-lg border border-gray-200 px-3.5 py-2.5 text-sm text-gray-700 outline-none transition focus:border-[#63a9c6] focus:ring-2 focus:ring-[#63a9c6]/10"
                            />

                            <p
                                v-if="profileForm.errors.email"
                                class="mt-1.5 text-xs text-red-500"
                            >
                                {{ profileForm.errors.email }}
                            </p>
                        </div>

                        <!-- PHONE -->
                        <div>
                            <label
                                for="telephone"
                                class="mb-2 block text-sm font-medium text-gray-700"
                            >
                                Phone Number
                            </label>

                            <input
                                id="telephone"
                                v-model="profileForm.telephone"
                                type="text"
                                class="w-full rounded-lg border border-gray-200 px-3.5 py-2.5 text-sm text-gray-700 outline-none transition focus:border-[#63a9c6] focus:ring-2 focus:ring-[#63a9c6]/10"
                            />

                            <p
                                v-if="profileForm.errors.telephone"
                                class="mt-1.5 text-xs text-red-500"
                            >
                                {{ profileForm.errors.telephone }}
                            </p>
                        </div>

                        <!-- CITY -->
                        <div>
                            <label
                                for="ville_id"
                                class="mb-2 block text-sm font-medium text-gray-700"
                            >
                                City
                            </label>

                            <select
                                id="ville_id"
                                v-model="profileForm.ville_id"
                                required
                                class="w-full rounded-lg border border-gray-200 bg-white px-3.5 py-2.5 text-sm text-gray-700 outline-none transition focus:border-[#63a9c6] focus:ring-2 focus:ring-[#63a9c6]/10"
                            >
                                <option
                                    value=""
                                    disabled
                                >
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

                            <p
                                v-if="profileForm.errors.ville_id"
                                class="mt-1.5 text-xs text-red-500"
                            >
                                {{ profileForm.errors.ville_id }}
                            </p>
                        </div>

                        <!-- SECTOR -->
                        <div>
                            <label
                                for="secteur"
                                class="mb-2 block text-sm font-medium text-gray-700"
                            >
                                Industry / Sector
                            </label>

                            <input
                                id="secteur"
                                v-model="profileForm.secteur"
                                type="text"
                                required
                                class="w-full rounded-lg border border-gray-200 px-3.5 py-2.5 text-sm text-gray-700 outline-none transition focus:border-[#63a9c6] focus:ring-2 focus:ring-[#63a9c6]/10"
                            />

                            <p
                                v-if="profileForm.errors.secteur"
                                class="mt-1.5 text-xs text-red-500"
                            >
                                {{ profileForm.errors.secteur }}
                            </p>
                        </div>

                        <!-- WEBSITE -->
                        <div>
                            <label
                                for="site_web"
                                class="mb-2 block text-sm font-medium text-gray-700"
                            >
                                Website
                            </label>

                            <input
                                id="site_web"
                                v-model="profileForm.site_web"
                                type="url"
                                placeholder="https://example.com"
                                class="w-full rounded-lg border border-gray-200 px-3.5 py-2.5 text-sm text-gray-700 outline-none transition placeholder:text-gray-300 focus:border-[#63a9c6] focus:ring-2 focus:ring-[#63a9c6]/10"
                            />

                            <p
                                v-if="profileForm.errors.site_web"
                                class="mt-1.5 text-xs text-red-500"
                            >
                                {{ profileForm.errors.site_web }}
                            </p>
                        </div>
                    </div>

                    <!-- ADDRESS -->
                    <div class="mt-5">
                        <label
                            for="adresse"
                            class="mb-2 block text-sm font-medium text-gray-700"
                        >
                            Address
                        </label>

                        <input
                            id="adresse"
                            v-model="profileForm.adresse"
                            type="text"
                            required
                            class="w-full rounded-lg border border-gray-200 px-3.5 py-2.5 text-sm text-gray-700 outline-none transition focus:border-[#63a9c6] focus:ring-2 focus:ring-[#63a9c6]/10"
                        />

                        <p
                            v-if="profileForm.errors.adresse"
                            class="mt-1.5 text-xs text-red-500"
                        >
                            {{ profileForm.errors.adresse }}
                        </p>
                    </div>

                    <!-- DESCRIPTION -->
                    <div class="mt-5">
                        <label
                            for="description"
                            class="mb-2 block text-sm font-medium text-gray-700"
                        >
                            Company Description
                        </label>

                        <textarea
                            id="description"
                            v-model="profileForm.description"
                            rows="5"
                            placeholder="Tell students about your company..."
                            class="w-full resize-none rounded-lg border border-gray-200 px-3.5 py-2.5 text-sm text-gray-700 outline-none transition placeholder:text-gray-300 focus:border-[#63a9c6] focus:ring-2 focus:ring-[#63a9c6]/10"
                        ></textarea>

                        <p
                            v-if="profileForm.errors.description"
                            class="mt-1.5 text-xs text-red-500"
                        >
                            {{ profileForm.errors.description }}
                        </p>
                    </div>

                    <!-- SAVE -->
                    <div
                        class="mt-6 flex items-center justify-end gap-4 border-t border-gray-100 pt-5"
                    >
                        <Transition
                            enter-active-class="transition"
                            enter-from-class="opacity-0"
                            leave-active-class="transition"
                            leave-to-class="opacity-0"
                        >
                            <span
                                v-if="profileForm.recentlySuccessful"
                                class="text-sm font-medium text-emerald-600"
                            >
                                Profile saved.
                            </span>
                        </Transition>

                        <button
                            type="submit"
                            :disabled="profileForm.processing"
                            class="rounded-lg bg-[#174e6d] px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#123e57] disabled:cursor-not-allowed disabled:opacity-50"
                        >
                            {{
                                profileForm.processing
                                    ? 'Saving...'
                                    : 'Save Changes'
                            }}
                        </button>
                    </div>
                </form>
            </section>

            <!-- ======================================================
                 SECURITY
            ======================================================= -->

            <section
                class="mt-6 overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm"
            >
                <div class="border-b border-gray-100 px-6 py-5">
                    <h2 class="text-base font-semibold text-gray-900">
                        Password & Security
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Change the password used to access your company account.
                    </p>
                </div>

                <form
                    class="p-6"
                    @submit.prevent="updatePassword"
                >
                    <div
                        class="grid grid-cols-1 gap-5 lg:grid-cols-3"
                    >
                        <!-- CURRENT PASSWORD -->
                        <div>
                            <label
                                for="current_password"
                                class="mb-2 block text-sm font-medium text-gray-700"
                            >
                                Current Password
                            </label>

                            <input
                                id="current_password"
                                ref="currentPasswordInput"
                                v-model="passwordForm.current_password"
                                type="password"
                                autocomplete="current-password"
                                class="w-full rounded-lg border border-gray-200 px-3.5 py-2.5 text-sm outline-none transition focus:border-[#63a9c6] focus:ring-2 focus:ring-[#63a9c6]/10"
                            />

                            <p
                                v-if="passwordForm.errors.current_password"
                                class="mt-1.5 text-xs text-red-500"
                            >
                                {{ passwordForm.errors.current_password }}
                            </p>
                        </div>

                        <!-- NEW PASSWORD -->
                        <div>
                            <label
                                for="new_password"
                                class="mb-2 block text-sm font-medium text-gray-700"
                            >
                                New Password
                            </label>

                            <input
                                id="new_password"
                                ref="newPasswordInput"
                                v-model="passwordForm.password"
                                type="password"
                                autocomplete="new-password"
                                class="w-full rounded-lg border border-gray-200 px-3.5 py-2.5 text-sm outline-none transition focus:border-[#63a9c6] focus:ring-2 focus:ring-[#63a9c6]/10"
                            />

                            <p
                                v-if="passwordForm.errors.password"
                                class="mt-1.5 text-xs text-red-500"
                            >
                                {{ passwordForm.errors.password }}
                            </p>
                        </div>

                        <!-- CONFIRM PASSWORD -->
                        <div>
                            <label
                                for="password_confirmation"
                                class="mb-2 block text-sm font-medium text-gray-700"
                            >
                                Confirm Password
                            </label>

                            <input
                                id="password_confirmation"
                                v-model="passwordForm.password_confirmation"
                                type="password"
                                autocomplete="new-password"
                                class="w-full rounded-lg border border-gray-200 px-3.5 py-2.5 text-sm outline-none transition focus:border-[#63a9c6] focus:ring-2 focus:ring-[#63a9c6]/10"
                            />

                            <p
                                v-if="passwordForm.errors.password_confirmation"
                                class="mt-1.5 text-xs text-red-500"
                            >
                                {{ passwordForm.errors.password_confirmation }}
                            </p>
                        </div>
                    </div>

                    <div
                        class="mt-6 flex items-center justify-end gap-4"
                    >
                        <Transition
                            enter-active-class="transition"
                            enter-from-class="opacity-0"
                            leave-active-class="transition"
                            leave-to-class="opacity-0"
                        >
                            <span
                                v-if="passwordForm.recentlySuccessful"
                                class="text-sm font-medium text-emerald-600"
                            >
                                Password updated.
                            </span>
                        </Transition>

                        <button
                            type="submit"
                            :disabled="passwordForm.processing"
                            class="rounded-lg bg-[#174e6d] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#123e57] disabled:cursor-not-allowed disabled:opacity-50"
                        >
                            {{
                                passwordForm.processing
                                    ? 'Updating...'
                                    : 'Update Password'
                            }}
                        </button>
                    </div>
                </form>
            </section>

            <!-- ======================================================
                 DANGER ZONE
            ======================================================= -->

            <section
                class="mt-6 overflow-hidden rounded-2xl border border-red-100 bg-white shadow-sm"
            >
                <div
                    class="border-b border-red-100 bg-red-50/40 px-6 py-5"
                >
                    <h2 class="text-base font-semibold text-red-700">
                        Danger Zone
                    </h2>

                    <p class="mt-1 text-sm text-red-500">
                        Permanently delete your company account.
                    </p>
                </div>

                <div
                    class="flex flex-col gap-5 p-6 sm:flex-row sm:items-center sm:justify-between"
                >
                    <div>
                        <h3 class="text-sm font-semibold text-gray-800">
                            Delete Company Account
                        </h3>

                        <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500">
                            Once deleted, your account and associated information
                            cannot be recovered.
                        </p>
                    </div>

                    <button
                        type="button"
                        class="shrink-0 rounded-lg bg-red-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-red-700"
                        @click="openDeleteModal"
                    >
                        Delete Account
                    </button>
                </div>
            </section>
        </div>

        <!-- ==========================================================
             DELETE MODAL
        =========================================================== -->

        <Teleport to="body">
            <div
                v-if="showDeleteModal"
                class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/40 p-4"
                @click.self="closeDeleteModal"
            >
                <div
                    class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl"
                >
                    <div
                        class="flex h-11 w-11 items-center justify-center rounded-full bg-red-100 text-red-600"
                    >
                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            class="h-5 w-5"
                        >
                            <path d="M3 6h18" />
                            <path d="M8 6V4h8v2" />
                            <path d="M19 6l-1 14H6L5 6" />
                            <path d="M10 11v5" />
                            <path d="M14 11v5" />
                        </svg>
                    </div>

                    <h2 class="mt-4 text-lg font-semibold text-gray-900">
                        Delete company account?
                    </h2>

                    <p class="mt-2 text-sm leading-6 text-gray-500">
                        This action cannot be undone. Enter your password
                        to confirm deletion.
                    </p>

                    <form
                        class="mt-6"
                        @submit.prevent="deleteAccount"
                    >
                        <label
                            for="delete_password"
                            class="mb-2 block text-sm font-medium text-gray-700"
                        >
                            Password
                        </label>

                        <input
                            id="delete_password"
                            ref="deletePasswordInput"
                            v-model="deleteForm.password"
                            type="password"
                            autocomplete="current-password"
                            placeholder="Enter your password"
                            class="w-full rounded-lg border border-gray-200 px-3.5 py-2.5 text-sm outline-none transition placeholder:text-gray-300 focus:border-red-400 focus:ring-2 focus:ring-red-100"
                        />

                        <p
                            v-if="deleteForm.errors.password"
                            class="mt-1.5 text-xs text-red-500"
                        >
                            {{ deleteForm.errors.password }}
                        </p>

                        <div class="mt-6 flex justify-end gap-3">
                            <button
                                type="button"
                                class="rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm font-semibold text-gray-600 transition hover:bg-gray-50"
                                @click="closeDeleteModal"
                            >
                                Cancel
                            </button>

                            <button
                                type="submit"
                                :disabled="
                                    deleteForm.processing ||
                                    !deleteForm.password
                                "
                                class="rounded-lg bg-red-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-red-700 disabled:cursor-not-allowed disabled:opacity-50"
                            >
                                {{
                                    deleteForm.processing
                                        ? 'Deleting...'
                                        : 'Delete Account'
                                }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </Teleport>
    </EntrepriseLayout>
</template>
