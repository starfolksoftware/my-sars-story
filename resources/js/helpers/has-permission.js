import { anyMatchInArray } from './any-match-in-array'

export const hasPermission = (permission) => CurrentTenant.user && CurrentTenant.user.permissions.includes(permission)

export const hasPermissions = (permissions = []) => CurrentTenant.user && anyMatchInArray(CurrentTenant.user.permissions, permissions)
