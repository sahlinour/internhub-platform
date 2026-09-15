<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import Icon from '@/Components/Stagiaire/Icon.vue'

const page = usePage()

const logoUrl = '/images/LogoBgDarkInternHub.png'

const isActive = (path) => {
    return page.url.startsWith(path)
}

const user = page.props.auth?.user

const fullName =
    user?.nom_complet ??
    `${user?.prenom ?? ''} ${user?.nom ?? ''}`.trim()

const initials = () => {
    if (!fullName) {
        return 'S'
    }

    return fullName
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
                    class="block max-h-[58px] w-[148px]
                           object-contain object-left"
                />
            </div>

            <!-- STAGIAIRE -->
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
                        {{ fullName || 'Student' }}
                    </strong>

                    <span
                        class="mt-0.5 block
                               text-[8px] text-white/50"
                    >
                        InternHub Student
                    </span>
                </div>
            </div>

            <!-- MENU -->
            <nav class="flex flex-col gap-[3px]">

                <!-- MY INTERNSHIP -->
                <p
                    class="mx-[10px] mb-[7px] mt-0
                           text-[7px] font-bold
                           tracking-[1.2px]
                           text-white/30"
                >
                    MY INTERNSHIP
                </p>

                <!-- DASHBOARD -->
                <Link
                    :href="route('stagiaire.dashboard')"
                    class="relative flex min-h-[39px]
                           items-center gap-[11px]
                           rounded-lg px-[11px] py-[9px]
                           text-[10.5px] font-medium
                           no-underline transition
                           hover:bg-white/[0.07]
                           hover:text-white"
                    :class="
                        isActive('/stagiaire/dashboard')
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

                <!-- INTERNSHIP OFFERS -->
                <Link
                    :href="route('offres.index')"
                    class="relative flex min-h-[39px]
                           items-center gap-[11px]
                           rounded-lg px-[11px] py-[9px]
                           text-[10.5px] font-medium
                           no-underline transition
                           hover:bg-white/[0.07]
                           hover:text-white"
                    :class="
                        isActive('/offres')
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

                <!-- MY APPLICATIONS -->
                <Link
                    :href="route('stagiaire.candidatures.index')"
                    class="relative flex min-h-[39px]
                           items-center gap-[11px]
                           rounded-lg px-[11px] py-[9px]
                           text-[10.5px] font-medium
                           no-underline transition
                           hover:bg-white/[0.07]
                           hover:text-white"
                    :class="
                        isActive('/stagiaire/candidatures')
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

                    <span>My Applications</span>
                </Link>


                <!-- MY CAREER -->
                <p
                    class="mx-[10px] mb-[7px] mt-[17px]
                           text-[7px] font-bold
                           tracking-[1.2px]
                           text-white/30"
                >
                    MY CAREER
                </p>

                <!-- MY CV -->
                <Link
                    href="#"
                    class="relative flex min-h-[39px]
                           items-center gap-[11px]
                           rounded-lg px-[11px] py-[9px]
                           text-[10.5px] font-medium
                           no-underline transition
                           hover:bg-white/[0.07]
                           hover:text-white
                           text-white/65"
                >
                    <span
                        class="flex h-[19px] w-[19px]
                               shrink-0 items-center justify-center"
                    >
                        <Icon
                            name="documents"
                            :size="18"
                        />
                    </span>

                    <span>My CV</span>
                </Link>

                <!-- CAREER ASSISTANT -->
                <Link
                    href="#"
                    class="relative flex min-h-[39px]
                           items-center gap-[11px]
                           rounded-lg px-[11px] py-[9px]
                           text-[10.5px] font-medium
                           no-underline transition
                           hover:bg-white/[0.07]
                           hover:text-white
                           text-white/65"
                >
                    <span
                        class="flex h-[19px] w-[19px]
                               shrink-0 items-center justify-center"
                    >
                        <Icon
                            name="skills"
                            :size="18"
                        />
                    </span>

                    <span>Career Assistant</span>
                </Link>

                <!-- NOTIFICATIONS -->
                <Link
                    :href="route('notifications.index')"
                    class="relative flex min-h-[39px]
                           items-center gap-[11px]
                           rounded-lg px-[11px] py-[9px]
                           text-[10.5px] font-medium
                           no-underline transition
                           hover:bg-white/[0.07]
                           hover:text-white
                           text-white/65"
                >
                    <span
                        class="flex h-[19px] w-[19px]
                               shrink-0 items-center justify-center"
                    >
                        <Icon
                            name="bell"
                            :size="18"
                        />
                    </span>

                    <span>Notifications</span>
                </Link>

                <!-- SAVED OPPORTUNITIES -->
                <Link
                    :href="route('stagiaire.favoris.index')"
                    class="relative flex min-h-[39px]
                           items-center gap-[11px]
                           rounded-lg px-[11px] py-[9px]
                           text-[10.5px] font-medium
                           no-underline transition
                           hover:bg-white/[0.07]
                           hover:text-white"
                    :class="
                        isActive('/stagiaire/favoris')
                            ? 'bg-[#449dc6]/[0.27] text-white before:absolute before:bottom-[9px] before:left-0 before:top-[9px] before:w-[3px] before:rounded-r-[3px] before:bg-[#78c0dc]'
                            : 'text-white/65'
                    "
                >
                    <span
                        class="flex h-[19px] w-[19px]
                               shrink-0 items-center justify-center"
                    >
                        <Icon
                            name="heart"
                            :size="18"
                        />
                    </span>

                    <span>Saved Opportunities</span>
                </Link>

                <!-- PROFILE -->
                <Link
                    :href="route('stagiaire.profile.show')"
                    class="relative flex min-h-[39px]
                           items-center gap-[11px]
                           rounded-lg px-[11px] py-[9px]
                           text-[10.5px] font-medium
                           no-underline transition
                           hover:bg-white/[0.07]
                           hover:text-white"
                    :class="
                        isActive('/stagiaire/profile')
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

                    <span>Profile</span>
                </Link>

            </nav>
        </div>

        <!-- SETTINGS -->
        <Link
            :href="route('profile.edit')"
            class="relative flex min-h-[39px]
                items-center gap-[11px]
                rounded-lg px-[11px] py-[9px]
                text-[10.5px] font-medium
                no-underline transition
                hover:bg-white/[0.07]
                hover:text-white"
            :class="
                isActive('/profile')
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

            <span>Settings</span>
        </Link>


        <!-- LOGOUT -->
        <div
            class="border-t border-white/[0.08]
                   pt-[14px]"
        >
            <Link
                :href="route('logout')"
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
