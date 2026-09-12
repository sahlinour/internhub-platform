<script setup>
import { computed } from 'vue'

const props = defineProps({
    offre: {
        type: Object,
        required: true,
    },
})

const rawRequirements = computed(() => {
    return (
        props.offre.competences ||
        props.offre.competences_requises ||
        props.offre.requirements ||
        props.offre.prerequis ||
        null
    )
})

const requirements = computed(() => {
    const value = rawRequirements.value

    if (!value) {
        return []
    }

    if (Array.isArray(value)) {
        return value
            .map(item => {
                if (typeof item === 'string') {
                    return item
                }

                return item?.nom || item?.name || item?.label || null
            })
            .filter(Boolean)
    }

    if (typeof value === 'string') {
        try {
            const parsed = JSON.parse(value)

            if (Array.isArray(parsed)) {
                return parsed
                    .map(item => {
                        if (typeof item === 'string') {
                            return item
                        }

                        return item?.nom || item?.name || item?.label || null
                    })
                    .filter(Boolean)
            }
        } catch {
            // Texte normal
        }

        return value
            .split(',')
            .map(item => item.trim())
            .filter(Boolean)
    }

    return []
})
</script>

<template>
    <section
        v-if="requirements.length"
        class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm"
    >
        <h2 class="text-lg font-bold text-slate-900">
            Compétences et prérequis
        </h2>

        <div class="mt-5 flex flex-wrap gap-2">
            <span
                v-for="(requirement, index) in requirements"
                :key="index"
                class="rounded-lg bg-[#EAF3F8] px-3 py-2 text-sm font-medium text-[#2F6690]"
            >
                {{ requirement }}
            </span>
        </div>
    </section>
</template>