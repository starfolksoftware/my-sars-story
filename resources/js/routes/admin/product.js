export default [
  {
    path: '/admin/products',
    name: 'products',
    component: require('../../screens/admin/products/ProductIndex').default,
  },
  {
    path: '/admin/products/create',
    name: 'products-create',
    component: require('../../screens/admin/products/ProductEdit').default,
  },
  {
    path: '/admin/products/:id/edit',
    name: 'products-edit',
    component: require('../../screens/admin/products/ProductEdit').default,
  },
]
