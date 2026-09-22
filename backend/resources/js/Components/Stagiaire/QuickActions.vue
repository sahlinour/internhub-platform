<script setup>
import { Link } from '@inertiajs/vue3'
import Icon from '@/Components/Stagiaire/Icon.vue'

const actions = [
    {
        label: 'Browse Internship Offers',
        description: 'Find an internship that matches your profile',
        routeName: 'offres.index',
        icon: 'briefcase',
    },
    {
        label: 'My Applications',
        description: 'Track your submitted applications',
        routeName: 'stagiaire.candidatures.index',
        icon: 'documents',
    },
    {
        label: 'My Documents',
        description: 'Access your internship documents',
        routeName: 'stagiaire.documents.index',
        icon: 'documents',
    },
    {
        label: 'My Profile',
        description: 'Update your personal information',
        routeName: 'stagiaire.profile.show',
        icon: 'user',
    },
]
</script>

<template>
    <div class="flex flex-col gap-2">
        <Link
            v-for="action in actions"
            :key="action.label"
            :href="route(action.routeName)"
            class="group flex items-center gap-3 rounded-[9px] border border-[#e1e7ec] bg-white p-3 no-underline transition duration-[180ms] hover:border-[#286d93] hover:bg-[#f8fbfd]"
        >
            <span
                class="flex h-[34px] w-[34px] shrink-0 items-center justify-center rounded-[8px] bg-[#eaf2f6] text-[#286d93] transition group-hover:bg-[#286d93] group-hover:text-white"
            >
                <Icon
                    :name="action.icon"
                    :size="16"
                />
            </span>

            <span class="min-w-0 flex-1">
                <strong
                    class="mb-0.5 block text-[10px] font-semibold text-[#20394b]"
                >
                    {{ action.label }}
                </strong>

                <span
                    class="block truncate text-[9px] text-[#8b9aa5]"
                >
                    {{ action.description }}
                </span>
            </span>

            <span
                class="shrink-0 text-[13px] text-[#a6b4bd] transition group-hover:translate-x-0.5 group-hover:text-[#286d93]"
            >
                →
            </span>
        </Link>
    </div>
</template>
