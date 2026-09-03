<script setup>
import { Link } from '@inertiajs/vue3'
import Icon from './Icon.vue'

const actions = [
    {
        label: 'Manage companies',
        routeName: 'admin.entreprises.index',
        icon: 'company',
    },
    {
        label: 'Manage students',
        routeName: 'admin.stagiaires.index',
        icon: 'users',
    },
    {
        label: 'Review offers',
        routeName: 'admin.offres.index',
        icon: 'briefcase',
    },
    {
        label: 'View reports',
        routeName: 'admin.signalements.index',
        icon: 'alert',
    },
]
</script>

<template>
    <div
        class="grid grid-cols-2 gap-[10px]
               max-[480px]:grid-cols-1"
    >
        <Link
            v-for="action in actions"
            :key="action.label"
            :href="route(action.routeName)"
            class="flex min-h-[86px]
                   flex-col items-center justify-center
                   gap-2 rounded-[10px]
                   border border-[#e1e7ec]
                   bg-white p-3
                   text-center text-[#344f62]
                   no-underline
                   transition duration-[180ms]
                   hover:-translate-y-px
                   hover:border-[#b8d2df]
                   hover:bg-[#f7fafc]"
        >
            <!-- ICON -->
            <span
                class="flex h-9 w-9
                       items-center justify-center
                       rounded-[9px]
                       bg-[#286d93]
                       text-white
                       [&_svg]:fill-none
                       [&_svg]:stroke-current"
            >
                <Icon
                    :name="action.icon"
                    :size="18"
                />
            </span>

            <!-- LABEL -->
            <span class="text-[10px] font-semibold">
                {{ action.label }}
            </span>
        </Link>
    </div>
</template>
