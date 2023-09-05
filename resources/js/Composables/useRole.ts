export const useRole = () => {
    const is = (role: string): boolean => {
        return usePage().props.auth.user.role === role;
    };

    const can = (permission: string): boolean => {
        return (
            usePage().props.auth.user.permissions.includes("*") ||
            usePage().props.auth.user.permissions.includes(permission)
        );
    };

    return { is, can };
};
