<script setup>
import EntrepriseSidebar from '@/Components/Entreprise/EntrepriseSidebar.vue'
import EntrepriseHeader from '@/Components/Entreprise/EntrepriseHeader.vue'
</script>

<template>
    <div class="min-h-screen bg-[#f5f7fa]">
        <!-- SIDEBAR -->
        <EntrepriseSidebar />

        <!-- RIGHT SIDE -->
        <div class="min-h-screen ml-[230px] max-[850px]:ml-0">

            <!-- HEADER -->
            <EntrepriseHeader />

            <!-- PAGE CONTENT -->
            <main class="p-6 lg:p-7">
                <slot />
            </main>

        </div>
    </div>
</template>
