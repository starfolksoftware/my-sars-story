import { hasPermission } from '../../helpers/has-permission'

let permissions = []

if (hasPermission('view_memorial')) {
  permissions.push({
    path: '/admin/memorial',
    name: 'memorial',
    component: require('../../screens/admin/memorial/MemorialIndex').default,
  })
}

if (hasPermission('create_memorial')) {
  permissions.push({
    path: '/admin/memorial/create',
    name: 'memorial-create',
    component: require('../../screens/admin/memorial/MemorialEdit').default,
  })
}

if (hasPermission('view_memorial')) {
  permissions.push({
    path: '/admin/memorial/:id/edit',
    name: 'memorial-edit',
    component: require('../../screens/admin/memorial/MemorialEdit').default,
  })
}

export default permissions
