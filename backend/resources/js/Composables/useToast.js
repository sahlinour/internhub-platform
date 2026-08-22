import { ref } from 'vue'

const toasts = ref([])
let nextId = 1

export function useToast() {
  function push(message, type = 'success', duration = 3000) {
    const id = nextId++
    toasts.value.push({ id, message, type })
    setTimeout(() => dismiss(id), duration)
  }

  function dismiss(id) {
    toasts.value = toasts.value.filter((t) => t.id !== id)
  }

  return { toasts, push, dismiss }
}
