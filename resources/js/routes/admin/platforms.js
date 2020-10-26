export default [
  // {
  //   path: '/admin/platforms',
  //   name: 'platforms',
  //   // component: require('../../screens/admin/platforms/PlatformIndex').default,
  //   redirect: '/admin/platforms/:id/edit'
  // },
  // {
  //   path: '/admin/platforms/create',
  //   name: 'platforms-create',
  //   // component: require('../../screens/admin/platforms/PlatformEdit').default,
  //   redirect: '/admin/platforms/:id/edit'
  // },
  {
    path: '/admin/platforms/:id/edit',
    name: 'platforms-edit',
    component: require('../../screens/admin/platforms/PlatformEdit').default,
  },
]
