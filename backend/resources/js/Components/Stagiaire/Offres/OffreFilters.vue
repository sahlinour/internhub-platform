<script setup>
import { reactive } from 'vue'

const props = defineProps({
    villes: {
        type: Array,
        default: () => [],
    },
})

const emit = defineEmits(['filter'])

const filters = reactive({
    location: 'all',
    workType: [],
    duration: 'all',
    skills: '',
})

const applyFilters = () => {
    emit('filter', {
        ...filters,
        workType: [...filters.workType],
    })
}

const resetFilters = () => {
    filters.location = 'all'
    filters.workType = []
    filters.duration = 'all'
    filters.skills = ''

    applyFilters()
}
</script>

<template>
    <aside
        class="rounded-2xl border border-[#E8F1F5]
               bg-white p-4 shadow-sm
               lg:sticky lg:top-5"
    >
        <!-- HEADER -->
        <div
            class="mb-4 flex items-start justify-between
                   border-b border-[#E8F1F5] pb-4"
        >
            <div class="flex items-center gap-3">
                <div
                    class="flex h-9 w-9 shrink-0 items-center justify-center
                           rounded-lg bg-[#E8F1F5]"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-5 w-5 text-[#3A7CA5]"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3 5h18M6 12h12m-9 7h6"
                        />
                    </svg>
                </div>

                <div>
                    <h2 class="text-sm font-bold text-[#16425B]">
                        Filters
                    </h2>

                    <p class="mt-0.5 text-[11px] text-slate-400">
                        Find the right internship
                    </p>
                </div>
            </div>

            <button
                type="button"
                @click="resetFilters"
                class="text-[11px] font-semibold text-[#3A7CA5]
                       transition hover:text-[#16425B] hover:underline"
            >
                Reset
            </button>
        </div>

        <div class="space-y-4">

            <!-- LOCATION -->
            <div>
                <label
                    class="mb-1.5 flex items-center gap-2
                           text-[11px] font-bold uppercase
                           tracking-wide text-[#16425B]"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-3.5 w-3.5 text-[#3A7CA5]"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 21s7-6.1 7-12a7 7 0 1 0-14 0c0 5.9 7 12 7 12Z"
                        />

                        <circle
                            cx="12"
                            cy="9"
                            r="2.2"
                        />
                    </svg>

                    Location
                </label>

                <select
                    v-model="filters.location"
                    class="w-full rounded-lg
                           border border-[#E8F1F5]
                           bg-[#E8F1F5]/40
                           px-3 py-2.5
                           text-xs text-[#16425B]
                           outline-none transition
                           focus:border-[#3A7CA5]
                           focus:bg-white
                           focus:ring-2 focus:ring-[#81C3D7]/30"
                >
                    <option value="all">
                        All locations
                    </option>

                    <option
                        v-for="ville in props.villes"
                        :key="ville.id"
                        :value="ville.nom"
                    >
                        {{ ville.nom }}
                    </option>
                </select>
            </div>

            <!-- WORK TYPE -->
            <div>
                <label
                    class="mb-2 flex items-center gap-2
                           text-[11px] font-bold uppercase
                           tracking-wide text-[#16425B]"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-3.5 w-3.5 text-[#3A7CA5]"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9 7V5.5A1.5 1.5 0 0 1 10.5 4h3A1.5 1.5 0 0 1 15 5.5V7"
                        />

                        <rect
                            width="18"
                            height="12"
                            x="3"
                            y="7"
                            rx="2"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3 12h18"
                        />
                    </svg>

                    Work Type
                </label>

                <div class="space-y-1.5">

                    <!-- ON-SITE -->
                    <label
                        class="flex cursor-pointer items-center gap-2.5
                               rounded-lg px-2.5 py-2
                               transition hover:bg-[#E8F1F5]"
                    >
                        <input
                            v-model="filters.workType"
                            type="checkbox"
                            value="On-site"
                            class="h-4 w-4 rounded
                                   border-slate-300
                                   text-[#3A7CA5]
                                   focus:ring-[#81C3D7]"
                        />

                        <span class="text-xs text-slate-600">
                            On-site
                        </span>
                    </label>

                    <!-- HYBRID -->
                    <label
                        class="flex cursor-pointer items-center gap-2.5
                               rounded-lg px-2.5 py-2
                               transition hover:bg-[#E8F1F5]"
                    >
                        <input
                            v-model="filters.workType"
                            type="checkbox"
                            value="Hybrid"
                            class="h-4 w-4 rounded
                                   border-slate-300
                                   text-[#3A7CA5]
                                   focus:ring-[#81C3D7]"
                        />

                        <span class="text-xs text-slate-600">
                            Hybrid
                        </span>
                    </label>

                    <!-- REMOTE -->
                    <label
                        class="flex cursor-pointer items-center gap-2.5
                               rounded-lg px-2.5 py-2
                               transition hover:bg-[#E8F1F5]"
                    >
                        <input
                            v-model="filters.workType"
                            type="checkbox"
                            value="Remote"
                            class="h-4 w-4 rounded
                                   border-slate-300
                                   text-[#3A7CA5]
                                   focus:ring-[#81C3D7]"
                        />

                        <span class="text-xs text-slate-600">
                            Remote
                        </span>
                    </label>
                </div>
            </div>

            <!-- DURATION -->
            <div>
                <label
                    class="mb-1.5 flex items-center gap-2
                           text-[11px] font-bold uppercase
                           tracking-wide text-[#16425B]"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-3.5 w-3.5 text-[#3A7CA5]"
                    >
                        <circle
                            cx="12"
                            cy="12"
                            r="9"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 7v5l3 2"
                        />
                    </svg>

                    Duration
                </label>

                <select
                    v-model="filters.duration"
                    class="w-full rounded-lg
                           border border-[#E8F1F5]
                           bg-[#E8F1F5]/40
                           px-3 py-2.5
                           text-xs text-[#16425B]
                           outline-none transition
                           focus:border-[#3A7CA5]
                           focus:bg-white
                           focus:ring-2 focus:ring-[#81C3D7]/30"
                >
                    <option value="all">
                        All durations
                    </option>

                    <option value="1-3">
                        1 to 3 months
                    </option>

                    <option value="3-6">
                        3 to 6 months
                    </option>

                    <option value="6+">
                        More than 6 months
                    </option>
                </select>
            </div>

            <!-- SKILLS -->
            <div>
                <label
                    class="mb-1.5 flex items-center gap-2
                           text-[11px] font-bold uppercase
                           tracking-wide text-[#16425B]"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-3.5 w-3.5 text-[#3A7CA5]"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M20.59 13.41 13.41 20.59a2 2 0 0 1-2.82 0L3.41 13.41a2 2 0 0 1 0-2.82l7.18-7.18a2 2 0 0 1 1.41-.59H19a2 2 0 0 1 2 2v7a2 2 0 0 1-.59 1.41Z"
                        />

                        <circle
                            cx="16.5"
                            cy="7.5"
                            r="1"
                        />
                    </svg>

                    Skills
                </label>

                <input
                    v-model="filters.skills"
                    type="text"
                    placeholder="e.g. Laravel, Vue, Python..."
                    class="w-full rounded-lg
                           border border-[#E8F1F5]
                           bg-[#E8F1F5]/40
                           px-3 py-2.5
                           text-xs text-[#16425B]
                           outline-none transition
                           placeholder:text-slate-400
                           hover:border-[#81C3D7]
                           focus:border-[#3A7CA5]
                           focus:bg-white
                           focus:ring-2 focus:ring-[#81C3D7]/30"
                    @keyup.enter="applyFilters"
                />
            </div>

            <!-- APPLY -->
            <button
                type="button"
                @click="applyFilters"
                class="flex w-full items-center justify-center gap-2
                       rounded-lg bg-[#16425B]
                       px-4 py-2.5
                       text-xs font-bold text-white
                       shadow-sm transition
                       hover:bg-[#3A7CA5]
                       focus:outline-none
                       focus:ring-2 focus:ring-[#81C3D7]/40
                       active:scale-[0.99]"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="2"
                    stroke="currentColor"
                    class="h-4 w-4"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M5 12h14m-6-6 6 6-6 6"
                    />
                </svg>

                Apply Filters
            </button>
        </div>
    </aside>
</template>