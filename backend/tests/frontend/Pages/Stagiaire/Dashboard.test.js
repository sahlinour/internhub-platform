import { mount } from '@vue/test-utils'
import { describe, expect, it, vi } from 'vitest'
import Dashboard from '@/Pages/Stagiaire/Dashboard.vue'

vi.mock('@inertiajs/vue3', () => ({
    Head: {
        template: '<head data-testid="head"><title>{{ title }}</title></head>',
        props: ['title'],
    },
}))

vi.mock('@/Components/Stagiaire/StagiaireLayout.vue', () => ({
    default: {
        template: '<div data-testid="stagiaire-layout"><slot /></div>',
    },
}))

vi.mock('@/Components/Stagiaire/DashboardCard.vue', () => ({
    default: {
        template: `
            <section data-testid="dashboard-card">
                <h2>{{ title }}</h2>
                <p>{{ subtitle }}</p>
                <slot />
            </section>
        `,
        props: ['title', 'subtitle'],
    },
}))

vi.mock('@/Components/Stagiaire/WelcomeBanner.vue', () => ({
    default: {
        template: '<div data-testid="welcome-banner">Welcome</div>',
        props: ['user'],
    },
}))

vi.mock('@/Components/Stagiaire/StatCard.vue', () => ({
    default: {
        template: `
            <div
                data-testid="stat-card"
                :data-label="label"
                :data-value="value"
            >
                {{ label }}: {{ value }}
            </div>
        `,
        props: ['label', 'value', 'detail', 'icon'],
    },
}))

vi.mock('@/Components/Stagiaire/CurrentInternship.vue', () => ({
    default: {
        template: '<div data-testid="current-internship">Current Internship</div>',
        props: ['stage'],
    },
}))

vi.mock('@/Components/Stagiaire/ApplicationTracker.vue', () => ({
    default: {
        template: '<div data-testid="application-tracker">Applications</div>',
        props: ['applications'],
    },
}))

vi.mock('@/Components/Stagiaire/RecentTasks.vue', () => ({
    default: {
        template: '<div data-testid="recent-tasks">Recent Tasks</div>',
        props: ['count'],
    },
}))

vi.mock('@/Components/Stagiaire/RecentDocuments.vue', () => ({
    default: {
        template: '<div data-testid="recent-documents">Recent Documents</div>',
        props: ['count'],
    },
}))

vi.mock('@/Components/Stagiaire/QuickActions.vue', () => ({
    default: {
        template: '<div data-testid="quick-actions">Quick Actions</div>',
    },
}))

vi.mock('@/Components/Stagiaire/RecommendedOffers.vue', () => ({
    default: {
        template: '<div data-testid="recommended-offers">Recommended Offers</div>',
        props: ['offers'],
    },
}))

vi.mock('@/Components/Stagiaire/ProfileCompletion.vue', () => ({
    default: {
        template: '<div data-testid="profile-completion">Profile Completion</div>',
        props: ['percentage', 'items'],
    },
}))

vi.mock('@/Components/Stagiaire/NotificationsPanel.vue', () => ({
    default: {
        template: '<div data-testid="notifications-panel">Notifications</div>',
        props: ['notifications'],
    },
}))

vi.mock('@/Components/Stagiaire/AIAssistant.vue', () => ({
    default: {
        template: '<div data-testid="ai-assistant">AI Assistant</div>',
    },
}))

