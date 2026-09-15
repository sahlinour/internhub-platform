<script setup>
import { Link, router } from '@inertiajs/vue3'

defineProps({
    cv: {
        type: Object,
        required: true,
    },
})

const deleteCV = (id) => {
    if (confirm('Are you sure you want to delete this CV?')) {
        router.delete(route('stagiaire.cv.destroy', id))
    }
}

const downloadCV = (url) => {
    window.open(url, '_blank')
}
</script>

<template>
    <div
        class="flex flex-col rounded-lg border border-[#e5ebf0]
               bg-white p-5 shadow-sm transition
               hover:shadow-md hover:border-[#2F6690]/30"
    >
        <!-- CV Icon and Title -->
        <div class="flex items-start justify-between">
            <div class="flex items-center gap-3">
                <div
                    class="flex h-10 w-10 items-center justify-center
                           rounded-lg bg-[#E8F3F8] text-[#2F6690]"
                >
                    <svg
                        width="20"
                        height="20"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <h3 class="truncate text-[13px] font-semibold text-[#16425B]">
                        {{ cv.nom || 'CV Document' }}
                    </h3>
                    <p class="text-[11px] text-slate-500">
                        v{{ cv.version || '1.0' }}
                    </p>
                </div>
            </div>

            <!-- Status Badge -->
            <span
                class="shrink-0 rounded-full px-2.5 py-1
                       text-[10px] font-medium"
                :class="
                    cv.statut === 'Approuvé'
                        ? 'bg-green-100 text-green-700'
                        : cv.statut === 'Rejeté'
                          ? 'bg-red-100 text-red-700'
                          : 'bg-yellow-100 text-yellow-700'
                "
            >
                {{ cv.statut || 'Pending' }}
            </span>
        </div>

        <!-- Details -->
        <div class="my-4 space-y-2 border-y border-[#e5ebf0] py-4">
            <div class="flex justify-between text-[11px]">
                <span class="text-slate-600">Upload Date:</span>
                <span class="font-medium text-[#16425B]">
                    {{ new Date(cv.created_at).toLocaleDateString() }}
                </span>
            </div>
            <div class="flex justify-between text-[11px]">
                <span class="text-slate-600">File:</span>
                <span class="font-medium text-[#16425B]">
                    {{ cv.fichier_url?.split('/').pop() || 'Document' }}
                </span>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex gap-2">
            <button
                @click="downloadCV(cv.fichier_url)"
                class="flex-1 rounded-lg border border-[#2F6690]
                       bg-white px-3 py-2 text-[10px] font-semibold
                       text-[#2F6690] transition
                       hover:bg-[#2F6690]/5"
            >
                Download
            </button>

            <button
                @click="deleteCV(cv.id)"
                class="flex-1 rounded-lg border border-red-200
                       bg-white px-3 py-2 text-[10px] font-semibold
                       text-red-600 transition
                       hover:bg-red-50"
            >
                Delete
            </button>
        </div>
    </div>
</template>
