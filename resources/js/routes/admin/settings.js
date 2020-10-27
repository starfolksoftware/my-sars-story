let permissions = []

permissions.push({
  path: '/admin/settings',
  name: 'settings-show',
  component: require('../../screens/admin/settings/SettingsShow').default,
})

export default permissions
