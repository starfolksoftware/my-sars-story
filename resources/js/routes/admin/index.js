import analytics from './analytics'
import memorial from './memorial'
import partner from './partner'
import platforms from './platforms'
import posts from './posts'
import roles from './roles'
import settings from './settings'
import tracker from './tracker'
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
  ...memorial,
  ...partner,
  ...posts,
  ...tracker,
  ...trackerItem
]

export default adminRoutes
