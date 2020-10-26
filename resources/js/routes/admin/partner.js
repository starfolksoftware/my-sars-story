export default [
  {
    path: '/admin/partners',
    name: 'partners',
      component: require('../../screens/admin/partners/PartnerIndex').default,
  },
  {
      path: '/admin/partners/create',
      name: 'partners-create',
      component: require('../../screens/admin/partners/PartnerEdit').default,
  },
  {
      path: '/admin/partners/:id/edit',
      name: 'partners-edit',
      component: require('../../screens/admin/partners/PartnerEdit').default,
  },
]
