<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import Icon from '@/Components/Admin/Icon.vue'

const page = usePage()

const logoUrl = '/images/LogoBgDarkInternHub.png'

const isActive = (path) => {
    return page.url.startsWith(path)
}

const admin = page.props.auth?.user

const initials = () => {
    if (!admin?.nom_complet) {
        return 'A'
    }

    return admin.nom_complet
        .split(' ')
        .map((word) => word[0])
        .join('')
        .slice(0, 2)
        .toUpperCase()
}
</script>

<template>
    <aside
        class="fixed bottom-0 left-0 top-0 z-50
               flex h-screen w-[230px] flex-col justify-between
               overflow-y-auto
               bg-gradient-to-b
               from-[#143d57]
               via-[#174e6d]
               to-[#12394f]
               px-[14px] pb-4 pt-5
               text-white
               shadow-[6px_0_22px_rgba(16,46,65,0.08)]
               max-[850px]:hidden"
    >
        <!-- MAIN -->
        <div class="min-h-0">

            <!-- LOGO -->
            <div class="px-[9px] pb-5 pt-[3px]">
                <img
                    :src="logoUrl"
                    alt="InternHub"
                    class="block max-h-[58px] w-[148px] object-contain object-left"
                />
            </div>

            <!-- ADMIN -->
            <div
                class="mb-[22px] flex items-center gap-[10px]
                       rounded-[10px]
                       border border-white/[0.06]
                       bg-white/[0.06]
                       p-[11px]"
            >
                <div
                    class="flex h-[35px] w-[35px] shrink-0
                           items-center justify-center
                           rounded-full
                           bg-[#63a9c6]
                           text-[10px] font-extrabold
                           text-white"
                >
                    {{ initials() }}
                </div>

                <div class="min-w-0">
                    <strong
                        class="block overflow-hidden text-ellipsis
                               whitespace-nowrap
                               text-[11px] font-bold text-white"
                    >
                        {{ admin?.nom_complet ?? 'Administrator' }}
                    </strong>

                    <span
                        class="mt-0.5 block
                               text-[8px] text-white/50"
                    >
                        InternHub Admin
                    </span>
                </div>
            </div>

            <!-- MENU -->
            <nav class="flex flex-col gap-[3px]">

                <!-- MANAGEMENT -->
                <p
                    class="mx-[10px] mb-[7px] mt-0
                           text-[7px] font-bold
                           tracking-[1.2px]
                           text-white/30"
                >
                    MANAGEMENT
                </p>

                <!-- DASHBOARD -->
                <Link
                    :href="route('admin.dashboard')"
                    class="relative flex min-h-[39px]
                           items-center gap-[11px]
                           rounded-lg px-[11px] py-[9px]
                           text-[10.5px] font-medium
                           no-underline transition
                           hover:bg-white/[0.07]
                           hover:text-white"
                    :class="
                        isActive('/admin/dashboard')
                            ? 'bg-[#449dc6]/[0.27] text-white before:absolute before:bottom-[9px] before:left-0 before:top-[9px] before:w-[3px] before:rounded-r-[3px] before:bg-[#78c0dc]'
                            : 'text-white/65'
                    "
                >
                    <span
                        class="flex h-[19px] w-[19px]
                               shrink-0 items-center justify-center"
                    >
                        <Icon
                            name="dashboard"
                            :size="18"
                        />
                    </span>

                    <span>Dashboard</span>
                </Link>

                <!-- INTERNS -->
                <Link
                    :href="route('admin.stagiaires.index')"
                    class="relative flex min-h-[39px]
                           items-center gap-[11px]
                           rounded-lg px-[11px] py-[9px]
                           text-[10.5px] font-medium
                           no-underline transition
                           hover:bg-white/[0.07]
                           hover:text-white"
                    :class="
                        isActive('/admin/stagiaires')
                            ? 'bg-[#449dc6]/[0.27] text-white before:absolute before:bottom-[9px] before:left-0 before:top-[9px] before:w-[3px] before:rounded-r-[3px] before:bg-[#78c0dc]'
                            : 'text-white/65'
                    "
                >
                    <span
                        class="flex h-[19px] w-[19px]
                               shrink-0 items-center justify-center"
                    >
                        <Icon
                            name="users"
                            :size="18"
                        />
                    </span>

                    <span>Interns</span>
                </Link>

                <!-- COMPANIES -->
                <Link
                    :href="route('admin.entreprises.index')"
                    class="relative flex min-h-[39px]
                           items-center gap-[11px]
                           rounded-lg px-[11px] py-[9px]
                           text-[10.5px] font-medium
                           no-underline transition
                           hover:bg-white/[0.07]
                           hover:text-white"
                    :class="
                        isActive('/admin/entreprises')
                            ? 'bg-[#449dc6]/[0.27] text-white before:absolute before:bottom-[9px] before:left-0 before:top-[9px] before:w-[3px] before:rounded-r-[3px] before:bg-[#78c0dc]'
                            : 'text-white/65'
                    "
                >
                    <span
                        class="flex h-[19px] w-[19px]
                               shrink-0 items-center justify-center"
                    >
                        <Icon
                            name="company"
                            :size="18"
                        />
                    </span>

                    <span>Companies</span>
                </Link>

                <!-- SUPERVISORS -->
                <Link
                    :href="route('admin.encadrants.index')"
                    class="relative flex min-h-[39px]
                           items-center gap-[11px]
                           rounded-lg px-[11px] py-[9px]
                           text-[10.5px] font-medium
                           no-underline transition
                           hover:bg-white/[0.07]
                           hover:text-white"
                    :class="
                        isActive('/admin/encadrants')
                            ? 'bg-[#449dc6]/[0.27] text-white before:absolute before:bottom-[9px] before:left-0 before:top-[9px] before:w-[3px] before:rounded-r-[3px] before:bg-[#78c0dc]'
                            : 'text-white/65'
                    "
                >
                    <span
                        class="flex h-[19px] w-[19px]
                               shrink-0 items-center justify-center"
                    >
                        <Icon
                            name="user"
                            :size="18"
                        />
                    </span>

                    <span>Supervisors</span>
                </Link>

                <!-- OFFERS -->
                <Link
                    :href="route('admin.offres.index')"
                    class="relative flex min-h-[39px]
                           items-center gap-[11px]
                           rounded-lg px-[11px] py-[9px]
                           text-[10.5px] font-medium
                           no-underline transition
                           hover:bg-white/[0.07]
                           hover:text-white"
                    :class="
                        isActive('/admin/offres')
                            ? 'bg-[#449dc6]/[0.27] text-white before:absolute before:bottom-[9px] before:left-0 before:top-[9px] before:w-[3px] before:rounded-r-[3px] before:bg-[#78c0dc]'
                            : 'text-white/65'
                    "
                >
                    <span
                        class="flex h-[19px] w-[19px]
                               shrink-0 items-center justify-center"
                    >
                        <Icon
                            name="briefcase"
                            :size="18"
                        />
                    </span>

                    <span>Internship Offers</span>
                </Link>

                <!-- APPLICATIONS -->
                <Link
                    :href="route('admin.candidatures.index')"
                    class="relative flex min-h-[39px]
                           items-center gap-[11px]
                           rounded-lg px-[11px] py-[9px]
                           text-[10.5px] font-medium
                           no-underline transition
                           hover:bg-white/[0.07]
                           hover:text-white"
                    :class="
                        isActive('/admin/candidatures')
                            ? 'bg-[#449dc6]/[0.27] text-white before:absolute before:bottom-[9px] before:left-0 before:top-[9px] before:w-[3px] before:rounded-r-[3px] before:bg-[#78c0dc]'
                            : 'text-white/65'
                    "
                >
                    <span
                        class="flex h-[19px] w-[19px]
                               shrink-0 items-center justify-center"
                    >
                        <Icon
                            name="check"
                            :size="18"
                        />
                    </span>

                    <span>Applications</span>
                </Link>

                <!-- INTERNSHIPS -->
                <Link
                    :href="route('admin.stages.index')"
                    class="relative flex min-h-[39px]
                           items-center gap-[11px]
                           rounded-lg px-[11px] py-[9px]
                           text-[10.5px] font-medium
                           no-underline transition
                           hover:bg-white/[0.07]
                           hover:text-white"
                    :class="
                        isActive('/admin/stages')
                            ? 'bg-[#449dc6]/[0.27] text-white before:absolute before:bottom-[9px] before:left-0 before:top-[9px] before:w-[3px] before:rounded-r-[3px] before:bg-[#78c0dc]'
                            : 'text-white/65'
                    "
                >
                    <span
                        class="flex h-[19px] w-[19px]
                               shrink-0 items-center justify-center"
                    >
                        <Icon
                            name="graduation"
                            :size="18"
                        />
                    </span>

                    <span>Internships</span>
                </Link>

                <!-- PLATFORM -->
                <p
                    class="mx-[10px] mb-[7px] mt-[17px]
                           text-[7px] font-bold
                           tracking-[1.2px]
                           text-white/30"
                >
                    PLATFORM
                </p>

                <!-- REPORTS -->
                <Link
                    :href="route('admin.signalements.index')"
                    class="relative flex min-h-[39px]
                           items-center gap-[11px]
                           rounded-lg px-[11px] py-[9px]
                           text-[10.5px] font-medium
                           no-underline transition
                           hover:bg-white/[0.07]
                           hover:text-white"
                    :class="
                        isActive('/admin/signalements')
                            ? 'bg-[#449dc6]/[0.27] text-white before:absolute before:bottom-[9px] before:left-0 before:top-[9px] before:w-[3px] before:rounded-r-[3px] before:bg-[#78c0dc]'
                            : 'text-white/65'
                    "
                >
                    <span
                        class="flex h-[19px] w-[19px]
                               shrink-0 items-center justify-center"
                    >
                        <Icon
                            name="alert"
                            :size="18"
                        />
                    </span>

                    <span>Reports</span>
                </Link>

                <!-- PROFILE -->
                <Link
                    :href="route('admin.profile.show')"
                    class="relative flex min-h-[39px]
                           items-center gap-[11px]
                           rounded-lg px-[11px] py-[9px]
                           text-[10.5px] font-medium
                           no-underline transition
                           hover:bg-white/[0.07]
                           hover:text-white"
                    :class="
                        isActive('/admin/profile')
                            ? 'bg-[#449dc6]/[0.27] text-white before:absolute before:bottom-[9px] before:left-0 before:top-[9px] before:w-[3px] before:rounded-r-[3px] before:bg-[#78c0dc]'
                            : 'text-white/65'
                    "
                >
                    <span
                        class="flex h-[19px] w-[19px]
                               shrink-0 items-center justify-center"
                    >
                        <Icon
                            name="settings"
                            :size="18"
                        />
                    </span>

                    <span>Profile</span>
                </Link>

            </nav>
        </div>

        <!-- LOGOUT -->
        <div
            class="border-t border-white/[0.08]
                   pt-[14px]"
        >
            <Link
                :href="route('admin.logout')"
                method="post"
                as="button"
                class="flex w-full items-center
                       gap-[11px]
                       rounded-lg border-0
                       bg-transparent
                       px-[11px] py-[10px]
                       text-left text-[10.5px]
                       font-medium text-white/60
                       transition
                       hover:bg-white/[0.06]
                       hover:text-white"
            >
                <span
                    class="flex h-[19px] w-[19px]
                           items-center justify-center"
                >
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
                        <path
                            d="M9 21H5a2 2 0 0 1-2-2V5a2
                               2 0 0 1 2-2h4"
                        />

                        <path d="M16 17l5-5-5-5" />
                        <path d="M21 12H9" />
                    </svg>
                </span>

                <span>Log out</span>
            </Link>
        </div>

    </aside>
</template>
