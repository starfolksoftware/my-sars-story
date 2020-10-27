import blog from './blog'
import memorial from './memorial'
import trackerItem from './trackerItem'
import resource from './resource'
// import tracker from '../admin/tracker'

let mainRoutes = [
  {
    path: '/',
    name: 'home',
    component: require('../../screens/main/home/HomeIndex').default,
  },
  {
    path: '/contact',
    name: 'contact',
    component: require('../../screens/main/contact/ContactIndex').default,
  },
  {
    path: '/privacy-policy',
    name: 'privacy-policy',
    component: require('../../screens/main/legal/PrivacyPolicy').default,
  },
  {
    path: '/terms',
    name: 'terms',
    component: require('../../screens/main/legal/Terms').default,
  },
  {
    path: '/login',
    name: 'login',
    redirect: '/login',
  },
  {
    path: '/register',
    name: 'register',
    redirect: '/register',
  },
  {
    path: '/password/reset',
    name: 'forgot-password',
    redirect: '/password/reset',
  },
  {
    path: '/settings',
    name: 'main-settings-show',
    component: require('../../screens/main/settings/SettingsShow').default,
  },
  {
    path: '*',
    name: 'catch-all',
    redirect: '/',
  },
  ...blog,
  ...trackerItem,
  ...memorial,
  ...resource,
]

export default mainRoutes
