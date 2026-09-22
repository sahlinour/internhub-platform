<script setup>
import { computed, ref } from 'vue'
import { useForm } from '@inertiajs/vue3'

const props = defineProps({
    stage: {
        type: Object,
        default: null,
    },
    show: {
        type: Boolean,
        default: false,
    },
})

const emit = defineEmits(['close'])

const fileInput = ref(null)

const form = useForm({
    id_Stage: props.stage?.id ?? '',
    nom: '',
    version: '',
    fichier: null,
})

const fileName = computed(() => {
    return form.fichier?.name ?? ''
})

const selectFile = () => {
    fileInput.value?.click()
}

const handleFile = (event) => {
    const file = event.target.files?.[0] ?? null

    form.fichier = file

    if (file && !form.nom) {
        form.nom = file.name
    }
}

const closeModal = () => {
    if (form.processing) return

    emit('close')
}

const submit = () => {
    form.post(route('stagiaire.documents.store'), {
        preserveScroll: true,
        forceFormData: true,
        onSuccess: () => {
            form.reset('nom', 'version', 'fichier')

            if (fileInput.value) {
                fileInput.value.value = ''
            }

            emit('close')
        },
    })
}
</script>

<template>
    <Teleport to="body">
        <div
            v-if="show && stage"
            class="fixed inset-0 z-[100]
                   flex items-center justify-center
                   bg-[#16425B]/30
                   px-4 py-6
                   backdrop-blur-[2px]"
            @click.self="closeModal"
        >
            <div
                class="w-full max-w-[560px]
                       overflow-hidden
                       rounded-2xl
                       border border-slate-100
                       bg-white
                       shadow-[0_20px_60px_rgba(16,46,65,0.18)]"
            >
                <!-- MODAL HEADER -->
                <div
                    class="flex items-start
                           justify-between
                           border-b border-slate-100
                           px-5 py-4"
                >
                    <div>
                        <h2
                            class="text-[14px]
                                   font-bold
                                   text-[#16425B]"
                        >
                            Upload a document
                        </h2>

                        <p
                            class="mt-0.5
                                   text-[9px]
                                   text-slate-400"
                        >
                            Add a document to your current internship.
                        </p>
                    </div>

                    <button
                        type="button"
                        :disabled="form.processing"
                        class="flex h-7 w-7
                               items-center justify-center
                               rounded-[7px]
                               text-slate-400
                               transition
                               hover:bg-slate-50
                               hover:text-[#16425B]
                               disabled:cursor-not-allowed
                               disabled:opacity-40"
                        @click="closeModal"
                    >
                        <svg
                            width="15"
                            height="15"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path d="M6 6l12 12" />
                            <path d="M18 6L6 18" />
                        </svg>
                    </button>
                </div>

                <!-- FORM -->
                <form
                    class="p-5"
                    @submit.prevent="submit"
                >
                    <div
                        class="grid grid-cols-1
                               gap-4 md:grid-cols-2"
                    >
                        <!-- NAME -->
                        <div>
                            <label
                                for="document-name"
                                class="mb-1.5 block
                                       text-[9px]
                                       font-semibold
                                       text-[#2b4354]"
                            >
                                Document name
                            </label>

                            <input
                                id="document-name"
                                v-model="form.nom"
                                type="text"
                                maxlength="255"
                                class="w-full rounded-[7px]
                                       border border-[#dce6eb]
                                       bg-[#fafcfd]
                                       px-3 py-2
                                       text-[10px]
                                       text-[#2b4354]
                                       outline-none
                                       transition
                                       focus:border-[#3a7ca5]
                                       focus:bg-white"
                                placeholder="Document name"
                            />

                            <p
                                v-if="form.errors.nom"
                                class="mt-1
                                       text-[8px]
                                       text-[#d80536]"
                            >
                                {{ form.errors.nom }}
                            </p>
                        </div>

                        <!-- VERSION -->
                        <div>
                            <label
                                for="document-version"
                                class="mb-1.5 block
                                       text-[9px]
                                       font-semibold
                                       text-[#2b4354]"
                            >
                                Version
                            </label>

                            <input
                                id="document-version"
                                v-model="form.version"
                                type="text"
                                maxlength="10"
                                class="w-full rounded-[7px]
                                       border border-[#dce6eb]
                                       bg-[#fafcfd]
                                       px-3 py-2
                                       text-[10px]
                                       text-[#2b4354]
                                       outline-none
                                       transition
                                       focus:border-[#3a7ca5]
                                       focus:bg-white"
                                placeholder="Optional"
                            />

                            <p
                                v-if="form.errors.version"
                                class="mt-1
                                       text-[8px]
                                       text-[#d80536]"
                            >
                                {{ form.errors.version }}
                            </p>
                        </div>

                        <!-- FILE -->
                        <div class="md:col-span-2">
                            <label
                                class="mb-1.5 block
                                       text-[9px]
                                       font-semibold
                                       text-[#2b4354]"
                            >
                                File
                            </label>

                            <input
                                ref="fileInput"
                                type="file"
                                accept=".pdf,.doc,.docx,.zip,.rar"
                                class="hidden"
                                @change="handleFile"
                            />

                            <button
                                type="button"
                                class="w-full rounded-[8px]
                                       border border-dashed
                                       border-[#b9ccd6]
                                       bg-[#fafcfd]
                                       px-3 py-3.5
                                       text-left
                                       transition
                                       hover:border-[#3a7ca5]
                                       hover:bg-[#f7fbfd]"
                                @click="selectFile"
                            >
                                <div class="flex items-center gap-3">
                                    <div
                                        class="flex h-8 w-8
                                               shrink-0
                                               items-center justify-center
                                               rounded-[7px]
                                               bg-[#e8f1f5]
                                               text-[#2f6690]"
                                    >
                                        <svg
                                            width="15"
                                            height="15"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                        >
                                            <path
                                                d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"
                                            />
                                            <path d="M17 8l-5-5-5 5" />
                                            <path d="M12 3v12" />
                                        </svg>
                                    </div>

                                    <div class="min-w-0">
                                        <span
                                            class="block truncate
                                                   text-[10px]
                                                   font-semibold
                                                   text-[#3a7ca5]"
                                        >
                                            {{ fileName || 'Choose a file' }}
                                        </span>

                                        <span
                                            class="mt-1 block
                                                   text-[8px]
                                                   text-[#8b9aa5]"
                                        >
                                            PDF, DOC, DOCX, ZIP or RAR ·
                                            Maximum 10 MB
                                        </span>
                                    </div>
                                </div>
                            </button>

                            <p
                                v-if="form.errors.fichier"
                                class="mt-1
                                       text-[8px]
                                       text-[#d80536]"
                            >
                                {{ form.errors.fichier }}
                            </p>
                        </div>
                    </div>

                    <!-- ACTIONS -->
                    <div
                        class="mt-5 flex
                               justify-end
                               gap-2
                               border-t border-slate-100
                               pt-4"
                    >
                        <button
                            type="button"
                            :disabled="form.processing"
                            class="rounded-[7px]
                                   border border-slate-200
                                   bg-white
                                   px-4 py-2
                                   text-[10px]
                                   font-semibold
                                   text-slate-500
                                   transition
                                   hover:bg-slate-50
                                   disabled:cursor-not-allowed
                                   disabled:opacity-40"
                            @click="closeModal"
                        >
                            Cancel
                        </button>

                        <button
                            type="submit"
                            :disabled="form.processing || !form.fichier"
                            class="rounded-[7px]
                                   bg-[#2f6690]
                                   px-4 py-2
                                   text-[10px]
                                   font-semibold
                                   text-white
                                   transition
                                   hover:bg-[#245775]
                                   disabled:cursor-not-allowed
                                   disabled:opacity-50"
                        >
                            {{
                                form.processing
                                    ? 'Uploading...'
                                    : 'Upload Document'
                            }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </Teleport>
</template>