export function useFormatTime() {
    function formatTimeSpend (timeSpend: number): string {
        let hours: number = 0
        let minutes: number = 0

        if (timeSpend < 60) {
            return timeSpend + 'm'
        }

        minutes = timeSpend % 60
        hours = (timeSpend - minutes) / 60

        return hours + 'h' + ((minutes < 10) ? '0' : '') + minutes + 'm'
    }

    return {
        formatTimeSpend,
    }
}
