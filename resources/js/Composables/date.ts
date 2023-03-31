import dayjs from '@/Plugins/dayjs'

export function datesAreOnSameDay(date1: Date, date2: Date): boolean {
    return dayjs(date1).isSame(date2, 'day')
}

export function useFormatDate(date: Date, format: string) {
    return dayjs(date).format(format)
}
