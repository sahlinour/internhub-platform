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
                Academic Information
            </h2>

            <p class="mt-0.5 text-xs text-slate-400">
                Your university and academic background.
            </p>
        </div>

        <div
            class="grid gap-5 p-5 sm:grid-cols-2 sm:p-6"
        >

            <!-- University -->
            <div>
                <label
                    for="universite"
                    class="mb-1.5 block text-xs font-semibold text-slate-600"
                >
                    University
                </label>

                <input
                    id="universite"
                    v-model="form.universite"
                    type="text"
                    class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700 outline-none transition focus:border-[#3A7CA5] focus:ring-2 focus:ring-[#81C3D7]/30"
                />

                <p
                    v-if="errors.universite"
                    class="mt-1 text-xs text-[#D80536]"
                >
                    {{ errors.universite }}
                </p>
            </div>

            <!-- Field -->
            <div>
                <label
                    for="filiere"
                    class="mb-1.5 block text-xs font-semibold text-slate-600"
                >
                    Field of Study
                </label>

                <input
                    id="filiere"
                    v-model="form.filiere"
                    type="text"
                    class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700 outline-none transition focus:border-[#3A7CA5] focus:ring-2 focus:ring-[#81C3D7]/30"
                />

                <p
                    v-if="errors.filiere"
                    class="mt-1 text-xs text-[#D80536]"
                >
                    {{ errors.filiere }}
                </p>
            </div>

            <!-- Level -->
            <div>
                <label
                    for="niveau"
                    class="mb-1.5 block text-xs font-semibold text-slate-600"
                >
                    Academic Level
                </label>

                <input
                    id="niveau"
                    v-model="form.niveau"
                    type="text"
                    class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-700 outline-none transition focus:border-[#3A7CA5] focus:ring-2 focus:ring-[#81C3D7]/30"
                />

                <p
                    v-if="errors.niveau"
                    class="mt-1 text-xs text-[#D80536]"
                >
                    {{ errors.niveau }}
                </p>
            </div>

        </div>
    </section>
</template>