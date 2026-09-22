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

const fields = [
    ['nom_complet', 'Full Name', 'text', 'Enter your full name'],
    ['email', 'Email', 'email', 'Enter your email'],
    ['telephone', 'Phone', 'text', 'Enter your phone number'],
    ['ville', 'City', 'text', 'Enter your city'],
    ['universite', 'University', 'text', 'Enter your university'],
    ['filiere', 'Field of Study', 'text', 'Enter your field of study'],
    ['niveau', 'Level', 'text', 'Enter your level'],
    ['date_naissance', 'Date of Birth', 'date', ''],
    ['linkedin_url', 'LinkedIn', 'url', 'https://linkedin.com/in/...'],
    ['portfolio_url', 'Portfolio', 'url', 'https://your-portfolio.com'],
]

const updateField = (field, value) => {
    emit('update:modelValue', { ...props.modelValue, [field]: value })
}
</script>

<template>
    <section class="space-y-5">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
            <h2 class="text-lg font-bold text-[#16425B]">Personal Information</h2>
            <p class="mt-1 text-xs text-slate-500">
                Complete or update your information before continuing.
            </p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
            <div class="grid gap-5 sm:grid-cols-2">
                <div v-for="[field, label, type, placeholder] in fields" :key="field">
                    <label
                        :for="field"
                        class="mb-1.5 block text-sm font-medium text-slate-700"
                    >
                        {{ label }}
                    </label>

                    <input
                        :id="field"
                        :type="type"
                        :value="modelValue[field]"
                        :placeholder="placeholder"
                        @input="updateField(field, $event.target.value)"
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none transition placeholder:text-slate-400 focus:border-[#2F6690] focus:ring-2 focus:ring-[#2F6690]/10"
                    />
                </div>
            </div>

            <div class="mt-6 rounded-xl border border-[#81C3D7]/40 bg-[#E8F1F5] p-4">
                <div class="flex gap-3">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 shrink-0 text-[#3A7CA5]"
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

                    <p class="text-xs leading-5 text-[#2F6690]">
                        Please make sure your information is accurate before continuing.
                    </p>
                </div>
            </div>
        </div>
    </section>
</template>
