<script setup>
import { Link } from '@inertiajs/vue3'

const props = defineProps({
    stagiaire: {
        type: Object,
        required: true,
    },
    errors: {
        type: Object,
        default: () => ({}),
    },
})
const emit = defineEmits([
    'photo-change',
])
const handlePhoto = (event) => {
    emit('photo-change', event)
}
</script>

<template>
    <div class="mb-6">

        <!-- Back -->
        <Link
            :href="route('stagiaire.profile.show')"
            class="mb-4 inline-flex items-center gap-2 text-xs font-semibold text-slate-500 transition hover:text-[#16425B]"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-4 w-4"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M15 19l-7-7 7-7"
                />
            </svg>

            Back to Profile
        </Link>

        <!-- Header -->
        <div
            class="flex flex-col gap-5 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:flex-row sm:items-center sm:justify-between sm:p-6"
        >

            <!-- Title -->
            <div class="flex items-center gap-4">

                <!-- Photo -->
                <div
                    class="flex h-16 w-16 shrink-0 items-center justify-center overflow-hidden rounded-full bg-[#E8F1F5] text-base font-bold text-[#16425B]"
                >
                    <img
                        v-if="stagiaire.photo"
                        :src="`/storage/${stagiaire.photo}`"
                        :alt="stagiaire.nom_complet"
                        class="h-full w-full object-cover"
                    />

                    <span v-else>
                        {{
                            stagiaire.nom_complet
                                ?.split(' ')
                                .filter(Boolean)
                                .slice(0, 2)
                                .map(word => word[0])
                                .join('')
                                .toUpperCase()
                        }}
                    </span>
                </div>

                <div>
                    <h1
                        class="text-xl font-bold text-[#16425B] sm:text-2xl"
                    >
                        Edit Profile
                    </h1>

                    <p class="mt-1 text-xs text-slate-500 sm:text-sm">
                        Update your personal, academic and professional
                        information.
                    </p>
                </div>
            </div>

            <!-- Change Photo -->
            <div class="shrink-0">

                <label
                    for="profile-photo"
                    class="inline-flex cursor-pointer items-center rounded-lg border border-slate-200 bg-white px-4 py-2 text-xs font-semibold text-[#16425B] transition hover:border-[#81C3D7] hover:bg-[#F4F7F9]"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="mr-2 h-4 w-4"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"
                        />
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"
                        />
                    </svg>

                    Change Photo
                </label>

                <input
                    id="profile-photo"
                    type="file"
                    accept="image/jpeg,image/png,image/jpg,image/webp"
                    class="hidden"
                    @change="handlePhoto"
                />

                <p class="mt-2 text-right text-[10px] text-slate-400">
                    JPG, PNG or WEBP · Max 2 MB
                </p>

                <p
                    v-if="errors.photo"
                    class="mt-1 text-right text-xs text-[#D80536]"
                >
                    {{ errors.photo }}
                </p>
            </div>

        </div>

    </div>
</template>