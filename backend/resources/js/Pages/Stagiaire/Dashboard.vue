<script setup>
import { Head } from '@inertiajs/vue3'

import StagiaireLayout from '@/Components/Stagiaire/StagiaireLayout.vue'

// Layout / cards
import DashboardCard from '@/Components/Stagiaire/DashboardCard.vue'

// Dashboard components
import WelcomeBanner from '@/Components/Stagiaire/WelcomeBanner.vue'
import StatsGrid from '@/Components/Stagiaire/StatsGrid.vue'
import StatCard from '@/Components/Stagiaire/StatCard.vue'

import CurrentInternship from '@/Components/Stagiaire/CurrentInternship.vue'
import ApplicationTracker from '@/Components/Stagiaire/ApplicationTracker.vue'
import RecentTasks from '@/Components/Stagiaire/RecentTasks.vue'
import RecentDocuments from '@/Components/Stagiaire/RecentDocuments.vue'
import QuickActions from '@/Components/Stagiaire/QuickActions.vue'

import RecommendedOffers from '@/Components/Stagiaire/RecommendedOffers.vue'
import ProfileCompletion from '@/Components/Stagiaire/ProfileCompletion.vue'
import NotificationsPanel from '@/Components/Stagiaire/NotificationsPanel.vue'
import AIAssistant from '@/Components/Stagiaire/AIAssistant.vue'


const props = defineProps({
    stats: {
        type: Object,
        default: () => ({
            has_stage: false,
            stage: null,
            taches_count: 0,
            docs_count: 0,
            applications_count: 0,
            applications: [],
            recommended_offers: [],
            notifications: [],
            profile_completion: 0,
        }),
    },
})


/*
|--------------------------------------------------------------------------
| Statistics
|--------------------------------------------------------------------------
*/

const stats = [
    {
        label: 'My Internship',
        value: props.stats.has_stage ? 'Active' : 'None',
        detail: props.stats.has_stage
            ? 'Currently active'
            : 'No active internship',
        icon: 'graduation',
    },
    {
        label: 'My Tasks',
        value: props.stats.taches_count,
        detail: 'Assigned tasks',
        icon: 'tasks',
    },
    {
        label: 'My Documents',
        value: props.stats.docs_count,
        detail: 'Internship documents',
        icon: 'documents',
    },
    {
        label: 'My Applications',
        value: props.stats.applications_count ?? 0,
        detail: 'Submitted applications',
        icon: 'briefcase',
    },
]
</script>


<template>

    <Head title="Intern Dashboard" />

    <StagiaireLayout>

        <div class="w-full">

            <!-- ====================================================== -->
            <!-- WELCOME -->
            <!-- ====================================================== -->

            <section class="mb-[18px]">
                <WelcomeBanner />
            </section>


            <!-- ====================================================== -->
            <!-- STATS -->
            <!-- ====================================================== -->

            <section
                class="mb-[18px]
                       grid grid-cols-4 gap-[14px]
                       max-[1150px]:grid-cols-2
                       max-[600px]:grid-cols-1"
            >

                <StatCard
                    v-for="stat in stats"
                    :key="stat.label"
                    v-bind="stat"
                    class="min-w-0"
                />

            </section>


            <!-- ====================================================== -->
            <!-- MAIN DASHBOARD -->
            <!-- ====================================================== -->

            <section
                class="grid items-start
                       grid-cols-[minmax(0,1.8fr)_minmax(280px,0.8fr)]
                       gap-4
                       max-[1150px]:grid-cols-1"
            >

                <!-- ================================================== -->
                <!-- LEFT COLUMN -->
                <!-- ================================================== -->

                <div class="flex min-w-0 flex-col gap-4">


                    <!-- CURRENT INTERNSHIP -->

                    <DashboardCard
                        title="My Internship"
                        subtitle="Information about your current internship"
                    >

                        <CurrentInternship
                            :stage="props.stats.stage"
                        />

                    </DashboardCard>


                    <!-- APPLICATION TRACKER -->

                    <DashboardCard
                        title="Application Tracker"
                        subtitle="Track your latest internship applications"
                    >

                        <ApplicationTracker
                            :applications="props.stats.applications ?? []"
                        />

                    </DashboardCard>


                    <!-- RECOMMENDED OFFERS -->

                    <DashboardCard
                        title="Recommended Offers"
                        subtitle="Internship opportunities that may interest you"
                    >

                        <RecommendedOffers
                            :offers="props.stats.recommended_offers ?? []"
                        />

                    </DashboardCard>

                </div>


                <!-- ================================================== -->
                <!-- RIGHT COLUMN -->
                <!-- ================================================== -->

                <div
                    class="flex min-w-0
                           flex-col gap-4"
                >


                    <!-- QUICK ACTIONS -->

                    <DashboardCard
                        title="Quick Actions"
                        subtitle="Common actions for your internship"
                    >

                        <QuickActions />

                    </DashboardCard>


                    <!-- RECENT TASKS -->

                    <DashboardCard
                        title="Recent Tasks"
                        subtitle="Latest tasks assigned to you"
                    >

                        <RecentTasks
                            :count="props.stats.taches_count"
                        />

                    </DashboardCard>


                    <!-- RECENT DOCUMENTS -->

                    <DashboardCard
                        title="Recent Documents"
                        subtitle="Latest documents related to your internship"
                    >

                        <RecentDocuments
                            :count="props.stats.docs_count"
                        />

                    </DashboardCard>


                    <!-- PROFILE COMPLETION -->

                    <DashboardCard
                        title="Profile Completion"
                        subtitle="Complete your profile to improve your opportunities"
                    >

                        <ProfileCompletion
                            :percentage="props.stats.profile_completion ?? 0"
                        />

                    </DashboardCard>

                </div>

            </section>


            <!-- ====================================================== -->
            <!-- BOTTOM SECTION -->
            <!-- ====================================================== -->

            <section
                class="mt-4
                       grid grid-cols-2 gap-4
                       max-[900px]:grid-cols-1"
            >


                <!-- NOTIFICATIONS -->

                <DashboardCard
                    title="Notifications"
                    subtitle="Your latest notifications"
                >

                    <NotificationsPanel
                        :notifications="props.stats.notifications ?? []"
                    />

                </DashboardCard>


                <!-- AI ASSISTANT -->

                <DashboardCard
                    title="AI Assistant"
                    subtitle="Get help with your internship journey"
                >

                    <AIAssistant />

                </DashboardCard>

            </section>

        </div>

    </StagiaireLayout>

</template>
