<script setup>
import { Head } from '@inertiajs/vue3'
import EncadrantLayout from '@/Layouts/EncadrantLayout.vue'
import AssignedInterns from '@/Components/Encadrant/AssignedInterns.vue'

defineProps({
    stages: {
        type: Object,
        required: true,
    },

    filters: {
        type: Object,
        default: () => ({}),
    },
})
</script>

<template>
    <Head title="Assigned Interns" />

    <EncadrantLayout>
        <AssignedInterns
            :stages="stages"
            :filters="filters"
        />
    </EncadrantLayout>
</template>
