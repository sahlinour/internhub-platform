<script setup>
import StagiaireSidebar from '@/Components/Stagiaire/StagiaireSidebar.vue'
import StagiaireTopbar from '@/Components/Stagiaire/StagiaireTopbar.vue'
import ChatbotWidget from './AI/Chatboot/ChatbotWidget.vue';
</script>

<template>
    <div class="min-h-screen bg-[#f4f7fb]">

        <!-- SIDEBAR -->
        <StagiaireSidebar />

        <!-- MAIN -->
        <div
            class="ml-[230px] min-h-screen
                   max-[850px]:ml-0"
        >

            <!-- TOPBAR -->
            <StagiaireTopbar />

            <!-- PAGE CONTENT -->
            <main
                class="w-auto min-w-0 p-[22px]
                       max-[600px]:p-[14px]"
            >
                <slot />
            </main>

        </div>

        <!-- ROSE AI ASSISTANT -->
        <ChatbotWidget />

    </div>
</template>