<script setup>
import { router } from '@inertiajs/vue3'

const props = defineProps({
    currentFilter: {
        type: String,
        default: 'all',
    },
})

const filters = [
    {
        key: 'all',
        label: 'All',
    },
    {
        key: 'unread',
        label: 'Unread',
    },
    {
        key: 'read',
        label: 'Read',
    },
    {
        key: 'tasks',
        label: 'Tasks',
    },
]

const changeFilter = (filter) => {
    router.get(
        route('notifications.index'),
        {
            filter,
        },
        {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        }
    )
}
</script>

<template>
    <div
        class="flex items-center gap-6 border-b border-slate-100
               px-4 py-3 sm:px-5"
    >
        <button
            v-for="item in filters"
            :key="item.key"
            type="button"
            @click="changeFilter(item.key)"
            class="relative pb-1 text-[9px] font-medium transition"
            :class="
                currentFilter === item.key
                    ? 'text-[#2F6690]'
                    : 'text-slate-500 hover:text-[#2F6690]'
            "
        >
            {{ item.label }}

            <span
                v-if="currentFilter === item.key"
                class="absolute bottom-0 left-0 h-0.5 w-full
                       rounded-full bg-[#2F6690]"
            ></span>
        </button>
    </div>
</template>