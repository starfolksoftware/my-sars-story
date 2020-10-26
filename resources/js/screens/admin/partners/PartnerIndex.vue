<template>
  <admin-page>
    <template slot="action">
      <router-link
        :to="{ name: 'partners-create' }"
        class="btn btn-sm btn-danger font-weight-bold my-auto"
      >{{ trans.app.new_partner }}</router-link>
    </template>
    <template slot="page-title">
      {{ trans.app.partners }}
    </template>
    <template slot="breadcrumb">
      <breadcrumb :links="breadcrumbLinks" />
    </template>
    <template slot="main">
      <div class="col">
        <div class="d-flex justify-content-between my-3">
          <h1>{{ trans.app.partners }}</h1>
        </div>

        <div class="mt-2">
          <div
            v-for="(partner, $index) in partners"
            :key="$index"
            class="d-flex border-top py-3 align-items-center"
          >
            <div class="mr-auto">
              <p class="mb-0 py-1">
                <router-link
                  :to="{name: 'partners-edit', params: { id: partner.id }}"
                  class="font-weight-bold text-lg lead text-decoration-none"
                >{{ partner.name }}</router-link>
              </p>
            </div>
            <div class="ml-auto">
              <span
                class="d-none d-md-inline-block"
              >
                {{ trans.app.created }} {{ moment(partner.created_at).locale(CurrentTenant.locale).fromNow() }}
              </span>
              <div
                v-if="partner.logo"
                id="featuredImage"
                class="mr-2 ml-3 shadow-inner"
                :style="{backgroundImage:'url(' + partner.logo +')',}"
              ></div>
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
  name: "partners-index",
  components: {
    InfiniteLoading
  },
  data() {
    return {
      page: 1,
      partners: [],
      trans: JSON.parse(CurrentTenant.translations),
      breadcrumbLinks: [
        {
          title: 'All Partners',
          url: '#',
        },
      ]
    };
  },
  created() {
    if (!this.isAdmin) {
      this.$router.push({ name: "home" });
    }
  },
  methods: {
    fetchData($state) {
      this.request()
        .get("/api/v1/partners", {
          params: {
            page: this.page
          }
        })
        .then(response => {
          if (!_.isEmpty(response.data) && !_.isEmpty(response.data.data)) {
            this.page += 1;
            this.partners.push(...response.data.data);
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
