<template>
  <admin-page>
    <template slot="page-title">
      {{ trans.app.states }}
    </template>
    <template slot="breadcrumb">
      <breadcrumb :links="breadcrumbLinks" />
    </template>
    <template slot="main">
      <div class="col">
        <div class="d-flex justify-content-between">
          <h1>{{ trans.app.states }}</h1>
        </div>

        <div class="mt-2">
          <div
            v-for="(state, $index) in states"
            :key="$index"
            class="d-flex border-top py-3 align-items-center"
          >
            <div class="mr-auto">
              <p class="mb-0 py-1">
                <router-link
                  to="#"
                  class="font-weight-bold text-lg lead text-decoration-none"
                >{{ state.name }}</router-link>
              </p>
            </div>
            <div class="ml-auto">
              <span class="text-muted mr-3">{{ state.local_governments.length + ' ' + trans.app.local_governments }}</span>
              <span
                class="d-none d-md-inline-block"
              >{{ trans.app.created }} {{ moment(state.created_at).locale(CurrentTenant.locale).fromNow() }}</span>
            </div>
          </div>

          <infinite-loading :identifier="infiniteId" @infinite="fetchData" spinner="spiral">
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
  name: "states-index",

  components: {
    InfiniteLoading
  },

  data() {
    return {
      page: 1,
      states: [],
      infiniteId: +new Date(),
      trans: JSON.parse(CurrentTenant.translations),
      breadcrumbLinks: [
        {
          title: 'All States',
          url: '/admin/states',
        }
      ]
    };
  },

  created() {

  },

  methods: {
    fetchData($state) {
      this.request()
        .get("/api/v1/states", {
          params: {
            page: this.page
          }
        })
        .then(response => {
          if (!_.isEmpty(response.data) && !_.isEmpty(response.data.data)) {
            this.page += 1;
            this.states.push(...response.data.data);

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
