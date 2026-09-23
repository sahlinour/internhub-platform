import { mount } from '@vue/test-utils'
import { describe, expect, it } from 'vitest'
import { defineComponent } from 'vue'

describe('Example Vue Test', () => {
    it('renders a Vue component correctly', () => {
        const component = defineComponent({
            template: '<div>Hello InternHub</div>',
        })

        const wrapper = mount(component)

        expect(wrapper.text()).toBe('Hello InternHub')
    })
})