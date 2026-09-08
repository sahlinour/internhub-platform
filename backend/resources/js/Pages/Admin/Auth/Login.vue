<script setup>
import { Head, useForm } from '@inertiajs/vue3'
import InputLabel from '@/Components/InputLabel.vue'
import TextInput from '@/Components/TextInput.vue'
import InputError from '@/Components/InputError.vue'

const logoUrl = '/images/LogoBgDarkInternHub.png'
const logoUrl2 = '/images/LogoBgWhiteInternHub.png'

const form = useForm({
    email: '',
    password: '',
    remember: false,
})

const submit = () => {
    form.post(route('admin.login.store'), {
        onFinish: () => form.reset('password'),
    })
}
</script>

<template>
    <Head title="Admin Login" />

    <div class="grid min-h-screen grid-cols-2 bg-white max-[820px]:grid-cols-1">

        <!-- LEFT PANEL -->
        <section
            class="relative flex min-h-screen flex-col justify-between overflow-hidden
                   bg-gradient-to-br from-[#14344c] via-[#1d5877] to-[#3195b6]
                   px-[58px] pb-[38px] pt-[52px] text-white
                   max-[980px]:px-10 max-[980px]:pb-[35px] max-[980px]:pt-[45px]
                   max-[820px]:min-h-0 max-[820px]:px-7 max-[820px]:py-[38px]
                   max-[480px]:px-5 max-[480px]:py-[30px]"
        >
            <!-- DECORATION -->
            <div
                class="pointer-events-none absolute -right-[150px] -top-[220px]
                       h-[430px] w-[430px] rounded-full
                       border border-white/10"
            ></div>

            <div
                class="pointer-events-none absolute -bottom-[300px] -left-[230px]
                       h-[520px] w-[520px] rounded-full
                       border border-white/10"
            ></div>

            <!-- CONTENT -->
            <div class="relative z-10">
                <div class="mb-[52px] max-[820px]:mb-[34px]">
                    <img
                        :src="logoUrl"
                        alt="InternHub Logo"
                        class="max-h-[76px] w-auto max-w-[190px] object-contain"
                    />
                </div>

                <span
                    class="mb-[22px] inline-flex w-fit rounded-full
                           border border-white/20 bg-white/[0.09]
                           px-[14px] py-[7px]
                           text-[11px] font-bold uppercase tracking-[0.1em]"
                >
                    Administration Portal
                </span>

                <h1
                    class="mb-5 max-w-[540px]
                           text-[clamp(38px,4vw,58px)]
                           font-medium leading-[1.08]
                           tracking-[-0.025em]
                           max-[980px]:text-[42px]
                           max-[820px]:max-w-[600px]
                           max-[820px]:text-[36px]
                           max-[480px]:text-[31px]"
                >
                    Manage
                    <strong class="font-extrabold">
                        InternHub
                    </strong>
                    securely.
                </h1>

                <p
                    class="max-w-[540px] text-[15px]
                           leading-[1.75] text-white/80
                           max-[820px]:max-w-[600px]
                           max-[480px]:text-[14px]"
                >
                    Access the administration space to supervise users,
                    companies, supervisors, internships, applications,
                    documents and platform activity.
                </p>

                <!-- SECURITY -->
                <div
                    class="mt-[34px] flex max-w-[520px] items-start gap-[14px]
                           rounded-[13px] border border-white/15
                           bg-white/[0.08] p-[17px]
                           backdrop-blur-md
                           max-[820px]:mt-[26px]
                           max-[480px]:p-[14px]"
                >
                    <span
                        class="flex h-8 w-8 shrink-0 items-center
                               justify-center rounded-full
                               bg-white/15 text-[14px] font-extrabold"
                    >
                        ✓
                    </span>

                    <div>
                        <strong class="mb-[3px] block text-[13px]">
                            Restricted access
                        </strong>

                        <p class="m-0 text-[12px] leading-[1.55] text-white/70">
                            This portal is reserved exclusively for
                            authorized administrators.
                        </p>
                    </div>
                </div>
            </div>

            <div
                class="relative z-10 mt-10 text-[11px] text-white/50
                       max-[820px]:mt-9"
            >
                InternHub Administration
            </div>
        </section>

        <!-- RIGHT PANEL -->
        <section
            class="flex min-h-screen items-center justify-center
                   bg-white px-10 py-12
                   max-[820px]:min-h-0 max-[820px]:px-6 max-[820px]:py-[52px]
                   max-[480px]:px-5 max-[480px]:py-[42px]"
        >
            <div class="w-full max-w-[420px]">

                <!-- LOGO -->
                <div class="mb-[26px] flex justify-center">
                    <img
                        :src="logoUrl2"
                        alt="InternHub Logo"
                        class="max-h-[74px] w-auto max-w-[180px]
                               object-contain max-[480px]:max-w-[155px]"
                    />
                </div>

                <h1
                    class="mb-2 text-center text-[27px]
                           font-extrabold tracking-[-0.02em]
                           text-[#17384f]
                           max-[480px]:text-[24px]"
                >
                    Admin access
                </h1>

                <p
                    class="mx-auto mb-[30px] max-w-[340px]
                           text-center text-[13px]
                           leading-[1.6] text-[#748896]"
                >
                    Sign in with your administrator credentials to continue.
                </p>

                <form @submit.prevent="submit">

                    <!-- EMAIL -->
                    <div class="mb-[17px]">
                        <InputLabel
                            for="email"
                            value="Administrator Email"
                            class="mb-[7px] block text-[13px] font-bold text-[#1e4056]"
                        />

                        <TextInput
                            id="email"
                            v-model="form.email"
                            type="email"
                            placeholder="admin@internhub.com"
                            autocomplete="username"
                            autofocus
                            required
                            class="w-full rounded-[9px] border border-[#d1dfe7]
                                   bg-[#eef4f7] px-[14px] py-3
                                   text-[14px] text-[#16364a]
                                   placeholder:text-[#97a8b3]
                                   focus:border-[#358db1]
                                   focus:bg-white
                                   focus:ring-4
                                   focus:ring-[#358db1]/10"
                        />

                        <InputError
                            :message="form.errors.email"
                            class="mt-[5px]"
                        />
                    </div>

                    <!-- PASSWORD -->
                    <div class="mb-[17px]">
                        <InputLabel
                            for="password"
                            value="Password"
                            class="mb-[7px] block text-[13px] font-bold text-[#1e4056]"
                        />

                        <TextInput
                            id="password"
                            v-model="form.password"
                            type="password"
                            placeholder="••••••••••••"
                            autocomplete="current-password"
                            required
                            class="w-full rounded-[9px] border border-[#d1dfe7]
                                   bg-[#eef4f7] px-[14px] py-3
                                   text-[14px] text-[#16364a]
                                   placeholder:text-[#97a8b3]
                                   focus:border-[#358db1]
                                   focus:bg-white
                                   focus:ring-4
                                   focus:ring-[#358db1]/10"
                        />

                        <InputError
                            :message="form.errors.password"
                            class="mt-[5px]"
                        />
                    </div>

                    <!-- REMEMBER -->
                    <div
                        class="mt-1 flex items-center justify-between
                               gap-3 text-[12px]
                               max-[480px]:items-start
                               max-[480px]:flex-col"
                    >
                        <label
                            class="flex cursor-pointer select-none
                                   items-center gap-[7px]
                                   text-[#405d6f]"
                        >
                            <input
                                v-model="form.remember"
                                type="checkbox"
                                class="h-[15px] w-[15px]
                                       accent-[#2c789c]"
                            />

                            <span>
                                Remember me
                            </span>
                        </label>

                        <span class="text-[11px] text-[#8a9aa5]">
                            Secure access only
                        </span>
                    </div>

                    <!-- LOGIN -->
                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="mt-5 flex min-h-[46px] w-full
                               items-center justify-center
                               rounded-[9px]
                               bg-[#28688c]
                               px-4 py-3
                               text-[14px] font-bold text-white
                               transition
                               hover:-translate-y-px
                               hover:bg-[#1c506e]
                               hover:shadow-[0_7px_18px_rgba(32,85,114,0.18)]
                               active:translate-y-0
                               disabled:cursor-not-allowed
                               disabled:opacity-60"
                    >
                        <span v-if="form.processing">
                            Signing in...
                        </span>

                        <span v-else>
                            Sign in to administration
                        </span>
                    </button>
                </form>

            </div>
        </section>

    </div>
</template>
