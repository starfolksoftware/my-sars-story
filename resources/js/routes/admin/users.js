export default [
  {
    path: '/admin/users',
    name: 'users',
      component: require('../../screens/admin/users/UserIndex').default,
  },
  {
      path: '/admin/users/create',
      name: 'users-create',
      component: require('../../screens/admin/users/UserEdit').default,
  },
  {
      path: '/admin/users/:id/edit',
      name: 'users-edit',
      component: require('../../screens/admin/users/UserEdit').default,
  },
]
