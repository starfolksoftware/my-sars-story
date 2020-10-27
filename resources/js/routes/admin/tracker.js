import { hasPermission } from '../../helpers/has-permission'

let permissions = []

if (hasPermission('view_trackers')) {
  permissions.push({
    path: '/admin/trackers',
    name: 'trackers',
    component: require('../../screens/admin/trackers/TrackerIndex').default,
  })
}

if (hasPermission('create_trackers')) {
  permissions.push({
    path: '/admin/trackers/create',
    name: 'trackers-create',
    component: require('../../screens/admin/trackers/TrackerEdit').default,
  })
}

if (hasPermission('update_trackers')) {
  permissions.push({
    path: '/admin/trackers/:id/edit',
    name: 'trackers-edit',
    component: require('../../screens/admin/trackers/TrackerEdit').default,
  })
}

export default permissions
