import { mount } from '@vue/test-utils'
import { describe, expect, it } from 'vitest'
import Icon from '@/Components/Stagiaire/Icon.vue'

describe('Stagiaire Icon', () => {
    it('renders the SVG correctly', () => {
        const wrapper = mount(Icon, {
            props: {
                name: 'dashboard',
            },
        })

        expect(wrapper.find('svg').exists()).toBe(true)
    })

    it('uses the default size of 18', () => {
        const wrapper = mount(Icon, {
            props: {
                name: 'dashboard',
            },
        })

        const svg = wrapper.find('svg')

        expect(svg.attributes('width')).toBe('18')
        expect(svg.attributes('height')).toBe('18')
    })

    it('accepts a custom size', () => {
        const wrapper = mount(Icon, {
            props: {
                name: 'tasks',
                size: 24,
            },
        })

        const svg = wrapper.find('svg')

        expect(svg.attributes('width')).toBe('24')
        expect(svg.attributes('height')).toBe('24')
    })

    it('renders the dashboard icon', () => {
        const wrapper = mount(Icon, {
            props: {
                name: 'dashboard',
            },
        })

        expect(wrapper.findAll('rect')).toHaveLength(4)
    })

    it('renders the tasks icon', () => {
        const wrapper = mount(Icon, {
            props: {
                name: 'tasks',
            },
        })

        expect(wrapper.findAll('path')).toHaveLength(2)
    })

    it('renders the profile icon', () => {
        const wrapper = mount(Icon, {
            props: {
                name: 'user',
            },
        })

        expect(wrapper.find('circle').exists()).toBe(true)
        expect(wrapper.find('path').exists()).toBe(true)
    })
})