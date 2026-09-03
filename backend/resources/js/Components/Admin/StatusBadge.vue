<script setup>
import { computed } from 'vue'

const props = defineProps({
    status: {
        type: String,
        default: '',
    },
})

const normalized = computed(() =>
    props.status?.toLowerCase() ?? ''
)

const statusClasses = computed(() => {
    // ACTIVE
    if (
        normalized.value === 'active' ||
        normalized.value === 'en cours'
    ) {
        return 'bg-[#e8f6ee] text-[#3f9a65]'
    }

    // PENDING
    if (
        normalized.value === 'pending' ||
        normalized.value === 'en attente'
    ) {
        return 'bg-[#fff3dc] text-[#c28b2a]'
    }

    // BLOCKED / INACTIVE / CANCELLED
    if (
        normalized.value === 'block' ||
        normalized.value === 'blocked' ||
        normalized.value === 'inactive' ||
        normalized.value === 'annulée'
    ) {
        return 'bg-[#fceaea] text-[#c25d5d]'
    }

    // COMPLETED
    if (
        normalized.value === 'terminée' ||
        normalized.value === 'completed'
    ) {
        return 'bg-[#e9f1f8] text-[#3e7195]'
    }

    // DEFAULT
    return 'bg-[#edf2f5] text-[#6c8290]'
})

const label = computed(() => {
    if (normalized.value === 'block') {
        return 'Inactive'
    }

    if (normalized.value === 'en cours') {
        return 'Active'
    }

    if (normalized.value === 'terminée') {
        return 'Completed'
    }

    if (normalized.value === 'annulée') {
        return 'Cancelled'
    }

    if (!props.status) {
        return 'Unknown'
    }

    return (
        props.status.charAt(0).toUpperCase() +
        props.status.slice(1)
    )
})
</script>

<template>
    <span
        class="inline-flex min-w-[62px]
               items-center justify-center
               rounded-full
               px-[9px] py-[5px]
               text-[8px] font-bold"
        :class="statusClasses"
    >
        {{ label }}
    </span>
</template>
