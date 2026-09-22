import { mount } from '@vue/test-utils'
import { describe, it, expect, vi, beforeEach } from 'vitest'

import Index from '@/Pages/Entreprise/Offres/Index.vue'

const routeMock = vi.fn((name, params) => {
    if (params !== undefined) {
        return `/${name}/${params}`
    }

    return `/${name}`
})

global.route = routeMock
const putMock = vi.hoisted(() => vi.fn())
const deleteMock = vi.hoisted(() => vi.fn())
const resetMock = vi.hoisted(() => vi.fn())
const clearErrorsMock = vi.hoisted(() => vi.fn())

const formMock = vi.hoisted(() => ({
    titre: '',
    description: '',
    duree: '',
    date_limite: '',
    statut: 'ouverte',
    put: putMock,
    reset: resetMock,
    clearErrors: clearErrorsMock,
}))

vi.mock('@inertiajs/vue3', () => ({
    Head: {
        name: 'Head',
        template: '<div />',
    },

    router: {
        delete: deleteMock,
    },

    useForm: vi.fn(() => formMock),
}))

vi.mock('@/Layouts/EntrepriseLayout.vue', () => ({
    default: {
        name: 'EntrepriseLayout',
        template: '<div><slot /></div>',
    },
}))

vi.mock('@/Components/Entreprise/Offres/InternshipHeader.vue', () => ({
    default: {
        name: 'InternshipHeader',
        props: ['createUrl'],
        template: '<div data-test="internship-header" />',
    },
}))

vi.mock('@/Components/Entreprise/Offres/InternshipStats.vue', () => ({
    default: {
        name: 'InternshipStats',
        props: ['stats'],
        template: `
            <div data-test="internship-stats">
                {{ stats.total }}
                {{ stats.ouverte }}
                {{ stats.en_attente }}
                {{ stats.fermee }}
            </div>
        `,
    },
}))

vi.mock('@/Components/Entreprise/Offres/InternshipTable.vue', () => ({
    default: {
        name: 'InternshipTable',
        props: ['offres'],
        emits: ['edit', 'delete'],
        template: `
            <div data-test="internship-table">
                <span>{{ offres.length }}</span>
                <button
                    data-test="edit-offer"
                    @click="$emit('edit', offres[0])"
                >
                    Edit
                </button>
                <button
                    data-test="delete-offer"
                    @click="$emit('delete', offres[0]?.id)"
                >
                    Delete
                </button>
            </div>
        `,
    },
}))

vi.mock('@/Components/Entreprise/Offres/InternshipEditModal.vue', () => ({
    default: {
        name: 'InternshipEditModal',
        props: ['show', 'offre', 'form'],
        emits: ['close', 'submit'],
        template: `
            <div data-test="edit-modal">
                <span>{{ show }}</span>
                <span>{{ offre?.titre }}</span>
                <button data-test="submit-edit" @click="$emit('submit')">
                    Submit
                </button>
                <button data-test="close-edit" @click="$emit('close')">
                    Close
                </button>
            </div>
        `,
    },
}))

const makeOffers = () => [
    {
        id: 1,
        titre: 'Laravel Developer',
        description: 'Develop Laravel applications',
        duree: '3 months',
        date_limite: '2026-12-01',
        statut: 'ouverte',
    },
    {
        id: 2,
        titre: 'Vue.js Developer',
        description: 'Develop Vue applications',
        duree: '4 months',
        date_limite: '2026-11-15',
        statut: 'en_attente',
    },
    {
        id: 3,
        titre: 'Frontend Developer',
        description: 'Frontend internship',
        duree: '2 months',
        date_limite: '2026-10-15',
        statut: 'fermee',
    },
    {
        id: 4,
        titre: 'Backend Developer',
        description: 'Backend internship',
        duree: '3 months',
        date_limite: '2026-12-15',
        statut: 'ouverte',
    },
]

