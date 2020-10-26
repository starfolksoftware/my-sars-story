export default [
  {
    path: '/admin/memorial',
    name: 'memorial',
    component: require('../../screens/admin/memorial/MemorialIndex').default,
  },
  {
    path: '/admin/memorial/create',
    name: 'memorial-create',
    component: require('../../screens/admin/memorial/MemorialEdit').default,
  },
  {
    path: '/admin/memorial/:id/edit',
    name: 'memorial-edit',
    component: require('../../screens/admin/memorial/MemorialEdit').default,
  },
]
