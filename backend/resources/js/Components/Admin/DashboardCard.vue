<script setup>
defineProps({
    title: {
        type: String,
        default: '',
    },
    subtitle: {
        type: String,
        default: '',
    },
})
</script>

<template>
    <section
        class="w-full rounded-[14px]
               border border-[#e0e8ed]
               bg-white p-[22px]
               shadow-[0_4px_14px_rgba(35,63,85,0.04)]"
    >
        <!-- CARD HEADER -->
        <div
            v-if="title || subtitle"
            class="mb-[18px] flex
                   items-start justify-between
                   gap-[18px]"
        >
            <div class="min-w-0">
                <h2
                    v-if="title"
                    class="mb-1 text-[15px]
                           font-bold text-[#20394b]"
                >
                    {{ title }}
                </h2>

                <p
                    v-if="subtitle"
                    class="m-0 text-[11px]
                           text-[#8b9aa5]"
                >
                    {{ subtitle }}
                </p>
            </div>

            <!-- ACTIONS -->
            <div class="shrink-0">
                <slot name="actions" />
            </div>
        </div>

        <!-- CARD CONTENT -->
        <div class="w-full min-w-0">
            <slot />
        </div>
    </section>
</template>
