<script setup>
import AdminSidebar from '@/Components/Admin/AdminSidebar.vue'
import AdminTopbar from '@/Components/Admin/AdminTopbar.vue'
</script>

<template>
    <div class="min-h-screen bg-[#f4f7fb]">

        <!-- SIDEBAR -->
        <AdminSidebar />

        <!-- MAIN -->
        <div
            class="ml-[230px] min-h-screen
                   max-[850px]:ml-0"
        >
            <!-- TOPBAR -->
            <AdminTopbar />

            <!-- PAGE CONTENT -->
            <main
                class="w-auto min-w-0 p-[22px]
                       max-[600px]:p-[14px]"
            >
                <slot />
            </main>
        </div>

    </div>
</template>
