<template>
  <div
    class="fixed z-50 bottom-4 right-4 sm:bottom-6 sm:right-6"
    :style="{
      '--primary': '#6C5CE7',
      '--primary-dark': '#5849C2',
      '--accent': '#17C3B2',
      '--ink': '#12142B'
    }"
  >
    <!-- Floating action button -->
    <button
      v-if="!isOpen"
      @click="toggleChat"
      class="relative w-16 h-16 rounded-full bg-[var(--primary)] shadow-lg shadow-[var(--primary)]/40 flex items-center justify-center text-3xl hover:scale-105 active:scale-95 transition-transform"
      aria-label="Open chat"
    >
      <span class="absolute inset-0 rounded-full bg-[var(--primary)] animate-ping opacity-30"></span>
      <span class="relative">🤖</span>
    </button>

    <!-- Chat window -->
    <transition
      enter-active-class="transition duration-200 ease-out"
      enter-from-class="opacity-0 scale-95 translate-y-2"
      enter-to-class="opacity-100 scale-100 translate-y-0"
      leave-active-class="transition duration-150 ease-in"
      leave-from-class="opacity-100 scale-100"
      leave-to-class="opacity-0 scale-95"
    >
      <div
        v-if="isOpen"
        class="fixed inset-0 sm:static sm:w-[380px] sm:h-[600px] sm:max-h-[80vh] bg-white sm:rounded-3xl shadow-2xl flex flex-col overflow-hidden border border-[#E6E7F5]"
      >
        <!-- Header -->
        <div class="flex items-center justify-between px-5 py-4 bg-[var(--ink)] shrink-0">
          <div class="flex items-center gap-3">
            <div class="relative w-10 h-10 rounded-full bg-gradient-to-br from-[var(--primary)] to-[var(--accent)] flex items-center justify-center text-xl">
              🤖
              <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 rounded-full bg-[var(--accent)] border-2 border-[var(--ink)]"></span>
            </div>
            <div>
              <p class="text-white font-semibold text-sm leading-tight">Rose</p>
              <p class="text-[#8B90AD] text-xs">Online</p>
            </div>
          </div>
          <button @click="toggleChat" class="text-[#8B90AD] hover:text-white transition-colors" aria-label="Close chat">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
              <line x1="18" y1="6" x2="6" y2="18" /><line x1="6" y1="6" x2="18" y2="18" />
            </svg>
          </button>
        </div>

        <!-- Messages -->
        <div ref="messagesContainer" class="flex-1 overflow-y-auto px-4 py-4 space-y-3 bg-[#F7F7FC]">
          <div v-for="msg in messages" :key="msg.id" class="flex" :class="msg.role === 'user' ? 'justify-end' : 'justify-start'">
            <!-- Bot message -->
            <div v-if="msg.role === 'bot'" class="flex items-end gap-2 max-w-[80%]">
              <span class="text-lg mb-1 shrink-0">🤖</span>
              <div>
                <div class="bg-white border-l-2 border-[var(--accent)] rounded-2xl rounded-bl-md px-4 py-2.5 text-sm text-[#1E1F3B] shadow-sm">
                  {{ msg.text }}
                </div>
                <p class="text-[10px] text-[#A3A7C2] mt-1 ml-1">{{ formatTime(msg.time) }}</p>
              </div>
            </div>
            <!-- User message -->
            <div v-else class="max-w-[80%]">
              <div class="bg-gradient-to-br from-[var(--primary)] to-[var(--primary-dark)] text-white rounded-2xl rounded-br-md px-4 py-2.5 text-sm shadow-sm">
                {{ msg.text }}
              </div>
              <p class="text-[10px] text-[#A3A7C2] mt-1 mr-1 text-right">{{ formatTime(msg.time) }}</p>
            </div>
          </div>

          <!-- Typing indicator -->
          <div v-if="isTyping" class="flex items-end gap-2">
            <span class="text-lg mb-1">🤖</span>
            <div class="bg-white border-l-2 border-[var(--accent)] rounded-2xl rounded-bl-md px-4 py-3 shadow-sm flex gap-1">
              <span class="w-1.5 h-1.5 rounded-full bg-[#A3A7C2] animate-bounce" style="animation-delay:0ms"></span>
              <span class="w-1.5 h-1.5 rounded-full bg-[#A3A7C2] animate-bounce" style="animation-delay:150ms"></span>
              <span class="w-1.5 h-1.5 rounded-full bg-[#A3A7C2] animate-bounce" style="animation-delay:300ms"></span>
            </div>
          </div>
        </div>

        <!-- Input area -->
        <div class="relative border-t border-[#E6E7F5] bg-white px-3 py-3 shrink-0">
          <!-- Emoji picker -->
          <div
            v-if="showEmojiPicker"
            ref="emojiPickerRef"
            class="absolute bottom-full left-3 mb-2 bg-white border border-[#E6E7F5] rounded-2xl shadow-xl p-3 grid grid-cols-6 gap-1 w-64"
          >
            <button
              v-for="emoji in quickEmojis"
              :key="emoji"
              @click="insertEmoji(emoji)"
              class="text-xl hover:bg-[#F3F4FA] rounded-lg p-1.5 transition-colors"
            >{{ emoji }}</button>
          </div>

          <div class="flex items-center gap-2">
            <button
              ref="emojiBtnRef"
              @click="showEmojiPicker = !showEmojiPicker"
              class="shrink-0 w-9 h-9 rounded-full flex items-center justify-center text-[#767B99] hover:bg-[#F3F4FA] transition-colors"
              aria-label="Emojis"
            >
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10" />
                <path stroke-linecap="round" d="M8 14s1.5 2 4 2 4-2 4-2" />
                <line x1="9" y1="9" x2="9.01" y2="9" stroke-linecap="round" stroke-width="2.5" />
                <line x1="15" y1="9" x2="15.01" y2="9" stroke-linecap="round" stroke-width="2.5" />
              </svg>
            </button>

            <input
              v-model="inputText"
              @keyup.enter="sendMessage"
              type="text"
              placeholder="Type a message..."
              class="flex-1 bg-[#F3F4FA] rounded-full px-4 py-2.5 text-sm text-[#1E1F3B] placeholder-[#A3A7C2] outline-none focus:ring-2 focus:ring-[var(--primary)]/40"
            />

            <button
              @click="sendMessage"
              :disabled="!inputText.trim()"
              :class="!inputText.trim() ? 'opacity-40 cursor-not-allowed' : 'hover:bg-[var(--primary-dark)]'"
              class="shrink-0 w-9 h-9 rounded-full bg-[var(--primary)] flex items-center justify-center text-white transition-colors"
              aria-label="Send"
            >
              <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M2 21l21-9L2 3v7l15 2-15 2z" /></svg>
            </button>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>

