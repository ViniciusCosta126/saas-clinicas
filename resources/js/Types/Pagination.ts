export interface IPagination<T> {
  data: T[]
  current_page: number
  last_page: number
  links: {
    url: string | null
    label: string
    active: boolean
  }[]
}