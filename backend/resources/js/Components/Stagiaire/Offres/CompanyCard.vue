<script setup>
import { computed } from 'vue'

const props = defineProps({
    offre: {
        type: Object,
        required: true,
    },
})

const entreprise = computed(() => props.offre?.entreprise)

const user = computed(() => entreprise.value?.user)

const companyName = computed(() => {
    return (
        user.value?.nom_complet ||
        entreprise.value?.nom ||
        entreprise.value?.raison_sociale ||
        'Entreprise'
    )
})

const ville = computed(() => {
    return (
        user.value?.ville?.nom ||
        entreprise.value?.ville?.nom ||
        null
    )
})

const description = computed(() => {
    return (
        entreprise.value?.description ||
        entreprise.value?.description_entreprise ||
        null
    )
})
</script>

<template>
    <section
        class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm"
    >
        <h2 class="text-lg font-bold text-slate-900">
            À propos de l'entreprise
        </h2>

        <div class="mt-5 flex items-start gap-4">

            <div
                class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-[#EAF3F8] font-bold text-[#2F6690]"
            >
                {{ companyName.charAt(0).toUpperCase() }}
            </div>

            <div class="min-w-0">
                <h3 class="font-semibold text-slate-900">
                    {{ companyName }}
                </h3>

                <p
                    v-if="ville"
                    class="mt-1 text-sm text-slate-500"
                >
                    {{ ville }}
                </p>

                <p
                    v-if="description"
                    class="mt-3 whitespace-pre-line text-sm leading-6 text-slate-600"
                >
                    {{ description }}
                </p>
            </div>
        </div>
    </section>
</template>