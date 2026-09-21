<script setup>
import ChatbotEmojiPicker from './ChatbotEmojiPicker.vue'

defineProps({
    modelValue: {
        type: String,
        required: true
    },

    isTyping: {
        type: Boolean,
        default: false
    },

    showEmojiPicker: {
        type: Boolean,
        default: false
    },

    emojis: {
        type: Array,
        required: true
    }
})

const emit = defineEmits([
    'update:modelValue',
    'send',
    'toggleEmoji',
    'selectEmoji'
])

function updateValue(event) {
    emit('update:modelValue', event.target.value)
}
</script>

<template>
    <div
        class="relative
               border-t border-[#E2E8F0]
               bg-white px-3 py-3 shrink-0"
    >

        <!-- Emoji picker -->
        <ChatbotEmojiPicker
            v-if="showEmojiPicker"
            :emojis="emojis"
            @select="emit('selectEmoji', $event)"
        />

        <div class="flex items-center gap-2">

            <!-- Emoji -->
            <button
                type="button"
                @click="emit('toggleEmoji')"
                class="flex h-9 w-9 shrink-0
                       items-center justify-center
                       rounded-full
                       text-[#64748B]
                       transition
                       hover:bg-[#E8F1F5]
                       hover:text-[#16425B]"
                aria-label="Emojis"
            >
                <svg
                    width="19"
                    height="19"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <circle cx="12" cy="12" r="10" />

                    <path
                        stroke-linecap="round"
                        d="M8 14s1.5 2 4 2 4-2 4-2"
                    />

                    <line
                        x1="9"
                        y1="9"
                        x2="9.01"
                        y2="9"
                        stroke-linecap="round"
                        stroke-width="2.5"
                    />

                    <line
                        x1="15"
                        y1="9"
                        x2="15.01"
                        y2="9"
                        stroke-linecap="round"
                        stroke-width="2.5"
                    />
                </svg>
            </button>

            <!-- Input -->
            <input
                :value="modelValue"
                @input="updateValue"
                @keyup.enter="$emit('send')"
                :disabled="isTyping"
                type="text"
                placeholder="Ask Sonic something..."
                class="min-w-0 flex-1
                       rounded-full
                       border border-transparent
                       bg-[#F4F7F9]
                       px-4 py-2.5
                       text-[12px]
                       text-[#334155]
                       outline-none
                       placeholder:text-[#94A3B8]
                       focus:border-[#81C3D7]
                       focus:bg-white
                       focus:ring-2
                       focus:ring-[#81C3D7]/20
                       disabled:opacity-50"
            />

            <!-- Send -->
            <button
                type="button"
                @click="emit('send')"
                :disabled="!modelValue.trim() || isTyping"
                class="flex h-9 w-9 shrink-0
                       items-center justify-center
                       rounded-full
                       bg-[#16425B]
                       text-white
                       transition
                       hover:bg-[#2F6690]
                       disabled:cursor-not-allowed
                       disabled:opacity-35"
                aria-label="Send message"
            >
                <svg
                    width="15"
                    height="15"
                    viewBox="0 0 24 24"
                    fill="currentColor"
                >
                    <path d="M2 21l21-9L2 3v7l15 2-15 2z" />
                </svg>
            </button>

        </div>

        <p
            class="mt-2 text-center
                   text-[8px] font-medium
                   text-[#94A3B8]"
        >
            Sonic can help you with internships and career questions.
        </p>

    </div>
</template>