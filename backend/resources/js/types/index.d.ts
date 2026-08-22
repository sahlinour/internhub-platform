export type Role = 'stagiaire' | 'encadrant' | 'entreprise' | 'admin'

export interface User {
  id: number
  name: string
  email: string
  role: Role
  avatar_url?: string
}

export interface Internship {
  id: number
  title: string
  description: string
  company_id: number
  status: 'draft' | 'published' | 'closed'
  start_date: string
  end_date: string
}

export interface Application {
  id: number
  internship_id: number
  student_id: number
  status: 'pending' | 'accepted' | 'rejected'
  submitted_at: string
}

export interface PaginatedResponse<T> {
  data: T[]
  current_page: number
  last_page: number
  total: number
}
