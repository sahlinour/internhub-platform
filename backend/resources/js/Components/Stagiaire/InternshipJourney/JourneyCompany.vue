<script setup>
import { computed } from 'vue'

const props = defineProps({
    company: {
        type: Object,
        default: null,
    },
})

const companyUser = computed(() => {
    return props.company?.user ?? null
})
</script>

<template>
    <section
        class="rounded-xl border border-slate-100
               bg-white p-5
               shadow-[0_3px_12px_rgba(15,23,42,0.04)]"
    >

        <p
            class="text-[9px] font-bold uppercase
                   tracking-[1.4px] text-[#3A7CA5]"
        >
            Company
        </p>

        <h2
            class="mt-2 text-[15px] font-bold
                   text-[#16425B]"
        >
            {{ companyUser?.nom_complet ?? '—' }}
        </h2>

        <div class="mt-4 space-y-2">

            <div
                v-if="company?.secteur"
                class="text-[10px] text-[#64748B]"
            >
                {{ company.secteur }}
            </div>

            <div
                v-if="company?.adresse"
                class="text-[10px] text-[#64748B]"
            >
                {{ company.adresse }}
            </div>

            <div
                v-if="companyUser?.ville"
                class="text-[10px] text-[#64748B]"
            >
                {{ companyUser.ville.nom ?? '—' }}
            </div>

            <div
                v-if="companyUser?.email"
                class="break-all text-[10px] text-[#64748B]"
            >
                {{ companyUser.email }}
            </div>

        </div>

    </section>
</template>