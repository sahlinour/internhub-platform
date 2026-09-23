import { mount } from '@vue/test-utils'
import { describe, expect, it, vi } from 'vitest'
import StagiaireLayout from '@/Components/Stagiaire/StagiaireLayout.vue'

vi.mock('@/Components/Stagiaire/StagiaireSidebar.vue', () => ({
    default: {
        template: '<aside data-testid="stagiaire-sidebar">Sidebar</aside>',
    },
}))

vi.mock('@/Components/Stagiaire/StagiaireTopbar.vue', () => ({
    default: {
        template: '<header data-testid="stagiaire-topbar">Topbar</header>',
    },
}))

vi.mock('@/Components/Stagiaire/AI/Chatboot/ChatbotWidget.vue', () => ({
    default: {
        template: '<div data-testid="chatbot-widget">Chatbot</div>',
    },
}))

describe('Stagiaire Layout', () => {
    it('renders the sidebar', () => {
        const wrapper = mount(StagiaireLayout)

        expect(wrapper.find('[data-testid="stagiaire-sidebar"]').exists()).toBe(true)
    })

    it('renders the topbar', () => {
        const wrapper = mount(StagiaireLayout)

        expect(wrapper.find('[data-testid="stagiaire-topbar"]').exists()).toBe(true)
    })

    it('renders the chatbot widget', () => {
        const wrapper = mount(StagiaireLayout)

        expect(wrapper.find('[data-testid="chatbot-widget"]').exists()).toBe(true)
    })

    it('renders page content through the slot', () => {
        const wrapper = mount(StagiaireLayout, {
            slots: {
                default: '<div data-testid="page-content">Dashboard content</div>',
            },
        })

        expect(wrapper.find('[data-testid="page-content"]').exists()).toBe(true)
        expect(wrapper.text()).toContain('Dashboard content')
    })

    it('applies the main layout classes', () => {
        const wrapper = mount(StagiaireLayout)

        const root = wrapper.find('div')
        const mainContainer = wrapper.find('div.ml-\\[230px\\]')
        const main = wrapper.find('main')

        expect(root.classes()).toContain('min-h-screen')
        expect(root.classes()).toContain('bg-[#f4f7fb]')

        expect(mainContainer.exists()).toBe(true)
        expect(mainContainer.classes()).toContain('min-h-screen')

        expect(main.exists()).toBe(true)
        expect(main.classes()).toContain('min-w-0')
    })
})