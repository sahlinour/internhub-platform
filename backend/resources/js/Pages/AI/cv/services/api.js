import { MOCK_RESPONSE } from './mock'

const API_URL = import.meta.env.VITE_API_URL || '/api'
const USE_MOCK = import.meta.env.VITE_USE_MOCK === 'true'

/**
 * Sends the CV to the backend and returns the best matching offers.
 *
 * POST {API_URL}/match          (multipart/form-data, field name: "cv")
 * Expected JSON response:
 * {
 *   "skills": ["Vue.js", "Docker", ...],
 *   "offers": [
 *     {
 *       "id": 1,
 *       "title": "Frontend Developer",
 *       "company": "Northwind Labs",
 *       "location": "Remote",
 *       "type": "Full-time",
 *       "score": 86,                       // match percentage, 0-100
 *       "matched": ["Vue.js", "Git"],      // skills from the CV found in the offer
 *       "missing": ["TypeScript"],         // skills required but not in the CV
 *       "url": "https://..."
 *     }
 *   ]
 * }
 */
export async function matchCv(file) {
  if (USE_MOCK) {
    await new Promise((r) => setTimeout(r, 1200))
    return MOCK_RESPONSE
  }

  const body = new FormData()
  body.append('cv', file)

  const res = await fetch(`${API_URL}/match`, { method: 'POST', body })
  if (!res.ok) {
    throw new Error(`The server could not analyze your CV (error ${res.status}). Try again.`)
  }

  const data = await res.json()
  return {
    skills: data.skills ?? [],
    offers: (data.offers ?? []).map((o) => ({
      ...o,
      matched: o.matched ?? [],
      missing: o.missing ?? [],
      url: o.url ?? '#'
    }))
  }
}
