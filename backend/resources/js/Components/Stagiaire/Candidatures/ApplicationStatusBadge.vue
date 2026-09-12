<script setup>
import { computed } from 'vue'

const props = defineProps({
    status: {
        type: String,
        required: true,
    },
})

const statusConfig = computed(() => {
    switch (props.status) {
        case 'En attente':
            return {
                label: 'Applied',
                classes: 'bg-slate-100 text-slate-600',
            }

        case 'En cours d’examen':
        case "En cours d'examen":
            return {
                label: 'Under Review',
                classes: 'bg-amber-50 text-amber-700',
            }

        case 'Acceptée':
            return {
                label: 'Offer',
                classes: 'bg-emerald-50 text-emerald-700',
            }

        case 'Refusée':
            return {
                label: 'Rejected',
                classes: 'bg-red-50 text-red-600',
            }

        default:
            return {
                label: props.status || 'Unknown',
                classes: 'bg-slate-100 text-slate-600',
            }
    }
})
</script>

<template>
    <span
        class="inline-flex items-center rounded-md px-2 py-1
               text-[9px] font-medium leading-none"
        :class="statusConfig.classes"
    >
        {{ statusConfig.label }}
    </span>
</template>