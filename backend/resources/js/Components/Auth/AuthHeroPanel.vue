<script setup>
defineProps({
  title: {
    type: String,
    default: 'Find your place. <strong>Build your future.</strong>'
  },

  subtitle: {
    type: String,
    default:
      'Discover opportunities that match your ambitions and connect with companies looking for emerging talent.'
  },

  features: {
    type: Array,
    default: () => []
  },

  footer: {
    type: String,
    default: 'From potential to opportunity.'
  }
})
</script>

<template>
  <div
    class="relative flex min-h-screen h-full w-full items-center overflow-hidden
           bg-[radial-gradient(circle_at_18%_18%,rgba(70,176,220,0.18),transparent_35%),linear-gradient(145deg,#0d3854_0%,#145675_48%,#102f47_100%)]
           max-[900px]:min-h-0"
  >

    <!-- TOP CIRCLE -->
    <div
      class="pointer-events-none absolute -right-[140px] -top-[190px]
             h-[440px] w-[440px] rounded-full
             bg-[linear-gradient(145deg,rgba(91,190,227,0.17),rgba(56,138,184,0.025))]"
    ></div>

    <!-- BOTTOM CIRCLE -->
    <div
      class="pointer-events-none absolute -bottom-[260px] -left-[230px]
             h-[520px] w-[520px] rounded-full
             bg-[linear-gradient(145deg,rgba(52,157,203,0.19),rgba(36,111,151,0.03))]"
    ></div>

    <!-- GLOW -->
    <div
      class="pointer-events-none absolute right-[-180px] top-[35%]
             h-[320px] w-[320px] rounded-full
             bg-[rgba(80,190,230,0.09)] blur-[60px]"
    ></div>

    <!-- CONTENT -->
    <div
      class="relative z-[2] w-full max-w-[620px] px-16 py-[58px] text-white
             max-[900px]:px-8 max-[900px]:py-[45px]"
    >

      <!-- LOGO -->
      <div class="mb-[58px] max-[900px]:mb-[35px]">
        <img
          src="/images/LogoBgDarkInternHub.png"
          alt="InternHub"
          class="block h-auto w-[185px] object-contain max-[900px]:w-[160px]"
        />
      </div>

      <!-- MAIN TEXT -->
      <div>

        <div
          class="mb-6 h-1 w-12 rounded-full
                 bg-gradient-to-r from-[#4fc0e9] to-[#8eddf5]"
        ></div>

        <h2
          v-html="title"
          class="mb-5 max-w-[520px]
                 text-[clamp(38px,4vw,54px)]
                 font-extrabold leading-[1.08]
                 tracking-[-1.5px]
                 text-white
                 [&_strong]:text-[#77d2f1]
                 max-[900px]:text-[34px]"
        ></h2>

        <p
          class="m-0 max-w-[500px]
                 text-[15px] leading-[1.75]
                 text-[rgba(235,247,252,0.82)]"
        >
          {{ subtitle }}
        </p>
      </div>

      <!-- FEATURES -->
      <div
        v-if="features.length"
        class="mt-[38px] flex flex-col gap-[19px]
               max-[900px]:hidden"
      >
        <div
          v-for="(feature, index) in features"
          :key="index"
          class="flex items-start gap-[14px]"
        >

          <!-- ICON -->
          <span
            class="mt-px flex h-[27px] w-[27px] shrink-0
                   items-center justify-center rounded-full
                   border border-[rgba(112,210,242,0.3)]
                   bg-[rgba(92,190,225,0.12)]
                   text-[13px] font-extrabold text-[#77d7f4]"
          >
            ✓
          </span>

          <div>
            <strong
              class="mb-[3px] block text-sm font-bold text-white"
            >
              {{ feature.title }}
            </strong>

            <p
              class="m-0 text-xs leading-[1.5]
                     text-[rgba(224,240,247,0.67)]"
            >
              {{ feature.text }}
            </p>
          </div>
        </div>
      </div>

      <!-- FOOTER -->
      <div
        class="mt-[45px] flex items-center gap-[14px]"
      >
        <span
          class="h-px w-[35px]
                 bg-[rgba(126,211,239,0.55)]"
        ></span>

        <p
          class="m-0 text-xs font-medium
                 tracking-[0.3px]
                 text-[rgba(225,242,249,0.62)]"
        >
          {{ footer }}
        </p>
      </div>

    </div>
  </div>
</template>
