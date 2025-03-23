import { usePage } from "@inertiajs/vue3";

export function useCheckPermission(permissions, $userId = null) {
    const { props } = usePage()
    const { userPermissions, userRoles, auth } = props
    
    if (userRoles.includes('super-admin')) {
        console.log('a')
        return true
    }

    if (permissions.length == 1 && permissions[0].includes('create')) {
        return userPermissions.includes(permissions[0])
    }

    if (permissions.filter(permission => permission.endsWith("-any")).length) {
        return permissions.some(permission => userPermissions.includes(permission))
    }

    return permissions.some(permission => userPermissions.includes(permission)) && (auth.user.id == $userId)
}