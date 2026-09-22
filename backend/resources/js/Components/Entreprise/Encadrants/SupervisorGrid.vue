<script setup>
import SupervisorCard from './SupervisorCard.vue'

defineProps({
    supervisors: {
        type: Array,
        default: () => [],
    },
    getInitials: {
        type: Function,
        required: true,
    },
    getSubtitle: {
        type: Function,
        required: true,
    },
})

const emit = defineEmits([
    'edit',
    'delete',
])
</script>

<template>
    <div
        v-if="supervisors.length"
        class="grid grid-cols-1 gap-4
               md:grid-cols-2
               xl:grid-cols-3"
    >
        <SupervisorCard
            v-for="user in supervisors"
            :key="user.id"
            :user="user"
            :initials="getInitials(user)"
            :subtitle="getSubtitle(user)"
            @edit="emit('edit', $event)"
            @delete="emit('delete', $event)"
        />
    </div>

    <div
        v-else
        class="rounded-2xl border
               border-slate-200
               bg-white px-6 py-14
               text-center shadow-sm"
    >
        <div
            class="mx-auto flex h-11 w-11
                   items-center justify-center
                   rounded-xl bg-[#F4F7F9]"
        >
            <svg
                class="h-5 w-5 text-slate-400"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1.8"
                    d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2m13-8a4 4 0 10-8 0m11 8v-2a4 4 0 00-3-3.87m-1-8a4 4 0 010 7.75"
                />
            </svg>
        </div>

        <h3
            class="mt-3 text-sm font-bold
                   text-[#16425B]"
        >
            No company supervisors found
        </h3>

        <p
            class="mx-auto mt-1 max-w-sm
                   text-xs text-slate-400"
        >
            Create a supervisor account to manage
            your interns.
        </p>
    </div>
</template>