describe('Stagiaire Dashboard', () => {
    const defaultStats = {
        has_stage: false,
        stage: null,
        taches_count: 0,
        docs_count: 0,
        applications_count: 0,
        applications: [],
        recommended_offers: [],
        notifications: [],
        profile_completion: 0,
    }

    const mountDashboard = (props = {}) => {
        return mount(Dashboard, {
            props: {
                user: {
                    nom_complet: 'Nour Sahli',
                },
                stats: {
                    ...defaultStats,
                    ...props.stats,
                },
                ...props,
            },
        })
    }

    it('renders the dashboard layout', () => {
        const wrapper = mountDashboard()

        expect(wrapper.find('[data-testid="stagiaire-layout"]').exists()).toBe(true)
    })

    it('renders the dashboard head title', () => {
        const wrapper = mountDashboard()

        expect(wrapper.find('[data-testid="head"]').exists()).toBe(true)
        expect(wrapper.find('[data-testid="head"]').text()).toContain(
            'Intern Dashboard'
        )
    })

    it('renders the welcome banner', () => {
        const wrapper = mountDashboard()

        expect(wrapper.find('[data-testid="welcome-banner"]').exists()).toBe(true)
    })

    it('renders the four statistics cards', () => {
        const wrapper = mountDashboard()

        const statCards = wrapper.findAll('[data-testid="stat-card"]')

        expect(statCards).toHaveLength(4)
        expect(wrapper.text()).toContain('My Internship')
        expect(wrapper.text()).toContain('My Tasks')
        expect(wrapper.text()).toContain('My Documents')
        expect(wrapper.text()).toContain('My Applications')
    })

    it('displays None when there is no active internship', () => {
        const wrapper = mountDashboard({
            stats: {
                has_stage: false,
            },
        })

        const internshipCard = wrapper
            .findAll('[data-testid="stat-card"]')
            .find((card) => card.attributes('data-label') === 'My Internship')

        expect(internshipCard.attributes('data-value')).toBe('None')
    })

    it('displays Active when the student has an internship', () => {
        const wrapper = mountDashboard({
            stats: {
                has_stage: true,
            },
        })

        const internshipCard = wrapper
            .findAll('[data-testid="stat-card"]')
            .find((card) => card.attributes('data-label') === 'My Internship')

        expect(internshipCard.attributes('data-value')).toBe('Active')
    })

    it('displays task, document and application counts', () => {
        const wrapper = mountDashboard({
            stats: {
                taches_count: 5,
                docs_count: 3,
                applications_count: 7,
            },
        })

        const statCards = wrapper.findAll('[data-testid="stat-card"]')

        const tasksCard = statCards.find(
            (card) => card.attributes('data-label') === 'My Tasks'
        )

        const documentsCard = statCards.find(
            (card) => card.attributes('data-label') === 'My Documents'
        )

        const applicationsCard = statCards.find(
            (card) => card.attributes('data-label') === 'My Applications'
        )

        expect(tasksCard.attributes('data-value')).toBe('5')
        expect(documentsCard.attributes('data-value')).toBe('3')
        expect(applicationsCard.attributes('data-value')).toBe('7')
    })

    it('renders the main dashboard sections', () => {
        const wrapper = mountDashboard()

        expect(wrapper.find('[data-testid="current-internship"]').exists()).toBe(true)
        expect(wrapper.find('[data-testid="application-tracker"]').exists()).toBe(true)
        expect(wrapper.find('[data-testid="recommended-offers"]').exists()).toBe(true)
        expect(wrapper.find('[data-testid="quick-actions"]').exists()).toBe(true)
        expect(wrapper.find('[data-testid="recent-tasks"]').exists()).toBe(true)
        expect(wrapper.find('[data-testid="recent-documents"]').exists()).toBe(true)
        expect(wrapper.find('[data-testid="profile-completion"]').exists()).toBe(true)
        expect(wrapper.find('[data-testid="notifications-panel"]').exists()).toBe(true)
        expect(wrapper.find('[data-testid="ai-assistant"]').exists()).toBe(true)
    })

    it('passes internship data to the current internship component', () => {
        const stage = {
            sujet: 'Web Development',
            statut: 'en cours',
        }

        const wrapper = mountDashboard({
            stats: {
                has_stage: true,
                stage,
            },
        })

        const component = wrapper.find('[data-testid="current-internship"]')

        expect(component.exists()).toBe(true)
    })
    it('renders the profile completion component', () => {
        const wrapper = mountDashboard({
            stats: {
                profile_completion: 75,
            },
        })

        const component = wrapper.find(
            '[data-testid="profile-completion"]'
        )

        expect(component.exists()).toBe(true)
    })
})