import { Task } from '@/Interfaces/Task'

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

    function getTotalTimeSpendOnATask (task: Task): number {
        let total = 0
        for (const timeSpend of task.task_time_spends) {
            total += timeSpend.time;
        }
        return total
    }

    function getTotalTimeSpendOnATaskFormatTimeHoursMinutes (task: Task): string {
        return formatTimeHoursMinutes(getTotalTimeSpendOnATask(task))
    }

    function validateTime (tempsStr: string) {
        tempsStr = tempsStr.toLowerCase();

        const pattern = /^(?:(\d+)h)?(?:(\d+)m?)?$/;
        const match = tempsStr.match(pattern);

        if (!match) {
            return false; // Format incorrect
        }

        const hoursStr = match[1];
        const minutesStr = match[2];

        let hours = 0;
        if (hoursStr) {
            hours = parseInt(hoursStr);
            if (isNaN(hours)) {
                return false; // Heure invalide
            }
        }

        let minutes = 0;
        if (minutesStr) {
            minutes = parseInt(minutesStr);
            if (isNaN(minutes)) {
                return false; // Minute invalide
            }
        } else if (!hoursStr && minutesStr === '') {
            return false; // Minute invalide
        } else if (!hoursStr && minutesStr === undefined) {
            minutes = parseInt(tempsStr);
            if (isNaN(minutes)) {
                return false; // Temps invalide
            }
        }

        if (minutes >= 60) {
            hours+= Math.floor(minutes / 60);
            minutes = minutes % 60
        }

        if (hours >= 24) {
            return false;
        }

        return hours * 60 + minutes;
    }

    return {
        formatTimeHoursMinutes,
        getTotalTimeSpendOnATask,
        getTotalTimeSpendOnATaskFormatTimeHoursMinutes,
        validateTime,
    }
}
