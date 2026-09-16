<template>
    <section class="bg-white py-24 font-body">
        <div class="mx-auto max-w-7xl px-8">

            <!-- Header -->
            <div class="mb-16 flex flex-col justify-between gap-6 md:flex-row md:items-end">
                <div>
                    <span
                        class="mb-4 inline-block rounded-full border px-4 py-1.5 text-xs
                               font-semibold uppercase tracking-widest"
                        style="
                            background:rgba(22,66,91,0.06);
                            color:#2F6690;
                            border-color:rgba(22,66,91,0.1);
                        "
                    >
                        How It Works
                    </span>

                    <h2
                        class="text-4xl font-bold md:text-5xl"
                        style="font-family:'Playfair Display',serif;color:#16425B;"
                    >
                        Get Started in<br>
                        <span style="color:#3A7CA5;">3 Simple Steps</span>
                    </h2>
                </div>

                <p class="max-w-xs text-sm leading-relaxed text-gray-400 md:text-right">
                    Simple, fast, and effective.<br>
                    Find your internship in minutes.
                </p>
            </div>

            <!-- Steps -->
            <div class="grid grid-cols-1 gap-8 md:grid-cols-3">

                <!-- Step 1 -->
                <div
                    class="group relative rounded-3xl p-8 transition-all duration-300 hover:-translate-y-2"
                    style="
                        background:#F0F7FB;
                        border:1px solid rgba(129,195,215,0.2);
                        box-shadow:0 4px 20px rgba(22,66,91,0.05);
                    "
                >
                    <span
                        class="absolute right-6 top-3 select-none text-8xl font-bold opacity-5"
                        style="font-family:'Playfair Display',serif;color:#16425B;"
                    >
                        1
                    </span>

                    <!-- User Check -->
                    <div
                        class="mb-6 flex h-14 w-14 items-center justify-center rounded-2xl
                               transition-transform duration-300 group-hover:scale-110"
                        style="background:#16425B;color:white;"
                    >
                        <svg
                            class="h-7 w-7"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <circle cx="9" cy="8" r="3"/>
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3.5 19c.7-3.1 2.5-5 5.5-5 1.4 0 2.6.4 3.6 1.2"
                            />
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m15 17 1.8 1.8 4-4"
                            />
                        </svg>
                    </div>

                    <span
                        class="mb-4 inline-block rounded-full px-3 py-1 text-xs font-bold"
                        style="
                            background:rgba(22,66,91,0.08);
                            color:#16425B;
                        "
                    >
                        Step 01
                    </span>

                    <h3
                        class="mb-3 text-xl font-bold"
                        style="font-family:'Playfair Display',serif;color:#16425B;"
                    >
                        Create Your Account
                    </h3>

                    <p class="text-sm leading-relaxed text-gray-400">
                        Sign up as an intern or company in less than 2 minutes.
                        Choose your profile and get started immediately.
                    </p>

                    <!-- Arrow -->
                    <div
                        class="absolute -right-5 top-1/2 z-10 hidden h-10 w-10
                               -translate-y-1/2 items-center justify-center rounded-full md:flex"
                        style="
                            background:white;
                            border:2px solid rgba(129,195,215,0.4);
                            color:#3A7CA5;
                            box-shadow:0 4px 12px rgba(22,66,91,0.08);
                        "
                    >
                        <svg
                            class="h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M5 12h14M13 6l6 6-6 6"
                            />
                        </svg>
                    </div>
                </div>

                <!-- Step 2 -->
                <div
                    class="group relative rounded-3xl p-8 transition-all duration-300 hover:-translate-y-2"
                    style="
                        background:linear-gradient(145deg,#16425B,#2F6690);
                        box-shadow:0 12px 35px rgba(22,66,91,0.22);
                    "
                >
                    <span
                        class="absolute right-6 top-3 select-none text-8xl font-bold text-white opacity-10"
                        style="font-family:'Playfair Display',serif;"
                    >
                        2
                    </span>

                    <!-- Search -->
                    <div
                        class="mb-6 flex h-14 w-14 items-center justify-center rounded-2xl
                               transition-transform duration-300 group-hover:scale-110"
                        style="background:rgba(129,195,215,0.2);color:#81C3D7;"
                    >
                        <svg
                            class="h-7 w-7"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <circle cx="10.8" cy="10.8" r="6.3"/>
                            <path
                                stroke-linecap="round"
                                d="m16 16 4.2 4.2"
                            />
                        </svg>
                    </div>

                    <span
                        class="mb-4 inline-block rounded-full px-3 py-1 text-xs font-bold"
                        style="
                            background:rgba(129,195,215,0.15);
                            color:#81C3D7;
                        "
                    >
                        Step 02
                    </span>

                    <h3
                        class="mb-3 text-xl font-bold text-white"
                        style="font-family:'Playfair Display',serif;"
                    >
                        Browse & Apply
                    </h3>

                    <p
                        class="text-sm leading-relaxed"
                        style="color:rgba(217,220,214,0.7);"
                    >
                        Explore hundreds of internship offers, filter by domain,
                        city or duration and apply with one click.
                    </p>

                    <!-- Arrow -->
                    <div
                        class="absolute -right-5 top-1/2 z-10 hidden h-10 w-10
                               -translate-y-1/2 items-center justify-center rounded-full md:flex"
                        style="
                            background:white;
                            border:2px solid rgba(129,195,215,0.4);
                            color:#3A7CA5;
                            box-shadow:0 4px 12px rgba(22,66,91,0.08);
                        "
                    >
                        <svg
                            class="h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M5 12h14M13 6l6 6-6 6"
                            />
                        </svg>
                    </div>
                </div>

                <!-- Step 3 -->
                <div
                    class="group relative rounded-3xl p-8 transition-all duration-300 hover:-translate-y-2"
                    style="
                        background:#F0F7FB;
                        border:1px solid rgba(129,195,215,0.2);
                        box-shadow:0 4px 20px rgba(22,66,91,0.05);
                    "
                >
                    <span
                        class="absolute right-6 top-3 select-none text-8xl font-bold opacity-5"
                        style="font-family:'Playfair Display',serif;color:#16425B;"
                    >
                        3
                    </span>

                    <!-- Briefcase Check -->
                    <div
                        class="mb-6 flex h-14 w-14 items-center justify-center rounded-2xl
                               transition-transform duration-300 group-hover:scale-110"
                        style="background:#3A7CA5;color:white;"
                    >
                        <svg
                            class="h-7 w-7"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <rect
                                x="3"
                                y="7"
                                width="18"
                                height="13"
                                rx="2"
                            />
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M8 7V5.5A1.5 1.5 0 0 1 9.5 4h5A1.5 1.5 0 0 1 16 5.5V7"
                            />
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m9 14 2 2 4-4"
                            />
                        </svg>
                    </div>

                    <span
                        class="mb-4 inline-block rounded-full px-3 py-1 text-xs font-bold"
                        style="
                            background:rgba(58,124,165,0.08);
                            color:#3A7CA5;
                        "
                    >
                        Step 03
                    </span>

                    <h3
                        class="mb-3 text-xl font-bold"
                        style="font-family:'Playfair Display',serif;color:#16425B;"
                    >
                        Land Your Internship
                    </h3>

                    <p class="text-sm leading-relaxed text-gray-400">
                        Track your applications in real time, receive responses
                        and start your internship with confidence.
                    </p>
                </div>

            </div>
        </div>
    </section>
</template>