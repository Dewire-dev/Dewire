import dayjs from '@/Plugins/dayjs'

export function datesAreOnSameDay(date1: Date, date2: Date): boolean {
    const firstDate = new Date(date1)
    const secondDate = new Date(date2)
    firstDate.setHours(0, 0, 0, 0)
    secondDate.setHours(0, 0, 0, 0)
    return firstDate.toISOString() === secondDate.toISOString()
}

export function formatDate(date: Date, format: string) {
    return dayjs(date).format(format)
}
