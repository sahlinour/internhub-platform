<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    user: {
        type: Object,
        default: () => ({}),
    },
});
</script>

<template>
    <section
        class="overflow-hidden rounded-2xl bg-[#16425B] px-5 py-6 text-white shadow-sm sm:px-7"
    >
        <div
            class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between"
        >
            <div>
                <p class="mb-1 text-sm text-[#B9D9E8]">
                    Bienvenue dans votre espace
                </p>

                <h1 class="text-2xl font-bold tracking-tight sm:text-3xl">
                    Bonjour{{ user?.name ? `, ${user.name}` : '' }} 👋
                </h1>

                <p class="mt-2 max-w-xl text-sm leading-6 text-[#D8ECF4]">
                    Suivez vos candidatures, découvrez de nouvelles opportunités
                    et gérez votre parcours de stage depuis votre espace.
                </p>
            </div>

            <div class="flex flex-wrap gap-3">
                <Link
                    :href="route('stagiaire.candidatures.index')"
                    class="rounded-lg bg-white px-4 py-2.5 text-sm font-semibold text-[#16425B] transition hover:bg-slate-100"
                >
                    Voir mes candidatures
                </Link>

                <Link
                    :href="route('offres.index')"
                    class="rounded-lg border border-white/30 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-white/10"
                >
                    Parcourir les offres
                </Link>
            </div>
        </div>
    </section>
</template>