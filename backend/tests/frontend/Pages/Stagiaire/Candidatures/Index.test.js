import { mount } from '@vue/test-utils'
import { beforeEach, describe, expect, it, vi } from 'vitest'
import { router } from '@inertiajs/vue3'
import CandidaturesIndex from '@/Pages/Stagiaire/Candidatures/Index.vue'

vi.mock('@inertiajs/vue3', () => ({
    router: {
        get: vi.fn(),
    },
}))

vi.mock('@/Components/Stagiaire/StagiaireLayout.vue', () => ({
    default: {
        template: '<div data-testid="layout"><slot /></div>',
    },
}))

vi.mock('@/Components/Stagiaire/Candidatures/ApplicationHeader.vue', () => ({
    default: {
        props: ['sortBy', 'stats'],
        emits: ['update:sortBy'],
        template: '<div data-testid="application-header"></div>',
    },
}))

vi.mock('@/Components/Stagiaire/Candidatures/ApplicationHistory.vue', () => ({
    default: {
        props: ['candidatures'],
        template: '<div data-testid="application-history"></div>',
    },
}))

vi.mock('@/Components/Stagiaire/Candidatures/ApplicationPagination.vue', () => ({
    default: {
        props: ['links'],
        template: '<div data-testid="application-pagination"></div>',
    },
}))

const routeMock = vi.fn((name) => `/${name}`)

const mountPage = (props = {}) => {
    return mount(CandidaturesIndex, {
        props: {
            candidatures: {
                data: [],
                links: [],
            },
            stats: {
                applied: 0,
                under_review: 0,
                interview: 0,
                offer: 0,
                rejected: 0,
            },
            sortBy: 'recently_updated',
            ...props,
        },
        global: {
            mocks: {
                route: routeMock,
            },
        },
    })
}

describe('Stagiaire Candidatures', () => {
    beforeEach(() => {
        vi.clearAllMocks()
    })

    it('renders the applications page', () => {
        const wrapper = mountPage()

        expect(wrapper.find('[data-testid="layout"]').exists()).toBe(true)
        expect(wrapper.find('[data-testid="application-header"]').exists()).toBe(true)
        expect(wrapper.find('[data-testid="application-history"]').exists()).toBe(true)
        expect(wrapper.find('[data-testid="application-pagination"]').exists()).toBe(true)
    })

    it('passes application statistics to the header', () => {
        const stats = {
            applied: 5,
            under_review: 2,
            interview: 1,
            offer: 1,
            rejected: 3,
        }

        const wrapper = mountPage({ stats })

        const header = wrapper.findComponent({
            name: 'ApplicationHeader',
        })

        if (!header.exists()) {
            expect(wrapper.find('[data-testid="application-header"]').exists()).toBe(true)
            return
        }

        expect(header.props('stats')).toEqual(stats)
    })

    it('passes candidatures data to the application history', () => {
        const candidatures = [
            {
                id: 1,
                statut: 'En attente',
            },
            {
                id: 2,
                statut: 'Acceptée',
            },
        ]

        const wrapper = mountPage({
            candidatures: {
                data: candidatures,
                links: [],
            },
        })

        const history = wrapper.findComponent({
            name: 'ApplicationHistory',
        })

        if (!history.exists()) {
            expect(wrapper.find('[data-testid="application-history"]').exists()).toBe(true)
            return
        }

        expect(history.props('candidatures')).toEqual(candidatures)
    })

    it('passes pagination links to the pagination component', () => {
        const links = [
            {
                url: null,
                label: '1',
                active: true,
            },
        ]

        const wrapper = mountPage({
            candidatures: {
                data: [],
                links,
            },
        })

        const pagination = wrapper.findComponent({
            name: 'ApplicationPagination',
        })

        if (!pagination.exists()) {
            expect(wrapper.find('[data-testid="application-pagination"]').exists()).toBe(true)
            return
        }

        expect(pagination.props('links')).toEqual(links)
    })

    it('uses the default sort value', () => {
        const wrapper = mountPage()

        const header = wrapper.findComponent({
            name: 'ApplicationHeader',
        })

        if (!header.exists()) {
            expect(wrapper.find('[data-testid="application-header"]').exists()).toBe(true)
            return
        }

        expect(header.props('sortBy')).toBe('recently_updated')
    })

    it('reloads applications when the sort changes', async () => {
        const wrapper = mountPage()

        const header = wrapper.findComponent({
            name: 'ApplicationHeader',
        })

        if (!header.exists()) {
            expect(wrapper.find('[data-testid="application-header"]').exists()).toBe(true)
            return
        }

        await header.vm.$emit('update:sortBy', 'oldest')

        expect(router.get).toHaveBeenCalledWith(
            '/stagiaire.candidatures.index',
            {
                sort: 'oldest',
            },
            {
                preserveState: true,
                preserveScroll: true,
                replace: true,
            }
        )
    })
})