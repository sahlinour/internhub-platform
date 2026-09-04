<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import HeroSection from '@/Components/home/HeroSection.vue';
import StatsSection from '@/Components/home/StatsSection.vue';
import FeaturesSection from '@/Components/home/FeaturesSection.vue';
import OffresRecentes from '@/Components/home/OffresRecentes.vue';
import HowItWorks from '@/Components/home/HowItWorks.vue';
import Testimonials from '@/Components/home/Testimonials.vue';
import CtaBanner from '@/Components/home/CtaBanner.vue';
</script>

<template>
    <GuestLayout>
        
        <!-- Home -->
        <section id="home">
            <HeroSection />
        </section>

        <!-- Stats -->
        <section id="stats">
            <StatsSection />
        </section>

        <!-- About / Features -->
        <section id="about">
            <FeaturesSection />
        </section>

        <!-- Explore / Offers -->
        <section id="explore">
            <OffresRecentes />
        </section>

        <!-- How it works -->
        <section id="how-it-works">
            <HowItWorks />
        </section>

        <!-- CTA -->
        <section id="cta">
            <CtaBanner />
        </section>

        <!-- Testimonials -->
        <section id="testimonials">
            <Testimonials />
        </section>

    </GuestLayout>
</template>