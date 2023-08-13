export const useRole = () => {
    const is = (role: string): boolean => {
        return usePage().props.currentRole === role;
    };

    const can = (permission: string): boolean => {
        return (
            usePage().props.currentPermissions.includes("*") ||
            usePage().props.currentPermissions.includes(permission)
        );
    };

    return { is, can };
};
