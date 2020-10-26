<template>
  <admin-page>
    <template slot="action">
      <router-link
        v-permission="['create_users']"
        :to="{ name: 'users-create' }"
        class="btn btn-sm btn-danger font-weight-bold my-auto"
      >{{ trans.app.new_user }}</router-link>
    </template>
    <template slot="page-title">
      {{ trans.app.users }}
    </template>
    <template slot="breadcrumb">
      <breadcrumb :links="breadcrumbLinks" />
    </template>
    <template slot="header-content">
      <div class="col col-md-6 mx-auto mb-4">
        <input v-model="query" type="text" class="form-control" :placeholder="trans.app.search">
      </div>
    </template>
    <template slot="main">
      <div class="col">
        <div class="d-flex justify-content-between">
          <h1>{{ trans.app.users }}</h1>

          <select
            name
            id
            v-model="role"
            @change="filterUsers"
            class="my-auto ml-auto w-auto bg-transparent custom-select border-0"
          >
            <option value="all">
              {{ trans.app.all }}
            </option>
            <option 
              v-for="(role, index) in roles" 
              :key="index" 
              :value="role">
              {{ role }}
            </option>
          </select>
        </div>

        <div class="mt-2">
          <div
            v-for="(user, $index) in users"
            :key="$index"
            class="d-flex border-top py-3 align-items-center"
          >
            <div class="mr-auto">
              <p class="mb-0 py-1">
                <router-link
                  :to="{name: 'users-edit', params: { id: user.id }}"
                  class="font-weight-bold text-lg lead text-decoration-none"
                >{{ user.name }}</router-link>
              </p>
            </div>
            <div class="ml-auto">
              <span class="text-muted mr-3">{{ user.roles[0] ? user.roles[0].name : 'User' }}</span>
              <span
                class="d-none d-md-inline-block"
              >{{ trans.app.created }} {{ moment(user.created_at).locale(CurrentTenant.locale).fromNow() }}</span>
            </div>
          </div>

          <infinite-loading :identifier="infiniteId" @infinite="fetchData" spinner="spiral">
            <span slot="no-more"></span>
            <div slot="no-results" class="text-left">
              <div class="mt-5">
                <p class="lead text-center text-muted mt-5 pt-5">{{ trans.app.you_have_no_users }}</p>
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
  name: "users-index",

  components: {
    InfiniteLoading
  },

  data() {
    return {
      page: 1,
      users: [],
      role: 'all',
      roles: [],
      query: '',
      infiniteId: +new Date(),
      trans: JSON.parse(CurrentTenant.translations),
      breadcrumbLinks: [
        {
          title: 'All Users',
          url: '/admin/users',
        }
      ]
    };
  },

  created() {
    if (!this.isAdmin) {
      this.$router.push({ name: "stats" });
    }

    this.fetchRoles()
  },

  watch: {
    query: function (val) {
      this.filterUsers()
    }
  },

  methods: {
    fetchData($state) {
      this.request()
        .get("/api/v1/users", {
          params: {
            page: this.page,
            role: this.role,
            query: this.query || null
          }
        })
        .then(response => {
          if (!_.isEmpty(response.data) && !_.isEmpty(response.data.data)) {
            this.page += 1;
            this.users.push(...response.data.data);

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
    },

    fetchRoles() {
      this.request()
        .get("/api/v1/roles?all=1")
        .then(response => {
          this.roles = response.data

          NProgress.done();
        })
        .catch(error => {
          NProgress.done();
        });
    },

    filterUsers() {
      this.page = 1;
      this.users = [];
      this.infiniteId += 1;
    },
  }
};
</script>
