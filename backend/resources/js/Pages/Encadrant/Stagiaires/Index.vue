<script setup>
import { Head } from '@inertiajs/vue3'
import EncadrantLayout from '@/Layouts/EncadrantLayout.vue'
import AssignedInterns from '@/Components/Encadrant/AssignedInterns.vue'
</script>

<template>
    <Head title="Assigned Interns" />

    <EncadrantLayout>
        <AssignedInterns />
    </EncadrantLayout>
</template>
