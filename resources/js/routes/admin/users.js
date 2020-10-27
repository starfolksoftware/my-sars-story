import { hasPermission } from '../../helpers/has-permission'

let permissions = []

if (hasPermission('view_users')) {
  permissions.push({
    path: '/admin/users',
    name: 'users',
      component: require('../../screens/admin/users/UserIndex').default,
  })
}

if (hasPermission('create_users')) {
  permissions.push({
    path: '/admin/users/create',
    name: 'users-create',
    component: require('../../screens/admin/users/UserEdit').default,
  })
}

if (hasPermission('update_users')) {
  permissions.push({
    path: '/admin/users/:id/edit',
    name: 'users-edit',
    component: require('../../screens/admin/users/UserEdit').default,
  })
}

export default permissions
