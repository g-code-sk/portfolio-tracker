import type { RouteLocationRaw } from 'vue-router'

export interface SidebarNavItem {
    label: string
    icon: string
    to?: string
    href?: string
}

export interface SelectOption {
    description?: any
    label: string
    value: string | number
}

export interface BreadcrumbItem {
    label: string | null
    to?: RouteLocationRaw
}
