export default [
  {
    path: '/admin/trackerItems/select',
    name: 'trackerItems-select',
    component: require('../../screens/admin/trackerItems/TrackerItemIndex').default,
  },
  {
    path: '/admin/trackerItems/:trackerId',
    name: 'trackerItems',
    component: require('../../screens/admin/trackerItems/TrackerItemIndex').default,
  },
  {
    path: '/admin/trackerItems/:trackerId/create',
    name: 'trackerItems-create',
    component: require('../../screens/admin/trackerItems/TrackerItemEdit').default,
  },
  {
    path: '/admin/trackerItems/:trackerId/:id/edit',
    name: 'trackerItems-edit',
    component: require('../../screens/admin/trackerItems/TrackerItemEdit').default,
  },
]
