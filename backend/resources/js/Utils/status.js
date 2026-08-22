const STATUS_STYLES = {
  pending: 'bg-yellow-100 text-yellow-800',
  accepted: 'bg-green-100 text-green-800',
  rejected: 'bg-red-100 text-red-800',
  draft: 'bg-gray-100 text-gray-800',
  published: 'bg-blue-100 text-blue-800',
  closed: 'bg-gray-200 text-gray-600'
}

export function statusBadgeClass(status) {
  return STATUS_STYLES[status] ?? 'bg-gray-100 text-gray-800'
}

