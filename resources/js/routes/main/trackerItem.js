export default [
  {
    path: '/trackerItems/:trackerId',
    name: 'trackerItems-main',
    component: require('../../screens/main/tracker-item/TrackerItemIndex').default,
  },
  {
    path: '/trackerItems/:trackerId/:id/show',
    name: 'trackerItems-show',
    component: require('../../screens/main/tracker-item/TrackerItemShow').default,
  },
  {
    path: '/trackerItems/:trackerId/submit',
    name: 'trackerItems-submit',
    component: require('../../screens/main/tracker-item/TrackerItemSubmit').default,
  },
]
