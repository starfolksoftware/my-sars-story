export default [
  {
    path: '/admin/services',
    name: 'services',
    component: require('../../screens/admin/services/ServiceIndex').default,
  },
  {
    path: '/admin/services/create',
    name: 'services-create',
    component: require('../../screens/admin/services/ServiceEdit').default,
  },
  {
    path: '/admin/services/:id/edit',
    name: 'services-edit',
    component: require('../../screens/admin/services/ServiceEdit').default,
  },
]
