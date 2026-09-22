<script setup>
import { Head, router } from '@inertiajs/vue3'
import { computed } from 'vue'

import EntrepriseLayout from '@/Layouts/EntrepriseLayout.vue'
import InternHeader from '@/Components/Entreprise/Stages/InternHeader.vue'
import InternTable from '@/Components/Entreprise/Stages/InternTable.vue'

const props = defineProps({
    stages: {
        type: Object,
        required: true,
    },
})

const appRoute = (name, params = undefined) => {
    return route(name, params, false)
}
const getStudentName = (stage) => {
    return (
        stage?.candidature?.stagiaire?.user?.nom_complet ??
        'Student'
    )
}
const getStudentEmail = (stage) => {
    return (
        stage?.candidature?.stagiaire?.user?.email ??
        '—'
    )
}
const getInternshipTitle = (stage) => {
    return (
        stage?.candidature?.offre_de_stage?.titre ??
        stage?.sujet ??
        'Internship'
    )
}
const getSupervisorName = (stage) => {
    return (
        stage?.encadrant?.user?.nom_complet ??
        'Not assigned'
    )
}
const getInitials = (name) => {
    if (!name) {
        return 'ST'
    }
    return name
        .trim()
        .split(/\s+/)
        .slice(0, 2)
        .map((word) => word.charAt(0).toUpperCase())
        .join('')
}
const formatDate = (date) => {
    if (!date) {
        return '—'
    }
    return new Intl.DateTimeFormat('en-GB', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
    }).format(new Date(date))
}
const getTimeline = (stage) => {
    if (
        !stage?.date_debut ||
        !stage?.date_fin
    ) {
        return '—'
    }
    const start = new Date(stage.date_debut)
    const end = new Date(stage.date_fin)
    const today = new Date()
    start.setHours(0, 0, 0, 0)
    end.setHours(0, 0, 0, 0)
    today.setHours(0, 0, 0, 0)
    const millisecondsPerWeek =
        1000 * 60 * 60 * 24 * 7
    const totalWeeks = Math.max(
        1,
        Math.ceil(
            (end.getTime() - start.getTime()) /
                millisecondsPerWeek
        )
    )
    if (today < start) {
        return `Week 0/${totalWeeks}`
    }
    if (today >= end) {
        return `Week ${totalWeeks}/${totalWeeks}`
    }
    const currentWeek = Math.max(
        1,
        Math.ceil(
            (today.getTime() - start.getTime()) /
                millisecondsPerWeek
        )
    )
    return `Week ${Math.min(
        currentWeek,
        totalWeeks
    )}/${totalWeeks}`
}
const getTimelinePercentage = (stage) => {
    if (
        !stage?.date_debut ||
        !stage?.date_fin
    ) {
        return 0
    }
    const start = new Date(stage.date_debut)
    const end = new Date(stage.date_fin)
    const today = new Date()
    const totalDuration =
        end.getTime() - start.getTime()
    if (totalDuration <= 0) {
        return 100
    }
    if (today <= start) {
        return 0
    }
    if (today >= end) {
        return 100
    }
    const elapsed =
        today.getTime() - start.getTime()
    return Math.min(
        100,
        Math.max(
            0,
            Math.round(
                (elapsed / totalDuration) * 100
            )
        )
    )
}
const deleteStage = (stage) => {
    if (!stage?.id) {
        return
    }
    if (
        !confirm(
            'Are you sure you want to delete this internship?'
        )
    ) {
        return
    }
    router.delete(
        appRoute(
            'entreprise.stages.destroy',
            stage.id
        ),
        {
            preserveScroll: true,
        }
    )
}
const students = computed(() => {
    return (
        props.stages?.data?.filter(
            (stage) => stage !== null
        ) ?? []
    )
})
const totalStudents = computed(() => {
    return (
        props.stages?.total ??
        students.value.length
    )
})
</script>

<template>
    <Head title="Current Interns" />
    <EntrepriseLayout>
        <main class="min-h-screen bg-[#F4F7F9]">
            <div
                class="mx-auto max-w-7xl
                       px-4 py-6
                       sm:px-6
                       lg:px-8"
            >
                <InternHeader
                    :total="totalStudents"
                />

                <section
                    class="mt-10 overflow-hidden
                           rounded-2xl border
                           border-slate-200
                           bg-white shadow-sm"
                >
                    <div
                        class="border-b border-slate-100
                               px-5 py-4
                               sm:px-6"
                    >
                        <h2
                            class="text-sm font-bold
                                   text-[#16425B]"
                        >
                            Current Interns
                        </h2>
                        <p
                            class="mt-0.5 text-xs
                                   text-slate-400"
                        >
                            Manage the students currently
                            completing internships.
                        </p>
                    </div>

                    <InternTable
                        :stages="students"
                        :get-student-name="getStudentName"
                        :get-student-email="getStudentEmail"
                        :get-internship-title="getInternshipTitle"
                        :get-supervisor-name="getSupervisorName"
                        :get-initials="getInitials"
                        :format-date="formatDate"
                        :get-timeline="getTimeline"
                        :get-timeline-percentage="getTimelinePercentage"
                        @delete="deleteStage"
                    />

                </section>
            </div>
        </main>
    </EntrepriseLayout>
</template>