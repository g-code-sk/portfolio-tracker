import type { SelectOption } from '@/lib/types/generic-types'

export interface CurrencySelectOption extends SelectOption {
    label: string
    value: number
}
