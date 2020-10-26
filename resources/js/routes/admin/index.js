import analytics from './analytics'
import designation from './designation'
import data from './data'
import member from './member'
import partner from './partner'
import platforms from './platforms'
import posts from './posts'
import product from './product'
import roles from './roles'
import service from './service'
import settings from './settings'
// import tracker from './tracker'
import trackerItem from './trackerItem'
import users from './users'
import location from './location'

let adminRoutes = [
  {
    path: '/admin',
    name: 'dashboard',
    redirect: '/admin/stats',
  },
  ...platforms,
  ...roles,
  ...users,
  ...settings,
  ...analytics,
  ...location,
  ...designation,
  ...member,
  ...partner,
  ...service,
  ...data,
  ...posts,
  ...product,
  // ...tracker,
  ...trackerItem
]

export default adminRoutes
