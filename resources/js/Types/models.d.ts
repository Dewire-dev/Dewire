/**
 * This file is auto generated using 'php artisan typescript:generate'
 *
 * Changes to this file will be lost when the command is run again
 */

declare namespace App.Models {
    export interface Task {
        id: number;
        project_id: string;
        user_creator_id: string | null;
        label: string;
        description: string | null;
        start_at: string;
        end_at: string;
        state: string;
        type: string;
        created_at: string | null;
        updated_at: string | null;
        project?: App.Models.Project | null;
        user_creator?: App.Models.User | null;
        task_logs?: Array<App.Models.TaskLog> | null;
        task_time_spends?: Array<App.Models.TaskTimeSpend> | null;
        users?: Array<App.Models.User> | null;
        task_logs_count?: number | null;
        task_time_spends_count?: number | null;
        users_count?: number | null;
    }

    export interface Membership {
        id: number;
        team_id: number;
        user_id: string;
        role: string | null;
        created_at: string | null;
        updated_at: string | null;
    }

    export interface Team {
        id: number;
        user_id: string;
        name: string;
        personal_team: boolean;
        created_at: string | null;
        updated_at: string | null;
        creator?: App.Models.User | null;
        owner?: App.Models.User | null;
        users?: Array<App.Models.User> | null;
        team_invitations?: Array<App.Models.TeamInvitation> | null;
        users_count?: number | null;
        team_invitations_count?: number | null;
    }

    export interface TaskLog {
        id: number;
        task_id: number;
        user_id: number;
        log: string;
        created_at: string | null;
        updated_at: string | null;
        user?: App.Models.User | null;
        task?: App.Models.Task | null;
    }

    export interface User {
        id: string;
        name: string;
        firstname: string | null;
        lastname: string | null;
        email: string;
        email_verified_at: string | null;
        password: string;
        two_factor_secret: string | null;
        two_factor_recovery_codes: string | null;
        two_factor_confirmed_at: string | null;
        remember_token: string | null;
        current_team_id: number | null;
        profile_photo_path: string | null;
        created_at: string | null;
        updated_at: string | null;
        task_logs?: Array<App.Models.TaskLog> | null;
        task_time_spends?: Array<App.Models.TaskTimeSpend> | null;
        tasks?: Array<App.Models.Task> | null;
        task_logs_count?: number | null;
        task_time_spends_count?: number | null;
        tasks_count?: number | null;
    }

    export interface TaskTimeSpend {
        id: number;
        task_id: number;
        user_id: number;
        time: number;
        description: string;
        created_at: string | null;
        updated_at: string | null;
        user?: App.Models.User | null;
        task?: App.Models.Task | null;
    }

    export interface Messages {
        id: number;
        sender_id: string;
        chat_id: number;
        content: string;
        created_at: string;
        read_at: string | null;
        updated_at: string;
    }

    export interface TeamInvitation {
        id: number;
        team_id: number;
        email: string;
        role: string | null;
        created_at: string | null;
        updated_at: string | null;
        team?: App.Models.Team | null;
    }

    export interface ChatsUser {
        id: number;
        user_id: string;
        chat_id: number;
        created_at: string;
        updated_at: string;
    }

    export interface Project {
        id: string;
        title: string;
        subtitle: string;
        description: string;
        created_at: string | null;
        updated_at: string | null;
        tasks?: Array<App.Models.Task> | null;
        tasks_count?: number | null;
    }

    export interface Chat {
        id: number;
        subject: string;
        name: string;
        project_id: string;
        created_at: string;
        updated_at: string;
    }

}
