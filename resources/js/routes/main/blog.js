export default [
  {
    path: '/blog',
    name: 'blog',
    component: require('../../screens/main/blog/HomeScreen').default,
  },
  {
    path: '/blog/tags',
    name: 'blog-tags',
    component: require('../../screens/main/blog/TagScreen').default,
  },
  {
    path: '/blog/tags/:slug',
    name: 'blog-tag-posts',
    component: require('../../screens/main/blog/TagPostsScreen').default,
  },
  {
    path: '/blog/topics',
    name: 'blog-topics',
    component: require('../../screens/main/blog/TopicScreen').default,
  },
  {
    path: '/blog/topics/:slug',
    name: 'blog-topic-posts',
    component: require('../../screens/main/blog/TopicPostsScreen').default,
  },
  {
    path: '/blog/:identifier',
    name: 'blog-user',
    component: require('../../screens/main/blog/UserScreen').default,
  },
  {
    path: '/blog/:identifier/:slug',
    name: 'blog-post',
    component: require('../../screens/main/blog/PostScreen').default,
  },
]
