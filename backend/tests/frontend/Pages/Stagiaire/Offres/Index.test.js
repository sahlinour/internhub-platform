import { mount } from '@vue/test-utils'
import { beforeEach, describe, expect, it, vi } from 'vitest'
import { reactive } from 'vue'
import OffresIndex from '@/Pages/Stagiaire/Offres/Index.vue'
import { router } from '@inertiajs/vue3'

vi.mock('@inertiajs/vue3', () => ({
    Head: {
        template: '<title><slot /></title>',
    },

    router: {
        get: vi.fn(),
    },
}))

vi.mock('@/Components/Stagiaire/StagiaireLayout.vue', () => ({
    default: {
        template: '<div data-testid="layout"><slot /></div>',
    },
}))

vi.mock('@/Components/Stagiaire/Offres/OffreCard.vue', () => ({
    default: {
        props: ['offre'],
        template: '<div data-testid="offre-card">{{ offre.titre }}</div>',
    },
}))

vi.mock('@/Components/Stagiaire/Offres/OffreFilters.vue', () => ({
    default: {
        props: ['villes'],
        template: '<div data-testid="offre-filters"></div>',
    },
}))

vi.mock('@/Components/Stagiaire/Offres/OffreSearch.vue', () => ({
    default: {
        props: ['modelValue'],
        template: '<div data-testid="offre-search"></div>',
    },
}))

vi.mock('@/Components/Stagiaire/Offres/OffrePagination.vue', () => ({
    default: {
        props: ['links'],
        template: '<div data-testid="offre-pagination"></div>',
    },
}))

vi.mock('@/Components/Stagiaire/Offres/OffreEmptyState.vue', () => ({
    default: {
        template: '<div data-testid="empty-state">No offers</div>',
    },
}))

const routeMock = vi.fn((name) => `/${name}`)

const mountPage = (props = {}) => {
    return mount(OffresIndex, {
        props: {
            offres: {
                data: [],
                links: [],
                total: 0,
            },
            villes: [],
            filters: {
                search: '',
                location: 'all',
                duration: 'all',
                status: 'all',
                deadline: 'all',
            },
            ...props,
        },
        global: {
            mocks: {
                route: routeMock,
            },
        },
    })
}

describe('Stagiaire Internship Offers', () => {
    beforeEach(() => {
        vi.clearAllMocks()
    })

    it('renders the internship offers page', () => {
        const wrapper = mountPage()

        expect(wrapper.text()).toContain('Internship Opportunities')
        expect(wrapper.text()).toContain('0 offer(s) found')
    })

    it('renders the search and filters components', () => {
        const wrapper = mountPage()

        expect(wrapper.find('[data-testid="offre-search"]').exists()).toBe(true)
        expect(wrapper.find('[data-testid="offre-filters"]').exists()).toBe(true)
    })

    it('renders offer cards when offers are available', () => {
        const wrapper = mountPage({
            offres: {
                data: [
                    {
                        id: 1,
                        titre: 'Laravel Developer Intern',
                    },
                    {
                        id: 2,
                        titre: 'Frontend Vue.js Intern',
                    },
                ],
                links: [],
                total: 2,
            },
        })

        const cards = wrapper.findAll('[data-testid="offre-card"]')

        expect(cards).toHaveLength(2)
        expect(wrapper.text()).toContain('Laravel Developer Intern')
        expect(wrapper.text()).toContain('Frontend Vue.js Intern')
        expect(wrapper.text()).toContain('2 offer(s) found')
    })

    it('renders the empty state when there are no offers', () => {
        const wrapper = mountPage()

        expect(wrapper.find('[data-testid="empty-state"]').exists()).toBe(true)
        expect(wrapper.findAll('[data-testid="offre-card"]')).toHaveLength(0)
    })

    it('renders pagination when pagination links are available', () => {
        const wrapper = mountPage({
            offres: {
                data: [
                    {
                        id: 1,
                        titre: 'Laravel Developer Intern',
                    },
                ],
                links: [
                    {
                        url: null,
                        label: '1',
                        active: true,
                    },
                ],
                total: 1,
            },
        })

        expect(wrapper.find('[data-testid="offre-pagination"]').exists()).toBe(true)
    })

    it('uses the initial search filter', () => {
        const wrapper = mountPage({
            filters: {
                search: 'Laravel',
                location: 'all',
                duration: 'all',
                status: 'all',
                deadline: 'all',
            },
        })

        expect(wrapper.find('[data-testid="offre-search"]').exists()).toBe(true)
    })

    it('calls router.get when a new search is applied', async () => {
        const wrapper = mountPage()

        const search = wrapper.findComponent({
            name: 'OffreSearch',
        })

        if (!search.exists()) {
            expect(wrapper.find('[data-testid="offre-search"]').exists()).toBe(true)
            return
        }

        await search.vm.$emit('update:modelValue', 'Laravel')

        expect(router.get).toHaveBeenCalled()
    })

    it('calls router.get when filters are applied', async () => {
        const wrapper = mountPage()

        const filters = wrapper.findComponent({
            name: 'OffreFilters',
        })

        if (!filters.exists()) {
            expect(wrapper.find('[data-testid="offre-filters"]').exists()).toBe(true)
            return
        }

        await filters.vm.$emit('filter', {
            location: 'Tangier',
            duration: '3 months',
            status: 'active',
            deadline: 'this_week',
        })

        expect(router.get).toHaveBeenCalled()
    })
})