<script setup>
import { Link } from '@inertiajs/vue3'
import Icon from '@/Components/Stagiaire/Icon.vue'

defineProps({
    stage: {
        type: Object,
        default: null,
    },
})
</script>

<template>
    <!-- Aucun stage -->
    <div
        v-if="!stage"
        class="flex flex-col items-center justify-center rounded-[11px] border border-dashed border-[#d9e3e9] bg-[#f8fafc] px-5 py-8 text-center"
    >
        <div
            class="mb-3 flex h-11 w-11 items-center justify-center rounded-[10px] bg-[#eaf2f6] text-[#286d93]"
        >
            <Icon
                name="graduation"
                :size="21"
            />
        </div>

        <h3 class="mb-1 text-[13px] font-bold text-[#20394b]">
            No active internship
        </h3>

        <p class="mb-4 max-w-[360px] text-[10px] leading-5 text-[#8b9aa5]">
            You don't have an active internship at the moment.
            Explore available internship opportunities and apply to the ones
            that match your profile.
        </p>

        <Link
            href="#"
            class="inline-flex items-center gap-2 rounded-[8px] bg-[#286d93] px-4 py-2.5 text-[10px] font-semibold text-white no-underline transition hover:bg-[#1f5d7d]"
        >
            <Icon
                name="briefcase"
                :size="14"
            />
            Browse Internship Offers
        </Link>
    </div>

    <!-- Stage actif -->
    <div
        v-else
        class="space-y-4"
    >
        <div
            class="flex items-start justify-between gap-4 rounded-[10px] bg-[#f6f9fb] p-4"
        >
            <div class="flex min-w-0 items-start gap-3">
                <div
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[9px] bg-[#286d93] text-white"
                >
                    <Icon
                        name="graduation"
                        :size="18"
                    />
                </div>

                <div class="min-w-0">
                    <h3 class="truncate text-[13px] font-bold text-[#20394b]">
                        {{ stage?.candidature?.offreDeStage?.titre ?? 'My Internship' }}
                    </h3>

                    <p class="mt-1 text-[10px] text-[#8b9aa5]">
                        Current internship
                    </p>
                </div>
            </div>

            <span
                class="shrink-0 rounded-full bg-[#e8f6ed] px-2.5 py-1 text-[9px] font-semibold text-[#4baa70]"
            >
                Active
            </span>
        </div>

        <div class="grid grid-cols-2 gap-3 max-[600px]:grid-cols-1">
            <div class="rounded-[9px] border border-[#e1e7ec] p-3">
                <span class="mb-1 block text-[9px] text-[#8b9aa5]">
                    Company
                </span>

                <strong class="text-[11px] text-[#20394b]">
                    {{ stage?.candidature?.offreDeStage?.entreprise?.nom ?? '—' }}
                </strong>
            </div>

            <div class="rounded-[9px] border border-[#e1e7ec] p-3">
                <span class="mb-1 block text-[9px] text-[#8b9aa5]">
                    Status
                </span>

                <strong class="text-[11px] text-[#20394b]">
                    Internship in progress
                </strong>
            </div>
        </div>

        <Link
            href="#"
            class="inline-flex items-center gap-2 text-[10px] font-semibold text-[#286d93] no-underline hover:underline"
        >
            View internship details
            <span>→</span>
        </Link>
    </div>
</template>