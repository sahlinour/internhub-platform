<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/Shared/InputError.vue';
import InputLabel from '@/Components/Shared/InputLabel.vue';
import PrimaryButton from '@/Components/Shared/PrimaryButton.vue';
import TextInput from '@/Components/Shared/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>
<template>
    <GuestLayout>
        <Head title="Forgot Password" />

            <section class="min-h-[620px] bg-[#e8f2f8] px-4 pb-20 pt-36 sm:pt-40">            <div class="mx-auto w-full max-w-lg rounded-2xl bg-white p-6 shadow-lg sm:p-10">
                <h1 class="mb-3 text-3xl font-bold text-slate-900">
                    Forgot your password?
                </h1>

                <p class="mb-8 text-sm leading-6 text-slate-600">
                    Enter your email address and we will send you a link
                    to reset your password.
                </p>

                <div
                    v-if="status"
                    class="mb-6 rounded-lg bg-green-50 p-4 text-sm text-green-700"
                >
                    {{ status }}
                </div>

                <form @submit.prevent="submit">
                    <div>
                        <InputLabel for="email" value="Email address" />

                        <TextInput
                            id="email"
                            v-model="form.email"
                            type="email"
                            class="mt-2 block w-full"
                            required
                            autofocus
                            autocomplete="username"
                        />

                        <InputError
                            class="mt-2"
                            :message="form.errors.email"
                        />
                    </div>

                    <PrimaryButton
                        class="mt-6 w-full justify-center"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    >
                        Send reset link
                    </PrimaryButton>
                </form>
            </div>
        </section>
    </GuestLayout>
</template>
