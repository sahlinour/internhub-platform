<script setup>
defineProps({
    message: {
        type: Object,
        required: true
    }
})

function formatTime(date) {
    return new Date(date).toLocaleTimeString('en-US', {
        hour: '2-digit',
        minute: '2-digit'
    })
}
</script>

<template>

    <!-- SONIC -->
    <div
        v-if="message.role === 'bot'"
        class="flex items-end gap-2"
    >
        <!-- Sonic avatar -->
        <div
            class="flex h-7 w-7 shrink-0 items-center justify-center
                   overflow-hidden rounded-full
                   bg-[#E8F1F5]
                   ring-1 ring-[#DCE5EA]"
        >
            <img
                src="http://localhost:8000/images/sonic.png"
                alt="Sonic AI"
                class="h-full w-full object-contain"
            />
        </div>

        <div class="max-w-[82%]">

            <!-- Message -->
            <div
                class="rounded-2xl rounded-bl-md
                       border border-[#E2E8F0]
                       border-l-[3px] border-l-[#81C3D7]
                       bg-white
                       px-3.5 py-2.5
                       text-[12px] leading-5
                       text-[#334155]
                       shadow-[0_2px_8px_rgba(22,66,91,0.05)]
                       whitespace-pre-wrap"
            >
                {{ message.text }}
            </div>

            <!-- Time -->
            <p
                class="ml-1 mt-1 text-[9px]
                       font-medium text-[#94A3B8]"
            >
                {{ formatTime(message.time) }}
            </p>

        </div>
    </div>

    <!-- USER -->
    <div
        v-else
        class="flex justify-end"
    >
        <div class="max-w-[82%]">

            <!-- Message -->
            <div
                class="rounded-2xl rounded-br-md
                       bg-gradient-to-br
                       from-[#16425B] to-[#2F6690]
                       px-3.5 py-2.5
                       text-[12px] leading-5
                       text-white
                       shadow-[0_3px_10px_rgba(22,66,91,0.15)]
                       whitespace-pre-wrap"
            >
                {{ message.text }}
            </div>

            <!-- Time -->
            <p
                class="mr-1 mt-1 text-right
                       text-[9px] font-medium
                       text-[#94A3B8]"
            >
                {{ formatTime(message.time) }}
            </p>

        </div>
    </div>

</template>