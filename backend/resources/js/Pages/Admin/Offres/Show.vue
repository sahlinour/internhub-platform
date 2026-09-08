<script setup>
import { Head, Link, router } from '@inertiajs/vue3'
import AdminLayout from '@/Components/Admin/AdminLayout.vue'
import StatusBadge from '@/Components/Admin/StatusBadge.vue'
import UserAvatar from '@/Components/Admin/UserAvatar.vue'

const props = defineProps({
    offre: {
        type: Object,
        required: true,
    },
})

const formatDate = (date) => {
    if (!date) {
        return 'Not specified'
    }

    return new Intl.DateTimeFormat('en-GB', {
        day: '2-digit',
        month: 'long',
        year: 'numeric',
    }).format(new Date(date))
}

const companyName = () => {
    return props.offre?.entreprise?.user?.nom_complet
        ?? 'Unknown company'
}

const deleteOffer = () => {
    if (
        !window.confirm(
            `Are you sure you want to delete "${props.offre.titre}"?`
        )
    ) {
        return
    }

    router.delete(
        route('admin.offres.destroy', props.offre.id)
    )
}
</script>

<template>
    <Head :title="offre.titre ?? 'Internship Offer'" />

    <AdminLayout>
        <div class="mx-auto w-full max-w-[1050px]">

            <header
                class="mb-6 flex items-start
                       justify-between gap-4
                       max-[700px]:flex-col"
            >
                <div>
                    <p
                        class="mb-1 text-[9px]
                               font-semibold uppercase
                               tracking-[0.12em]
                               text-[#7890a0]"
                    >
                        Internship Offer
                    </p>

                    <h1
                        class="text-[22px]
                               font-bold text-[#20394b]"
                    >
                        {{ offre.titre || 'Untitled offer' }}
                    </h1>

                    <div
                        class="mt-2 flex items-center gap-2"
                    >
                        <StatusBadge :status="offre.statut" />
                    </div>
                </div>

                <div
                    class="flex items-center gap-2
                           max-[700px]:w-full
                           max-[700px]:flex-wrap"
                >
                    <Link
                        :href="route('admin.offres.index')"
                        class="inline-flex min-h-[38px]
                               items-center justify-center
                               rounded-lg
                               border border-[#dce5eb]
                               bg-white px-4
                               text-[9px] font-semibold
                               text-[#536f80]
                               no-underline
                               transition
                               hover:bg-[#f5f8fa]"
                    >
                        Back
                    </Link>

                    <Link
                        :href="route('admin.offres.edit', offre.id)"
                        class="inline-flex min-h-[38px]
                               items-center justify-center
                               rounded-lg
                               border border-[#bed2de]
                               bg-[#edf5f9] px-4
                               text-[9px] font-semibold
                               text-[#276587]
                               no-underline
                               transition
                               hover:bg-[#e3f0f6]"
                    >
                        Edit
                    </Link>

                    <button
                        type="button"
                        class="inline-flex min-h-[38px]
                               items-center justify-center
                               rounded-lg
                               border border-[#efcccc]
                               bg-white px-4
                               text-[9px] font-semibold
                               text-[#c95858]
                               transition
                               hover:bg-[#fff3f3]"
                        @click="deleteOffer"
                    >
                        Delete
                    </button>
                </div>
            </header>

            <div
                class="grid grid-cols-[2fr_1fr]
                       gap-5
                       max-[850px]:grid-cols-1"
            >
                <!-- MAIN DETAILS -->
                <section
                    class="rounded-xl
                           border border-[#e3eaef]
                           bg-white p-6
                           shadow-sm"
                >
                    <h2
                        class="mb-4 text-[14px]
                               font-bold text-[#294355]"
                    >
                        Offer Details
                    </h2>

                    <div
                        class="grid grid-cols-2 gap-5
                               max-[600px]:grid-cols-1"
                    >
                        <div>
                            <p class="mb-1 text-[9px] font-semibold text-[#899aa6]">
                                Duration
                            </p>

                            <p class="text-[11px] font-semibold text-[#40596b]">
                                {{ offre.duree || 'Not specified' }}
                            </p>
                        </div>

                        <div>
                            <p class="mb-1 text-[9px] font-semibold text-[#899aa6]">
                                Application Deadline
                            </p>

                            <p class="text-[11px] font-semibold text-[#40596b]">
                                {{ formatDate(offre.date_limite) }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-6">
                        <p class="mb-2 text-[9px] font-semibold text-[#899aa6]">
                            Description
                        </p>

                        <p
                            class="whitespace-pre-line
                                   text-[11px]
                                   leading-6
                                   text-[#506878]"
                        >
                            {{
                                offre.description
                                || 'No description available.'
                            }}
                        </p>
                    </div>
                </section>

                <!-- COMPANY -->
                <aside
                    class="rounded-xl
                           border border-[#e3eaef]
                           bg-white p-5
                           shadow-sm"
                >
                    <h2
                        class="mb-4 text-[14px]
                               font-bold text-[#294355]"
                    >
                        Company
                    </h2>

                    <div
                        class="flex items-center gap-3"
                    >
                        <UserAvatar
                            :name="companyName()"
                            :photo="offre.entreprise?.user?.photo"
                            :size="42"
                        />

                        <div class="min-w-0">
                            <p
                                class="truncate
                                       text-[11px]
                                       font-bold
                                       text-[#40596b]"
                            >
                                {{ companyName() }}
                            </p>

                            <p
                                v-if="offre.entreprise?.user?.email"
                                class="mt-1 truncate
                                       text-[9px]
                                       text-[#8c9ca7]"
                            >
                                {{ offre.entreprise.user.email }}
                            </p>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </AdminLayout>
</template>
