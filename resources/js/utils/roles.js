export const roles = {
    user: "user",
    admin: "admin",
    sysadmin: "sysadmin"
}

export const rolesNames = {
    [roles.user]: "Пользователь",
    [roles.admin]: "Администратор",
    [roles.sysadmin]: "Системный администратор",
}

export const rolesList = [
    {
        id: roles.user,
        value: rolesNames[roles.user]
    },
    {
        id: roles.admin,
        value: rolesNames[roles.admin]
    },
    {
        id: roles.sysadmin,
        value: rolesNames[roles.sysadmin]
    }
]

export function checkAdminAccount(role) {
    return roles.admin === role || roles.sysadmin === role
}

