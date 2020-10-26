<template>
  <div>
    <vue-headful
      :title="metaTitle"
      :description="metaDescription"
      :image="metaImageUrl"
      :url="metaUrl"
    />
    <page-header>
      <template v-if="tracker.has_user_reporting === 1" slot="action">
        <router-link
          :to="{ name: 'trackerItems-submit' }"
          class="btn btn-sm btn-outline-success font-weight-bold my-auto"
        >{{ trans.app.report }}</router-link>
      </template>
    </page-header>

    <div class="py-5">
      <div class="col-xl-10 offset-xl-1 px-xl-5 col-md-12">
        <div class="row">
          <div class="col-4 d-none d-sm-block">
            <h1>
              {{ tracker.name }}
              <hr>
            </h1>
            <div class="p-3">
              <div v-for="(field, index) in tracker.fields" :key="index">
                <div v-if="field.type === 'select'" class="form-group mb-3">
                  <label :for="field.model">{{ field.label }}</label>
                  <select v-model="query" class="form-control" :id="field.model">
                    <option value="" disabled>{{ trans.app.select }}</option>
                    <option 
                      v-for="(value, index) in field.values" 
                      :key="index"
                      :value="value">
                      {{ value }}
                    </option>
                  </select>
                </div>
              </div>
              <div>
                <input 
                  class="form-control" 
                  type="text" 
                  placeholder="Search" 
                  aria-label="Search"
                  v-model="query"
                >
                <small>showing from {{ from }} to {{ to }} of {{ total }}</small>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-8">
            <main>
              <div class="mt-2">
                <div 
                  v-for="(trackerItem, $index) in trackerItems" 
                  :key="$index" 
                  class="card flex-md-row mb-4 h-md-250 shadown-sm">
                  <div class="card-body d-flex flex-column align-items-start">
                    <!-- <strong class="d-inline-block mb-2 text-success"></strong> -->
                    <h3 class="mb-0">
                      <router-link
                        :to="{name: 'trackerItems-show', params: { trackerId: $route.params.trackerId, id: trackerItem.id }}"
                        class="text-dark"
                      >
                        {{ trackerItem.title }}
                      </router-link>
                    </h3>
                    <p class="lead" v-html="trackerItem.description"></p>
                    <div class="mb-1 text-muted">{{moment(trackerItem.created_at).locale(CurrentTenant.locale).fromNow()}}</div>
                    <router-link :to="{name: 'trackerItems-show', params: { trackerId: $route.params.trackerId, id: trackerItem.id }}">
                      {{ trans.app.view }}
                    </router-link>
                  </div>
                  <div class="flex-auto d-none d-lg-block"></div>
                </div>

                <infinite-loading 
                  :identifier="infiniteId"
                  @infinite="fetchData" 
                  spinner="spiral" 
                  style="position: relative; top: 0">
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
          </div>
        </div>
      </div>
    </div>

    <page-footer></page-footer>
  </div>
</template>

<script>
import _ from "lodash"
import moment from "moment";
import NProgress from "nprogress";
import InfiniteLoading from "vue-infinite-loading";

export default {
  name: "trackerItems-index",

  components: {
    InfiniteLoading
  },

  data() {
    return {
      page: 1,
      trackerItems: [],
      tracker: {},
      trans: JSON.parse(CurrentTenant.translations),
      infiniteId: +new Date(),
      query: "",
      url: `/api/v1/trackerItems/${this.$route.params.trackerId}`,
      from: "",
      to: "",
      total: "",
    };
  },

  created() {
    
  },

  watch: {
    query: function (val) {

      if (val === "") {
        this.url = `/api/v1/trackerItems/${this.$route.params.trackerId}`
      } else {
        this.url = `/api/v1/trackerItems/${this.$route.params.trackerId}?query=${this.query}`
      }
      
      this.page = 1;
      this.trackerItems = [];
      this.infiniteId += 1;

    }, 

    $route(to, from) {
      this.refreshLoader()
    }
  },

  beforeRouteEnter(to, from, next) {
    next(vm => {
      vm.request()
        .get("/api/v1/trackers/" + to.params.trackerId)
        .then(response => {
          vm.tracker = response.data
        })
    })
  },

  methods: {
    fetchData($state) {
      this.request()
        .get(this.url, {
          params: {
            page: this.page,
            confirmationStatus: 'confirmed'
          }
        })
        .then(response => {
          if (!_.isEmpty(response.data) && !_.isEmpty(response.data.trackerItems.data)) {
            this.page += 1;
            this.trackerItems.push(...response.data.trackerItems.data);
            this.from = response.data.trackerItems.from
            this.to = response.data.trackerItems.data.to
            this.total = response.data.trackerItems.total

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

    refreshLoader() {
      this.page = 1;
      this.trackerItems = [];
      this.url = `/api/v1/trackerItems/${this.$route.params.trackerId}`
      this.infiniteId += 1
      this.query = ""

      this.request()
        .get("/api/v1/trackers/" + this.$route.params.trackerId)
        .then(response => {
          this.tracker = response.data
        })
    }
  }
};
</script>

<style scoped></style>
