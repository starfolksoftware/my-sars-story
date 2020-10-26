export default [
    {
        path: "/admin/posts",
        name: "posts",
        component: require("../../screens/admin/posts/PostIndex").default
    },
    {
        path: "/admin/posts/create",
        name: "posts-create",
        component: require("../../screens/admin/posts/PostEdit").default
    },
    {
        path: "/admin/posts/:id/edit",
        name: "posts-edit",
        component: require("../../screens/admin/posts/PostEdit").default
    },
    {
        path: "/admin/posts/tags",
        name: "tags",
        component: require("../../screens/admin/posts/TagsIndex").default
    },
    {
        path: "/admin/posts/tags/create",
        name: "tags-create",
        component: require("../../screens/admin/posts/TagsEdit").default
    },
    {
        path: "/admin/posts/tags/:id/edit",
        name: "tags-edit",
        component: require("../../screens/admin/posts/TagsEdit").default
    },
    {
        path: "/admin/posts/topics",
        name: "topics",
        component: require("../../screens/admin/posts/TopicsIndex").default
    },
    {
        path: "/admin/posts/topics/create",
        name: "topics-create",
        component: require("../../screens/admin/posts/TopicsEdit").default
    },
    {
        path: "/admin/posts/topics/:id/edit",
        name: "topics-edit",
        component: require("../../screens/admin/posts/TopicsEdit").default
    }
];
