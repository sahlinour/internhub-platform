import { mount } from '@vue/test-utils'
import { beforeEach, describe, expect, it, vi } from 'vitest'
import StagiaireTopbar from '@/Components/Stagiaire/StagiaireTopbar.vue'
import { usePage } from '@inertiajs/vue3'

vi.mock('@inertiajs/vue3', () => ({
    Link: {
        template: '<a :href="href"><slot /></a>',
        props: ['href', 'method', 'as'],
    },

    usePage: vi.fn(),
}))

vi.mock('@/Components/Stagiaire/Icon.vue', () => ({
    default: {
        template: '<svg data-testid="icon"></svg>',
        props: ['name', 'size'],
    },
}))

const mountTopbar = () => {
    return mount(StagiaireTopbar)
}

describe('Stagiaire Topbar', () => {
    beforeEach(() => {
        vi.clearAllMocks()

        usePage.mockReturnValue({
            props: {
                auth: {
                    user: {
                        nom_complet: 'Nour Sahli',
                    },
                },
            },
        })
    })

    it('renders the topbar header', () => {
        const wrapper = mountTopbar()

        expect(wrapper.find('header').exists()).toBe(true)
    })

    it('displays the student full name', () => {
        const wrapper = mountTopbar()

        expect(wrapper.text()).toContain('Nour Sahli')
    })

    it('displays the student role', () => {
        const wrapper = mountTopbar()

        expect(wrapper.text()).toContain('InternHub Student')
    })

    it('generates the correct initials from the full name', () => {
        const wrapper = mountTopbar()

        const avatar = wrapper
            .findAll('div')
            .find((element) => element.text() === 'NS')

        expect(avatar).toBeTruthy()
    })

    it('displays Student when no user name is available', () => {
        usePage.mockReturnValue({
            props: {
                auth: {
                    user: {},
                },
            },
        })

        const wrapper = mountTopbar()

        expect(wrapper.text()).toContain('Student')
    })

    it('renders the internship search input', () => {
        const wrapper = mountTopbar()

        const input = wrapper.find('input[type="search"]')

        expect(input.exists()).toBe(true)
        expect(input.attributes('placeholder')).toBe(
            'Search internships, companies...'
        )
    })

    it('renders the notification link and bell icon', () => {
        const wrapper = mountTopbar()

        const notificationLink = wrapper.find('a')

        expect(notificationLink.exists()).toBe(true)
        expect(notificationLink.attributes('href')).toBe('#')
        expect(wrapper.find('[data-testid="icon"]').exists()).toBe(true)
    })

    it('supports first and last names when nom_complet is unavailable', () => {
        usePage.mockReturnValue({
            props: {
                auth: {
                    user: {
                        prenom: 'Nour',
                        nom: 'Sahli',
                    },
                },
            },
        })

        const wrapper = mountTopbar()

        expect(wrapper.text()).toContain('Nour Sahli')
        expect(wrapper.text()).toContain('NS')
    })
})