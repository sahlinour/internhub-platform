<script setup>
const activities = [
    {
        title: 'New company registered',
        description: 'Atlas Digital joined InternHub',
        time: '12 min ago',
    },
    {
        title: 'Internship offer published',
        description: 'Frontend Developer Internship',
        time: '35 min ago',
    },
    {
        title: 'New student account',
        description: 'Sara Alaoui created an account',
        time: '1 hour ago',
    },
    {
        title: 'Application submitted',
        description: 'A new application was sent for an internship offer',
        time: '2 hours ago',
    },
]
</script>

<template>
    <div class="flex flex-col">
        <div
            v-for="(activity, index) in activities"
            :key="`${activity.title}-${activity.time}`"
            class="grid grid-cols-[auto_minmax(0,1fr)_auto]
                   items-start gap-[10px]
                   border-b border-[#edf1f4]
                   py-3
                   first:pt-0.5
                   last:border-b-0
                   last:pb-0.5
                   max-[520px]:grid-cols-[auto_minmax(0,1fr)]"
        >
            <!-- DOT -->
            <div
                class="mt-[5px] h-2 w-2
                       shrink-0 rounded-full
                       bg-[#286d93]"
            ></div>

            <!-- CONTENT -->
            <div class="min-w-0">
                <strong
                    class="mb-[3px] block
                           text-[10px] font-bold
                           text-[#2b4354]"
                >
                    {{ activity.title }}
                </strong>

                <span
                    class="block overflow-hidden
                           text-ellipsis
                           text-[9px] leading-[1.45]
                           text-[#8999a5]"
                >
                    {{ activity.description }}
                </span>
            </div>

            <!-- TIME -->
            <small
                class="whitespace-nowrap pt-px
                       text-[8px] text-[#9ba8b2]
                       max-[520px]:col-start-2
                       max-[520px]:mt-[3px]
                       max-[520px]:pt-0"
            >
                {{ activity.time }}
            </small>
        </div>
    </div>
</template>
