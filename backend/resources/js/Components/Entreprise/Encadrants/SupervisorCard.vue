<script setup>
defineProps({
    user: {
        type: Object,
        required: true,
    },
    initials: {
        type: String,
        default: 'SU',
    },
    subtitle: {
        type: String,
        default: 'Supervisor',
    },
})

const emit = defineEmits([
    'edit',
    'delete',
])
</script>

<template>
    <article
        class="rounded-2xl border border-slate-200
               bg-white p-4 shadow-sm
               transition duration-200
               hover:-translate-y-0.5 hover:shadow-md"
    >
        <!-- PROFILE -->
        <div class="flex items-center gap-3">
            <div
                class="flex h-11 w-11 shrink-0
                       items-center justify-center
                       rounded-full
                       bg-[#E8F1F5]
                       text-xs font-bold
                       text-[#16425B]"
            >
                {{ initials }}
            </div>

            <div class="min-w-0 flex-1">
                <h3
                    class="truncate text-sm font-bold
                           text-[#16425B]"
                >
                    {{ user.nom_complet }}
                </h3>

                <p
                    class="mt-0.5 truncate
                           text-[11px] text-slate-400"
                >
                    {{ subtitle }}
                </p>
            </div>
        </div>

        <!-- CONTACT -->
        <div
            class="mt-4 space-y-2
                   border-t border-slate-100
                   pt-3"
        >
            <div class="flex items-center gap-2">
                <svg
                    class="h-3.5 w-3.5 shrink-0 text-slate-400"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.7"
                        d="M3 8l9 6 9-6M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                    />
                </svg>

                <span
                    class="truncate text-xs text-slate-600"
                >
                    {{ user.email }}
                </span>
            </div>

            <div
                v-if="user.telephone"
                class="flex items-center gap-2"
            >
                <svg
                    class="h-3.5 w-3.5 shrink-0 text-slate-400"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.7"
                        d="M6.6 10.8a15.5 15.5 0 006.6 6.6l2.2-2.2a1.5 1.5 0 011.5-.36l2.4.8a1.5 1.5 0 011 1.43v2.2a1.5 1.5 0 01-1.64 1.5A17.5 17.5 0 013.7 3.84 1.5 1.5 0 015.2 2.2h2.2a1.5 1.5 0 011.43 1l.8 2.4a1.5 1.5 0 01-.36 1.5l-2.67 2.7z"
                    />
                </svg>

                <span class="text-xs text-slate-600">
                    {{ user.telephone }}
                </span>
            </div>
        </div>

        <!-- DETAILS -->
        <div
            v-if="
                user.encadrant?.poste ||
                user.encadrant?.specialite ||
                user.encadrant?.departement
            "
            class="mt-3 flex flex-wrap gap-1.5"
        >
            <span
                v-if="user.encadrant?.poste"
                class="rounded-full bg-slate-100
                       px-2 py-1
                       text-[10px] font-medium
                       text-slate-600"
            >
                {{ user.encadrant.poste }}
            </span>

            <span
                v-if="user.encadrant?.specialite"
                class="rounded-full bg-[#E8F1F5]
                       px-2 py-1
                       text-[10px] font-medium
                       text-[#3A7CA5]"
            >
                {{ user.encadrant.specialite }}
            </span>

            <span
                v-if="user.encadrant?.departement"
                class="rounded-full bg-slate-100
                       px-2 py-1
                       text-[10px] font-medium
                       text-slate-600"
            >
                {{ user.encadrant.departement }}
            </span>
        </div>

        <!-- FOOTER -->
        <div
            class="mt-4 flex items-center
                   justify-between gap-2
                   border-t border-slate-100
                   pt-3"
        >
            <p
                class="truncate text-[10px]
                       text-slate-400"
            >
                {{ user.ville?.nom ?? 'City not specified' }}
            </p>

            <div class="flex shrink-0 gap-1.5">
                <button
                    type="button"
                    class="rounded-lg border
                           border-slate-200
                           px-2.5 py-1.5
                           text-[10px] font-semibold
                           text-slate-600
                           transition
                           hover:border-[#3A7CA5]
                           hover:text-[#3A7CA5]"
                    @click="emit('edit', user)"
                >
                    Edit
                </button>

                <button
                    type="button"
                    class="rounded-lg border
                           border-red-100
                           px-2.5 py-1.5
                           text-[10px] font-semibold
                           text-red-500
                           transition
                           hover:bg-red-50"
                    @click="emit('delete', user)"
                >
                    Delete
                </button>
            </div>
        </div>
    </article>
</template>