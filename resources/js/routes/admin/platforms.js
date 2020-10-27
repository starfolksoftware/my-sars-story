import { hasPermission } from '../../helpers/has-permission'

let permissions = []

if (hasPermission('update_platforms')) {
  permissions.push({
    path: '/admin/platforms/:id/edit',
    name: 'platforms-edit',
    component: require('../../screens/admin/platforms/PlatformEdit').default,
  })
}

export default permissions
