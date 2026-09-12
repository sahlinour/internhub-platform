<script setup>
defineProps({
    offre: {
        type: Object,
        required: true,
    },
})
</script>

<template>
    <section
        class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm"
    >
        <h2 class="text-lg font-bold text-slate-900">
            Description du stage
        </h2>

        <div
            v-if="offre.description"
            class="mt-4 whitespace-pre-line text-sm leading-7 text-slate-600"
        >
            {{ offre.description }}
        </div>

        <div
            v-else
            class="mt-4 rounded-xl bg-slate-50 p-5 text-sm text-slate-500"
        >
            Aucune description détaillée n'est disponible pour cette offre.
        </div>
    </section>
</template>