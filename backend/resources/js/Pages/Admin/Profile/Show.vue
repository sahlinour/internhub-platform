<script setup>
import { Head, Link } from '@inertiajs/vue3'

import AdminLayout from '@/Components/Admin/AdminLayout.vue'
import DashboardCard from '@/Components/Admin/DashboardCard.vue'
import UserAvatar from '@/Components/Admin/UserAvatar.vue'

defineProps({
    admin: {
        type: Object,
        required: true,
    },
})
</script>

<template>
    <Head title="Admin Profile" />

    <AdminLayout>
        <div class="w-full max-w-[1050px]">

            <!-- ================= HEADER ================= -->
            <header
                class="mb-5 flex items-center justify-between gap-5
                       max-[700px]:flex-col
                       max-[700px]:items-start"
            >
                <div>
                    <h1
                        class="mb-[5px] text-[22px]
                               font-bold text-[#20394b]"
                    >
                        My Profile
                    </h1>

                    <p class="m-0 text-[11px] text-[#8798a6]">
                        View and manage your administrator account.
                    </p>
                </div>

                <Link
                    :href="route('admin.profile.edit')"
                    class="inline-flex min-h-10
                           items-center justify-center
                           rounded-lg bg-[#174966]
                           px-4 text-[10px]
                           font-bold text-white
                           no-underline transition
                           hover:bg-[#123e57]
                           max-[700px]:w-full"
                >
                    Edit Profile
                </Link>
            </header>

            <!-- ================= PROFILE CARD ================= -->
            <DashboardCard>

                <!-- PROFILE HEADER -->
                <div
                    class="flex items-center gap-[18px]
                           border-b border-[#edf1f4]
                           pb-[22px]"
                >
                    <UserAvatar
                        :name="admin.nom_complet"
                        :photo="admin.photo"
                        :size="76"
                    />

                    <div class="min-w-0">
                        <h2
                            class="mb-[5px] truncate
                                   text-[18px] font-bold
                                   text-[#294355]"
                        >
                            {{ admin.nom_complet }}
                        </h2>

                        <p class="m-0 text-[10px] text-[#8d9ca7]">
                            InternHub Administrator
                        </p>
                    </div>
                </div>

                <!-- ================= INFORMATION ================= -->
                <div
                    class="mt-[22px] grid grid-cols-2 gap-[18px]
                           max-[700px]:grid-cols-1"
                >

                    <!-- EMAIL -->
                    <div
                        class="rounded-[9px]
                               border border-[#e3e9ed]
                               bg-[#f9fbfc] p-[15px]"
                    >
                        <span
                            class="mb-[5px] block
                                   text-[9px] text-[#8c9ca7]"
                        >
                            Email
                        </span>

                        <strong
                            class="break-all text-[11px]
                                   font-bold text-[#40596a]"
                        >
                            {{ admin.email }}
                        </strong>
                    </div>

                    <!-- PHONE -->
                    <div
                        class="rounded-[9px]
                               border border-[#e3e9ed]
                               bg-[#f9fbfc] p-[15px]"
                    >
                        <span
                            class="mb-[5px] block
                                   text-[9px] text-[#8c9ca7]"
                        >
                            Phone
                        </span>

                        <strong
                            class="text-[11px]
                                   font-bold text-[#40596a]"
                        >
                            {{ admin.telephone || 'Not provided' }}
                        </strong>
                    </div>

                    <!-- CITY -->
                    <div
                        class="rounded-[9px]
                               border border-[#e3e9ed]
                               bg-[#f9fbfc] p-[15px]"
                    >
                        <span
                            class="mb-[5px] block
                                   text-[9px] text-[#8c9ca7]"
                        >
                            City
                        </span>

                        <strong
                            class="text-[11px]
                                   font-bold text-[#40596a]"
                        >
                            {{ admin.ville?.nom || 'Not provided' }}
                        </strong>
                    </div>

                    <!-- ROLE -->
                    <div
                        class="rounded-[9px]
                               border border-[#e3e9ed]
                               bg-[#f9fbfc] p-[15px]"
                    >
                        <span
                            class="mb-[5px] block
                                   text-[9px] text-[#8c9ca7]"
                        >
                            Role
                        </span>

                        <strong
                            class="text-[11px]
                                   font-bold text-[#40596a]"
                        >
                            {{ admin.role }}
                        </strong>
                    </div>

                </div>

            </DashboardCard>

        </div>
    </AdminLayout>
</template>
