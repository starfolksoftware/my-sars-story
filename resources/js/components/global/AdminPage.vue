<template>
  <div>
    <!-- Sidenav -->
    <nav
      style="z-index: 1600"
      class="sidenav navbar navbar-vertical fixed-left navbar-expand-xs navbar-light bg-white"
      id="sidenav-main"
    >
      <div class="scrollbar-inner">
        <!-- Brand -->
        <div class="sidenav-header d-flex align-items-center">
          <router-link class="navbar-brand" to="/admin">
            {{ CurrentTenant.platform.name || CurrentTenant.platform.display_name }}
          </router-link>
          <div class="ml-auto">
            <!-- Sidenav toggler -->
            <div
              class="sidenav-toggler d-none d-xl-block"
              data-action="sidenav-unpin"
              data-target="#sidenav-main"
            >
              <div class="sidenav-toggler-inner">
                <i class="sidenav-toggler-line"></i>
                <i class="sidenav-toggler-line"></i>
                <i class="sidenav-toggler-line"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="navbar-inner">
          <!-- Collapse -->
          <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Nav items -->
            <ul class="navbar-nav">
              <li class="nav-item">
                <router-link
                  to="/admin/stats"
                  class="nav-link"
                  :class="{'active': /admin\/stats/.test($route.path)}"
                >
                  <i class="fa fa-home text-primary"></i>
                  <span class="sidenav-normal">{{ trans.app.dashboard }}</span>
                </router-link>
              </li>
              <li 
                v-permission="[
                  'view_partners', 'create_partners', 'update_partners', 'delete_partners',
                  'view_platforms', 'create_platforms', 'update_platforms', 'delete_platforms',
                ]" 
                class="nav-item">
                <a
                  href="#platformSubmenu"
                  data-toggle="collapse"
                  aria-expanded="false"
                  class="nav-link"
                  :class="{'active': /admin\/partners/.test($route.path) || 
                    /admin\/platforms/.test($route.path)}"
                >
                  <i class="ni ni-app text-primary"></i>
                  <span class="sidenav-normal">{{ trans.app.platform }}</span>
                </a>
                <div class="collapse" id="platformSubmenu">
                  <ul class="nav nav-sm flex-column">
                    <li class="nav-item"
                      v-permission="[
                        'view_platforms', 'create_platforms', 'update_platforms', 'delete_platforms',
                      ]">
                      <router-link :to="`/admin/platforms/${CurrentTenant.platform.id}/edit`" class="nav-link">
                        <span class="sidenav-normal">{{ trans.app.platforms }}</span>
                      </router-link>
                    </li>
                    <li class="nav-item"
                      v-permission="[
                        'view_partners', 'create_partners', 'update_partners', 'delete_partners',
                      ]"
                    >
                      <router-link to="/admin/partners" class="nav-link">
                        <span class="sidenav-normal">{{ trans.app.partners }}</span>
                      </router-link>
                    </li>
                  </ul>
                </div>
              </li>
              <li
                v-permission="[
                  'view_states', 'create_states', 'update_states', 'delete_states', 
                  'view_local_governments', 'create_local_governments', 'update_local_governments', 'delete_local_goverments'
                ]"
                class="nav-item"
              >
                <a
                  class="nav-link"
                  :class="{'active': /admin\/states/.test($route.path) || /admin\/local-governments/.test($route.path)}"
                  href="#navbar-location"
                  data-toggle="collapse"
                  role="button"
                  aria-expanded="false"
                  aria-controls="navbar-location"
                >
                  <i class="ni ni-pin-3 text-primary"></i>
                  <span class="nav-link-text">{{ trans.app.location }}</span>
                </a>
                <div class="collapse" id="navbar-location">
                  <ul class="nav nav-sm flex-column">
                    <li
                      v-permission="['view_states', 'create_states', 'update_users', 'delete_states']"
                      class="nav-item"
                    >
                      <router-link to="/admin/states" class="nav-link">
                        <span class="sidenav-normal">{{ trans.app.states }}</span>
                      </router-link>
                    </li>
                    <li
                      v-permission="['view_local_governments', 'create_local_governments', 'update_local_governments', 'delete_local_goverments']"
                      class="nav-item"
                    >
                      <router-link to="/admin/local-governments" class="nav-link">
                        <span class="sidenav-normal">{{ trans.app.local_governments }}</span>
                      </router-link>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item"
                v-permission="['view_memorial', 'create_memorial', 'update_memorial', 'delete_memorial']">
                <router-link
                  to="/admin/memorial"
                  class="nav-link"
                  :class="{'active': /admin\/memorial/.test($route.path)}"
                >
                  <i class="ni ni-single-02 text-primary"></i>
                  <span class="sidenav-normal">{{ trans.app.members }}</span>
                </router-link>
              </li>
              <li
                v-permission="['create_posts', 'update_posts', 'update_own_posts', 'view_posts', 'delete_posts', 'delete_own_posts', 'approve_posts', 'publish_posts']"
                class="nav-item"
              >
                <a
                  class="nav-link"
                  :class="{'active': /admin\/posts/.test($route.path)}"
                  href="#navbar-posts"
                  data-toggle="collapse"
                  role="button"
                  aria-expanded="false"
                  aria-controls="navbar-posts"
                >
                  <i class="ni ni-bold text-primary"></i>
                  <span class="nav-link-text">{{ trans.app.posts_simple }}</span>
                </a>
                <div class="collapse" id="navbar-posts">
                  <ul class="nav nav-sm flex-column">
                    <li class="nav-item">
                      <router-link to="/admin/posts" class="nav-link">
                        <span class="sidenav-normal">{{ trans.app.posts_simple }}</span>
                      </router-link>
                    </li>
                    <li class="nav-item">
                      <router-link to="/admin/posts/tags" class="nav-link">
                        <span class="sidenav-normal">{{ trans.app.tags }}</span>
                      </router-link>
                    </li>
                    <li class="nav-item">
                      <router-link to="/admin/posts/topics" class="nav-link">
                        <span class="sidenav-normal">{{ trans.app.topics }}</span>
                      </router-link>
                    </li>
                  </ul>
                </div>
              </li>
              <li
                v-permission="[
                  'create_trackers', 'update_trackers', 'view_trackers', 'delete_trackers',
                  'create_tracker_items', 'update_tracker_items', 'view_tracker_items', 'delete_tracker_items'
                ]"
                class="nav-item"
              >
                <a
                  class="nav-link"
                  :class="{'active': /admin\/trackers/.test($route.path) || /admin\/trackerItems/.test($route.path)}"
                  href="#navbar-tracker"
                  data-toggle="collapse"
                  role="button"
                  aria-expanded="false"
                  aria-controls="navbar-tracker"
                >
                  <i class="ni ni-square-pin text-primary"></i>
                  <span class="nav-link-text">{{ trans.app.trackers }}</span>
                </a>
                <div class="collapse" id="navbar-tracker">
                  <ul class="nav nav-sm flex-column">
                    <li
                      v-permission="['create_trackers', 'update_trackers', 'view_trackers', 'delete_trackers']"
                      class="nav-item"
                    >
                      <router-link to="/admin/trackers" class="nav-link">
                        <span class="sidenav-normal">{{ trans.app.trackers }}</span>
                      </router-link>
                    </li>
                    <li
                      v-permission="['create_tracker_items', 'update_tracker_items', 'view_tracker_items', 'delete_tracker_items']"
                      class="nav-item"
                    >
                      <router-link :to="{ name: 'trackerItems-select' }" class="nav-link">
                        <span class="sidenav-normal">{{ trans.app.tracker_items }}</span>
                      </router-link>
                    </li>
                  </ul>
                </div>
              </li>
              <li
                v-permission="[
                  'view_users', 'view_own_users', 'create_users', 'update_users', 'update_own_users', 'delete_users', 'delete_own_users', 'change_users_password', 'change_users_own_password',
                  'create_roles', 'update_roles', 'view_roles', 'delete_roles'
                ]"
                class="nav-item"
              >
                <a
                  class="nav-link"
                  :class="{'active': /admin\/users/.test($route.path) || /admin\/roles/.test($route.path)}"
                  href="#navbar-users"
                  data-toggle="collapse"
                  role="button"
                  aria-expanded="false"
                  aria-controls="navbar-users"
                >
                  <i class="ni ni-single-02 text-primary"></i>
                  <span class="nav-link-text">{{ trans.app.users }}</span>
                </a>
                <div class="collapse" id="navbar-users">
                  <ul class="nav nav-sm flex-column">
                    <li
                      v-permission="['create_roles', 'update_roles', 'view_roles', 'delete_roles']"
                      class="nav-item"
                    >
                      <router-link to="/admin/roles" class="nav-link">
                        <span class="sidenav-normal">{{ trans.app.roles }}</span>
                      </router-link>
                    </li>
                    <li
                      v-permission="['view_users', 'view_own_users', 'create_users', 'update_users', 'update_own_users', 'delete_users', 'delete_own_users', 'change_users_password', 'change_users_own_password']"
                      class="nav-item"
                    >
                      <router-link to="/admin/users" class="nav-link">
                        <span class="sidenav-normal">{{ trans.app.users }}</span>
                      </router-link>
                    </li>
                  </ul>
                </div>
              </li>
              <h6 class="navbar-heading text-muted mb-0 pb-0">
                <span class="docs-normal">{{ trans.app.session }}</span>
              </h6>
              <li class="nav-item">
                <router-link
                  target="_blank"
                  class="nav-link"
                  to="/"
                >
                  <i class="ni ni-tv-2 text-primary"></i>
                  <span class="nav-link-text">{{ trans.app.view_site }}</span>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link
                  class="nav-link"
                  :class="{'active': /admin\/settings/.test($route.path)}"
                  to="/admin/settings"
                >
                  <i class="ni ni-settings-gear-65 text-primary"></i>
                  <span class="nav-link-text">{{ trans.app.settings }}</span>
                </router-link>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#" @click.prevent="sessionLogout">
                  <i class="ni ni-button-power text-primary"></i>
                  <span class="nav-link-text">{{ trans.app.sign_out }}</span>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </nav>

    <!-- Main content -->
    <div class="main-content" id="panel">
      <main>
        <nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom">
          <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <!-- Search form -->
              <form
                class="navbar-search navbar-search-light form-inline mr-sm-3"
                id="navbar-search-main"
              >
                <div class="form-group mb-0">
                  <div class="input-group input-group-alternative input-group-merge">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="fas fa-search"></i>
                      </span>
                    </div>
                    <input class="form-control" placeholder="Search" type="text" disabled />
                  </div>
                </div>
                <button
                  type="button"
                  class="close"
                  data-action="search-close"
                  data-target="#navbar-search-main"
                  aria-label="Close"
                >
                  <span aria-hidden="true">×</span>
                </button>
              </form>
              <ul class="navbar-nav align-items-center  ml-md-auto ">
                <li class="nav-item d-xl-none">
                  <!-- Sidenav toggler -->
                  <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin" data-target="#sidenav-main">
                    <div class="sidenav-toggler-inner">
                      <i class="sidenav-toggler-line"></i>
                      <i class="sidenav-toggler-line"></i>
                      <i class="sidenav-toggler-line"></i>
                    </div>
                  </div>
                </li>
                <li class="nav-item d-sm-none">
                  <a class="nav-link" href="#" data-action="search-show" data-target="#navbar-search-main">
                    <i class="ni ni-zoom-split-in"></i>
                  </a>
                </li>
                <!-- <li class="nav-item dropdown">
                  <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="ni ni-bell-55"></i>
                  </a>
                  <div class="dropdown-menu dropdown-menu-xl  dropdown-menu-right  py-0 overflow-hidden">
                    <div class="px-3 py-3">
                      <h6 class="text-sm text-muted m-0">You have <strong class="text-primary">13</strong> notifications.</h6>
                    </div>
                    <div class="list-group list-group-flush">
                      <a href="#!" class="list-group-item list-group-item-action">
                        <div class="row align-items-center">
                          <div class="col-auto">
                            <img alt="Image placeholder" :src="avatar" class="avatar rounded-circle">
                          </div>
                          <div class="col ml--2">
                            <div class="d-flex justify-content-between align-items-center">
                              <div>
                                <h4 class="mb-0 text-sm">John Snow</h4>
                              </div>
                              <div class="text-right text-muted">
                                <small>2 hrs ago</small>
                              </div>
                            </div>
                            <p class="text-sm mb-0">Let's meet at Starbucks at 11:30. Wdyt?</p>
                          </div>
                        </div>
                      </a>
                    </div>
                  </div>
                </li> -->
                <!-- <li class="nav-item dropdown">
                  <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="ni ni-ungroup"></i>
                  </a>
                  <div class="dropdown-menu dropdown-menu-lg dropdown-menu-dark bg-default  dropdown-menu-right ">
                    <div class="row shortcuts px-4">
                      <a href="#!" class="col-4 shortcut-item">
                        <span class="shortcut-media avatar rounded-circle bg-gradient-red">
                          <i class="ni ni-calendar-grid-58"></i>
                        </span>
                        <small>Calendar</small>
                      </a>
                      <a href="#!" class="col-4 shortcut-item">
                        <span class="shortcut-media avatar rounded-circle bg-gradient-orange">
                          <i class="ni ni-email-83"></i>
                        </span>
                        <small>Email</small>
                      </a>
                      <a href="#!" class="col-4 shortcut-item">
                        <span class="shortcut-media avatar rounded-circle bg-gradient-info">
                          <i class="ni ni-credit-card"></i>
                        </span>
                        <small>Payments</small>
                      </a>
                      <a href="#!" class="col-4 shortcut-item">
                        <span class="shortcut-media avatar rounded-circle bg-gradient-green">
                          <i class="ni ni-books"></i>
                        </span>
                        <small>Reports</small>
                      </a>
                      <a href="#!" class="col-4 shortcut-item">
                        <span class="shortcut-media avatar rounded-circle bg-gradient-purple">
                          <i class="ni ni-pin-3"></i>
                        </span>
                        <small>Maps</small>
                      </a>
                      <a href="#!" class="col-4 shortcut-item">
                        <span class="shortcut-media avatar rounded-circle bg-gradient-yellow">
                          <i class="ni ni-basket"></i>
                        </span>
                        <small>Shop</small>
                      </a>
                    </div>
                  </div>
                </li> -->
              </ul>
            </div>
          </div>
        </nav>
        <div class="header bg-primary pb-6">
          <div class="container-fluid">
            <div class="header-body">
              <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                  <h6 class="h2 text-white d-inline-block mb-0">
                    <slot name="page-title" />
                  </h6>
                  <slot name="breadcrumb" />
                </div>
                <div style="z-index: 1501" class="col-lg-6 col-5 text-right">
                  <ul class="navbar-nav mr-3">
                    <li class="text-white font-weight-bold">
                      <slot name="status" />
                    </li>
                  </ul>

                  <div >
                    <slot name="action" />
                  </div>

                  <slot name="menu" />
                </div>
              </div>
              <slot name="header-content" />
            </div>
          </div>
        </div>
        <div style="z-index: 1500" class="container-fluid mt--6">
          <div class="row">
            <div class="col">
              <div class="card">
                <div class="card-header border-0">
                  <slot name="main-card-header" />
                </div>
                <slot name="main" />
                <div class="card-footer py-4">
                  <slot name="main-card-footer" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>

    <slot name="modals" />
  </div>
</template>

<script>

export default {
  name: "page-side-bar",

  data() {
    return {
      trans: JSON.parse(CurrentTenant.translations)
    };
  },

  created() {
    if (this.isUser) {
      this.$router.push({ name: "home" });
    }
  },

  methods: {
    sessionLogout() {
      this.logout();
    },
  }
};
</script>

<style scoped>

</style>
