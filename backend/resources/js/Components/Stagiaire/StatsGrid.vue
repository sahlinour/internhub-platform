<script setup>
import StatCard from './StatCard.vue';

defineProps({
    stats: {
        type: Object,
        default: () => ({
            candidatures: 0,
            favoris: 0,
            entretiens: 0,
            profil: 0,
        }),
    },
});
</script>

<template>
    <div class="grid grid-cols-2 gap-4 xl:grid-cols-4">
        <StatCard
            title="Candidatures"
            :value="stats.candidatures"
            subtitle="Candidatures envoyées"
            icon="file"
        />

        <StatCard
            title="Offres favorites"
            :value="stats.favoris"
            subtitle="Offres enregistrées"
            icon="star"
        />

        <StatCard
            title="Entretiens"
            :value="stats.entretiens"
            subtitle="Entretiens planifiés"
            icon="calendar"
        />

        <StatCard
            title="Profil complété"
            :value="`${stats.profil}%`"
            subtitle="Complétez votre profil"
            icon="user"
        />
    </div>
</template>