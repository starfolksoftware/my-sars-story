import { hasPermission } from '../../helpers/has-permission'

let permissions = []

if (hasPermission('view_roles')) {
  permissions.push({
    path: '/admin/roles',
    name: 'roles',
    component: require('../../screens/admin/roles/RoleIndex').default,
  })
}

if (hasPermission('create_roles')) {
  permissions.push({
    path: '/admin/roles/create',
    name: 'roles-create',
    component: require('../../screens/admin/roles/RoleEdit').default,
  })
}

if (hasPermission('update_roles')) {
  permissions.push({
    path: '/admin/roles/:id/edit',
    name: 'roles-edit',
    component: require('../../screens/admin/roles/RoleEdit').default,
  })
}

export default permissions
