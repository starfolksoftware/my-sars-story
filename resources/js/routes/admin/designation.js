export default [
  {
    path: '/admin/designations',
    name: 'designations',
      component: require('../../screens/admin/designations/DesignationIndex').default,
  },
  {
      path: '/admin/designations/create',
      name: 'designations-create',
      component: require('../../screens/admin/designations/DesignationEdit').default,
  },
  {
      path: '/admin/designations/:id/edit',
      name: 'designations-edit',
      component: require('../../screens/admin/designations/DesignationEdit').default,
  },
]