<script setup>
import { ref, reactive, nextTick, onMounted, onUnmounted } from 'vue'

const emit = defineEmits(['send'])

const isOpen = ref(false)
const inputText = ref('')
const isTyping = ref(false)
const showEmojiPicker = ref(false)

const messagesContainer = ref(null)
const emojiPickerRef = ref(null)
const emojiBtnRef = ref(null)

const messages = reactive([
  { id: 1, role: 'bot', text: "Hi 👋 I'm Rose, your AI assistant. How can I help you today?", time: new Date() }
])

const quickEmojis = ['😀', '😂', '😍', '👍', '🙏', '🎉', '🔥', '❤️', '👏', '🤔', '😎', '✅', '❌', '💡', '🤖', '😢']

// Demo replies — swap these out for a real API call 
const demoReplies = [
  "Good question — let me look into that for you 🔍",
  "Got it, thanks for the details ✨",
  "Working on it, one moment...",
  "Sure thing! Anything else I can help with?"
]

function formatTime(date) {
  return date.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' })
}

function scrollToBottom() {
  nextTick(() => {
    if (messagesContainer.value) {
      messagesContainer.value.scrollTop = messagesContainer.value.scrollHeight
    }
  })
}

function toggleChat() {
  isOpen.value = !isOpen.value
  if (isOpen.value) scrollToBottom()
}

function insertEmoji(emoji) {
  inputText.value += emoji
  showEmojiPicker.value = false
}

function sendMessage() {
  const text = inputText.value.trim()
  if (!text) return

  messages.push({ id: Date.now(), role: 'user', text, time: new Date() })
  emit('send', text) // hook up your backend here FastAPI /api/chat)
  inputText.value = ''
  showEmojiPicker.value = false
  scrollToBottom()

  isTyping.value = true
  setTimeout(() => {
    isTyping.value = false
    const reply = demoReplies[Math.floor(Math.random() * demoReplies.length)]
    messages.push({ id: Date.now() + 1, role: 'bot', text: reply, time: new Date() })
    scrollToBottom()
  }, 900 + Math.random() * 700)
}

// Close the emoji picker when clicking outside of it
function handleClickOutside(e) {
  if (
    showEmojiPicker.value &&
    emojiPickerRef.value && !emojiPickerRef.value.contains(e.target) &&
    emojiBtnRef.value && !emojiBtnRef.value.contains(e.target)
  ) {
    showEmojiPicker.value = false
  }
}

onMounted(() => document.addEventListener('click', handleClickOutside))
onUnmounted(() => document.removeEventListener('click', handleClickOutside))
</script>

<style scoped>
/* Thin, subtle scrollbar for the messages area */
div::-webkit-scrollbar { width: 6px; }
div::-webkit-scrollbar-thumb { background: #D8DAEF; border-radius: 999px; }
</style>
