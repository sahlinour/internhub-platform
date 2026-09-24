<script setup>
import { computed } from 'vue'

const props = defineProps({
    status: {
        type: String,
        default: '',
    },
})

const normalized = computed(() =>
    String(props.status ?? '').trim().toLowerCase()
)

const statusClasses = computed(() => {
    if (['active', 'open', 'ouverte', 'en cours'].includes(normalized.value)) {
        return 'bg-[#e8f6ee] text-[#3f9a65]'
    }

    if (['pending', 'en_attente', 'en attente'].includes(normalized.value)) {
        return 'bg-[#fff3dc] text-[#c28b2a]'
    }

    if (
        ['block', 'blocked', 'inactive', 'closed', 'fermee', 'annulée']
            .includes(normalized.value)
    ) {
        return 'bg-[#fceaea] text-[#c25d5d]'
    }

    if (['terminée', 'completed'].includes(normalized.value)) {
        return 'bg-[#e9f1f8] text-[#3e7195]'
    }

    return 'bg-[#edf2f5] text-[#6c8290]'
})

const label = computed(() => {
    const labels = {
        block: 'Inactive',
        blocked: 'Inactive',
        inactive: 'Inactive',
        open: 'Open',
        ouverte: 'Open',
        pending: 'Pending',
        en_attente: 'Pending',
        closed: 'Closed',
        fermee: 'Closed',
        'en cours': 'Active',
        'en attente': 'Pending',
        terminée: 'Completed',
        completed: 'Completed',
        annulée: 'Cancelled',
    }

    if (!normalized.value) {
        return 'Unknown'
    }

    return labels[normalized.value]
        ?? props.status.charAt(0).toUpperCase() + props.status.slice(1)
})
</script>

<template>
    <span
        class="inline-flex min-w-[62px] items-center justify-center rounded-full px-[9px] py-[5px] text-[8px] font-bold"
        :class="statusClasses"
    >
        {{ label }}
    </span>
</template>
