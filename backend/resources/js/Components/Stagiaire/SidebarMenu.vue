<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import Icon from '@/Components/Stagiaire/Icon.vue'

const page = usePage()

const isActive = (path) => {
    return page.url.startsWith(path)
}

const hasStage = page.props.stagiaire?.has_stage ?? false
</script>

<template>
    <div
        class="sidebar-scroll min-h-0 flex-1 overflow-y-auto pr-[3px]"
    >
        <nav class="flex flex-col gap-[3px]">

            <!-- MY INTERNSHIP -->
            <p class="mx-[10px] mb-[7px] mt-0 text-[7px] font-bold tracking-[1.2px] text-white/30">
                MY INTERNSHIP
            </p>

            <!-- DASHBOARD -->
            <Link
                :href="route('stagiaire.dashboard')"
                class="relative flex min-h-[39px] items-center gap-[11px] rounded-lg px-[11px] py-[9px] text-[10.5px] font-medium no-underline transition hover:bg-white/[0.07] hover:text-white"
                :class="isActive('/stagiaire/dashboard') ? 'bg-[#449dc6]/[0.27] text-white before:absolute before:bottom-[9px] before:left-0 before:top-[9px] before:w-[3px] before:rounded-r-[3px] before:bg-[#78c0dc]' : 'text-white/65'"
            >
                <span class="flex h-[19px] w-[19px] shrink-0 items-center justify-center">
                    <Icon name="dashboard" :size="18" />
                </span>
                <span>Dashboard</span>
            </Link>

            <!-- INTERNSHIP OFFERS -->
            <Link
                :href="route('offres.index')"
                class="relative flex min-h-[39px] items-center gap-[11px] rounded-lg px-[11px] py-[9px] text-[10.5px] font-medium no-underline transition hover:bg-white/[0.07] hover:text-white"
                :class="isActive('/offres') ? 'bg-[#449dc6]/[0.27] text-white before:absolute before:bottom-[9px] before:left-0 before:top-[9px] before:w-[3px] before:rounded-r-[3px] before:bg-[#78c0dc]' : 'text-white/65'"
            >
                <span class="flex h-[19px] w-[19px] shrink-0 items-center justify-center">
                    <Icon name="briefcase" :size="18" />
                </span>
                <span>Internship Offers</span>
            </Link>

            <!-- MY APPLICATIONS -->
            <Link
                :href="route('stagiaire.candidatures.index')"
                class="relative flex min-h-[39px] items-center gap-[11px] rounded-lg px-[11px] py-[9px] text-[10.5px] font-medium no-underline transition hover:bg-white/[0.07] hover:text-white"
                :class="isActive('/stagiaire/candidatures') ? 'bg-[#449dc6]/[0.27] text-white before:absolute before:bottom-[9px] before:left-0 before:top-[9px] before:w-[3px] before:rounded-r-[3px] before:bg-[#78c0dc]' : 'text-white/65'"
            >
                <span class="flex h-[19px] w-[19px] shrink-0 items-center justify-center">
                    <Icon name="check" :size="18" />
                </span>
                <span>My Applications</span>
            </Link>

            <!-- MY INTERNSHIP JOURNEY -->
            <template v-if="hasStage">
                <p class="mx-[10px] mb-[7px] mt-[17px] text-[7px] font-bold tracking-[1.2px] text-white/30">
                    MY INTERNSHIP JOURNEY
                </p>

                <!-- INTERNSHIP JOURNEY -->
                <Link
                    :href="route('stagiaire.internship-journey')"
                    class="relative flex min-h-[39px] items-center gap-[11px] rounded-lg px-[11px] py-[9px] text-[10.5px] font-medium no-underline transition hover:bg-white/[0.07] hover:text-white"
                    :class="isActive('/stagiaire/internship-journey')
                        ? 'bg-[#449dc6]/[0.27] text-white before:absolute before:bottom-[9px] before:left-0 before:top-[9px] before:w-[3px] before:rounded-r-[3px] before:bg-[#78c0dc]'
                        : 'text-white/65'"
                >
                    <span
                        class="flex h-[19px] w-[19px] shrink-0 items-center justify-center"
                    >
                        <Icon name="briefcase" :size="18" />
                    </span>

                    <span>Internship Journey</span>
                </Link>

                <!-- PROGRESS -->
                <Link
                    :href="route('stagiaire.progress')"
                    class="relative flex min-h-[39px] items-center gap-[11px] rounded-lg px-[11px] py-[9px] text-[10.5px] font-medium no-underline transition hover:bg-white/[0.07] hover:text-white"
                    :class="isActive('/stagiaire/progress')
                        ? 'bg-[#449dc6]/[0.27] text-white before:absolute before:bottom-[9px] before:left-0 before:top-[9px] before:w-[3px] before:rounded-r-[3px] before:bg-[#78c0dc]'
                        : 'text-white/65'"
                >
                    <span
                        class="flex h-[19px] w-[19px] shrink-0 items-center justify-center"
                    >
                        <Icon name="progress" :size="18" />
                    </span>

                    <span>My Progress</span>
                </Link>

                <Link
                    :href="route('stagiaire.taches.index')"
                    class="relative flex min-h-[39px] items-center gap-[11px] rounded-lg px-[11px] py-[9px] text-[10.5px] font-medium no-underline transition hover:bg-white/[0.07] hover:text-white"
                    :class="isActive('/stagiaire/taches') ? 'bg-[#449dc6]/[0.27] text-white before:absolute before:bottom-[9px] before:left-0 before:top-[9px] before:w-[3px] before:rounded-r-[3px] before:bg-[#78c0dc]' : 'text-white/65'"
                >
                    <span class="flex h-[19px] w-[19px] shrink-0 items-center justify-center">
                        <Icon name="check" :size="18" />
                    </span>
                    <span>My Tasks</span>
                </Link>

                <!-- LOGBOOK -->
                <Link
                    :href="route('stagiaire.logbook')"
                    class="relative flex min-h-[39px] items-center gap-[11px] rounded-lg px-[11px] py-[9px] text-[10.5px] font-medium no-underline transition hover:bg-white/[0.07] hover:text-white"
                    :class="isActive('/stagiaire/logbook')
                        ? 'bg-[#449dc6]/[0.27] text-white before:absolute before:bottom-[9px] before:left-0 before:top-[9px] before:w-[3px] before:rounded-r-[3px] before:bg-[#78c0dc]'
                        : 'text-white/65'"
                >
                    <span
                        class="flex h-[19px] w-[19px] shrink-0 items-center justify-center"
                    >
                        <Icon name="book" :size="18" />
                    </span>

                    <span>My Logbook</span>
                </Link>

                <Link
                    :href="route('stagiaire.documents.index')"
                    class="relative flex min-h-[39px] items-center gap-[11px] rounded-lg px-[11px] py-[9px] text-[10.5px] font-medium no-underline transition hover:bg-white/[0.07] hover:text-white"
                    :class="isActive('/stagiaire/documents') ? 'bg-[#449dc6]/[0.27] text-white before:absolute before:bottom-[9px] before:left-0 before:top-[9px] before:w-[3px] before:rounded-r-[3px] before:bg-[#78c0dc]' : 'text-white/65'"
                >
                    <span class="flex h-[19px] w-[19px] shrink-0 items-center justify-center">
                        <Icon name="folder" :size="18" />
                    </span>
                    <span>Documents</span>
                </Link>
            </template>

            <!-- MY CAREER -->
            <p class="mx-[10px] mb-[7px] mt-[17px] text-[7px] font-bold tracking-[1.2px] text-white/30">
                MY CAREER
            </p>

            <Link
                href="#"
                class="relative flex min-h-[39px] items-center gap-[11px] rounded-lg px-[11px] py-[9px] text-[10.5px] font-medium no-underline transition hover:bg-white/[0.07] hover:text-white text-white/65"
            >
                <span class="flex h-[19px] w-[19px] shrink-0 items-center justify-center">
                    <Icon name="cv" :size="18" />
                </span>
                <span>My CV</span>
            </Link>

            <Link
                href="#"
                class="relative flex min-h-[39px] items-center gap-[11px] rounded-lg px-[11px] py-[9px] text-[10.5px] font-medium no-underline transition hover:bg-white/[0.07] hover:text-white text-white/65"
            >
                <span class="flex h-[19px] w-[19px] shrink-0 items-center justify-center">
                    <Icon name="skills" :size="18" />
                </span>
                <span>Career Assistant</span>
            </Link>

            <Link
                :href="route('notifications.index')"
                class="relative flex min-h-[39px] items-center gap-[11px] rounded-lg px-[11px] py-[9px] text-[10.5px] font-medium no-underline transition hover:bg-white/[0.07] hover:text-white text-white/65"
            >
                <span class="flex h-[19px] w-[19px] shrink-0 items-center justify-center">
                    <Icon name="bell" :size="18" />
                </span>
                <span>Notifications</span>
            </Link>

            <Link
                :href="route('stagiaire.favoris.index')"
                class="relative flex min-h-[39px] items-center gap-[11px] rounded-lg px-[11px] py-[9px] text-[10.5px] font-medium no-underline transition hover:bg-white/[0.07] hover:text-white"
                :class="isActive('/stagiaire/favoris') ? 'bg-[#449dc6]/[0.27] text-white before:absolute before:bottom-[9px] before:left-0 before:top-[9px] before:w-[3px] before:rounded-r-[3px] before:bg-[#78c0dc]' : 'text-white/65'"
            >
                <span class="flex h-[19px] w-[19px] shrink-0 items-center justify-center">
                    <Icon name="heart" :size="18" />
                </span>
                <span>Saved Opportunities</span>
            </Link>

            <Link
                :href="route('stagiaire.profile.show')"
                class="relative flex min-h-[39px] items-center gap-[11px] rounded-lg px-[11px] py-[9px] text-[10.5px] font-medium no-underline transition hover:bg-white/[0.07] hover:text-white"
                :class="isActive('/stagiaire/profile') ? 'bg-[#449dc6]/[0.27] text-white before:absolute before:bottom-[9px] before:left-0 before:top-[9px] before:w-[3px] before:rounded-r-[3px] before:bg-[#78c0dc]' : 'text-white/65'"
            >
                <span class="flex h-[19px] w-[19px] shrink-0 items-center justify-center">
                    <Icon name="user" :size="18" />
                </span>
                <span>Profile</span>
            </Link>

            <!-- SETTINGS (maintenant dans le menu scrollable) -->
            <Link
                :href="route('profile.edit')"
                class="relative flex min-h-[39px] items-center gap-[11px] rounded-lg px-[11px] py-[9px] text-[10.5px] font-medium no-underline transition hover:bg-white/[0.07] hover:text-white"
                :class="isActive('/profile') ? 'bg-[#449dc6]/[0.27] text-white before:absolute before:bottom-[9px] before:left-0 before:top-[9px] before:w-[3px] before:rounded-r-[3px] before:bg-[#78c0dc]' : 'text-white/65'"
            >
                <span class="flex h-[19px] w-[19px] shrink-0 items-center justify-center">
                    <Icon name="settings" :size="18" />
                </span>
                <span>Settings</span>
            </Link>

        </nav>
    </div>
</template>

<style scoped>
.sidebar-scroll {
    scrollbar-width: thin;
    scrollbar-color: rgba(99, 169, 198, 0.3) transparent;
}

.sidebar-scroll::-webkit-scrollbar {
    width: 4px;
}

.sidebar-scroll::-webkit-scrollbar-track {
    background: transparent;
}

.sidebar-scroll::-webkit-scrollbar-thumb {
    background-color: rgba(99, 169, 198, 0.3);
    border-radius: 10px;
}

.sidebar-scroll:hover::-webkit-scrollbar-thumb {
    background-color: rgba(99, 169, 198, 0.5);
}
</style>
