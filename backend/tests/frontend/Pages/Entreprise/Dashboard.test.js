import { mount } from '@vue/test-utils'
import { describe, expect, it, vi } from 'vitest'
import Dashboard from '@/Pages/Entreprise/Dashboard.vue'

vi.mock('@inertiajs/vue3', () => ({
    Head: {
        template: '<title><slot /></title>',
    },
}))

vi.mock('@/Layouts/EntrepriseLayout.vue', () => ({
    default: {
        template: '<div data-testid="entreprise-layout"><slot /></div>',
    },
}))

const mountPage = (props = {}) => {
    return mount(Dashboard, {
        props: {
            stats: {
                open_offers: 0,
                applicants: 0,
                accepted: 0,
                active_interns: 0,
            },
            recentApplicants: [],
            upcomingInterviews: [],
            ...props,
        },
    })
}

describe('Entreprise Dashboard', () => {
    it('renders the dashboard layout and welcome message', () => {
        const wrapper = mountPage()

        expect(
            wrapper.find('[data-testid="entreprise-layout"]').exists()
        ).toBe(true)

        expect(wrapper.text()).toContain('Welcome back!')
        expect(wrapper.text()).toContain('Manage your internship opportunities')
    })

    it('displays all dashboard statistics', () => {
        const wrapper = mountPage({
            stats: {
                open_offers: 5,
                applicants: 24,
                accepted: 8,
                active_interns: 6,
            },
        })

        expect(wrapper.text()).toContain('Open Internships')
        expect(wrapper.text()).toContain('5')

        expect(wrapper.text()).toContain('Total Applicants')
        expect(wrapper.text()).toContain('24')

        expect(wrapper.text()).toContain('Accepted Students')
        expect(wrapper.text()).toContain('8')

        expect(wrapper.text()).toContain('Current Interns')
        expect(wrapper.text()).toContain('6')
    })

    it('shows the empty state when there are no applicants', () => {
        const wrapper = mountPage({
            recentApplicants: [],
        })

        expect(wrapper.text()).toContain('No applications yet')
        expect(wrapper.text()).toContain(
            'New applications will appear here.'
        )
    })

    it('renders recent applicants when data is available', () => {
        const wrapper = mountPage({
            recentApplicants: [
                {
                    id: 1,
                    name: 'Stagiaire 1',
                    offer: 'Laravel Developer',
                    initials: 'S1',
                    status: 'Pending',
                },
                {
                    id: 2,
                    name: 'Stagiaire 2',
                    offer: 'Vue.js Developer',
                    initials: 'S2',
                    status: 'Accepted',
                },
            ],
        })

        expect(wrapper.text()).toContain('Stagiaire 1')
        expect(wrapper.text()).toContain('Laravel Developer')
        expect(wrapper.text()).toContain('Pending')

        expect(wrapper.text()).toContain('Stagiaire 2')
        expect(wrapper.text()).toContain('Vue.js Developer')
        expect(wrapper.text()).toContain('Accepted')

        expect(wrapper.text()).not.toContain('No applications yet')
    })

    it('shows the empty state when there are no upcoming interviews', () => {
        const wrapper = mountPage({
            upcomingInterviews: [],
        })

        expect(wrapper.text()).toContain('No interviews scheduled')
        expect(wrapper.text()).toContain(
            'Upcoming interviews will appear here.'
        )
    })

    it('renders upcoming interviews when data is available', () => {
        const wrapper = mountPage({
            upcomingInterviews: [
                {
                    id: 1,
                    student: 'Stagiaire 1',
                    date: '25 September 2026',
                },
                {
                    id: 2,
                    student: 'Stagiaire 2',
                    date: '28 September 2026',
                },
            ],
        })

        expect(wrapper.text()).toContain('Stagiaire 1')
        expect(wrapper.text()).toContain('25 September 2026')
        expect(wrapper.text()).toContain('Stagiaire 2')
        expect(wrapper.text()).toContain('28 September 2026')

        expect(wrapper.text()).not.toContain('No interviews scheduled')
    })

    it('renders the quick actions and applications overview', () => {
        const wrapper = mountPage()

        expect(wrapper.text()).toContain('Quick Actions')
        expect(wrapper.text()).toContain('+ Post Internship')
        expect(wrapper.text()).toContain('View Applicants')
        expect(wrapper.text()).toContain('Add Supervisor')
        expect(wrapper.text()).toContain('Company Profile')

        expect(wrapper.text()).toContain('Applications Overview')
        expect(wrapper.text()).toContain('Last 7 days')
        expect(wrapper.text()).toContain('Last 30 days')
        expect(wrapper.text()).toContain('Last 3 months')
    })
})