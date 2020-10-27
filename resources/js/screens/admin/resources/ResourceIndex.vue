<template>
  <admin-page>
    <template slot="action">
      <router-link
        :to="{ name: 'resources-create' }"
        class="btn btn-sm btn-danger font-weight-bold my-auto"
      >{{ trans.app.new_resource }}</router-link>
    </template>
    <template slot="page-title">
      {{ trans.app.resources }}
    </template>
    <template slot="breadcrumb">
      <breadcrumb :links="breadcrumbLinks" />
    </template>
    <template slot="main">
      <div class="col">
        <div class="d-flex justify-content-between my-3">
          <h1>{{ trans.app.resources }}</h1>
        </div>

        <div class="mt-2">
          <div
            v-for="(resource, $index) in resources"
            :key="$index"
            class="d-flex border-top py-3 align-items-center"
          >
            <div class="mr-auto">
              <p class="mb-0 py-1">
                <router-link
                  :to="{name: 'resources-edit', params: { id: resource.id }}"
                  class="font-weight-bold text-lg lead text-decoration-none"
                >{{ resource.title }}</router-link>
              </p>
              <p class="mb-1" v-if="resource.description" v-html="trim(resource.description, 200)"></p>
            </div>
            <div class="ml-auto">
              <span
                class="d-none d-md-inline-block"
              >
                {{ trans.app.updated }} {{ moment(resource.updated_at).locale(CurrentTenant.locale).fromNow() }}
              </span>
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
  name: "resource-index",
  components: {
    InfiniteLoading
  },
  data() {
    return {
      page: 1,
      resources: [],
      trans: JSON.parse(CurrentTenant.translations),
      breadcrumbLinks: [
        {
          title: JSON.parse(CurrentTenant.translations).app.resources,
          url: '#',
        },
      ]
    };
  },
  created() {
    
  },
  methods: {
    fetchData($state) {
      this.request()
        .get("/api/v1/resources", {
          params: {
            page: this.page
          }
        })
        .then(response => {
          if (!_.isEmpty(response.data) && !_.isEmpty(response.data.data)) {
            this.page += 1;
            this.resources.push(...response.data.data);
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
