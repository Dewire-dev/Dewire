export const useRole = () => {
    const is = (role: string): boolean => {
        return usePage().props.role === role;
    };

    const can = (permission: string): boolean => {
        return (
            usePage().props.permissions.includes("*") ||
            usePage().props.permissions.includes(permission)
        );
    };

    return { is, can };
};
