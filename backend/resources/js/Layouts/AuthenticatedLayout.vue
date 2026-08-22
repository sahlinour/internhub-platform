<script setup>
import { ref } from 'vue'
import ApplicationLogo from '@/Components/Shared/ApplicationLogo.vue'
import Dropdown from '@/Components/Shared/Dropdown.vue'
import DropdownLink from '@/Components/Shared/DropdownLink.vue'
import NavLink from '@/Components/Shared/NavLink.vue'
import ResponsiveNavLink from '@/Components/Shared/ResponsiveNavLink.vue'

defineProps({
  role: {
    type: String,
    default: 'stagiaire' // stagiaire | encadrant | entreprise | admin
  }
})

const showingMobileMenu = ref(false)
</script>

<template>
  <div class="min-h-screen bg-gray-100">
    <nav class="border-b border-gray-100 bg-white">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 justify-between">
          <div class="flex">
            <div class="flex shrink-0 items-center">
              <ApplicationLogo class="block h-9 w-auto" />
            </div>

            <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
              <slot name="nav-links" />
            </div>
          </div>

          <div class="hidden sm:ms-6 sm:flex sm:items-center">
            <Dropdown align="right" width="48">
              <template #trigger>
                <button
                  class="inline-flex items-center rounded-md border border-transparent px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition hover:text-gray-700"
                >
                  <slot name="user-name">Mon compte</slot>
                </button>
              </template>
              <template #content>
                <DropdownLink href="/profile">Profil</DropdownLink>
                <DropdownLink href="/logout" as="button">Déconnexion</DropdownLink>
              </template>
            </Dropdown>
          </div>

          <div class="-me-2 flex items-center sm:hidden">
            <button
              class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500"
              @click="showingMobileMenu = !showingMobileMenu"
            >
              ☰
            </button>
          </div>
        </div>
      </div>

      <div v-show="showingMobileMenu" class="sm:hidden">
        <div class="space-y-1 pb-3 pt-2">
          <slot name="mobile-nav-links" />
        </div>
      </div>
    </nav>

    <header v-if="$slots.header" class="bg-white shadow">
      <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <slot name="header" />
      </div>
    </header>

    <main>
      <slot />
    </main>
  </div>
</template>
