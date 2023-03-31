import { Project } from '@/Interfaces/Project'
import { TaskTimeSpend } from '@/Interfaces/TaskTimeSpend'

export interface Task {
    id: number,
    project_id: string,
    project?: Project,
    label: string,
    description?: string | null,
    scheduled_time?: number | null,
    start_at: Date,
    updated_at: Date,
    task_time_spends: Array<TaskTimeSpend>,
    state: string,
    type: string,
}
