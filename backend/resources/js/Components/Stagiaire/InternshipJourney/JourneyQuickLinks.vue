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
            Quick Links
        </p>

        <div class="mt-3 space-y-1">

            <a
                :href="route('stagiaire.taches.index')"
                class="flex items-center justify-between
                       rounded-lg px-3 py-2.5
                       text-[10px] font-medium
                       text-[#16425B]
                       transition
                       hover:bg-[#f4f7f9]"
            >
                <span>My Tasks</span>
                <span class="text-[#3A7CA5]">→</span>
            </a>

            <a
                :href="route('stagiaire.documents.index')"
                class="flex items-center justify-between
                       rounded-lg px-3 py-2.5
                       text-[10px] font-medium
                       text-[#16425B]
                       transition
                       hover:bg-[#f4f7f9]"
            >
                <span>My Documents</span>
                <span class="text-[#3A7CA5]">→</span>
            </a>

            <a
                :href="route('stagiaire.dashboard')"
                class="flex items-center justify-between
                       rounded-lg px-3 py-2.5
                       text-[10px] font-medium
                       text-[#16425B]
                       transition
                       hover:bg-[#f4f7f9]"
            >
                <span>Dashboard</span>
                <span class="text-[#3A7CA5]">→</span>
            </a>
        </div>
    </section>
</template>