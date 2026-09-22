<script setup>
import {ref,reactive,nextTick,onMounted,onUnmounted} from 'vue'
import ChatbotHeader from './ChatbotHeader.vue'
import ChatbotMessage from './ChatbotMessage.vue'
import ChatbotTyping from './ChatbotTyping.vue'
import ChatbotInput from './ChatbotInput.vue'

const isOpen = ref(false)
const inputText = ref('')
const isTyping = ref(false)
const showEmojiPicker = ref(false)

const messagesContainer = ref(null)
const emojiPickerRef = ref(null)
const emojiBtnRef = ref(null)

const API_URL = 'http://localhost:8001/api/chat'

const REQUEST_TIMEOUT = 60000

const messages = reactive([
    {
        id: 1,
        role: 'bot',
        text: "Hi 👋 I'm Sonic, your AI assistant. How can I help you today?",
        time: new Date()
    }
])

const quickEmojis = [
    '😀', '😂', '😍', '👍',
    '🙏', '🎉', '🔥', '❤️',
    '👏', '🤔', '😎', '✅',
    '❌', '💡', '🤖', '😢'
]

function scrollToBottom() {
    nextTick(() => {
        const container = messagesContainer.value

        if (container) {
            container.scrollTop = container.scrollHeight
        }
    })
}

function toggleChat() {
    isOpen.value = !isOpen.value

    if (isOpen.value) {
        showEmojiPicker.value = false
        scrollToBottom()
    }
}

function insertEmoji(emoji) {
    inputText.value += emoji
    showEmojiPicker.value = false
}

async function sendMessage() {
    const text = inputText.value.trim()

    if (!text || isTyping.value) {
        return
    }

    messages.push({
        id: `${Date.now()}-user`,
        role: 'user',
        text,
        time: new Date()
    })

    inputText.value = ''
    showEmojiPicker.value = false

    scrollToBottom()

    isTyping.value = true

    const controller = new AbortController()

    const timeout = setTimeout(() => {
        controller.abort()
    }, REQUEST_TIMEOUT)

    try {
        const response = await fetch(API_URL, {
            method: 'POST',

            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },

            body: JSON.stringify({
                messages: [
                    {
                        role: 'user',
                        content: text
                    }
                ]
            }),

            signal: controller.signal
        })

        let data

        try {
            data = await response.json()
        } catch {
            throw new Error('Invalid response from FastAPI')
        }

        if (!response.ok) {
            throw new Error(
                data?.detail ||
                `FastAPI returned ${response.status}`
            )
        }

        const reply =
            data?.reply ||
            data?.response ||
            data?.message

        if (!reply || !reply.trim()) {
            throw new Error('Sonic returned an empty response')
        }

        messages.push({
            id: `${Date.now()}-bot`,
            role: 'bot',
            text: reply.trim(),
            time: new Date()
        })

    } catch (error) {

        console.error('Sonic AI error:', error)

        let errorMessage =
            '❌ Sorry, Sonic could not answer right now.'

        if (error.name === 'AbortError') {
            errorMessage =
                '⏱️ Sonic is taking too long to respond. Please try again.'
        } else if (error.message) {
            console.error(
                'FastAPI details:',
                error.message
            )

            errorMessage = `❌ ${error.message}`
        }

        messages.push({
            id: `${Date.now()}-error`,
            role: 'bot',
            text: errorMessage,
            time: new Date()
        })

    } finally {

        clearTimeout(timeout)

        isTyping.value = false

        scrollToBottom()
    }
}

function handleClickOutside(event) {
    if (!showEmojiPicker.value) {
        return
    }

    const picker = emojiPickerRef.value
    const button = emojiBtnRef.value

    if (
        picker &&
        !picker.contains(event.target) &&
        button &&
        !button.contains(event.target)
    ) {
        showEmojiPicker.value = false
    }
}

onMounted(() => {
    document.addEventListener(
        'click',
        handleClickOutside
    )
})

onUnmounted(() => {
    document.removeEventListener(
        'click',
        handleClickOutside
    )
})
</script>

<template>
    <div
        class="fixed bottom-5 right-5 z-[60]
               sm:bottom-6 sm:right-6"
    >

        <!-- FLOATING BUTTON -->
        <button
            v-if="!isOpen"
            type="button"
            @click="toggleChat"
            class="group relative
                   flex h-14 w-14
                   items-center justify-center
                   rounded-full
                   bg-gradient-to-br
                   from-[#16425B] to-[#2F6690]
                   shadow-[0_8px_25px_rgba(22,66,91,0.28)]
                   ring-4 ring-white
                   transition-all duration-200
                   hover:scale-105
                   hover:shadow-[0_10px_30px_rgba(22,66,91,0.35)]
                   active:scale-95"
            aria-label="Open Sonic AI assistant"
        >

            <!-- Soft pulse -->
            <span
                class="absolute inset-0
                       rounded-full
                       bg-[#81C3D7]
                       opacity-20
                       animate-ping"
            ></span>

            <!-- Sonic AI image -->
            <img
                 src="http://localhost:8000/images/sonic.png"
                alt="Sonic AI"
                class="relative h-9 w-9 object-contain"
            />

        </button>


        <!-- CHAT WINDOW -->
        <transition
            enter-active-class="transition duration-200 ease-out"
            enter-from-class="opacity-0 translate-y-3 scale-[0.97]"
            enter-to-class="opacity-100 translate-y-0 scale-100"
            leave-active-class="transition duration-150 ease-in"
            leave-from-class="opacity-100 translate-y-0 scale-100"
            leave-to-class="opacity-0 translate-y-3 scale-[0.97]"
        >

            <div
                v-if="isOpen"
                class="fixed inset-x-3 bottom-3
                       flex h-[min(650px,calc(100vh-24px))]
                       flex-col overflow-hidden
                       rounded-2xl
                       border border-[#DCE5EA]
                       bg-white
                       shadow-[0_20px_60px_rgba(22,66,91,0.20)]
                       sm:static
                       sm:h-[580px]
                       sm:w-[370px]"
            >

                <!-- HEADER -->
                <ChatbotHeader
                    @close="toggleChat"
                />


                <!-- MESSAGES -->
                <div
                    ref="messagesContainer"
                    class="flex-1
                           overflow-y-auto
                           bg-[#F4F7F9]
                           px-3.5 py-4"
                >

                    <div
                        class="space-y-4"
                    >

                        <ChatbotMessage
                            v-for="message in messages"
                            :key="message.id"
                            :message="message"
                        />

                        <ChatbotTyping
                            v-if="isTyping"
                        />

                    </div>

                </div>


                <!-- INPUT -->
                <ChatbotInput
                    v-model="inputText"
                    :is-typing="isTyping"
                    :show-emoji-picker="showEmojiPicker"
                    :emojis="quickEmojis"
                    @send="sendMessage"
                    @toggle-emoji="
                        showEmojiPicker = !showEmojiPicker
                    "
                    @select-emoji="insertEmoji"
                />

            </div>

        </transition>

    </div>
</template>

<style scoped>
div::-webkit-scrollbar {
    width: 4px;
}

div::-webkit-scrollbar-track {
    background: transparent;
}

div::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 999px;
}

div::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}
</style>