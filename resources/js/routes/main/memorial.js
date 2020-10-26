export default [
  {
    path: '/memorial',
    name: 'memorial-main',
    component: require('../../screens/main/memorial/MemorialIndex').default,
  },
  {
    path: '/memorial/:id/show',
    name: 'memorial-show',
    component: require('../../screens/main/memorial/MemorialShow').default,
  },
]
