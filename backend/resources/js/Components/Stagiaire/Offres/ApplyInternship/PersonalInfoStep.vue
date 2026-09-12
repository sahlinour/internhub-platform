<script setup>
const props = defineProps({
    modelValue: {
        type: Object,
        default: () => ({
            nom_complet: '',
            email: '',
            telephone: '',
            ville: '',
            universite: '',
            filiere: '',
            niveau: '',
            date_naissance: '',
            linkedin_url: '',
            portfolio_url: '',
        }),
    },
})

const emit = defineEmits(['update:modelValue'])

const updateField = (field, value) => {
    emit('update:modelValue', {
        ...props.modelValue,
        [field]: value,
    })
}
</script>

<template>
    <section class="space-y-5">

        <!-- Header -->
        <div
            class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6"
        >
            <h2 class="text-xl font-bold text-slate-900">
                Personal Information
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Complete or update your personal information before continuing.
            </p>
        </div>

        <!-- Personal information -->
        <div
            class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6"
        >
            <div class="grid gap-5 sm:grid-cols-2">

                <!-- Full Name -->
                <div>
                    <label
                        for="nom_complet"
                        class="mb-1.5 block text-sm font-medium text-slate-700"
                    >
                        Full Name
                    </label>

                    <input
                        id="nom_complet"
                        type="text"
                        :value="modelValue.nom_complet"
                        @input="updateField('nom_complet', $event.target.value)"
                        placeholder="Enter your full name"
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-[#2F6690] focus:ring-2 focus:ring-[#2F6690]/10"
                    />
                </div>

                <!-- Email -->
                <div>
                    <label
                        for="email"
                        class="mb-1.5 block text-sm font-medium text-slate-700"
                    >
                        Email
                    </label>

                    <input
                        id="email"
                        type="email"
                        :value="modelValue.email"
                        @input="updateField('email', $event.target.value)"
                        placeholder="Enter your email"
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-[#2F6690] focus:ring-2 focus:ring-[#2F6690]/10"
                    />
                </div>

                <!-- Phone -->
                <div>
                    <label
                        for="telephone"
                        class="mb-1.5 block text-sm font-medium text-slate-700"
                    >
                        Phone
                    </label>

                    <input
                        id="telephone"
                        type="text"
                        :value="modelValue.telephone"
                        @input="updateField('telephone', $event.target.value)"
                        placeholder="Enter your phone number"
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-[#2F6690] focus:ring-2 focus:ring-[#2F6690]/10"
                    />
                </div>

                <!-- City -->
                <div>
                    <label
                        for="ville"
                        class="mb-1.5 block text-sm font-medium text-slate-700"
                    >
                        City
                    </label>

                    <input
                        id="ville"
                        type="text"
                        :value="modelValue.ville"
                        @input="updateField('ville', $event.target.value)"
                        placeholder="Enter your city"
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-[#2F6690] focus:ring-2 focus:ring-[#2F6690]/10"
                    />
                </div>

                <!-- University -->
                <div>
                    <label
                        for="universite"
                        class="mb-1.5 block text-sm font-medium text-slate-700"
                    >
                        University
                    </label>

                    <input
                        id="universite"
                        type="text"
                        :value="modelValue.universite"
                        @input="updateField('universite', $event.target.value)"
                        placeholder="Enter your university"
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-[#2F6690] focus:ring-2 focus:ring-[#2F6690]/10"
                    />
                </div>

                <!-- Field of Study -->
                <div>
                    <label
                        for="filiere"
                        class="mb-1.5 block text-sm font-medium text-slate-700"
                    >
                        Field of Study
                    </label>

                    <input
                        id="filiere"
                        type="text"
                        :value="modelValue.filiere"
                        @input="updateField('filiere', $event.target.value)"
                        placeholder="Enter your field of study"
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-[#2F6690] focus:ring-2 focus:ring-[#2F6690]/10"
                    />
                </div>

                <!-- Level -->
                <div>
                    <label
                        for="niveau"
                        class="mb-1.5 block text-sm font-medium text-slate-700"
                    >
                        Level
                    </label>

                    <input
                        id="niveau"
                        type="text"
                        :value="modelValue.niveau"
                        @input="updateField('niveau', $event.target.value)"
                        placeholder="Enter your level"
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-[#2F6690] focus:ring-2 focus:ring-[#2F6690]/10"
                    />
                </div>

                <!-- Date of Birth -->
                <div>
                    <label
                        for="date_naissance"
                        class="mb-1.5 block text-sm font-medium text-slate-700"
                    >
                        Date of Birth
                    </label>

                    <input
                        id="date_naissance"
                        type="date"
                        :value="modelValue.date_naissance"
                        @input="updateField('date_naissance', $event.target.value)"
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition focus:border-[#2F6690] focus:ring-2 focus:ring-[#2F6690]/10"
                    />
                </div>

                <!-- LinkedIn -->
                <div>
                    <label
                        for="linkedin_url"
                        class="mb-1.5 block text-sm font-medium text-slate-700"
                    >
                        LinkedIn
                    </label>

                    <input
                        id="linkedin_url"
                        type="url"
                        :value="modelValue.linkedin_url"
                        @input="updateField('linkedin_url', $event.target.value)"
                        placeholder="https://linkedin.com/in/..."
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-[#2F6690] focus:ring-2 focus:ring-[#2F6690]/10"
                    />
                </div>

                <!-- Portfolio -->
                <div>
                    <label
                        for="portfolio_url"
                        class="mb-1.5 block text-sm font-medium text-slate-700"
                    >
                        Portfolio
                    </label>

                    <input
                        id="portfolio_url"
                        type="url"
                        :value="modelValue.portfolio_url"
                        @input="updateField('portfolio_url', $event.target.value)"
                        placeholder="https://your-portfolio.com"
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-[#2F6690] focus:ring-2 focus:ring-[#2F6690]/10"
                    />
                </div>

            </div>

            <!-- Info -->
            <div
                class="mt-6 rounded-xl border border-blue-100 bg-blue-50 p-4"
            >
                <div class="flex gap-3">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 shrink-0 text-[#2F6690]"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M13 16h-1v-4h-1m1-4h.01M12 22a10 10 0 100-20 10 10 0 000 20z"
                        />
                    </svg>

                    <p class="text-sm leading-6 text-[#2F6690]">
                        Please make sure that your information is accurate
                        before continuing.
                    </p>
                </div>
            </div>
        </div>

    </section>
</template>
