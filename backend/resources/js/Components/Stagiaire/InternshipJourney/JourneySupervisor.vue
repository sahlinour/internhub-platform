<script setup>
import { computed } from 'vue'

const props = defineProps({
    supervisor: {
        type: Object,
        default: null,
    },
})

const supervisorUser = computed(() => {
    return props.supervisor?.user ?? null
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
            Assigned Supervisor
        </p>

        <h2
            class="mt-2 text-[15px] font-bold
                   text-[#16425B]"
        >
            {{ supervisorUser?.nom_complet ?? '—' }}
        </h2>

        <div class="mt-3 space-y-1.5">

            <p
                v-if="supervisor?.poste"
                class="text-[10px] text-[#64748B]"
            >
                {{ supervisor.poste }}
            </p>

            <p
                v-if="supervisor?.specialite"
                class="text-[10px] text-[#64748B]"
            >
                {{ supervisor.specialite }}
            </p>

            <p
                v-if="supervisor?.departement"
                class="text-[10px] text-[#64748B]"
            >
                {{ supervisor.departement }}
            </p>

            <p
                v-if="supervisorUser?.email"
                class="break-all text-[10px]
                       text-[#64748B]"
            >
                {{ supervisorUser.email }}
            </p>
        </div>
    </section>
</template>