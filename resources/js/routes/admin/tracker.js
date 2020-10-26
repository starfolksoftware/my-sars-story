export default [
  {
    path: '/admin/trackers',
    name: 'trackers',
    component: require('../../screens/admin/trackers/TrackerIndex').default,
  },
  {
    path: '/admin/trackers/create',
    name: 'trackers-create',
    component: require('../../screens/admin/trackers/TrackerEdit').default,
  },
  {
    path: '/admin/trackers/:id/edit',
    name: 'trackers-edit',
    component: require('../../screens/admin/trackers/TrackerEdit').default,
  },
]
