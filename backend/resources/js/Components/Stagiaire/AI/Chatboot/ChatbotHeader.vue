<script setup>
defineEmits(['close'])
</script>

<template>
    <div
        class="flex items-center justify-between
               border-b border-white/10
               bg-gradient-to-r from-[#16425B] to-[#2F6690]
               px-4 py-3.5 shrink-0"
    >
        <div class="flex items-center gap-3">

            <!-- Sonic avatar -->
            <div class="relative">
                <div
                    class="flex h-10 w-10 items-center justify-center
                           overflow-hidden rounded-full
                           bg-white/10
                           ring-1 ring-white/15"
                >
                    <img
                        src="http://localhost:8000/images/sonic.png"
                        alt="Sonic AI"
                        class="h-full w-full object-contain"
                    />
                </div>

                <!-- Online indicator -->
                <span
                    class="absolute bottom-0 right-0
                           h-3 w-3 rounded-full
                           border-2 border-[#2F6690]
                           bg-[#81C3D7]"
                ></span>
            </div>

            <div>
                <p class="text-sm font-bold text-white">
                    Sonic
                </p>

                <div class="mt-0.5 flex items-center gap-1.5">
                    <span
                        class="h-1.5 w-1.5 rounded-full
                               bg-[#81C3D7]"
                    ></span>

                    <p class="text-[10px] font-medium text-white/65">
                        AI Career Assistant
                    </p>
                </div>
            </div>

        </div>

        <!-- Close -->
        <button
            type="button"
            @click="$emit('close')"
            class="flex h-8 w-8 items-center justify-center
                   rounded-lg text-white/60
                   transition hover:bg-white/10
                   hover:text-white"
            aria-label="Close chat"
        >
            <svg
                width="18"
                height="18"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
            >
                <line x1="18" y1="6" x2="6" y2="18" />
                <line x1="6" y1="6" x2="18" y2="18" />
            </svg>
        </button>

    </div>
</template>