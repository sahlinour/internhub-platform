<script setup>
defineProps({
    offres: {
        type: Array,
        default: () => [],
    },
    filters: {
        type: Object,
        default: () => ({
            statut: '',
            offre_id: '',
        }),
    },
})

defineEmits([
    'status-change',
    'offer-change',
])
</script>

<template>
    <div
        class="flex flex-col gap-3
               sm:flex-row sm:items-center"
    >

        <!-- STATUS -->
        <div class="relative">
            <select
                :value="filters?.statut || ''"
                @change="$emit('status-change', $event)"
                class="h-10 min-w-[165px]
                       appearance-none rounded-lg
                       border border-slate-200
                       bg-white px-3 pr-9
                       text-xs font-medium
                       text-slate-700 outline-none
                       transition
                       focus:border-[#3A7CA5]
                       focus:ring-2
                       focus:ring-[#E8F1F5]"
            >
                <option value="">
                    All Statuses
                </option>

                <option value="en_attente">
                    Pending
                </option>

                <option value="acceptee">
                    Accepted
                </option>

                <option value="refusee">
                    Rejected
                </option>
            </select>

            <svg
                class="pointer-events-none
                       absolute right-3 top-1/2
                       h-3.5 w-3.5
                       -translate-y-1/2
                       text-slate-400"
                viewBox="0 0 20 20"
                fill="currentColor"
            >
                <path
                    fill-rule="evenodd"
                    d="M5.23 7.21a.75.75 0 011.06.02L10 11.17l3.71-3.94a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06Z"
                    clip-rule="evenodd"
                />
            </svg>
        </div>

        <!-- INTERNSHIP -->
        <div class="relative">
            <select
                :value="filters?.offre_id || ''"
                @change="$emit('offer-change', $event)"
                class="h-10 min-w-[220px]
                       appearance-none rounded-lg
                       border border-slate-200
                       bg-white px-3 pr-9
                       text-xs font-medium
                       text-slate-700 outline-none
                       transition
                       focus:border-[#3A7CA5]
                       focus:ring-2
                       focus:ring-[#E8F1F5]"
            >
                <option value="">
                    All Internships
                </option>

                <option
                    v-for="offre in offres"
                    :key="offre.id"
                    :value="offre.id"
                >
                    {{ offre.titre }}
                </option>
            </select>

            <svg
                class="pointer-events-none
                       absolute right-3 top-1/2
                       h-3.5 w-3.5
                       -translate-y-1/2
                       text-slate-400"
                viewBox="0 0 20 20"
                fill="currentColor"
            >
                <path
                    fill-rule="evenodd"
                    d="M5.23 7.21a.75.75 0 011.06.02L10 11.17l3.71-3.94a.75.75 0 111.08 1.04l-4.25-4.5a.75.75 0 01-1.08 1.04l-4.25-4.5a.75.75 0 01.02-1.06Z"
                    clip-rule="evenodd"
                />
            </svg>
        </div>

    </div>
</template>