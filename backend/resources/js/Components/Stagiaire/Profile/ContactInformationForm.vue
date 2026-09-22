<script setup>
const form = defineModel({
    type: Object,
    required: true,
})

const props = defineProps({
    villes: {
        type: Array,
        default: () => [],
    },
    errors: {
        type: Object,
        default: () => ({}),
    },
    currentCv: {
        type: String,
        default: null,
    },
})
const emit = defineEmits([
    'cv-change',
])
const handleCv = (event) => {
    emit('cv-change', event)
}
</script>

<template>
    <section
        class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
    >
        <div
            class="border-b border-slate-100 px-5 py-4 sm:px-6"
        >
            <h2 class="text-sm font-bold text-[#16425B]">
                Contact & Professional Information
            </h2>

            <p class="mt-0.5 text-xs text-slate-400">
                Your contact details, professional links and documents.
            </p>
        </div>

        <div class="space-y-6 p-5 sm:p-6">

            <!-- City -->
            <div>
                <label
                    for="ville_id"
                    class="mb-1.5 block text-xs font-semibold text-slate-600"
                >
                    City
                </label>

                <select
                    id="ville_id"
                    v-model="form.ville_id"
                    class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700 outline-none transition focus:border-[#3A7CA5] focus:ring-2 focus:ring-[#81C3D7]/30"
                >
                    <option value="" disabled>
                        Select your city
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
                    v-if="errors.ville_id"
                    class="mt-1 text-xs text-[#D80536]"
                >
                    {{ errors.ville_id }}
                </p>
            </div>

            <!-- LinkedIn -->
            <div>
                <label
                    for="linkedin_url"
                    class="mb-1.5 block text-xs font-semibold text-slate-600"
                >
                    LinkedIn URL
                </label>

                <input
                    id="linkedin_url"
                    v-model="form.linkedin_url"
                    type="url"
                    placeholder="https://linkedin.com/in/..."
                    class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700 outline-none transition placeholder:text-slate-300 focus:border-[#3A7CA5] focus:ring-2 focus:ring-[#81C3D7]/30"
                />

                <p
                    v-if="errors.linkedin_url"
                    class="mt-1 text-xs text-[#D80536]"
                >
                    {{ errors.linkedin_url }}
                </p>
            </div>

            <!-- Portfolio -->
            <div>
                <label
                    for="portfolio_url"
                    class="mb-1.5 block text-xs font-semibold text-slate-600"
                >
                    Portfolio URL
                </label>

                <input
                    id="portfolio_url"
                    v-model="form.portfolio_url"
                    type="url"
                    placeholder="https://..."
                    class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700 outline-none transition placeholder:text-slate-300 focus:border-[#3A7CA5] focus:ring-2 focus:ring-[#81C3D7]/30"
                />

                <p
                    v-if="errors.portfolio_url"
                    class="mt-1 text-xs text-[#D80536]"
                >
                    {{ errors.portfolio_url }}
                </p>
            </div>

            <!-- Internship Status -->
            <div>
                <label
                    for="statut_stage"
                    class="mb-1.5 block text-xs font-semibold text-slate-600"
                >
                    Internship Status
                </label>

                <select
                    id="statut_stage"
                    v-model="form.statut_stage"
                    class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700 outline-none transition focus:border-[#3A7CA5] focus:ring-2 focus:ring-[#81C3D7]/30"
                >
                    <option value="">
                        Select status
                    </option>

                    <option value="recherche">
                        Looking for an internship
                    </option>

                    <option value="en_attente">
                        Application pending
                    </option>

                    <option value="en_cours">
                        Currently in an internship
                    </option>

                    <option value="termine">
                        Internship completed
                    </option>

                    <option value="annule">
                        Cancelled
                    </option>
                </select>

                <p
                    v-if="errors.statut_stage"
                    class="mt-1 text-xs text-[#D80536]"
                >
                    {{ errors.statut_stage }}
                </p>
            </div>

            <!-- CV -->
            <div class="border-t border-slate-100 pt-5">

                <label
                    class="mb-1.5 block text-xs font-semibold text-slate-600"
                >
                    Curriculum Vitae
                </label>

                <div
                    class="rounded-xl border border-slate-200 bg-[#F4F7F9] p-4"
                >
                    <!-- Current CV -->
                    <div
                        v-if="currentCv"
                        class="mb-4 flex items-center gap-3"
                    >
                        <div
                            class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[#E8F1F5] text-[10px] font-bold text-[#16425B]"
                        >
                            CV
                        </div>

                        <div class="min-w-0">
                            <p
                                class="truncate text-xs font-semibold text-[#16425B]"
                            >
                                {{ currentCv.split('/').pop() }}
                            </p>

                            <p class="text-[10px] text-slate-400">
                                Current CV
                            </p>
                        </div>
                    </div>

                    <label
                        for="cv"
                        class="inline-flex cursor-pointer items-center rounded-lg border border-slate-200 bg-white px-4 py-2 text-xs font-semibold text-[#16425B] transition hover:border-[#81C3D7]"
                    >
                        Choose New CV
                    </label>

                    <input
                        id="cv"
                        type="file"
                        accept=".pdf,.doc,.docx"
                        class="hidden"
                        @change="handleCv"
                    />

                    <p class="mt-2 text-[10px] text-slate-400">
                        PDF, DOC or DOCX. Maximum 5 MB.
                    </p>

                    <p
                        v-if="form.cv"
                        class="mt-2 text-xs font-medium text-[#3A7CA5]"
                    >
                        Selected: {{ form.cv.name }}
                    </p>

                    <p
                        v-if="errors.cv"
                        class="mt-1 text-xs text-[#D80536]"
                    >
                        {{ errors.cv }}
                    </p>
                </div>
            </div>

        </div>
    </section>
</template>