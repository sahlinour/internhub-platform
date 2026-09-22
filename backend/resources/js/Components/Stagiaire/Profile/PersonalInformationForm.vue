<script setup>
const form = defineModel({
    type: Object,
    required: true,
})

defineProps({
    errors: {
        type: Object,
        default: () => ({}),
    },
})
</script>

<template>
    <section
        class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
    >
        <div
            class="border-b border-slate-100 px-5 py-4 sm:px-6"
        >
            <h2 class="text-sm font-bold text-[#16425B]">
                Personal Information
            </h2>

            <p class="mt-0.5 text-xs text-slate-400">
                Your basic personal information.
            </p>
        </div>

        <div
            class="grid gap-5 p-5 sm:grid-cols-2 sm:p-6"
        >

            <!-- Full Name -->
            <div>
                <label
                    for="nom_complet"
                    class="mb-1.5 block text-xs font-semibold text-slate-600"
                >
                    Full Name
                </label>

                <input
                    id="nom_complet"
                    v-model="form.nom_complet"
                    type="text"
                    class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700 outline-none transition placeholder:text-slate-300 focus:border-[#3A7CA5] focus:ring-2 focus:ring-[#81C3D7]/30"
                />

                <p
                    v-if="errors.nom_complet"
                    class="mt-1 text-xs text-[#D80536]"
                >
                    {{ errors.nom_complet }}
                </p>
            </div>

            <!-- Email -->
            <div>
                <label
                    for="email"
                    class="mb-1.5 block text-xs font-semibold text-slate-600"
                >
                    Email
                </label>

                <input
                    id="email"
                    v-model="form.email"
                    type="email"
                    class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700 outline-none transition placeholder:text-slate-300 focus:border-[#3A7CA5] focus:ring-2 focus:ring-[#81C3D7]/30"
                />

                <p
                    v-if="errors.email"
                    class="mt-1 text-xs text-[#D80536]"
                >
                    {{ errors.email }}
                </p>
            </div>

            <!-- Phone -->
            <div>
                <label
                    for="telephone"
                    class="mb-1.5 block text-xs font-semibold text-slate-600"
                >
                    Phone
                </label>

                <input
                    id="telephone"
                    v-model="form.telephone"
                    type="text"
                    class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700 outline-none transition placeholder:text-slate-300 focus:border-[#3A7CA5] focus:ring-2 focus:ring-[#81C3D7]/30"
                />

                <p
                    v-if="errors.telephone"
                    class="mt-1 text-xs text-[#D80536]"
                >
                    {{ errors.telephone }}
                </p>
            </div>

            <!-- Birth Date -->
            <div>
                <label
                    for="date_naissance"
                    class="mb-1.5 block text-xs font-semibold text-slate-600"
                >
                    Date of Birth
                </label>

                <input
                    id="date_naissance"
                    v-model="form.date_naissance"
                    type="date"
                    class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700 outline-none transition focus:border-[#3A7CA5] focus:ring-2 focus:ring-[#81C3D7]/30"
                />

                <p
                    v-if="errors.date_naissance"
                    class="mt-1 text-xs text-[#D80536]"
                >
                    {{ errors.date_naissance }}
                </p>
            </div>

        </div>
    </section>
</template>