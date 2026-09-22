<script setup>
import { Link } from '@inertiajs/vue3'
import Icon from '@/Components/Stagiaire/Icon.vue'

defineProps({
    count: {
        type: Number,
        default: 0,
    },
})

const documents = [
    {
        name: 'Internship Agreement',
        status: 'Validated',
    },
    {
        name: 'Internship Report',
        status: 'Pending',
    },
    {
        name: 'Evaluation Document',
        status: 'Pending',
    },
]
</script>

<template>

    <div v-if="count === 0">

        <div
            class="rounded-[10px]
                   bg-[#fafcfd]
                   p-5 text-center"
        >

            <Icon
                name="documents"
                :size="20"
                class="mx-auto mb-2 text-[#8b9aa5]"
            />

            <p
                class="m-0 text-[10px]
                       text-[#8b9aa5]"
            >
                No documents available yet.
            </p>

        </div>

    </div>

    <div v-else class="flex flex-col">

        <div
            v-for="document in documents.slice(
                0,
                Math.min(count, 3)
            )"
            :key="document.name"
            class="flex items-center
                   gap-[10px]
                   border-b border-[#edf1f4]
                   py-3
                   first:pt-0.5
                   last:border-b-0"
        >

            <div
                class="flex h-8 w-8
                       shrink-0
                       items-center justify-center
                       rounded-[8px]
                       bg-[#eef5f8]
                       text-[#286d93]"
            >
                <Icon
                    name="documents"
                    :size="15"
                />
            </div>

            <div class="min-w-0 flex-1">

                <strong
                    class="mb-1 block
                           truncate
                           text-[10px]
                           font-bold
                           text-[#2b4354]"
                >
                    {{ document.name }}
                </strong>

                <span
                    class="text-[8px]"
                    :class="
                        document.status === 'Validated'
                            ? 'text-[#459d69]'
                            : 'text-[#c79030]'
                    "
                >
                    {{ document.status }}
                </span>

            </div>

        </div>

        <Link
            :href="route('stagiaire.documents.index')"
            class="mt-3 text-right
                   text-[9px]
                   font-semibold
                   text-[#286d93]
                   no-underline
                   hover:text-[#1f5c7c]"
        >
            View all documents →
        </Link>

    </div>

</template>