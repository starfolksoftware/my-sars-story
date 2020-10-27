import { hasPermission } from '../../helpers/has-permission'

let permissions = []

if (hasPermission('view_resources')) {
  permissions.push({
    path: '/admin/resources',
    name: 'resources',
    component: require('../../screens/admin/resources/ResourceIndex').default,
  })
}

if (hasPermission('create_resources')) {
  permissions.push({
    path: '/admin/resources/create',
    name: 'resources-create',
    component: require('../../screens/admin/resources/ResourceEdit').default,
  })
}

if (hasPermission('update_resources')) {
  permissions.push({
    path: '/admin/resources/:id/edit',
    name: 'resources-edit',
    component: require('../../screens/admin/resources/ResourceEdit').default,
  })
}

export default permissions
