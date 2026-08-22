import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'

/**
 * Expose the authenticated user and role-check helpers.
 * Assumes the Laravel HandleInertiaRequests middleware shares `auth.user.role`.
 */
export function useAuth() {
  const page = usePage()

  const user = computed(() => page.props.auth?.user ?? null)
  const role = computed(() => user.value?.role ?? null)

  const isStagiaire = computed(() => role.value === 'stagiaire')
  const isEncadrant = computed(() => role.value === 'encadrant')
  const isEntreprise = computed(() => role.value === 'entreprise')
  const isAdmin = computed(() => role.value === 'admin')

  return { user, role, isStagiaire, isEncadrant, isEntreprise, isAdmin }
}

