<script setup>
import { computed } from 'vue'
import { Head, router } from '@inertiajs/vue3'
import EntrepriseLayout from '@/Layouts/EntrepriseLayout.vue'
import AcceptedStudentsHeader from '@/Components/Entreprise/AcceptedStudents/AcceptedStudentsHeader.vue'
import AcceptedStudentsSummary from '@/Components/Entreprise/AcceptedStudents/AcceptedStudentsSummary.vue'
import AcceptedStudentsTable from '@/Components/Entreprise/AcceptedStudents/AcceptedStudentsTable.vue'

const props = defineProps({
    acceptedStudents: {
        type: Object,
        required: true,
    },
})

const appRoute = (name, params = undefined) => {
    return route(name, params, false)
}
const students = computed(() => {
    return props.acceptedStudents?.data ?? []
})
const totalStudents = computed(() => {
    return (
        props.acceptedStudents?.total ??
        students.value.length
    )
})
const paginationLinks = computed(() => {
    return props.acceptedStudents?.links ?? []
})
const visitPage = (url) => {
    if (!url) {
        return
    }
    router.get(
        url,
        {},
        {
            preserveState: true,
            preserveScroll: true,
        }
    )
}
</script>

<template>
    <EntrepriseLayout>
        <Head title="Accepted Students" />
        <main class="min-h-screen bg-[#F4F7F9]">
            <div
                class="mx-auto max-w-7xl
                       px-4 py-6
                       sm:px-6
                       lg:px-8"
            >
                <AcceptedStudentsHeader
                    :total="totalStudents"
                />

                <div class="mt-8">
                    <AcceptedStudentsSummary
                        :total="totalStudents"
                        :displayed="students.length"
                    />
                </div>

                <section
                    class="mt-10 overflow-hidden
                           rounded-2xl
                           border border-slate-200
                           bg-white
                           shadow-sm"
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
                            Accepted Students
                        </h2>

                        <p
                            class="mt-0.5 text-xs
                                   text-slate-400"
                        >
                            Manage students accepted
                            for your internships.
                        </p>
                    </div>

                    <AcceptedStudentsTable
                        :students="students"
                    />
                </section>

                <div
                    v-if="paginationLinks.length > 3"
                    class="mt-4 flex flex-col gap-3
                           border-t border-slate-200
                           px-2 py-4
                           sm:flex-row
                           sm:items-center
                           sm:justify-between"
                >
                    <p class="text-[10px] text-slate-400">
                        Showing
                        {{ acceptedStudents.from ?? 0 }}
                        to
                        {{ acceptedStudents.to ?? 0 }}
                        of
                        {{ acceptedStudents.total ?? 0 }}
                        students
                    </p>

                    <div class="flex flex-wrap gap-1">
                        <button
                            v-for="(link, index) in paginationLinks"
                            :key="index"
                            type="button"
                            :disabled="!link.url"
                            @click="visitPage(link.url)"
                            class="min-w-9 rounded-lg
                                   border px-3 py-2
                                   text-xs transition"
                            :class="[
                                link.active
                                    ? 'border-[#16425B] bg-[#16425B] text-white'
                                    : 'border-slate-200 bg-white text-slate-600 hover:border-[#81C3D7] hover:bg-[#E8F1F5]',

                                !link.url
                                    ? 'cursor-not-allowed opacity-40'
                                    : '',
                            ]"
                            v-html="link.label"
                        />
                    </div>
                </div>
            </div>
        </main>
    </EntrepriseLayout>
</template>