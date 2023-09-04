import type { Page, PageProps } from "@inertiajs/core";

declare module "@inertiajs/core" {
    interface PageProps {
        jetstream: {
            canCreateTeams: boolean;
            canManageTwoFactorAuthentication: boolean;
            canUpdatePassword: boolean;
            canUpdateProfileInformation: boolean;
            hasEmailVerification: boolean;
            flash: {
                bannerStyle?: "success" | "danger";
                banner?: string;
                token?: string;
            };
            hasAccountDeletionFeatures: boolean;
            hasApiFeatures: boolean;
            hasTeamFeatures: boolean;
            hasTermsAndPrivacyPolicyFeature: boolean;
            managesProfilePhotos: boolean;
        };
        auth: {
            user: App.Models.User & {
                all_teams?: Array<App.Models.Team> | null;
                current_team?: App.Models.Team;
                two_factor_enabled: boolean;
                membership?: App.Models.Membership;
            };
        };
        layout: {
            projects: Array<App.Models.Project>;
        };
        currentRole: string;
        currentPermissions: string[];
        isAdmin: boolean;
    }
}

declare module "vue" {
    interface ComponentCustomProperties {
        $page: Page<PageProps>;
    }
}
