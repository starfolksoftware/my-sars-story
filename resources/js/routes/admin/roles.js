export default [
  {
    path: '/admin/roles',
    name: 'roles',
    component: require('../../screens/admin/roles/RoleIndex').default,
  },
  {
    path: '/admin/roles/create',
    name: 'roles-create',
    component: require('../../screens/admin/roles/RoleEdit').default,
  },
  {
    path: '/admin/roles/:id/edit',
    name: 'roles-edit',
    component: require('../../screens/admin/roles/RoleEdit').default,
  },
]
