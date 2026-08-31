```vue
<script setup>
defineProps({
    notifications: {
        type: Array,
        default: () => [],
    },
})
</script>

<template>
    <div class="min-h-screen bg-gray-100 py-10">
        <div class="mx-auto max-w-6xl px-6">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800">
                    notifications
                </h1>

                <p class="mt-2 text-gray-600">
                    Liste des notifications du 
                </p>
            </div>

            <div
                v-if="notifications.length > 0"
                class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4"
            >
                <div
                    v-for="ville in notifications"
                    :key="ville.id"
                    class="rounded-lg bg-white p-6 shadow transition hover:shadow-lg"
                >
                    <h2 class="text-xl font-semibold text-gray-800">
                        {{ ville.titre }}
                    </h2>

                    <p class="mt-2 text-sm text-gray-500">
                        ID : {{ ville.id }}
                    </p>
                </div>
            </div>

            <div
                v-else
                class="rounded-lg bg-white p-8 text-center shadow"
            >
                <p class="text-gray-500">
                    Aucune ville trouvée.
                </p>
            </div>
        </div>
    </div>
</template>
```
