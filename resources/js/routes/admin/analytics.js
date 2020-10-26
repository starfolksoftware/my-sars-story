export default [
  {
    path: "/admin/stats",
    name: "stats",
    component: require("../../screens/admin/analytics/StatsIndex").default
  },
  {
    path: "/admin/stats/:id/:className",
    name: "stats-show",
    component: require("../../screens/admin/analytics/StatsShow").default
  },
]