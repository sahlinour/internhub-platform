<script setup>
import { Link } from '@inertiajs/vue3'
</script>

<template>
    <div
        class="rounded-2xl border border-dashed border-slate-200
               bg-white px-6 py-14 text-center shadow-sm"
    >
        <div
            class="mx-auto flex h-14 w-14 items-center justify-center
                   rounded-full bg-[#E8F3F8] text-[#2F6690]"
        >
            <svg
                width="25"
                height="25"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                stroke-linecap="round"
                stroke-linejoin="round"
            >
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                <polyline points="14 2 14 8 20 8" />
            </svg>
        </div>

        <h2 class="mt-4 text-[15px] font-bold text-[#16425B]">
            No CV uploaded yet
        </h2>

        <p class="mx-auto mt-2 max-w-md text-[11px] leading-5 text-slate-500">
            Upload your professional CV to make it easily accessible for
            internship applications and your profile.
        </p>

        <Link
            :href="route('stagiaire.cv.create')"
            class="mt-5 inline-flex rounded-lg bg-[#2F6690]
                   px-5 py-2.5 text-[10px] font-semibold text-white
                   transition hover:bg-[#16425B]"
        >
            Upload Your CV
        </Link>
    </div>
</template>
