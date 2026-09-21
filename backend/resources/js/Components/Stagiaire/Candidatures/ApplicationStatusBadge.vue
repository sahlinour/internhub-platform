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
        case 'en_attente':
            return {
                label: 'Pending',
                classes: 'bg-slate-100 text-slate-600',
            }

        case 'en_cours_examen':
            return {
                label: 'Under Review',
                classes: 'bg-amber-50 text-amber-700',
            }

        case 'acceptee':
            return {
                label: 'Accepted',
                classes: 'bg-emerald-50 text-emerald-700',
            }

        case 'refusee':
            return {
                label: 'Rejected',
                classes: 'bg-red-50 text-red-600',
            }

        default:
            return {
                label: 'Unknown',
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