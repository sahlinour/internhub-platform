<script setup>
defineProps({
    canUpload: {
        type: Boolean,
        default: false,
    },
})

const emit = defineEmits(['open-upload'])

const openUpload = () => {
    emit('open-upload')
}
</script>

<template>
    <section class="mb-6">

        <div
            class="relative overflow-hidden rounded-2xl
                   bg-gradient-to-r from-[#16425B] to-[#2F6690]
                   px-6 py-6 text-white
                   shadow-[0_8px_25px_rgba(22,66,91,0.12)]"
        >
            <div
                class="absolute -right-10 -top-14
                       h-36 w-36 rounded-full
                       bg-white/[0.06]"
            ></div>

            <div
                class="absolute -bottom-16 right-24
                       h-32 w-32 rounded-full
                       bg-[#81C3D7]/10"
            ></div>

            <div
                class="relative flex flex-col gap-5
                       sm:flex-row sm:items-center
                       sm:justify-between"
            >

                <!-- TEXT -->
                <div>
                    <p
                        class="mb-1 text-[9px] font-bold uppercase
                               tracking-[1.5px] text-[#81C3D7]"
                    >
                        My Internship
                    </p>

                    <h1
                        class="text-[25px] font-bold
                               tracking-[-0.4px]"
                    >
                        My Documents
                    </h1>

                    <p
                        class="mt-1 max-w-[550px]
                               text-[11px] leading-5
                               text-white/65"
                    >
                        Access and manage your internship documents.
                    </p>
                </div>

                <!-- UPLOAD BUTTON -->
                <button
                    v-if="canUpload"
                    type="button"
                    class="relative inline-flex shrink-0
                           items-center justify-center gap-2
                           self-start
                           rounded-[8px]
                           bg-white
                           px-4 py-2.5
                           text-[10px]
                           font-bold
                           text-[#16425B]
                           shadow-[0_4px_12px_rgba(0,0,0,0.12)]
                           transition
                           hover:bg-[#F4F7F9]
                           hover:shadow-[0_6px_16px_rgba(0,0,0,0.16)]
                           sm:self-center"
                    @click="openUpload"
                >
                    <svg
                        width="15"
                        height="15"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path d="M12 5v14" />
                        <path d="M5 12h14" />
                    </svg>

                    Upload Document
                </button>

            </div>
        </div>

    </section>
</template>