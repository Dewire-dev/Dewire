export function useFormatTime() {
    function formatTimeHoursMinutes (timeSpend: number): string {
        let hours: number = 0
        let minutes: number = 0

        if (timeSpend < 60) {
            return timeSpend + 'm'
        }

        minutes = timeSpend % 60
        hours = (timeSpend - minutes) / 60

        if (minutes === 0) {
            return hours + 'h'
        }

        return hours + 'h' + ((minutes < 10) ? '0' : '') + minutes + 'm'
    }

    return {
        formatTimeHoursMinutes,
    }
}
