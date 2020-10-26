export default [
  {
    path: '/members',
    name: 'members-main',
    component: require('../../screens/main/member/MemberIndex').default,
  },
  {
    path: '/members/create',
    name: 'members-show',
    component: require('../../screens/main/member/MemberShow').default,
  },
]
