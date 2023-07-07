export const usePermissions = () => {
    const can = (permission: string): boolean => {
        return (
            usePage().props.permissions.includes("*") ||
            usePage().props.permissions.includes(permission)
        );
    };

    return { can };
};
