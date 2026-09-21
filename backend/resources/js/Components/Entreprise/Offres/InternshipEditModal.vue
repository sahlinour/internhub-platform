<script setup>
defineProps({
    show: Boolean,
    offre: Object,
    form: {
        type: Object,
        required: true,
    },
})

const emit = defineEmits(['close', 'submit'])

const fields = [
    { key: 'titre', label: 'Title', type: 'text', required: true },
    { key: 'duree', label: 'Duration', type: 'text', required: true },
    { key: 'date_limite', label: 'Deadline', type: 'date', required: true },
]
</script>

<template>
    <div
        v-if="show"
        class="fixed inset-0 z-[100] flex items-center justify-center
               bg-slate-950/40 p-4 backdrop-blur-sm"
        @click.self="emit('close')"
    >
        <div class="max-h-[92vh] w-full max-w-2xl overflow-y-auto rounded-2xl bg-white shadow-2xl">

            <!-- HEADER -->
            <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
                <div>
                    <h2 class="text-sm font-bold text-[#16425B]">
                        Edit Internship
                    </h2>
                    <p class="mt-0.5 text-[10px] text-slate-400">
                        Update internship information.
                    </p>
                </div>

                <button
                    type="button"
                    class="flex h-8 w-8 items-center justify-center rounded-lg
                           text-slate-400 transition hover:bg-slate-100 hover:text-slate-700"
                    @click="emit('close')"
                >
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- FORM -->
            <form class="p-5" @submit.prevent="emit('submit')">

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div
                        v-for="field in fields"
                        :key="field.key"
                        :class="field.key === 'titre' ? 'md:col-span-2' : ''"
                    >
                        <label class="mb-1.5 block text-[11px] font-semibold text-slate-600">
                            {{ field.label }}
                            <span v-if="field.required" class="text-red-500">*</span>
                        </label>

                        <input
                            v-model="form[field.key]"
                            :type="field.type"
                            class="w-full rounded-xl border border-slate-200
                                   px-3 py-2.5 text-xs text-slate-700
                                   outline-none transition
                                   focus:border-[#3A7CA5]
                                   focus:ring-2 focus:ring-[#3A7CA5]/10"
                        />

                        <p v-if="form.errors[field.key]" class="mt-1 text-[10px] text-red-500">
                            {{ form.errors[field.key] }}
                        </p>
                    </div>
                </div>

                <!-- DESCRIPTION -->
                <div class="mt-4">
                    <label class="mb-1.5 block text-[11px] font-semibold text-slate-600">
                        Description
                        <span class="text-red-500">*</span>
                    </label>

                    <textarea
                        v-model="form.description"
                        rows="5"
                        class="w-full rounded-xl border border-slate-200
                               px-3 py-2.5 text-xs text-slate-700
                               outline-none transition
                               focus:border-[#3A7CA5]
                               focus:ring-2 focus:ring-[#3A7CA5]/10"
                    />

                    <p v-if="form.errors.description" class="mt-1 text-[10px] text-red-500">
                        {{ form.errors.description }}
                    </p>
                </div>

                <!-- STATUS -->
                <div class="mt-4">
                    <label class="mb-1.5 block text-[11px] font-semibold text-slate-600">
                        Status
                    </label>

                    <select
                        v-model="form.statut"
                        class="w-full rounded-xl border border-slate-200
                               px-3 py-2.5 text-xs text-slate-700
                               outline-none transition
                               focus:border-[#3A7CA5]
                               focus:ring-2 focus:ring-[#3A7CA5]/10"
                    >
                        <option value="ouverte">Open</option>
                        <option value="en_attente">Pending</option>
                        <option value="fermee">Closed</option>
                    </select>

                    <p v-if="form.errors.statut" class="mt-1 text-[10px] text-red-500">
                        {{ form.errors.statut }}
                    </p>
                </div>

                <!-- ACTIONS -->
                <div class="mt-5 flex justify-end gap-2 border-t border-slate-100 pt-4">
                    <button
                        type="button"
                        class="rounded-xl border border-slate-200 bg-white
                               px-4 py-2 text-xs font-semibold text-slate-600
                               hover:bg-slate-50"
                        @click="emit('close')"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="rounded-xl bg-[#16425B] px-4 py-2
                               text-xs font-semibold text-white transition
                               hover:bg-[#12364B] disabled:opacity-50"
                    >
                        {{ form.processing ? 'Saving...' : 'Save Changes' }}
                    </button>
                </div>

            </form>
        </div>
    </div>
</template>