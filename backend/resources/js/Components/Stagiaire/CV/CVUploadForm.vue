<script setup>
import { ref } from 'vue'

const props = defineProps({
    form: {
        type: Object,
        required: true,
    },
})

const emit = defineEmits(['submit'])

const fileInput = ref(null)
const fileName = ref('')

const handleFileSelect = (event) => {
    const file = event.target.files[0]
    if (file) {
        fileName.value = file.name
        props.form.fichier = file
    }
}

const triggerFileInput = () => {
    fileInput.value?.click()
}
</script>

<template>
    <form
        @submit.prevent="$emit('submit')"
        class="rounded-lg border border-[#e5ebf0]
               bg-white p-6 shadow-sm"
    >
        <!-- CV Name -->
        <div class="mb-6">
            <label
                for="nom"
                class="block text-[12px] font-semibold text-[#16425B]"
            >
                CV Name
            </label>
            <input
                id="nom"
                v-model="form.nom"
                type="text"
                placeholder="e.g., My Resume 2024"
                class="mt-2 w-full rounded-lg border border-[#e5ebf0]
                       bg-white px-4 py-2.5 text-[13px]
                       text-[#16425B] placeholder:text-slate-400
                       transition focus:border-[#2F6690]
                       focus:outline-none focus:ring-2
                       focus:ring-[#2F6690]/20"
            />
            <p
                v-if="form.errors.nom"
                class="mt-1 text-[11px] text-red-600"
            >
                {{ form.errors.nom }}
            </p>
        </div>

        <!-- CV Version -->
        <div class="mb-6">
            <label
                for="version"
                class="block text-[12px] font-semibold text-[#16425B]"
            >
                Version
            </label>
            <input
                id="version"
                v-model="form.version"
                type="text"
                placeholder="e.g., 1.0"
                class="mt-2 w-full rounded-lg border border-[#e5ebf0]
                       bg-white px-4 py-2.5 text-[13px]
                       text-[#16425B] placeholder:text-slate-400
                       transition focus:border-[#2F6690]
                       focus:outline-none focus:ring-2
                       focus:ring-[#2F6690]/20"
            />
        </div>

        <!-- File Upload -->
        <div class="mb-6">
            <label
                for="fichier"
                class="block text-[12px] font-semibold text-[#16425B]"
            >
                CV File
            </label>

            <input
                ref="fileInput"
                id="fichier"
                type="file"
                accept=".pdf,.doc,.docx"
                class="hidden"
                @change="(e) => {
                    form.fichier = e.target.files[0]
                    handleFileSelect(e)
                }"
            />

            <div
                @click="triggerFileInput"
                class="mt-2 flex cursor-pointer flex-col items-center
                       justify-center rounded-lg border-2
                       border-dashed border-[#2F6690]/30 bg-[#2F6690]/5
                       px-6 py-8 transition
                       hover:border-[#2F6690]/50 hover:bg-[#2F6690]/10"
            >
                <svg
                    width="32"
                    height="32"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.5"
                    class="text-[#2F6690]"
                >
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                    <polyline points="17 8 12 3 7 8" />
                    <line x1="12" y1="3" x2="12" y2="15" />
                </svg>

                <p class="mt-3 text-center">
                    <span class="text-[12px] font-semibold text-[#2F6690]">
                        Click to upload
                    </span>
                    <span class="text-[11px] text-slate-500">
                        or drag and drop
                    </span>
                </p>

                <p class="mt-2 text-[10px] text-slate-400">
                    PDF, DOC or DOCX (Max 10MB)
                </p>

                <div
                    v-if="fileName"
                    class="mt-3 rounded-lg bg-green-50 px-3 py-2"
                >
                    <p class="text-[11px] font-medium text-green-700">
                        ✓ {{ fileName }}
                    </p>
                </div>
            </div>

            <p
                v-if="form.errors.fichier"
                class="mt-2 text-[11px] text-red-600"
            >
                {{ form.errors.fichier }}
            </p>
        </div>

        <!-- Submit Button -->
        <div class="flex gap-3">
            <button
                type="submit"
                :disabled="form.processing"
                class="flex-1 rounded-lg bg-[#2F6690] px-4 py-2.5
                       text-[12px] font-semibold text-white
                       transition hover:bg-[#16425B]
                       disabled:opacity-50 disabled:cursor-not-allowed"
            >
                {{ form.processing ? 'Uploading...' : 'Upload CV' }}
            </button>

            <a
                :href="route('stagiaire.cv.index')"
                class="inline-flex rounded-lg border border-[#e5ebf0]
                       bg-white px-4 py-2.5 text-[12px]
                       font-semibold text-[#16425B] transition
                       hover:bg-[#f4f7fb]"
            >
                Cancel
            </a>
        </div>
    </form>
</template>
