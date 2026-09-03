<script setup>
import { Head } from '@inertiajs/vue3'

import AdminLayout from '@/Components/Admin/AdminLayout.vue'
import StatCard from '@/Components/Admin/StatCard.vue'
import DashboardCard from '@/Components/Admin/DashboardCard.vue'
import RecentUsersTable from '@/Components/Admin/RecentUsersTable.vue'
import RecentActivity from '@/Components/Admin/RecentActivity.vue'
import QuickActions from '@/Components/Admin/QuickActions.vue'

const stats = [
    {
        label: 'Total Users',
        value: 248,
        detail: '+18 this month',
        icon: 'users',
    },
    {
        label: 'Companies',
        value: 42,
        detail: '+5 this month',
        icon: 'company',
    },
    {
        label: 'Internship Offers',
        value: 76,
        detail: '21 currently open',
        icon: 'briefcase',
    },
    {
        label: 'Active Internships',
        value: 34,
        detail: '+8 this month',
        icon: 'graduation',
    },
]
</script>

<template>
    <Head title="Admin Dashboard" />

    <AdminLayout>
        <div class="w-full">

            <!-- WELCOME -->
            <section
                class="mb-[18px] rounded-[13px]
                       bg-gradient-to-br
                       from-[#153e59]
                       to-[#1b5875]
                       px-[26px] py-6
                       text-white"
            >
                <div>
                    <span
                        class="mb-[7px] block
                               text-[8px] font-bold
                               tracking-[1.5px]
                               text-white/50"
                    >
                        ADMINISTRATION
                    </span>

                    <h1
                        class="mb-1.5
                               text-[21px] font-bold"
                    >
                        Welcome back, Admin
                    </h1>

                    <p
                        class="m-0
                               text-[11px]
                               text-white/70"
                    >
                        Here is an overview of what is happening
                        on InternHub today.
                    </p>
                </div>
            </section>

            <!-- STATS -->
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

            <!-- DASHBOARD GRID -->
            <section
                class="grid items-start
                       grid-cols-[minmax(0,1.8fr)_minmax(280px,0.8fr)]
                       gap-4
                       max-[1150px]:grid-cols-1"
            >

                <!-- LEFT -->
                <div class="min-w-0">
                    <DashboardCard
                        title="Recent Users"
                        subtitle="Latest users registered on InternHub"
                    >
                        <RecentUsersTable />
                    </DashboardCard>
                </div>

                <!-- RIGHT -->
                <div
                    class="flex min-w-0
                           flex-col gap-4"
                >
                    <DashboardCard
                        title="Recent Activity"
                        subtitle="Latest platform activity"
                    >
                        <RecentActivity />
                    </DashboardCard>

                    <DashboardCard
                        title="Quick Actions"
                        subtitle="Common administration tasks"
                    >
                        <QuickActions />
                    </DashboardCard>
                </div>

            </section>

        </div>
    </AdminLayout>
</template>
