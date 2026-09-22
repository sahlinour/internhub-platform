import { mount } from '@vue/test-utils'
import { beforeEach, describe, expect, it, vi } from 'vitest'
import SidebarMenu from '@/Components/Stagiaire/SidebarMenu.vue'
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

const routeMock = vi.fn((name) => `/${name}`)

const mountSidebar = () => {
    return mount(SidebarMenu, {
        global: {
            mocks: {
                route: routeMock,
            },
        },
    })
}

describe('Stagiaire Sidebar Menu', () => {
    beforeEach(() => {
        vi.clearAllMocks()

        usePage.mockReturnValue({
            url: '/stagiaire/dashboard',
            props: {
                stagiaire: {
                    has_stage: false,
                },
            },
        })
    })

    it('displays the main navigation links', () => {
        const wrapper = mountSidebar()

        expect(wrapper.text()).toContain('Dashboard')
        expect(wrapper.text()).toContain('Internship Offers')
        expect(wrapper.text()).toContain('My Applications')
        expect(wrapper.text()).toContain('My CV')
        expect(wrapper.text()).toContain('Notifications')
        expect(wrapper.text()).toContain('Saved Opportunities')
        expect(wrapper.text()).toContain('Profile')
        expect(wrapper.text()).toContain('Settings')
    })

    it('hides internship journey links when the student has no stage', () => {
        const wrapper = mountSidebar()

        expect(wrapper.text()).not.toContain('Internship Journey')
        expect(wrapper.text()).not.toContain('My Progress')
        expect(wrapper.text()).not.toContain('My Tasks')
        expect(wrapper.text()).not.toContain('My Logbook')
        expect(wrapper.text()).not.toContain('Documents')
    })

    it('displays internship journey links when the student has a stage', () => {
        usePage.mockReturnValue({
            url: '/stagiaire/internship-journey',
            props: {
                stagiaire: {
                    has_stage: true,
                },
            },
        })

        const wrapper = mountSidebar()

        expect(wrapper.text()).toContain('Internship Journey')
        expect(wrapper.text()).toContain('My Progress')
        expect(wrapper.text()).toContain('My Tasks')
        expect(wrapper.text()).toContain('My Logbook')
        expect(wrapper.text()).toContain('Documents')
    })

    it('marks the dashboard link as active', () => {
        const wrapper = mountSidebar()

        const dashboardLink = wrapper
            .findAll('a')
            .find((link) => link.text() === 'Dashboard')

        expect(dashboardLink).toBeTruthy()
        expect(dashboardLink.classes()).toContain('bg-[#449dc6]/[0.27]')
    })

    it('marks the internship journey link as active', () => {
        usePage.mockReturnValue({
            url: '/stagiaire/internship-journey',
            props: {
                stagiaire: {
                    has_stage: true,
                },
            },
        })

        const wrapper = mountSidebar()

        const journeyLink = wrapper
            .findAll('a')
            .find((link) => link.text() === 'Internship Journey')

        expect(journeyLink).toBeTruthy()
        expect(journeyLink.classes()).toContain('bg-[#449dc6]/[0.27]')
    })

    it('renders an icon for each navigation item', () => {
        const wrapper = mountSidebar()

        expect(wrapper.findAll('[data-testid="icon"]').length).toBeGreaterThan(0)
    })
})