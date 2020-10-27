import { hasPermission } from '../../helpers/has-permission'

let permissions = []

if (hasPermission('view_partners')) {
  permissions.push({
    path: '/admin/partners',
    name: 'partners',
    component: require('../../screens/admin/partners/PartnerIndex').default,
  })
}

if (hasPermission('create_partners')) {
  permissions.push({
    path: '/admin/partners/create',
    name: 'partners-create',
    component: require('../../screens/admin/partners/PartnerEdit').default,
  })
}

if (hasPermission('update_partners')) {
  permissions.push({
    path: '/admin/partners/:id/edit',
    name: 'partners-edit',
    component: require('../../screens/admin/partners/PartnerEdit').default,
  })
}

export default permissions
