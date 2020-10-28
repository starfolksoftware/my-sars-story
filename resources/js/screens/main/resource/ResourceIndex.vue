<template>
  <div>
    <page-header></page-header>
    <main class="text-primary px-4">
      <div class="page-title w-full">
        <h2 class="font-weight-900 display-4 text-primary mt-5">
          {{ trans.app.resources }}
        </h2>
      </div>
      <div class="mt-5">
        <div 
          v-for="(resource, $index) in resources"
          :key="$index" 
          class="col-12 mb-5">
          <div class="row mb-5">
            <div style="height: 250px" class="col-md-4 rounded border border-primary d-flex justify-content-center">
              <span class="display-4 align-self-center format">
                {{ `.${mediaFormat(resource.path)}` }}
              </span>
            </div>
            <div class="col-md-8 text-left d-flex flex-column justify-content-between">
              <div>
                <h3 class="font-weight-800 text-primary mt-0">{{ resource.title }}</h3>
                <p class="font-weight-500 lead" v-html="resource.description"></p>
              </div>
              <div class="w-full">
                <a
                  :href="resource.path"
                  class="btn btn-lg btn-outline-secondary w-50 float-right" download>
                  <i>{{ trans.app.download }}</i>
                </a>
              </div>
            </div>
          </div>
          <hr>
        </div>

        <infinite-loading 
          :identifier="infiniteId"
          @infinite="fetchData" 
          spinner="spiral">
          <span slot="no-more"></span>
          <div slot="no-results" class="text-left">
            <div class="mt-5">
              <p class="lead text-center text-muted mt-5 pt-5">
                <span>
                  {{trans.app.you_have_no_results}}
                </span>
              </p>
            </div>
          </div>
        </infinite-loading>
      </div>
    </main>
    <page-footer></page-footer>
  </div>
</template>

<script>
import moment from "moment";
import NProgress from "nprogress";
import InfiniteLoading from "vue-infinite-loading";

export default {
  name: "resources-index",
  components: {
    InfiniteLoading,
  },
  data() {
    return {
      page: 1,
      resources: [],
      trans: JSON.parse(CurrentTenant.translations),
      infiniteId: +new Date(),
      url: "/api/v1/resources",
    };
  },
  methods: {
    fetchData(
      $state
    ) {
      this.request()
        .get(this.url, {
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
    },
  }
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Audiowide&display=swap');

.img-grayscale {
  filter: grayscale(100%);
}

.page-title h2:after {
  background-image: linear-gradient(180deg,transparent,transparent 6.25%,#000 0,#000 25%,transparent 0,transparent 40.625%,#000 0,#000 59.375%,transparent 0,transparent 75%,#000 0,#000 93.75%,transparent 0,transparent);
  content: "";
  height: .75em;
  /* left: .2em; */
  display: inline-block;
  width: 100%;
}

.format {
  font-family: 'Audiowide', cursive;
}
</style>
