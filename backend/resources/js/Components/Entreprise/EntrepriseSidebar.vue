<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import Icon from '@/Components/Admin/Icon.vue'

const page = usePage()

const entreprise = page.props.auth?.user
const logoUrl = '/images/LogoBgDarkInternHub.png'

const isActive = (path) => {
    return page.url.startsWith(path)
}

const entrepriseRoute = (name) => {
    return route(name, undefined, false)
}

const initials = () => {
    const name = entreprise?.nom_complet

    if (!name) {
        return 'EN'
    }

    return name
        .split(' ')
        .filter(Boolean)
        .map((word) => word[0])
        .join('')
        .slice(0, 2)
        .toUpperCase()
}
</script>

<template>
    <aside
    class="fixed inset-y-0 left-0 z-50 flex h-screen w-[230px] flex-col
           overflow-y-auto
           bg-gradient-to-b from-[#102F42] via-[#123B52] to-[#0D2939]
           px-[14px] pb-4 pt-5 text-white
           shadow-[6px_0_22px_rgba(16,46,65,0.12)]
           max-[850px]:hidden"
>
        <!-- Logo -->
        <div class="px-[9px] pb-5 pt-[3px]">
            <img
                :src="logoUrl"
                alt="InternHub"
                class="block max-h-[58px] w-[148px] object-contain object-left"
            />
        </div>

        <!-- Company card -->
        <div
            class="mb-[22px] flex items-center gap-[10px] rounded-[10px] border border-white/[0.06] bg-white/[0.06] p-[11px]"
        >
            <div
                class="flex h-[35px] w-[35px] shrink-0 items-center justify-center rounded-full bg-[#63a9c6] text-[10px] font-extrabold text-white"
            >
                {{ initials() }}
            </div>

            <div class="min-w-0">
                <strong
                    class="block overflow-hidden text-ellipsis whitespace-nowrap text-[11px] font-bold text-white"
                >
                    {{ entreprise?.nom_complet ?? 'Company' }}
                </strong>

                <span class="mt-0.5 block text-[8px] text-white/50">
                    Company
                </span>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex flex-1 flex-col gap-[3px]">

           <Link :href="entrepriseRoute('dashboard')" class="relative flex min-h-[39px] items-center gap-[11px] rounded-lg px-[11px] py-[9px] text-[10.5px] font-medium no-underline transition hover:bg-white/[0.07] hover:text-white":class="
                        isActive('/dashboard')
                            ? 'bg-[#449dc6]/[0.27] text-white before:absolute before:bottom-[9px] before:left-0 before:top-[9px] before:w-[3px] before:rounded-r-[3px] before:bg-[#78c0dc]'
                            : 'text-white/65'
                    "
                >
                    <span
                        class="flex h-[19px] w-[19px] shrink-0 items-center justify-center"
                    >
                        <Icon name="dashboard" :size="18" />
                    </span>

                    <span>Dashboard</span>
           </Link>

            <!-- Internship offers -->
            <Link
                :href="entrepriseRoute('entreprise.offres.index')"
                class="relative flex min-h-[39px] items-center gap-[11px] rounded-lg px-[11px] py-[9px] text-[10.5px] font-medium no-underline transition hover:bg-white/[0.07] hover:text-white"
                :class="
                    isActive('/entreprise/offres')
                        ? 'bg-[#449dc6]/[0.27] text-white before:absolute before:bottom-[9px] before:left-0 before:top-[9px] before:w-[3px] before:rounded-r-[3px] before:bg-[#78c0dc]'
                        : 'text-white/65'
                "
            >
                <span class="flex h-[19px] w-[19px] shrink-0 items-center justify-center">
                    <Icon name="briefcase" :size="18" />
                </span>

                <span>Internships</span>
            </Link>

            <!-- Applicants -->
            <Link
                :href="entrepriseRoute('entreprise.candidatures.index')"
                class="relative flex min-h-[39px] items-center gap-[11px] rounded-lg px-[11px] py-[9px] text-[10.5px] font-medium no-underline transition hover:bg-white/[0.07] hover:text-white"
                :class="
                    isActive('/entreprise/candidatures')
                        ? 'bg-[#449dc6]/[0.27] text-white before:absolute before:bottom-[9px] before:left-0 before:top-[9px] before:w-[3px] before:rounded-r-[3px] before:bg-[#78c0dc]'
                        : 'text-white/65'
                "
            >
                <span class="flex h-[19px] w-[19px] shrink-0 items-center justify-center">
                    <Icon name="users" :size="18" />
                </span>

                <span>Applicants</span>
            </Link>

          <!-- Accepted students -->
            <Link
                :href="entrepriseRoute('entreprise.acceptedStudents.index')"
                class="relative flex min-h-[39px] items-center gap-[11px] rounded-lg px-[11px] py-[9px] text-[10.5px] font-medium no-underline transition hover:bg-white/[0.07] hover:text-white"
                :class="
                    isActive('/entreprise/accepted-students')
                        ? 'bg-[#449dc6]/[0.27] text-white before:absolute before:bottom-[9px] before:left-0 before:top-[9px] before:w-[3px] before:rounded-r-[3px] before:bg-[#78c0dc]'
                        : 'text-white/65'
                "
            >
                <span
                    class="flex h-[19px] w-[19px] shrink-0 items-center justify-center"
                >
                    <Icon name="check" :size="18" />
                </span>

                <span>Accepted Students</span>
            </Link>

            <!-- Current interns -->
            <Link
                :href="entrepriseRoute('entreprise.stages.index')"
                class="relative flex min-h-[39px] items-center gap-[11px] rounded-lg px-[11px] py-[9px] text-[10.5px] font-medium no-underline transition hover:bg-white/[0.07] hover:text-white"
                :class="
                    isActive('/entreprise/stages')
                        ? 'bg-[#449dc6]/[0.27] text-white before:absolute before:bottom-[9px] before:left-0 before:top-[9px] before:w-[3px] before:rounded-r-[3px] before:bg-[#78c0dc]'
                        : 'text-white/65'
                "
            >
                <span class="flex h-[19px] w-[19px] shrink-0 items-center justify-center">
                    <Icon name="graduation" :size="18" />
                </span>

                <span>Current Interns</span>
            </Link>

            <!-- Supervisors -->
            <Link
                :href="entrepriseRoute('entreprise.encadrants.index')"
                class="relative flex min-h-[39px] items-center gap-[11px] rounded-lg px-[11px] py-[9px] text-[10.5px] font-medium no-underline transition hover:bg-white/[0.07] hover:text-white"
                :class="
                    isActive('/entreprise/encadrants')
                        ? 'bg-[#449dc6]/[0.27] text-white before:absolute before:bottom-[9px] before:left-0 before:top-[9px] before:w-[3px] before:rounded-r-[3px] before:bg-[#78c0dc]'
                        : 'text-white/65'
                "
            >
                <span class="flex h-[19px] w-[19px] shrink-0 items-center justify-center">
                    <Icon name="user" :size="18" />
                </span>

                <span>Company Supervisors</span>
            </Link>



            <!-- Notifications -->
            <!-- <div
                class="relative flex min-h-[39px] cursor-default items-center gap-[11px] rounded-lg px-[11px] py-[9px] text-[10.5px] font-medium text-white/65 transition hover:bg-white/[0.07] hover:text-white"
            >
                <span class="flex h-[19px] w-[19px] shrink-0 items-center justify-center">
                    <Icon name="chart" :size="18" />
                </span>

                <span>Notifications</span>
            </div> -->

            <div class="my-[10px] border-t border-white/[0.08]"></div>

            <!-- Settings -->
            <Link
                :href="entrepriseRoute('entreprise.profile.show')"
                class="relative flex min-h-[39px] items-center gap-[11px] rounded-lg px-[11px] py-[9px] text-[10.5px] font-medium no-underline transition hover:bg-white/[0.07] hover:text-white"
                :class="
                    isActive('/entreprise/profile')
                        ? 'bg-[#449dc6]/[0.27] text-white before:absolute before:bottom-[9px] before:left-0 before:top-[9px] before:w-[3px] before:rounded-r-[3px] before:bg-[#78c0dc]'
                        : 'text-white/65'
                "
            >
                <span class="flex h-[19px] w-[19px] shrink-0 items-center justify-center">
                    <Icon name="settings" :size="18" />
                </span>

                <span>Settings</span>
            </Link>
        </nav>

        <!-- Logout -->
        <div class="mt-4 border-t border-white/[0.08] pt-[14px]">
            <Link
                href="/logout"
                method="post"
                as="button"
                class="relative flex w-full min-h-[39px] items-center gap-[11px] rounded-lg border-0 bg-transparent px-[11px] py-[9px] text-left text-[10.5px] font-medium text-white/65 transition hover:bg-white/[0.07] hover:text-white"
            >
                <span class="flex h-[19px] w-[19px] items-center justify-center">
                    <svg
                        viewBox="0 0 24 24"
                        width="18"
                        height="18"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                        <path d="M16 17l5-5-5-5" />
                        <path d="M21 12H9" />
                    </svg>
                </span>

                <span>Logout</span>
            </Link>
        </div>
    </aside>
</template>
