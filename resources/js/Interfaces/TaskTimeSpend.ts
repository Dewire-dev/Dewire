export interface TaskTimeSpend {
    id: number,
    tast_id: number,
    user_id: string,
    time: number,
    description?: string | null,
    date: Date,
}