const mountPage = (offres = makeOffers()) => {
    return mount(Index, {
        props: {
            offres,
        },
    })
}

beforeEach(() => {
    vi.clearAllMocks()

    formMock.titre = ''
    formMock.description = ''
    formMock.duree = ''
    formMock.date_limite = ''
    formMock.statut = 'ouverte'

    global.confirm = vi.fn(() => true)
})

describe('Entreprise - Offres Index', () => {
    it('renders the internship page', () => {
        const wrapper = mountPage()

        expect(wrapper.text()).toContain('Internship Listings')
        expect(wrapper.text()).toContain(
            'Manage the internships published by your company.'
        )

        expect(
            wrapper.find('[data-test="internship-header"]').exists()
        ).toBe(true)

        expect(
            wrapper.find('[data-test="internship-stats"]').exists()
        ).toBe(true)

        expect(
            wrapper.find('[data-test="internship-table"]').exists()
        ).toBe(true)
    })

    it('calculates internship statistics correctly', () => {
        const wrapper = mountPage()

        const stats = wrapper.find(
            '[data-test="internship-stats"]'
        ).text()

        expect(stats).toContain('4')
        expect(stats).toContain('2')
        expect(stats).toContain('1')
    })

    it('opens the edit modal with the selected offer', async () => {
        const wrapper = mountPage()

        await wrapper
            .find('[data-test="edit-offer"]')
            .trigger('click')

        expect(
            wrapper.find('[data-test="edit-modal"]').text()
        ).toContain('true')

        expect(
            wrapper.find('[data-test="edit-modal"]').text()
        ).toContain('Laravel Developer')

        expect(formMock.titre).toBe('Laravel Developer')
        expect(formMock.description).toBe(
            'Develop Laravel applications'
        )
        expect(formMock.duree).toBe('3 months')
        expect(formMock.date_limite).toBe('2026-12-01')
        expect(formMock.statut).toBe('ouverte')
    })

    it('closes the edit modal and resets the form', async () => {
        const wrapper = mountPage()

        await wrapper
            .find('[data-test="edit-offer"]')
            .trigger('click')

        await wrapper
            .find('[data-test="close-edit"]')
            .trigger('click')

        expect(
            wrapper.find('[data-test="edit-modal"]').text()
        ).toContain('false')

        expect(resetMock).toHaveBeenCalled()
        expect(clearErrorsMock).toHaveBeenCalled()
    })

    it('submits the selected offer update', async () => {
        const wrapper = mountPage()

        await wrapper
            .find('[data-test="edit-offer"]')
            .trigger('click')

        await wrapper
            .find('[data-test="submit-edit"]')
            .trigger('click')

        expect(putMock).toHaveBeenCalledWith(
            '/entreprise.offres.update/1',
            expect.objectContaining({
                preserveScroll: true,
                onSuccess: expect.any(Function),
            })
        )
    })

    it('deletes an offer after confirmation', async () => {
        const wrapper = mountPage()

        await wrapper
            .find('[data-test="delete-offer"]')
            .trigger('click')

        expect(global.confirm).toHaveBeenCalledWith(
            'Are you sure you want to delete this internship?'
        )

        expect(deleteMock).toHaveBeenCalledWith(
            '/entreprise.offres.destroy/1',
            {
                preserveScroll: true,
            }
        )
    })

    it('does not delete an offer when confirmation is cancelled', async () => {
        global.confirm = vi.fn(() => false)

        const wrapper = mountPage()

        await wrapper
            .find('[data-test="delete-offer"]')
            .trigger('click')

        expect(deleteMock).not.toHaveBeenCalled()
    })

    it('handles an empty offers list', () => {
        const wrapper = mountPage([])

        const stats = wrapper.find(
            '[data-test="internship-stats"]'
        ).text()

        expect(stats).toContain('0')

        expect(
            wrapper.find('[data-test="internship-table"]').exists()
        ).toBe(true)
    })
})