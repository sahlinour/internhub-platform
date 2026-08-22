export function formatDate(dateString, locale = 'fr-FR') {
  if (!dateString) return ''
  return new Date(dateString).toLocaleDateString(locale, {
    day: '2-digit',
    month: 'long',
    year: 'numeric'
  })
}

export function timeAgo(dateString) {
  const seconds = Math.floor((new Date() - new Date(dateString)) / 1000)
  const units = [
    ['an', 31536000],
    ['mois', 2592000],
    ['jour', 86400],
    ['heure', 3600],
    ['minute', 60]
  ]

  for (const [label, secondsInUnit] of units) {
    const value = Math.floor(seconds / secondsInUnit)
    if (value >= 1) return `il y a ${value} ${label}${value > 1 && label !== 'mois' ? 's' : ''}`
  }
  return "à l'instant"
}
