<script setup>
import { ref } from 'vue';

const question = ref('');

const emit = defineEmits(['ask']);

const suggestions = [
    'Trouver des stages adaptés à mon profil',
    'Améliorer mon CV',
    'Quelles compétences dois-je développer ?',
    'Préparer mon entretien',
];

function askQuestion(text = question.value) {
    const value = text.trim();

    if (!value) return;

    emit('ask', value);

    question.value = '';
}
</script>

<template>
    <section
        class="overflow-hidden rounded-2xl bg-[#16425B] p-5 text-white shadow-sm sm:p-6"
    >
        <div class="flex items-start gap-3">
            <div
                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white/10 text-lg"
            >
                ✨
            </div>

            <div>
                <h2 class="font-bold">
                    AI Career Assistant
                </h2>

                <p class="mt-1 text-sm leading-6 text-[#D8ECF4]">
                    Obtenez des recommandations personnalisées pour votre
                    recherche de stage et votre évolution professionnelle.
                </p>
            </div>
        </div>

        <form
            class="mt-5 flex flex-col gap-2 sm:flex-row"
            @submit.prevent="askQuestion()"
        >
            <input
                v-model="question"
                type="text"
                placeholder="Posez une question à votre assistant..."
                class="min-w-0 flex-1 rounded-lg border-0 bg-white/10 px-4 py-3 text-sm text-white outline-none placeholder:text-[#B9D9E8] focus:ring-2 focus:ring-white/30"
            />

            <button
                type="submit"
                class="rounded-lg bg-[#3A7CA5] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#2F6690]"
            >
                Envoyer
            </button>
        </form>

        <div class="mt-4 flex flex-wrap gap-2">
            <button
                v-for="suggestion in suggestions"
                :key="suggestion"
                type="button"
                @click="askQuestion(suggestion)"
                class="rounded-lg border border-white/10 bg-white/5 px-3 py-2 text-xs text-[#D8ECF4] transition hover:bg-white/10"
            >
                {{ suggestion }}
            </button>
        </div>
    </section>
</template>