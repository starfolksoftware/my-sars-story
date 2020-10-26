export default [
  {
    path: '/admin/members',
    name: 'members',
    component: require('../../screens/admin/members/MemberIndex').default,
  },
  {
    path: '/admin/members/create',
    name: 'members-create',
    component: require('../../screens/admin/members/MemberEdit').default,
  },
  {
    path: '/admin/members/:id/edit',
    name: 'members-edit',
    component: require('../../screens/admin/members/MemberEdit').default,
  },
]
