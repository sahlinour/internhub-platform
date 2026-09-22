import { mount } from '@vue/test-utils'
import { beforeEach, describe, expect, it, vi } from 'vitest'
import { router } from '@inertiajs/vue3'
import Dashboard from '@/Pages/Encadrant/Dashboard.vue'

vi.mock('@inertiajs/vue3', () => ({
    Head: {
        template: '<title><slot /></title>',
    },

    Link: {
        name: 'Link',
        props: ['href'],
        template: '<a :href="href"><slot /></a>',
    },

    router: {
        get: vi.fn(),
    },
}))

vi.mock('@/Layouts/EncadrantLayout.vue', () => ({
    default: {
        template: '<div data-testid="encadrant-layout"><slot /></div>',
    },
}))

vi.mock('@/Components/Encadrant/StatCard.vue', () => ({
    default: {
        name: 'StatCard',
        props: ['title', 'value', 'subtitle', 'icon', 'variant'],
        template: `
            <div data-testid="stat-card">
                <span>{{ title }}</span>
                <span>{{ value }}</span>
                <span>{{ subtitle }}</span>
            </div>
        `,
    },
}))

vi.mock('@/Components/Encadrant/StagiaireCard.vue', () => ({
    default: {
        name: 'StagiaireCard',
        props: ['stagiaire'],
        template: `
            <div data-testid="stagiaire-card">
                {{ stagiaire.name }}
            </div>
        `,
    },
}))

vi.mock('@/Components/Encadrant/RecentActivity.vue', () => ({
    default: {
        name: 'RecentActivity',
        props: ['activities'],
        template: '<div data-testid="recent-activity">Recent Activity</div>',
    },
}))

vi.mock('@/Components/Encadrant/PendingTaskReviews.vue', () => ({
    default: {
        name: 'PendingTaskReviews',
        props: ['tasks'],
        emits: ['review'],
        template: `
            <div data-testid="pending-task-reviews">
                <button
                    v-for="task in tasks"
                    :key="task.id"
                    @click="$emit('review', task)"
                >
                    Review
                </button>
            </div>
        `,
    },
}))

const routeMock = vi.fn((name) => `/${name}`)
global.route = routeMock
const mountPage = (props = {}) => {
    return mount(Dashboard, {
        props: {
            encadrant: {
                id: 1,
                name: 'Ahmed Supervisor',
            },
            stats: {
                stagiaires: 4,
                pendingReviews: 3,
                meetings: 2,
                averageProgress: 75,
            },
            stagiaires: [],
            activities: [],
            pendingTasks: [],
            ...props,
        },
        global: {
            mocks: {
                route: routeMock,
            },
        },
    })
}

describe('Encadrant Dashboard', () => {
    beforeEach(() => {
        vi.clearAllMocks()
    })

    it('renders the dashboard layout and welcome message', () => {
        const wrapper = mountPage()

        expect(
            wrapper.find('[data-testid="encadrant-layout"]').exists()
        ).toBe(true)

        expect(wrapper.text()).toContain('Supervisor Dashboard')
        expect(wrapper.text()).toContain(
            'Welcome back, Ahmed Supervisor'
        )
    })

    it('displays the supervisor statistics', () => {
        const wrapper = mountPage()

        const cards = wrapper.findAll('[data-testid="stat-card"]')

        expect(cards).toHaveLength(4)
        expect(wrapper.text()).toContain('Assigned students')
        expect(wrapper.text()).toContain('4')
        expect(wrapper.text()).toContain('Tasks to review')
        expect(wrapper.text()).toContain('3')
        expect(wrapper.text()).toContain('Upcoming meetings')
        expect(wrapper.text()).toContain('2')
        expect(wrapper.text()).toContain('Average progress')
        expect(wrapper.text()).toContain('75%')
    })

    it('shows the empty state when no students are assigned', () => {
        const wrapper = mountPage({
            stagiaires: [],
        })

        expect(wrapper.text()).toContain('No students assigned')
        expect(wrapper.text()).toContain(
            'Students assigned to you will appear here.'
        )
    })

    it('renders assigned students when data is available', () => {
        const wrapper = mountPage({
            stagiaires: [
                {
                    id: 1,
                    name: 'Student One',
                },
                {
                    id: 2,
                    name: 'Student Two',
                },
            ],
        })

        const cards = wrapper.findAll('[data-testid="stagiaire-card"]')

        expect(cards).toHaveLength(2)
        expect(wrapper.text()).toContain('Student One')
        expect(wrapper.text()).toContain('Student Two')
        expect(wrapper.text()).not.toContain('No students assigned')
    })

    it('passes activities and pending tasks to their components', () => {
        const activities = [
            {
                id: 1,
                title: 'Document submitted',
            },
        ]

        const pendingTasks = [
            {
                id: 10,
                title: 'Review project task',
            },
        ]

        const wrapper = mountPage({
            activities,
            pendingTasks,
        })

        const activity = wrapper.findComponent({
            name: 'RecentActivity',
        })

        const reviews = wrapper.findComponent({
            name: 'PendingTaskReviews',
        })

        expect(activity.exists()).toBe(true)
        expect(reviews.exists()).toBe(true)

        expect(activity.props('activities')).toEqual(activities)
        expect(reviews.props('tasks')).toEqual(pendingTasks)
    })

    it('navigates to task reviews when a task is reviewed', async () => {
        const pendingTask = {
            id: 10,
            title: 'Review project task',
        }

        const wrapper = mountPage({
            pendingTasks: [pendingTask],
        })

        const reviews = wrapper.findComponent({
            name: 'PendingTaskReviews',
        })

        expect(reviews.exists()).toBe(true)

        await reviews.find('button').trigger('click')

        expect(router.get).toHaveBeenCalledWith(
            '/encadrant.task-reviews.index',
            {
                task_id: 10,
            },
            {
                preserveScroll: true,
                preserveState: false,
            }
        )
    })

    it('renders the main dashboard sections', () => {
        const wrapper = mountPage()

        expect(wrapper.text()).toContain('Assigned students')
        expect(wrapper.text()).toContain('Tasks to review')
        expect(wrapper.text()).toContain('Review tasks')
        expect(wrapper.text()).toContain('View students')
        expect(wrapper.text()).toContain('Recent Activity')
    })
})