export default [
  {
    path: "/admin/data/topics",
    name: "datatopics",
    component: require("../../screens/admin/data/TopicsIndex").default
  },
  {
    path: "/admin/data/topics/create",
    name: "datatopics-create",
    component: require("../../screens/admin/data/TopicsEdit").default
  },
  {
    path: "/admin/data/topics/:id/edit",
    name: "datatopics-edit",
    component: require("../../screens/admin/data/TopicsEdit").default
  },
  {
    path: "/admin/data/tags",
    name: "datatags",
    component: require("../../screens/admin/data/TagsIndex").default
  },
  {
    path: "/admin/data/tags/create",
    name: "datatags-create",
    component: require("../../screens/admin/data/TagsEdit").default
  },
  {
    path: "/admin/data/tags/:id/edit",
    name: "datatags-edit",
    component: require("../../screens/admin/data/TagsEdit").default
  },
  {
    path: "/admin/data/formats",
    name: "formats",
    component: require("../../screens/admin/data/FormatsIndex").default
  },
  {
    path: "/admin/data/formats/create",
    name: "formats-create",
    component: require("../../screens/admin/data/FormatsEdit").default
  },
  {
    path: "/admin/data/formats/:id/edit",
    name: "formats-edit",
    component: require("../../screens/admin/data/FormatsEdit").default
  },
  {
    path: "/admin/data/licenses",
    name: "licenses",
    component: require("../../screens/admin/data/LicensesIndex").default
  },
  {
    path: "/admin/data/licenses/create",
    name: "licenses-create",
    component: require("../../screens/admin/data/LicensesEdit").default
  },
  {
    path: "/admin/data/licenses/:id/edit",
    name: "licenses-edit",
    component: require("../../screens/admin/data/LicensesEdit").default
  },
  {
    path: "/admin/data/datasets",
    name: "datasets",
    component: require("../../screens/admin/data/DatasetsIndex").default
  },
  {
    path: "/admin/data/datasets/create",
    name: "datasets-create",
    component: require("../../screens/admin/data/DatasetsEdit").default
  },
  {
    path: "/admin/data/datasets/:id/edit",
    name: "datasets-edit",
    component: require("../../screens/admin/data/DatasetsEdit").default
  }
];
