<script setup>
defineProps({
    total: {
        type: Number,
        default: 0,
    },

    displayed: {
        type: Number,
        default: 0,
    },
})
</script>

<template>
    <div
        class="rounded-xl
               border border-slate-200
               bg-white
               px-5 py-4
               shadow-sm"
    >
        <div class="flex items-center gap-3">

            <!-- ICON -->

            <div
                class="flex h-10 w-10 shrink-0
                       items-center justify-center
                       rounded-lg
                       bg-[#E8F1F5]
                       text-[#3A7CA5]"
            >
                <svg
                    class="h-5 w-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="1.8"
                        d="m5 13 4 4L19 7"
                    />
                </svg>
            </div>

            <!-- CONTENT -->

            <div>
                <p
                    class="text-[10px] font-medium
                           uppercase tracking-wide
                           text-slate-400"
                >
                    Total accepted
                </p>

                <p
                    class="mt-0.5 text-lg font-bold
                           text-[#16425B]"
                >
                    {{ total }}
                </p>
            </div>

        </div>
    </div>
</template>