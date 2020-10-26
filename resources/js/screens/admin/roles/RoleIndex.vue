<template>
  <admin-page>
    <template slot="action">
      <router-link
        :to="{ name: 'roles-create' }"
        class="btn btn-sm btn-danger font-weight-bold my-auto"
      >{{ trans.app.new_role }}</router-link>
    </template>
    <template slot="page-title">
      {{ trans.app.roles }}
    </template>
    <template slot="breadcrumb">
      <breadcrumb :links="breadcrumbLinks" />
    </template>
    <template slot="main">
      <div class="col">
        <div class="d-flex justify-content-between">
          <h1>{{ trans.app.roles }}</h1>
        </div>

        <div class="mt-2">
          <div
            v-for="(role, $index) in roles"
            :key="$index"
            class="d-flex border-top py-3 align-items-center"
          >
            <div class="mr-auto">
              <p class="mb-0 py-1">
                <router-link
                  :to="{name: 'roles-edit', params: { id: role.id }}"
                  class="font-weight-bold text-lg lead text-decoration-none"
                >{{ role.name }}</router-link>
              </p>
            </div>
            <div class="ml-auto">
              <span class="text-muted mr-3">{{ role.permissions_count }} {{ trans.app.permissions }}</span>
              <span
                class="d-none d-md-inline-block"
              >{{ trans.app.created }} {{ moment(role.created_at).locale(CurrentTenant.locale).fromNow() }}</span>
            </div>
          </div>

          <infinite-loading @infinite="fetchData" spinner="spiral">
            <span slot="no-more"></span>
            <div slot="no-results" class="text-left">
              <div class="mt-5">
                <p class="lead text-center text-muted mt-5 pt-5">{{ trans.app.you_have_no_results }}</p>
              </div>
            </div>
          </infinite-loading>
        </div>
      </div>
    </template>
  </admin-page>
</template>

<script>
import NProgress from "nprogress";
import InfiniteLoading from "vue-infinite-loading";

export default {
  name: "roles-index",

  components: {
    InfiniteLoading
  },

  data() {
    return {
      page: 1,
      roles: [],
      trans: JSON.parse(CurrentTenant.translations),
      breadcrumbLinks: [
        {
          title: JSON.parse(CurrentTenant.translations).app.roles,
          url: '/admin/roles',
        }
      ]
    };
  },

  created() {
    if (!this.isAdmin) {
      this.$router.push({ name: "stats" });
    }
  },

  methods: {
    fetchData($state) {
      this.request()
        .get("/api/v1/roles", {
          params: {
            page: this.page
          }
        })
        .then(response => {
          if (!_.isEmpty(response.data) && !_.isEmpty(response.data.data)) {
            this.page += 1;
            this.roles.push(...response.data.data);

            $state.loaded();
          } else {
            $state.complete();
          }

          NProgress.done();
        })
        .catch(error => {
          // Add any error debugging...

          NProgress.done();
        });
    }
  }
};
</script>
