<script setup>
import StagiaireLayout from '@/Layouts/StagiaireLayout.vue'
import { Head } from '@inertiajs/vue3'

defineProps({
    stats: {
        type: Object,
        default: () => ({
            has_stage: false,
            stage: null,
            taches_count: 0,
            docs_count: 0,
        }),
    },
})
</script>

<template>
    <StagiaireLayout>
        <Head title="Intern Dashboard" />

        <template #user-name>
            My Account
        </template>

        <template #header>
            <div>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Intern Dashboard
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Welcome to your internship dashboard
                </p>
            </div>
        </template>

        <div class="py-8">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

                <!-- Welcome -->
                <div class="mb-8">
                    <h1 class="text-2xl font-bold text-gray-900">
                        Welcome back 👋
                    </h1>

                    <p class="mt-1 text-gray-500">
                        Here's an overview of your internship.
                    </p>
                </div>

                <!-- Statistics -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">

                    <!-- Stage -->
                    <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">
                                    Internship
                                </p>

                                <p class="mt-2 text-3xl font-bold text-gray-900">
                                    {{ stats.has_stage ? 'Active' : 'None' }}
                                </p>
                            </div>

                            <div class="rounded-lg bg-blue-50 p-3">
                                🎓
                            </div>
                        </div>
                    </div>

                    <!-- Tasks -->
                    <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">
                                    Tasks
                                </p>

                                <p class="mt-2 text-3xl font-bold text-gray-900">
                                    {{ stats.taches_count }}
                                </p>
                            </div>

                            <div class="rounded-lg bg-blue-50 p-3">
                                ✓
                            </div>
                        </div>
                    </div>

                    <!-- Documents -->
                    <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">
                                    Documents
                                </p>

                                <p class="mt-2 text-3xl font-bold text-gray-900">
                                    {{ stats.docs_count }}
                                </p>
                            </div>

                            <div class="rounded-lg bg-blue-50 p-3">
                                📄
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Internship -->
                <div class="mt-8 rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-100">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">
                            My Internship
                        </h3>

                        <p class="mt-1 text-sm text-gray-500">
                            Information about your current internship.
                        </p>
                    </div>

                    <div
                        v-if="stats.has_stage"
                        class="rounded-lg bg-gray-50 p-5"
                    >
                        Internship found
                    </div>

                    <div
                        v-else
                        class="rounded-lg border border-dashed border-gray-300 p-8 text-center"
                    >
                        <p class="font-medium text-gray-700">
                            No active internship
                        </p>

                        <p class="mt-1 text-sm text-gray-500">
                            You don't have an active internship yet.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </StagiaireLayout>
</template>