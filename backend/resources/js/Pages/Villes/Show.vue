<script setup>
defineProps({
    villes: Array
})
</script>

<template>
    <div>
        <h1>Liste des villes</h1>

        <ul>
            <li v-for="ville in villes" :key="ville.id">
                {{ ville.nom }}
            </li>
        </ul>
    </div>
</template>