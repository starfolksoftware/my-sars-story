import { hasPermission } from '../../helpers/has-permission'

let permissions = []

if (hasPermission('view_posts')) {
    permissions.push({
        path: "/admin/posts",
        name: "posts",
        component: require("../../screens/admin/posts/PostIndex").default
    })
}

if (hasPermission('create_posts')) {
    permissions.push({
        path: "/admin/posts/create",
        name: "posts-create",
        component: require("../../screens/admin/posts/PostEdit").default
    })
}

if (hasPermission('update_posts')) {
    permissions.push({
        path: "/admin/posts/:id/edit",
        name: "posts-edit",
        component: require("../../screens/admin/posts/PostEdit").default
    })
}

if (hasPermission('view_tags')) {
    permissions.push({
        path: "/admin/posts/tags",
        name: "tags",
        component: require("../../screens/admin/posts/TagsIndex").default
    })
}

if (hasPermission('create_tags')) {
    permissions.push({
        path: "/admin/posts/tags/create",
        name: "tags-create",
        component: require("../../screens/admin/posts/TagsEdit").default
    })
}

if (hasPermission('update_tags')) {
    permissions.push({
        path: "/admin/posts/tags/:id/edit",
        name: "tags-edit",
        component: require("../../screens/admin/posts/TagsEdit").default
    })
}

if (hasPermission('view_topics')) {
    permissions.push({
        path: "/admin/posts/topics",
        name: "topics",
        component: require("../../screens/admin/posts/TopicsIndex").default
    })
}

if (hasPermission('create_topics')) {
    permissions.push({
        path: "/admin/posts/topics/create",
        name: "topics-create",
        component: require("../../screens/admin/posts/TopicsEdit").default
    })
}

if (hasPermission('update_topics')) {
    permissions.push({
        path: "/admin/posts/topics/:id/edit",
        name: "topics-edit",
        component: require("../../screens/admin/posts/TopicsEdit").default
    })
}

export default permissions
