import { anyMatchInArray } from './any-match-in-array'

export const hasPermission = (permission) => CurrentTenant.user.permissions.includes(permission)

export const hasPermissions = (permissions = []) => anyMatchInArray(CurrentTenant.user.permissions, permissions)
