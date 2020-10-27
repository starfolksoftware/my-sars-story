import { hasPermission } from '../../helpers/has-permission'

let permissions = []

if (hasPermission('view_tracker_items')) {
  permissions.push({
    path: '/admin/trackerItems/select',
    name: 'trackerItems-select',
    component: require('../../screens/admin/trackerItems/TrackerItemIndex').default,
  })

  permissions.push({
    path: '/admin/trackerItems/:trackerId',
    name: 'trackerItems',
    component: require('../../screens/admin/trackerItems/TrackerItemIndex').default,
  })
}

if (hasPermission('create_tracker_items')) {
  permissions.push({
    path: '/admin/trackerItems/:trackerId/create',
    name: 'trackerItems-create',
    component: require('../../screens/admin/trackerItems/TrackerItemEdit').default,
  })
}

if (hasPermission('update_tracker_items')) {
  permissions.push({
    path: '/admin/trackerItems/:trackerId/:id/edit',
    name: 'trackerItems-edit',
    component: require('../../screens/admin/trackerItems/TrackerItemEdit').default,
  })
}

export default permissions
