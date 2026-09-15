<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    processing: {
        type: Boolean,
        default: false,
    },
})
</script>

<template>
    <div
        class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end"
    >

        <Link
            :href="route('stagiaire.profile.show')"
            class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-xs font-semibold text-slate-600 transition hover:bg-slate-50"
        >
            Cancel
        </Link>

        <button
            type="submit"
            :disabled="processing"
            class="inline-flex items-center justify-center rounded-xl bg-[#16425B] px-6 py-2.5 text-xs font-semibold text-white transition hover:bg-[#2F6690] disabled:cursor-not-allowed disabled:opacity-60"
        >
            <svg
                v-if="!processing"
                xmlns="http://www.w3.org/2000/svg"
                class="mr-2 h-4 w-4"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M5 13l4 4L19 7"
                />
            </svg>

            {{ processing ? 'Saving...' : 'Save Changes' }}
        </button>

    </div>
</template>