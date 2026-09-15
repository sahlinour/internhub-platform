<script setup>
defineProps({
    name: {
        type: String,
        default: 'Encadrant',
    },
    pendingReviews: {
        type: Number,
        default: 0,
    },
    upcomingMeetings: {
        type: Number,
        default: 0,
    },
})
</script>

<template>
    <section
        class="rounded-xl bg-[#17629b] px-6 py-5 text-white shadow-sm"
    >
        <div
            class="flex flex-col gap-5 md:flex-row
                   md:items-center md:justify-between"
        >
            <div>
                <p class="mb-2 text-xs text-blue-100">
                    Tableau de bord Encadrant
                </p>

                <h1 class="text-xl font-bold">
                    Bonjour, {{ name }} 👋
                </h1>

                <p class="mt-2 text-sm text-blue-100">
                    Vous avez
                    <strong class="text-white">
                        {{ pendingReviews }}
                    </strong>
                    tâche(s) à valider et
                    <strong class="text-white">
                        {{ upcomingMeetings }}
                    </strong>
                    réunion(s) à venir.
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                <button
                    type="button"
                    class="rounded-lg bg-[#11517f] px-4 py-2
                           text-xs font-semibold text-white transition
                           hover:bg-[#0e456c]"
                >
                    Voir les validations
                </button>

                <button
                    type="button"
                    class="rounded-lg bg-white px-4 py-2
                           text-xs font-semibold text-[#17629b]
                           transition hover:bg-gray-50"
                >
                    Assigner une tâche
                </button>
            </div>
        </div>
    </section>
</template>
