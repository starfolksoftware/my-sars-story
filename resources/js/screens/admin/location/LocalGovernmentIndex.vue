<template>
  <admin-page>
    <template slot="page-title">
      {{ trans.app.local_governments }}
    </template>
    <template slot="breadcrumb">
      <breadcrumb :links="breadcrumbLinks" />
    </template>
    <template slot="main">
      <div class="col">
        <div class="d-flex justify-content-between">
          <h1>{{ trans.app.local_governments }}</h1>

          <select
            name
            id
            v-model="state"
            @change="filterLocalGovernments"
            class="my-auto ml-auto w-auto bg-transparent custom-select border-0"
          >
            <option value="all">
              {{ trans.app.all }}
            </option>
            <option 
              v-for="(state, index) in states" 
              :key="index" 
              :value="state.id">
              {{ state.name }}
            </option>
          </select>
        </div>

        <div class="mt-2">
          <div
            v-for="(localGovernment, $index) in localGovernments"
            :key="$index"
            class="d-flex border-top py-3 align-items-center"
          >
            <div class="mr-auto">
              <p class="mb-0 py-1">
                <router-link
                  to="#"
                  class="font-weight-bold text-lg lead text-decoration-none"
                >{{ localGovernment.name }}</router-link>
              </p>
            </div>
            <div class="ml-auto">
              <span class="text-muted mr-3" v-if="localGovernment.state">{{ localGovernment.state[0].name }}</span>
              <span
                class="d-none d-md-inline-block"
              >{{ trans.app.created }} {{ moment(localGovernment.created_at).locale(CurrentTenant.locale).fromNow() }}</span>
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
  name: "local-governments-index",

  components: {
    InfiniteLoading
  },

  data() {
    return {
      page: 1,
      localGovernments: [],
      state: 'all',
      states: [],
      infiniteId: +new Date(),
      trans: JSON.parse(CurrentTenant.translations),
      breadcrumbLinks: [
        {
          title: JSON.parse(CurrentTenant.translations).app.local_governments,
          url: '/admin/local-governments',
        }
      ]
    };
  },

  created() {
    this.fetchStates()
  },

  methods: {
    fetchData($state) {
      this.request()
        .get("/api/v1/localGovernments", {
          params: {
            page: this.page,
            state: this.state
          }
        })
        .then(response => {
          if (!_.isEmpty(response.data) && !_.isEmpty(response.data.data)) {
            this.page += 1;
            this.localGovernments.push(...response.data.data);

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

    fetchStates() {
      this.request()
        .get("/api/v1/states?all=1")
        .then(response => {
          this.states = response.data

          NProgress.done();
        })
        .catch(error => {
          NProgress.done();
        });
    },

    filterLocalGovernments() {
      this.page = 1;
      this.localGovernments = [];
      this.infiniteId += 1;
    }
  }
};
</script>
