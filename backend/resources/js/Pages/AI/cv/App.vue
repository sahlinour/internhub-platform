<script setup>
import { ref } from 'vue'

import StagiaireLayout from '@/Components/Stagiaire/StagiaireLayout.vue'

import UploadZone from '@/Components/Stagiaire/AI/CV/UploadZone.vue'
import JobCard from '@/Components/Stagiaire/AI/CV/JobCard.vue'
import CVHeader from '@/Components/Stagiaire/AI/CV/CVHeader.vue'
import CVInfoCard from '@/Components/Stagiaire/AI/CV/CVInfoCard.vue'
import CVLoading from '@/Components/Stagiaire/AI/CV/CVLoading.vue'
import CVSummary from '@/Components/Stagiaire/AI/CV/CVSummary.vue'
import CVResultsHeader from '@/Components/Stagiaire/AI/CV/CVResultsHeader.vue'
import CVEmptyState from '@/Components/Stagiaire/AI/CV/CVEmptyState.vue'

import { matchCv } from './services/api'

const status = ref('idle')
const fileName = ref('')
const selectedFile = ref(null)
const skills = ref([])
const results = ref([])
const error = ref('')

async function analyze(file) {
    if (!file) {
        return
    }

    selectedFile.value = file
    fileName.value = file.name

    status.value = 'loading'
    error.value = ''
    results.value = []
    skills.value = []

    try {
        const data = await matchCv(file)

        skills.value = data.skills ?? []

        results.value = [...(data.offers ?? [])]
            .sort((a, b) => Number(b.score || 0) - Number(a.score || 0))
            .slice(0, 10)

        status.value = 'done'
    } catch (e) {
        console.error('CV matching error:', e)

        error.value =
            e?.message ||
            'Something went wrong while analyzing your CV.'

        status.value = 'error'
    }
}

function reset() {
    status.value = 'idle'
    fileName.value = ''
    selectedFile.value = null
    skills.value = []
    results.value = []
    error.value = ''
}
</script>

<template>
    <StagiaireLayout>

        <main class="min-h-screen bg-[#F4F7F9]">

            <div
                class="mx-auto max-w-4xl px-4 py-6 sm:px-6 lg:px-8"
            >

                <!-- HEADER -->
                <CVHeader />

                <!-- UPLOAD -->
                <section
                    v-if="status === 'idle' || status === 'error'"
                    class="max-w-4xl"
                >

                    <CVInfoCard />

                    <UploadZone
                        @file="analyze"
                    />

                    <!-- API ERROR -->
                    <div
                        v-if="status === 'error' && error"
                        class="mt-4 rounded-xl border border-red-200 bg-red-50 p-4"
                    >
                        <p
                            class="text-[11px] font-semibold text-red-700"
                        >
                            Analysis failed
                        </p>

                        <p
                            class="mt-1 text-[11px] leading-5 text-red-600"
                        >
                            {{ error }}
                        </p>
                    </div>

                </section>

                <!-- LOADING -->
                <CVLoading
                    v-if="status === 'loading'"
                    :file-name="fileName"
                />

                <!-- RESULTS -->
                <section v-if="status === 'done'">

                    <!-- CV SUMMARY -->
                    <CVSummary
                        :file-name="fileName"
                        :results-count="results.length"
                        :skills="skills"
                        @reset="reset"
                    />

                    <!-- MATCHES -->
                    <template v-if="results.length">

                        <CVResultsHeader
                            :count="results.length"
                        />

                        <div class="space-y-3">

                            <JobCard
                                v-for="(job, index) in results"
                                :key="job.id ?? index"
                                :job="job"
                                :rank="index + 1"
                            />

                        </div>

                    </template>

                    <!-- EMPTY -->
                    <CVEmptyState
                        v-else
                        @reset="reset"
                    />

                </section>

            </div>

        </main>

    </StagiaireLayout>
</template>