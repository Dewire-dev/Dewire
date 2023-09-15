export interface TaskTimeSpend {
    id?: number,
    task_id: number,
    user_id?: string,
    time?: number|string,
    description?: string | null,
    date?: Date,
}
