<script setup>
import { computed, ref } from 'vue'
import StagiaireLayout from '@/Components/Stagiaire/StagiaireLayout.vue'
import DocumentHeader from '@/Components/Stagiaire/Documents/DocumentHeader.vue'
import DocumentUpload from '@/Components/Stagiaire/Documents/DocumentUpload.vue'
import DocumentCard from '@/Components/Stagiaire/Documents/DocumentCard.vue'
import DocumentPagination from '@/Components/Stagiaire/Documents/DocumentPagination.vue'

const props = defineProps({
    documents: {
        type: Object,
        required: true,
    },
    stage: {
        type: Object,
        default: null,
    },
})

const documentList = computed(() => {
    return props.documents?.data ?? []
})

const showUploadModal = ref(false)

const openUploadModal = () => {
    if (!props.stage) return

    showUploadModal.value = true
}

const closeUploadModal = () => {
    showUploadModal.value = false
}
</script>

<template>
    <StagiaireLayout>
        <main class="min-h-screen bg-[#F4F7F9]">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

                <!-- PAGE HEADER -->
                <DocumentHeader
                    :can-upload="!!stage"
                    @open-upload="openUploadModal"
                />

                <!-- DOCUMENT UPLOAD MODAL -->
                <DocumentUpload
                    :stage="stage"
                    :show="showUploadModal"
                    @close="closeUploadModal"
                />

                <!-- DOCUMENT SECTION -->
                <section
                    class="mt-10 rounded-2xl border border-slate-100
                        bg-white
                        shadow-[0_4px_18px_rgba(16,46,65,0.045)]"
                >
                    <!-- SECTION HEADER -->
                    <div
                        class="border-b border-slate-100
                            px-5 py-4"
                    >
                        <h2
                            class="text-[14px] font-bold
                                text-[#16425B]"
                        >
                            Internship Documents
                        </h2>

                        <p
                            class="mt-0.5 text-[9px]
                                text-slate-400"
                        >
                            Documents related to your current internship.
                        </p>
                    </div>

                    <!-- EMPTY -->
                    <div
                        v-if="documentList.length === 0"
                        class="flex flex-col items-center
                            justify-center px-6 py-16
                            text-center"
                    >
                        <div
                            class="mb-4 flex h-14 w-14
                                items-center justify-center
                                rounded-2xl bg-[#3A7CA5]/10
                                text-[#2F6690]"
                        >
                            <svg
                                width="25"
                                height="25"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.6"
                            >
                                <path
                                    d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"
                                />
                                <path d="M14 2v6h6" />
                                <path d="M8 13h8" />
                                <path d="M8 17h5" />
                            </svg>
                        </div>

                        <h3
                            class="text-[14px] font-semibold
                                text-[#16425B]"
                        >
                            No documents found
                        </h3>

                        <p
                            class="mt-1 max-w-[350px]
                                text-[10px] leading-5
                                text-slate-400"
                        >
                            No documents are available for your internship yet.
                        </p>
                    </div>

                    <!-- DOCUMENT CARDS -->
                    <div
                        v-else
                        class="space-y-3 p-5"
                    >
                        <DocumentCard
                            v-for="document in documentList"
                            :key="document.id"
                            :document="document"
                        />
                    </div>

                    <!-- PAGINATION -->
                    <DocumentPagination
                        :links="documents?.links ?? []"
                    />
                </section>
            </div>
        </main>
    </StagiaireLayout>
</template>