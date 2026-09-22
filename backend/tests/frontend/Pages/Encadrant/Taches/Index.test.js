import { mount } from '@vue/test-utils'
import { beforeEach, describe, expect, it, vi } from 'vitest'
import { router } from '@inertiajs/vue3'
import Index from '@/Pages/Encadrant/Taches/Index.vue'

vi.mock('@inertiajs/vue3', () => ({
    Head: {
        template: '<title><slot /></title>',
    },

    Link: {
        name: 'Link',
        props: ['href', 'preserveScroll'],
        template: '<a :href="href"><slot /></a>',
    },

    router: {
        delete: vi.fn(),
    },
}))

vi.mock('@/Layouts/EncadrantLayout.vue', () => ({
    default: {
        template: '<div data-testid="encadrant-layout"><slot /></div>',
    },
}))

const routeMock = vi.fn((name, params) => {
    if (params?.id) {
        return `/${name}/${params.id}`
    }

    return `/${name}`
})

global.route = routeMock

const mountPage = (props = {}) => {
    return mount(Index, {
        props: {
            taches: {
                data: [],
                links: [],
            },
            stages: [],
            filters: {},
            ...props,
        },
        global: {
            mocks: {
                route: routeMock,
            },
        },
    })
}

describe('Encadrant Tasks Index', () => {
    beforeEach(() => {
        vi.clearAllMocks()

        global.confirm = vi.fn(() => true)
    })

    it('renders the page layout and header', () => {
        const wrapper = mountPage()

        expect(
            wrapper.find('[data-testid="encadrant-layout"]').exists()
        ).toBe(true)

        expect(wrapper.text()).toContain('Assign Tasks')
        expect(wrapper.text()).toContain(
            'Create and manage tasks assigned to your interns.'
        )
        expect(wrapper.text()).toContain('Assign New Task')
    })

    it('shows the empty state when there are no tasks', () => {
        const wrapper = mountPage({
            taches: {
                data: [],
                links: [],
            },
        })

        expect(wrapper.text()).toContain('No tasks assigned yet')
        expect(wrapper.text()).toContain(
            'Start by assigning a task to one of your interns.'
        )
        expect(wrapper.text()).toContain('Assign Task')

        expect(wrapper.find('table').exists()).toBe(false)
    })

    it('renders tasks in the table', () => {
        const wrapper = mountPage({
            taches: {
                data: [
                    {
                        id: 1,
                        titre: 'Create Laravel API',
                        description: 'Build the internship API',
                        priorite: 'High',
                        date_echeance: '2026-09-30',
                        statut: 'In Progress',
                        stage: {
                            candidature: {
                                stagiaire: {
                                    user: {
                                        nom_complet: 'Student One',
                                    },
                                },
                            },
                        },
                    },
                    {
                        id: 2,
                        titre: 'Prepare documentation',
                        description: 'Write project documentation',
                        priorite: 'Medium',
                        date_echeance: '2026-10-05',
                        statut: 'Pending',
                        stage: {
                            candidature: {
                                stagiaire: {
                                    user: {
                                        nom_complet: 'Student Two',
                                    },
                                },
                            },
                        },
                    },
                ],
                links: [],
            },
        })

        expect(wrapper.find('table').exists()).toBe(true)

        expect(wrapper.text()).toContain('Create Laravel API')
        expect(wrapper.text()).toContain('Build the internship API')
        expect(wrapper.text()).toContain('Student One')
        expect(wrapper.text()).toContain('High')
        expect(wrapper.text()).toContain('2026-09-30')
        expect(wrapper.text()).toContain('In Progress')

        expect(wrapper.text()).toContain('Prepare documentation')
        expect(wrapper.text()).toContain('Student Two')
        expect(wrapper.text()).toContain('Medium')
        expect(wrapper.text()).toContain('Pending')
    })

    it('uses a dash when intern information is missing', () => {
        const wrapper = mountPage({
            taches: {
                data: [
                    {
                        id: 1,
                        titre: 'Task without intern',
                        priorite: null,
                        date_echeance: null,
                        statut: null,
                        stage: null,
                    },
                ],
                links: [],
            },
        })

        expect(wrapper.text()).toContain('Task without intern')
        expect(wrapper.text()).toContain('—')
        expect(wrapper.text()).toContain('Unknown')
    })

    it('applies the correct priority and status classes', () => {
        const wrapper = mountPage({
            taches: {
                data: [
                    {
                        id: 1,
                        titre: 'Urgent task',
                        priorite: 'Urgent',
                        date_echeance: '2026-09-30',
                        statut: 'Completed',
                        stage: null,
                    },
                ],
                links: [],
            },
        })

        const row = wrapper.find('tbody tr')

        const priorityCell = row.findAll('td')[2]
        const statusSpan = row.find('td:nth-child(5) span')

        expect(priorityCell.classes()).toContain('text-red-600')
        expect(statusSpan.classes()).toContain('bg-emerald-50')
        expect(statusSpan.classes()).toContain('text-emerald-700')
    })

    it('renders pagination when there are more than three links', () => {
        const wrapper = mountPage({
            taches: {
                data: [
                    {
                        id: 1,
                        titre: 'Paginated task',
                        priorite: 'Low',
                        date_echeance: '2026-09-30',
                        statut: 'Pending',
                        stage: null,
                    },
                ],
                links: [
                    {
                        label: '&laquo; Previous',
                        url: null,
                        active: false,
                    },
                    {
                        label: '1',
                        url: '/encadrant/taches?page=1',
                        active: true,
                    },
                    {
                        label: '2',
                        url: '/encadrant/taches?page=2',
                        active: false,
                    },
                    {
                        label: 'Next &raquo;',
                        url: '/encadrant/taches?page=2',
                        active: false,
                    },
                ],
            },
        })

        const paginationLinks = wrapper.findAll('a')

        expect(paginationLinks.length).toBeGreaterThan(3)
        expect(wrapper.text()).toContain('Previous')
        expect(wrapper.text()).toContain('Next')
    })

    it('deletes a task after confirmation', async () => {
        const wrapper = mountPage({
            taches: {
                data: [
                    {
                        id: 15,
                        titre: 'Task to delete',
                        priorite: 'Low',
                        date_echeance: '2026-09-30',
                        statut: 'Pending',
                        stage: null,
                    },
                ],
                links: [],
            },
        })

        const deleteButton = wrapper
            .findAll('button')
            .find((button) => button.text() === 'Delete')

        expect(deleteButton).toBeTruthy()

        await deleteButton.trigger('click')

        expect(global.confirm).toHaveBeenCalledWith(
            'Are you sure you want to delete "Task to delete"?'
        )

        expect(router.delete).toHaveBeenCalledWith(
            '/encadrant.taches.destroy/15',
            {
                preserveScroll: true,
            }
        )
    })

    it('does not delete a task when confirmation is cancelled', async () => {
        global.confirm = vi.fn(() => false)

        const wrapper = mountPage({
            taches: {
                data: [
                    {
                        id: 20,
                        titre: 'Cancelled deletion',
                        priorite: 'Low',
                        date_echeance: '2026-09-30',
                        statut: 'Pending',
                        stage: null,
                    },
                ],
                links: [],
            },
        })

        const deleteButton = wrapper
            .findAll('button')
            .find((button) => button.text() === 'Delete')

        await deleteButton.trigger('click')

        expect(global.confirm).toHaveBeenCalled()
        expect(router.delete).not.toHaveBeenCalled()
    })
})