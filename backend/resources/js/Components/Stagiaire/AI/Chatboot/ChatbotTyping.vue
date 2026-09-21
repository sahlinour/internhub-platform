<template>
    <div class="flex items-end gap-2">

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

        <!-- Typing indicator -->
        <div
            class="flex items-center gap-1
                   rounded-2xl rounded-bl-md
                   border border-[#E2E8F0]
                   border-l-[3px] border-l-[#81C3D7]
                   bg-white
                   px-4 py-3
                   shadow-[0_2px_8px_rgba(22,66,91,0.05)]"
        >
            <span
                class="h-1.5 w-1.5 animate-bounce
                       rounded-full bg-[#81C3D7]"
            ></span>

            <span
                class="h-1.5 w-1.5 animate-bounce
                       rounded-full bg-[#81C3D7]"
                style="animation-delay: 150ms"
            ></span>

            <span
                class="h-1.5 w-1.5 animate-bounce
                       rounded-full bg-[#81C3D7]"
                style="animation-delay: 300ms"
            ></span>
        </div>

    </div>
</template>