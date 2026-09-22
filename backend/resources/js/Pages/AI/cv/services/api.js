import { MOCK_RESPONSE } from './mock'

const API_URL = import.meta.env.VITE_API_URL || '/api'
const USE_MOCK = import.meta.env.VITE_USE_MOCK === 'true'

export async function matchCv(file) {
  if (!(file instanceof File)) {
    throw new Error('Please select a valid PDF file.')
  }

  // Frontend testing without backend
  if (USE_MOCK) {
    await new Promise((resolve) => setTimeout(resolve, 1200))
    return MOCK_RESPONSE
  }

  const body = new FormData()
  body.append('cv', file)

  const response = await fetch(`${API_URL}/match`, {
    method: 'POST',
    body,
    headers: {
      Accept: 'application/json',
    },
  })

  const data = await response.json().catch(() => ({}))

  if (!response.ok) {
    throw new Error(
      data.error ||
      data.message ||
      `The server could not analyze your CV (error ${response.status}).`
    )
  }

  return {
    skills: data.skills ?? [],
    offers: (data.offers ?? []).map((offer) => ({
      ...offer,
      matched: offer.matched ?? [],
      missing: offer.missing ?? [],
      reasoning: offer.reasoning ?? '',
      url: offer.url ?? '#',
    })),
  }
} 