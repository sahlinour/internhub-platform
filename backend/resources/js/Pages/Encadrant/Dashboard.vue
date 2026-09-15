<script setup>
import { Head } from '@inertiajs/vue3'

import EncadrantLayout from '@/Layouts/EncadrantLayout.vue'
import WelcomeBanner from '@/Components/Encadrant/WelcomeBanner.vue'
import StatCard from '@/Components/Encadrant/StatCard.vue'
import StagiaireCard from '@/Components/Encadrant/StagiaireCard.vue'
import RecentActivity from '@/Components/Encadrant/RecentActivity.vue'
import PendingTaskReviews from '@/Components/Encadrant/PendingTaskReviews.vue'

/*
|--------------------------------------------------------------------------
| Temporary demo data
|--------------------------------------------------------------------------
| We'll replace this with Laravel props after validating the UI.
*/

const stats = {
    stagiaires: 4,
    pendingReviews: 5,
    meetings: 2,
    averageProgress: 62,
}

const stagiaires = [
    {
        id: 1,
        name: 'Soukayna El Amrani',
        filiere: 'Développement Backend',
        progress: 68,
        completedTasks: 8,
        totalTasks: 14,
        status: 'on_track',
        lastActivity: 'Il y a 2 h',
    },
    {
        id: 2,
        name: 'Marcus Chen',
        filiere: 'Génie Logiciel',
        progress: 82,
        completedTasks: 12,
        totalTasks: 14,
        status: 'on_track',
        lastActivity: 'Il y a 30 min',
    },
    {
        id: 3,
        name: 'Priya Nair',
        filiere: 'Infrastructure Data',
        progress: 41,
        completedTasks: 5,
        totalTasks: 12,
        status: 'at_risk',
        lastActivity: 'Il y a 2 jours',
    },
    {
        id: 4,
        name: 'Tom Baptiste',
        filiere: 'Platform Engineering',
        progress: 55,
        completedTasks: 7,
        totalTasks: 13,
        status: 'on_track',
        lastActivity: 'Il y a 1 jour',
    },
]

const activities = [
    {
        id: 1,
        text: 'Soukayna a soumis une tâche pour validation.',
        time: 'Il y a 2 heures',
    },
    {
        id: 2,
        text: 'Vous avez validé une tâche de Marcus.',
        time: 'Il y a 5 heures',
    },
    {
        id: 3,
        text: 'Un nouveau document de suivi a été ajouté.',
        time: 'Il y a 1 jour',
    },
    {
        id: 4,
        text: 'Tom a ajouté un commentaire sur une tâche.',
        time: 'Il y a 1 jour',
    },
    {
        id: 5,
        text: 'Une tâche de Priya a été signalée comme étant à risque.',
        time: 'Il y a 2 jours',
    },
]

const pendingTasks = [
    {
        id: 1,
        title: 'Implémenter la logique de validation',
        stagiaire: 'Soukayna El Amrani',
        date: '16 septembre 2026',
        priority: 'high',
    },
    {
        id: 2,
        title: "Écrire les tests d'intégration API",
        stagiaire: 'Marcus Chen',
        date: '15 septembre 2026',
        priority: 'medium',
    },
    {
        id: 3,
        title: 'Documenter le service interne',
        stagiaire: 'Tom Baptiste',
        date: '16 septembre 2026',
        priority: 'low',
    },
]

const reviewTask = (task) => {
    console.log('Review task:', task)
}
</script>

<template>
    <Head title="Tableau de bord Encadrant" />

    <EncadrantLayout>
        <div class="mx-auto max-w-[1500px] space-y-5">

            <!-- Welcome -->
            <WelcomeBanner
                name="Sarah"
                :pending-reviews="stats.pendingReviews"
                :upcoming-meetings="stats.meetings"
            />

            <!-- Statistics -->
            <section
                class="grid grid-cols-1 gap-4
                       sm:grid-cols-2 xl:grid-cols-4"
            >
                <StatCard
                    title="Stagiaires assignés"
                    :value="stats.stagiaires"
                    subtitle="Stagiaires actuellement suivis"
                    icon="users"
                    variant="blue"
                />

                <StatCard
                    title="Tâches à valider"
                    :value="stats.pendingReviews"
                    subtitle="En attente de votre retour"
                    icon="tasks"
                    variant="violet"
                />

                <StatCard
                    title="Réunions à venir"
                    :value="stats.meetings"
                    subtitle="Prochaine : demain"
                    icon="calendar"
                    variant="orange"
                />

                <StatCard
                    title="Progression moyenne"
                    :value="`${stats.averageProgress}%`"
                    subtitle="Progression des stagiaires"
                    icon="progress"
                    variant="green"
                />
            </section>

            <!-- Dashboard content -->
            <section
                class="grid grid-cols-1 gap-5
                       xl:grid-cols-[minmax(0,2fr)_minmax(280px,0.8fr)]"
            >

                <!-- LEFT -->
                <div class="space-y-5">

                    <!-- Assigned students -->
                    <section
                        class="rounded-xl border border-gray-200
                               bg-white p-5 shadow-sm"
                    >
                        <div
                            class="mb-4 flex items-center
                                   justify-between"
                        >
                            <div>
                                <h2
                                    class="text-sm font-semibold
                                           text-gray-900"
                                >
                                    Stagiaires assignés
                                </h2>

                                <p
                                    class="mt-1 text-xs
                                           text-gray-400"
                                >
                                    Suivi de vos stagiaires
                                </p>
                            </div>

                            <button
                                type="button"
                                class="text-xs font-semibold
                                       text-[#17629b]
                                       hover:underline"
                            >
                                Tout voir →
                            </button>
                        </div>

                        <div
                            class="grid grid-cols-1 gap-4
                                   lg:grid-cols-2"
                        >
                            <StagiaireCard
                                v-for="stagiaire in stagiaires"
                                :key="stagiaire.id"
                                :stagiaire="stagiaire"
                            />
                        </div>
                    </section>

                    <!-- Pending reviews -->
                    <PendingTaskReviews
                        :tasks="pendingTasks"
                        @review="reviewTask"
                    />

                </div>

                <!-- RIGHT -->
                <div>
                    <RecentActivity
                        :activities="activities"
                    />
                </div>

            </section>

        </div>
    </EncadrantLayout>
</template>
