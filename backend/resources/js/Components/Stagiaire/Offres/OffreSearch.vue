<script setup>
defineProps({
    modelValue: {
        type: String,
        default: '',
    },
})

defineEmits(['update:modelValue'])
</script>

<template>
    <section
        class="overflow-hidden rounded-2xl bg-[#16425B] px-5 py-6 text-white shadow-sm sm:px-7"
    >
        <!-- Header -->
        <div class="mb-5">
            <div class="flex items-center gap-3">
                <!-- Search icon -->
                <div
                    class="flex h-11 w-11 shrink-0 items-center justify-center
                           rounded-xl bg-white/10"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-6 w-6 text-[#81C3D7]"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m21 21-4.35-4.35m1.35-5.65a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"
                        />
                    </svg>
                </div>

                <div>
                    <h2 class="text-xl font-bold tracking-tight sm:text-2xl">
                        Find Your Internship
                    </h2>

                    <p class="mt-1 text-sm text-[#B9D9E8]">
                        Explore internship opportunities and find the one
                        that matches your goals.
                    </p>
                </div>
            </div>
        </div>

        <!-- Search -->
        <div class="relative">
            <!-- Search icon inside input -->
            <span
                class="pointer-events-none absolute left-4 top-1/2
                       flex h-5 w-5 -translate-y-1/2
                       items-center justify-center
                       text-[#2F6690]"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="2"
                    stroke="currentColor"
                    class="h-[18px] w-[18px]"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="m21 21-4.35-4.35m1.35-5.65a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"
                    />
                </svg>
            </span>

            <input
                :value="modelValue"
                @input="$emit('update:modelValue', $event.target.value)"
                type="text"
                placeholder="Search by internship title..."
                class="w-full rounded-xl
                       border border-white/20
                       bg-white
                       py-3.5 pl-12 pr-4
                       text-sm text-[#16425B]
                       shadow-sm
                       outline-none
                       transition
                       placeholder:text-slate-400
                       hover:border-[#81C3D7]
                       focus:border-[#81C3D7]
                       focus:ring-4 focus:ring-[#81C3D7]/20"
            />
        </div>
    </section>
</template>