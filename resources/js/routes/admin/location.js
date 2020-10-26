export default [
  {
    path: '/admin/states',
    name: 'states',
    component: require('../../screens/admin/location/StateIndex').default,
  },
  {
    path: '/admin/local-governments',
    name: 'local-governments',
    component: require('../../screens/admin/location/LocalGovernmentIndex').default,
  },
]
