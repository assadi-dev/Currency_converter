export type LinksType = {
    first: string|null
    last:string|null
    prev:string|null
    next:string | null
  }
  
 type LinksMeta = {
    url: string | null
    label: string
    active: boolean
  }
  
  
  export type MetaType = {
    current_page: number
    from: number
    last_page: number
    links: LinksMeta[]
    path: string,
    per_page: number
    to: number,
    total: number
  }