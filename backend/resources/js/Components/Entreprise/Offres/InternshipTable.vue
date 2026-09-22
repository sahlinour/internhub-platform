<script setup>
import InternshipRow from './InternshipTableRow.vue'

defineProps({
    offres: {
        type: Array,
        default: () => [],
    },
})

const emit = defineEmits(['edit', 'delete'])
</script>

<template>
    <div class="w-full">
        <!-- DESKTOP -->
        <div class="hidden overflow-x-auto md:block">
            <table class="w-full min-w-[760px] text-left">
                <thead class="border-b border-slate-100 bg-slate-50/60">
                    <tr class="text-[10px] font-semibold uppercase tracking-wide text-slate-400">
                        <th class="px-5 py-3">Internship</th>
                        <th class="px-5 py-3">Details</th>
                        <th class="px-5 py-3">Deadline</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3 text-right">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <InternshipRow
                        v-for="offre in offres"
                        :key="offre.id"
                        :offre="offre"
                        @edit="emit('edit', $event)"
                        @delete="emit('delete', $event)"
                    />

                    <tr v-if="!offres.length">
                        <td colspan="5" class="px-5 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <div
                                    class="flex h-10 w-10 items-center justify-center
                                           rounded-full bg-[#F4F7F9]"
                                >
                                    <svg
                                        class="h-5 w-5 text-slate-400"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.5"
                                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0H4"
                                        />
                                    </svg>
                                </div>

                                <p class="mt-3 text-xs font-semibold text-[#16425B]">
                                    No internships found
                                </p>

                                <p class="mt-1 text-[10px] text-slate-400">
                                    Create your first internship offer.
                                </p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- MOBILE -->
        <div class="divide-y divide-slate-100 md:hidden">
            <InternshipRow
                v-for="offre in offres"
                :key="offre.id"
                :offre="offre"
                @edit="emit('edit', $event)"
                @delete="emit('delete', $event)"
            />

            <div v-if="!offres.length" class="px-5 py-12 text-center">
                <p class="text-xs font-semibold text-[#16425B]">
                    No internships found
                </p>

                <p class="mt-1 text-[10px] text-slate-400">
                    Create your first internship offer.
                </p>
            </div>
        </div>
    </div>
</template>