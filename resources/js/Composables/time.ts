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

    return {
        formatTimeHoursMinutes,
        getTotalTimeSpendOnATask,
        getTotalTimeSpendOnATaskFormatTimeHoursMinutes,
    }
}
