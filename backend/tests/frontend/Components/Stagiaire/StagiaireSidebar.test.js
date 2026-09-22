import { mount } from '@vue/test-utils'
import { describe, expect, it, vi } from 'vitest'
import StagiaireSidebar from '@/Components/Stagiaire/StagiaireSidebar.vue'

vi.mock('@inertiajs/vue3', () => ({
    Link: {
        template: '<a><slot /></a>',
        props: ['href', 'method', 'as'],
    },

    usePage: vi.fn(() => ({
        props: {
            auth: {
                user: {
                    nom_complet: 'Nour Sahli',
                },
            },
        },
    })),
}))

vi.mock('@/Components/Stagiaire/SidebarMenu.vue', () => ({
    default: {
        template: '<nav data-testid="sidebar-menu">Sidebar menu</nav>',
    },
}))

describe('Stagiaire Sidebar', () => {
    it('displays the student full name', () => {
        const wrapper = mount(StagiaireSidebar, {
            global: {
                mocks: {
                    route: () => '/logout',
                },
            },
        })

        expect(wrapper.text()).toContain('Nour Sahli')
    })

    it('generates the correct initials from the full name', () => {
        const wrapper = mount(StagiaireSidebar, {
            global: {
                mocks: {
                    route: () => '/logout',
                },
            },
        })

        expect(wrapper.text()).toContain('NS')
    })

    it('displays the Student fallback when no name exists', async () => {
        const { usePage } = await import('@inertiajs/vue3')

        vi.mocked(usePage).mockReturnValue({
            props: {
                auth: {
                    user: {},
                },
            },
        })

        const wrapper = mount(StagiaireSidebar, {
            global: {
                mocks: {
                    route: () => '/logout',
                },
            },
        })

        expect(wrapper.text()).toContain('Student')
        expect(wrapper.text()).toContain('S')
    })

    it('renders the sidebar menu', () => {
        const wrapper = mount(StagiaireSidebar, {
            global: {
                mocks: {
                    route: () => '/logout',
                },
            },
        })

        expect(
            wrapper.find('[data-testid="sidebar-menu"]').exists()
        ).toBe(true)
    })

    it('renders the logout button', () => {
        const wrapper = mount(StagiaireSidebar, {
            global: {
                mocks: {
                    route: () => '/logout',
                },
            },
        })

        expect(wrapper.text()).toContain('Log out')
    })
})