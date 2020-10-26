import blog from './blog'
import data from './data'
import member from './member'
import product from './product'
import trackerItem from './trackerItem'
import tracker from '../admin/tracker'

let mainRoutes = [
  {
    path: '/',
    name: 'home',
    component: require('../../screens/main/home/HomeIndex').default,
  },
  {
    path: '/portfolio',
    name: 'portfolio',
    component: require('../../screens/main/portfolio/Index').default,
  },
  {
    path: '/services',
    name: 'services',
    component: require('../../screens/main/service/Index').default,
  },
  // {
  //   path: '/about',
  //   name: 'about',
  //   component: require('../../screens/main/about/AboutIndex').default,
  // },
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
  ...data,
  ...tracker,
  ...trackerItem,
  ...member,
  ...product
]

export default mainRoutes
