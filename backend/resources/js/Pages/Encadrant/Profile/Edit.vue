<script setup>
import { Head, useForm } from '@inertiajs/vue3'
import EncadrantLayout from '@/Layouts/EncadrantLayout.vue'

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },

    encadrant: {
        type: Object,
        default: null,
    },
})

const profileForm = useForm({
    nom_complet: props.user.nom_complet ?? '',
    email: props.user.email ?? '',
    telephone: props.user.telephone ?? '',
    poste: props.encadrant?.poste ?? '',
    specialite: props.encadrant?.specialite ?? '',
    departement: props.encadrant?.departement ?? '',
})

const passwordForm = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
})

const updateProfile = () => {
    profileForm.patch('/encadrant/profile', {
        preserveScroll: true,
    })
}

const updatePassword = () => {
    passwordForm.put('/encadrant/profile/password', {
        preserveScroll: true,

        onSuccess: () => {
            passwordForm.reset()
        },
    })
}
</script>

<template>
    <Head title="Settings" />

    <EncadrantLayout>
        <div class="p-6 lg:p-8">

            <!-- Header -->
            <div class="mb-7">
                <h1 class="text-2xl font-bold text-gray-900">
                    Settings
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Manage your profile and account security.
                </p>
            </div>

            <div class="max-w-4xl space-y-6">

                <!-- PROFILE INFORMATION -->
                <div
                    class="rounded-2xl border border-gray-200
                           bg-white shadow-sm"
                >
                    <div
                        class="border-b border-gray-100
                               px-6 py-5"
                    >
                        <h2 class="text-base font-semibold text-gray-900">
                            Profile Information
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            Update your personal and professional information.
                        </p>
                    </div>

                    <form
                        class="space-y-6 p-6"
                        @submit.prevent="updateProfile"
                    >
                        <!-- Full Name -->
                        <div>
                            <label
                                class="mb-2 block text-sm
                                       font-semibold text-gray-700"
                            >
                                Full Name
                            </label>

                            <input
                                v-model="profileForm.nom_complet"
                                type="text"
                                required
                                class="block w-full rounded-xl
                                       border border-gray-300
                                       px-4 py-3 text-sm
                                       text-gray-800 shadow-sm
                                       outline-none transition
                                       focus:border-[#17629b]
                                       focus:ring-2
                                       focus:ring-[#17629b]/10"
                            />

                            <p
                                v-if="profileForm.errors.nom_complet"
                                class="mt-1.5 text-xs text-red-600"
                            >
                                {{ profileForm.errors.nom_complet }}
                            </p>
                        </div>

                        <!-- Email + Phone -->
                        <div class="grid gap-5 md:grid-cols-2">

                            <!-- Email -->
                            <div>
                                <label
                                    class="mb-2 block text-sm
                                           font-semibold text-gray-700"
                                >
                                    Email Address
                                </label>

                                <input
                                    v-model="profileForm.email"
                                    type="email"
                                    required
                                    class="block w-full rounded-xl
                                           border border-gray-300
                                           px-4 py-3 text-sm
                                           text-gray-800 shadow-sm
                                           outline-none transition
                                           focus:border-[#17629b]
                                           focus:ring-2
                                           focus:ring-[#17629b]/10"
                                />

                                <p
                                    v-if="profileForm.errors.email"
                                    class="mt-1.5 text-xs text-red-600"
                                >
                                    {{ profileForm.errors.email }}
                                </p>
                            </div>

                            <!-- Phone -->
                            <div>
                                <label
                                    class="mb-2 block text-sm
                                           font-semibold text-gray-700"
                                >
                                    Phone
                                </label>

                                <input
                                    v-model="profileForm.telephone"
                                    type="text"
                                    placeholder="+212 ..."
                                    class="block w-full rounded-xl
                                           border border-gray-300
                                           px-4 py-3 text-sm
                                           text-gray-800 shadow-sm
                                           outline-none transition
                                           focus:border-[#17629b]
                                           focus:ring-2
                                           focus:ring-[#17629b]/10"
                                />

                                <p
                                    v-if="profileForm.errors.telephone"
                                    class="mt-1.5 text-xs text-red-600"
                                >
                                    {{ profileForm.errors.telephone }}
                                </p>
                            </div>
                        </div>

                        <!-- Position + Specialty -->
                        <div class="grid gap-5 md:grid-cols-2">

                            <!-- Position -->
                            <div>
                                <label
                                    class="mb-2 block text-sm
                                           font-semibold text-gray-700"
                                >
                                    Position
                                </label>

                                <input
                                    v-model="profileForm.poste"
                                    type="text"
                                    placeholder="e.g. Software Engineer"
                                    class="block w-full rounded-xl
                                           border border-gray-300
                                           px-4 py-3 text-sm
                                           text-gray-800 shadow-sm
                                           outline-none transition
                                           focus:border-[#17629b]
                                           focus:ring-2
                                           focus:ring-[#17629b]/10"
                                />

                                <p
                                    v-if="profileForm.errors.poste"
                                    class="mt-1.5 text-xs text-red-600"
                                >
                                    {{ profileForm.errors.poste }}
                                </p>
                            </div>

                            <!-- Specialty -->
                            <div>
                                <label
                                    class="mb-2 block text-sm
                                           font-semibold text-gray-700"
                                >
                                    Specialty
                                </label>

                                <input
                                    v-model="profileForm.specialite"
                                    type="text"
                                    placeholder="e.g. Web Development"
                                    class="block w-full rounded-xl
                                           border border-gray-300
                                           px-4 py-3 text-sm
                                           text-gray-800 shadow-sm
                                           outline-none transition
                                           focus:border-[#17629b]
                                           focus:ring-2
                                           focus:ring-[#17629b]/10"
                                />

                                <p
                                    v-if="profileForm.errors.specialite"
                                    class="mt-1.5 text-xs text-red-600"
                                >
                                    {{ profileForm.errors.specialite }}
                                </p>
                            </div>
                        </div>

                        <!-- Department -->
                        <div>
                            <label
                                class="mb-2 block text-sm
                                       font-semibold text-gray-700"
                            >
                                Department
                            </label>

                            <input
                                v-model="profileForm.departement"
                                type="text"
                                placeholder="e.g. IT Department"
                                class="block w-full rounded-xl
                                       border border-gray-300
                                       px-4 py-3 text-sm
                                       text-gray-800 shadow-sm
                                       outline-none transition
                                       focus:border-[#17629b]
                                       focus:ring-2
                                       focus:ring-[#17629b]/10"
                            />

                            <p
                                v-if="profileForm.errors.departement"
                                class="mt-1.5 text-xs text-red-600"
                            >
                                {{ profileForm.errors.departement }}
                            </p>
                        </div>

                        <!-- Role -->
                        <div>
                            <label
                                class="mb-2 block text-sm
                                       font-semibold text-gray-700"
                            >
                                Role
                            </label>

                            <input
                                :value="user.role"
                                disabled
                                type="text"
                                class="block w-full cursor-not-allowed
                                       rounded-xl border border-gray-200
                                       bg-gray-50 px-4 py-3
                                       text-sm text-gray-500"
                            />

                            <p class="mt-1.5 text-xs text-gray-400">
                                Your role cannot be changed here.
                            </p>
                        </div>

                        <!-- Save Profile -->
                        <div
                            class="flex justify-end
                                   border-t border-gray-100 pt-5"
                        >
                            <button
                                type="submit"
                                :disabled="profileForm.processing"
                                class="rounded-xl bg-[#17629b]
                                       px-5 py-2.5
                                       text-sm font-semibold
                                       text-white transition
                                       hover:bg-[#124f7e]
                                       disabled:cursor-not-allowed
                                       disabled:opacity-50"
                            >
                                {{
                                    profileForm.processing
                                        ? 'Saving...'
                                        : 'Save Changes'
                                }}
                            </button>
                        </div>
                    </form>
                </div>


                <!-- CHANGE PASSWORD -->
                <div
                    class="rounded-2xl border border-gray-200
                           bg-white shadow-sm"
                >
                    <div
                        class="border-b border-gray-100
                               px-6 py-5"
                    >
                        <h2 class="text-base font-semibold text-gray-900">
                            Change Password
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            Use a strong password to protect your account.
                        </p>
                    </div>

                    <form
                        class="space-y-5 p-6"
                        @submit.prevent="updatePassword"
                    >
                        <!-- Current Password -->
                        <div>
                            <label
                                class="mb-2 block text-sm
                                       font-semibold text-gray-700"
                            >
                                Current Password
                            </label>

                            <input
                                v-model="passwordForm.current_password"
                                type="password"
                                autocomplete="current-password"
                                required
                                class="block w-full rounded-xl
                                       border border-gray-300
                                       px-4 py-3 text-sm
                                       shadow-sm outline-none transition
                                       focus:border-[#17629b]
                                       focus:ring-2
                                       focus:ring-[#17629b]/10"
                            />

                            <p
                                v-if="passwordForm.errors.current_password"
                                class="mt-1.5 text-xs text-red-600"
                            >
                                {{ passwordForm.errors.current_password }}
                            </p>
                        </div>

                        <!-- New Passwords -->
                        <div class="grid gap-5 md:grid-cols-2">

                            <!-- New Password -->
                            <div>
                                <label
                                    class="mb-2 block text-sm
                                           font-semibold text-gray-700"
                                >
                                    New Password
                                </label>

                                <input
                                    v-model="passwordForm.password"
                                    type="password"
                                    autocomplete="new-password"
                                    required
                                    class="block w-full rounded-xl
                                           border border-gray-300
                                           px-4 py-3 text-sm
                                           shadow-sm outline-none transition
                                           focus:border-[#17629b]
                                           focus:ring-2
                                           focus:ring-[#17629b]/10"
                                />

                                <p
                                    v-if="passwordForm.errors.password"
                                    class="mt-1.5 text-xs text-red-600"
                                >
                                    {{ passwordForm.errors.password }}
                                </p>
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label
                                    class="mb-2 block text-sm
                                           font-semibold text-gray-700"
                                >
                                    Confirm New Password
                                </label>

                                <input
                                    v-model="passwordForm.password_confirmation"
                                    type="password"
                                    autocomplete="new-password"
                                    required
                                    class="block w-full rounded-xl
                                           border border-gray-300
                                           px-4 py-3 text-sm
                                           shadow-sm outline-none transition
                                           focus:border-[#17629b]
                                           focus:ring-2
                                           focus:ring-[#17629b]/10"
                                />
                            </div>
                        </div>

                        <!-- Update Password -->
                        <div
                            class="flex justify-end
                                   border-t border-gray-100 pt-5"
                        >
                            <button
                                type="submit"
                                :disabled="passwordForm.processing"
                                class="rounded-xl bg-[#17629b]
                                       px-5 py-2.5
                                       text-sm font-semibold
                                       text-white transition
                                       hover:bg-[#124f7e]
                                       disabled:cursor-not-allowed
                                       disabled:opacity-50"
                            >
                                {{
                                    passwordForm.processing
                                        ? 'Updating...'
                                        : 'Update Password'
                                }}
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </EncadrantLayout>
</template>
