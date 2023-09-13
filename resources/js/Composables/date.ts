import dayjs from '@/Plugins/dayjs'

export function useDate() {
    function datesAreOnSameDay(date1: Date, date2: Date): boolean {
        return dayjs(date1).isSame(date2, 'day')
    }

    function formatDate(date: Date, format: string) {
        return dayjs(date).format(format)
    }

    return {
        datesAreOnSameDay,
        formatDate,
    }
}
