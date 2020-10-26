export default [
  {
    path: "/data",
    name: "data",
    component: require("../../screens/main/data/DataIndex").default
  },
  {
    path: "/data/:filter/:filterId",
    name: "filtered-data",
    component: require("../../screens/main/data/DataIndex").default
  },
  {
    path: "/data/:id",
    name: "data-show",
    component: require("../../screens/main/data/DataShow").default
  },
  {
    path: "/data/:id/resource/:resourceId",
    name: "resource-show",
    component: require("../../screens/main/data/ResourceShow").default
  }
];
