<script setup>
import { useForm } from '@inertiajs/vue3'

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    user: {
        type: Object,
        default: null,
    },
    updateUrl: {
        type: Function,
        required: true,
    },
})

const emit = defineEmits([
    'close',
])

const editForm = useForm({
    nom_complet: '',
    email: '',
    telephone: '',
    poste: '',
    specialite: '',
    departement: '',
    ville_id: '',
})

const initializeForm = (user) => {
    if (!user) return

    editForm.nom_complet = user?.nom_complet ?? ''
    editForm.email = user?.email ?? ''
    editForm.telephone = user?.telephone ?? ''
    editForm.poste = user?.encadrant?.poste ?? ''
    editForm.specialite = user?.encadrant?.specialite ?? ''
    editForm.departement = user?.encadrant?.departement ?? ''
    editForm.ville_id = user?.ville_id ?? ''

    editForm.clearErrors()
}

const close = () => {
    editForm.reset()
    editForm.clearErrors()
    emit('close')
}

const submit = () => {
    if (!props.user) return

    editForm.put(
        props.updateUrl(props.user.id),
        {
            preserveScroll: true,
            onSuccess: close,
        }
    )
}

defineExpose({
    initializeForm,
})
</script>

<template>
    <div
        v-if="show"
        class="fixed inset-0 z-[100]
               flex items-center justify-center
               bg-slate-950/40 p-4
               backdrop-blur-sm"
        @click.self="close"
    >
        <div
            class="max-h-[92vh] w-full max-w-2xl
                   overflow-y-auto
                   rounded-2xl bg-white shadow-2xl"
        >
            <!-- HEADER -->
            <div
                class="flex items-center justify-between
                       border-b border-slate-100
                       px-5 py-4"
            >
                <div>
                    <h2
                        class="text-sm font-bold
                               text-[#16425B]"
                    >
                        Edit Company Supervisor
                    </h2>

                    <p
                        class="mt-0.5 text-[10px]
                               text-slate-400"
                    >
                        Update supervisor information.
                    </p>
                </div>

                <button
                    type="button"
                    class="flex h-8 w-8
                           items-center justify-center
                           rounded-lg text-slate-400
                           transition
                           hover:bg-slate-100
                           hover:text-slate-700"
                    @click="close"
                >
                    <svg
                        class="h-4 w-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>
            </div>

            <!-- FORM -->
            <form
                class="p-5"
                @submit.prevent="submit"
            >
                <div
                    class="grid grid-cols-1 gap-4
                           md:grid-cols-2"
                >
                    <div
                        v-for="field in [
                            {
                                key: 'nom_complet',
                                label: 'Full Name',
                                type: 'text',
                                required: true,
                            },
                            {
                                key: 'email',
                                label: 'Email',
                                type: 'email',
                                required: true,
                            },
                            {
                                key: 'telephone',
                                label: 'Phone',
                                type: 'text',
                            },
                            {
                                key: 'poste',
                                label: 'Position',
                                type: 'text',
                                required: true,
                            },
                            {
                                key: 'specialite',
                                label: 'Speciality',
                                type: 'text',
                            },
                            {
                                key: 'departement',
                                label: 'Department',
                                type: 'text',
                            },
                            {
                                key: 'ville_id',
                                label: 'City ID',
                                type: 'number',
                                required: true,
                            },
                        ]"
                        :key="field.key"
                    >
                        <label
                            class="mb-1.5 block
                                   text-[11px] font-semibold
                                   text-slate-600"
                        >
                            {{ field.label }}

                            <span
                                v-if="field.required"
                                class="text-red-500"
                            >
                                *
                            </span>
                        </label>

                        <input
                            v-model="editForm[field.key]"
                            :type="field.type"
                            :min="
                                field.type === 'number'
                                    ? 1
                                    : undefined
                            "
                            class="w-full rounded-xl
                                   border border-slate-200
                                   px-3 py-2.5
                                   text-xs text-slate-700
                                   outline-none transition
                                   focus:border-[#3A7CA5]
                                   focus:ring-2
                                   focus:ring-[#3A7CA5]/10"
                        />

                        <p
                            v-if="editForm.errors[field.key]"
                            class="mt-1 text-[10px]
                                   text-red-500"
                        >
                            {{ editForm.errors[field.key] }}
                        </p>
                    </div>
                </div>

                <!-- ACTIONS -->
                <div
                    class="mt-5 flex justify-end gap-2
                           border-t border-slate-100
                           pt-4"
                >
                    <button
                        type="button"
                        class="rounded-xl
                               border border-slate-200
                               bg-white px-4 py-2
                               text-xs font-semibold
                               text-slate-600
                               hover:bg-slate-50"
                        @click="close"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        :disabled="editForm.processing"
                        class="rounded-xl
                               bg-[#16425B]
                               px-4 py-2
                               text-xs font-semibold
                               text-white
                               transition
                               hover:bg-[#12364B]
                               disabled:opacity-50"
                    >
                        {{
                            editForm.processing
                                ? 'Saving...'
                                : 'Save Changes'
                        }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>