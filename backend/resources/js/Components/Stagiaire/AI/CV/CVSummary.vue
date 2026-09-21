<script setup>
defineProps({
    fileName: {
        type: String,
        required: true,
    },

    resultsCount: {
        type: Number,
        default: 0,
    },

    skills: {
        type: Array,
        default: () => [],
    },
})

const emit = defineEmits(['reset'])
</script>

<template>
    <div
        class="rounded-2xl border border-[#E2E8F0] bg-white p-5 shadow-[0_2px_12px_rgba(22,66,91,0.05)]"
    >

        <!-- Header -->
        <div
            class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
        >

            <div class="min-w-0">

                <p
                    class="text-[9px] font-bold uppercase tracking-[1px] text-[#3A7CA5]"
                >
                    CV analyzed
                </p>

                <h2
                    class="mt-1 truncate text-[16px] font-bold text-[#16425B]"
                >
                    {{ fileName }}
                </h2>

                <p
                    class="mt-1 text-[11px] text-[#64748B]"
                >
                    {{ resultsCount }}
                    internship offer<span v-if="resultsCount !== 1">s</span>
                    found
                </p>

            </div>

            <button
                type="button"
                class="rounded-lg bg-[#16425B] px-4 py-2.5 text-[11px] font-semibold text-white transition hover:bg-[#2F6690]"
                @click="emit('reset')"
            >
                Upload another CV
            </button>

        </div>

        <!-- Skills -->
        <div
            v-if="skills.length"
            class="mt-5 border-t border-[#EDF2F5] pt-5"
        >

            <div
                class="flex items-center justify-between"
            >
                <p
                    class="text-[11px] font-semibold text-[#16425B]"
                >
                    Detected skills
                </p>

                <span
                    class="text-[9px] text-[#64748B]"
                >
                    {{ skills.length }} detected
                </span>
            </div>

            <div
                class="mt-3 flex flex-wrap gap-2"
            >
                <span
                    v-for="skill in skills"
                    :key="skill"
                    class="rounded-full border border-[#81C3D7]/40 bg-[#E8F1F5] px-3 py-1.5 text-[10px] font-semibold text-[#16425B]"
                >
                    {{ skill }}
                </span>
            </div>

        </div>

    </div>
</template>