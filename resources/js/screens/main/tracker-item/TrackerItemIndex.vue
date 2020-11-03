<template>
  <div>
    <vue-headful
      :title="metaTitle"
      :description="metaDescription"
      :image="metaImageUrl"
      :url="metaUrl"
    />
    <page-header>
      <template v-if="tracker.has_user_reporting === '1'" slot="action">
        <a
          @click.prevent="showReportModal"
          href="#"
          class="btn btn-sm btn-outline-primary font-weight-bold my-auto"
        >{{ trans.app.report }}</a>
      </template>
    </page-header>

    <div class="pt-5">
      <div class="col-xl-10 offset-xl-1 px-xl-5 col-12">
        <div class="row">
          <div class="col-12 col-md-4">
            <div class="form-group mb-5">
              <select
                class="form-control float-right"
                v-model="trId"
                @change="$router.push({ name: 'trackerItems-main', params: { trackerId: trId }})">
                <option value="" disabled>{{ trans.app.select }}</option> 
                <option 
                  v-for="(tracker, index) in trackers" 
                  :key="index" 
                  :value="tracker.id"
                  >
                  {{ tracker.name }}
                </option>
              </select>
            </div>
            <hr>
            <p class="lead text-secondary" v-html="tracker.description"></p>
            <div class="p-3">
              <div v-for="(field, index) in tracker.fields" :key="index">
                <div v-if="field.type === 'select'" class="form-group mb-3">
                  <label :for="field.name" class="text-primary">{{ field.label }}</label>
                  <select v-model="query" class="form-control" :id="field.name">
                    <option value="" disabled>{{ trans.app.select }}</option>
                    <option 
                      v-for="(option, index) in field.options" 
                      :key="index"
                      :value="option.value">
                      {{ option.label }}
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
                <!-- <small>showing from {{ from }} to {{ to }} of {{ total }}</small> -->
              </div>
            </div>
          </div>
          <div class="col-12 col-md-8">
            <map-preview :markers="markers" />
          </div>
        </div>
      </div>
    </div>

    <page-footer></page-footer>

    <report-modal 
      v-if="tracker.id" ref="reportModal"
      :tracker="tracker"
    />
  </div>
</template>

<script>
import _ from "lodash"
import moment from "moment"
import NProgress from "nprogress"
import InfiniteLoading from "vue-infinite-loading"
import ReportModal from "../../../components/global/modals/ReportModal"
import MapPreview from "../../../components/global/previews/MapPreview"

export default {
  name: "trackerItems-index",

  components: {
    InfiniteLoading,
    ReportModal,
    MapPreview
  },

  data() {
    return {
      trackerItems: [],
      tracker: {},
      trId: this.$route.params.trackerId,
      trackers: CurrentTenant.trackers || [],
      trans: JSON.parse(CurrentTenant.translations),
      query: "",
      url: `/api/v1/trackerItems/${this.$route.params.trackerId}?forMap=1`,
      from: "",
      to: "",
      total: "",
      markers: []
    };
  },

  watch: {
    query: function (val) {

      if (val === "") {
        this.url = `/api/v1/trackerItems/${this.$route.params.trackerId}?forMap=1`
      } else {
        this.url = `/api/v1/trackerItems/${this.$route.params.trackerId}?forMap=1&&query=${this.query}`
      }
      
      this.fetchData()

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
          NProgress.done()
        })

      vm.fetchData()
    })
  },

  methods: {
    fetchData() {
      this.markers = []
      this.request()
        .get(this.url, {
          params: {
            confirmationStatus: 'confirmed'
          }
        })
        .then(response => {
          if (!_.isEmpty(response.data)) {
            this.markers = response.data;
          } 

          NProgress.done();
        })
        .catch(error => {
          // Add any error debugging...

          NProgress.done();
        });
    },

    refreshLoader() {
      this.markers = [];
      this.url = `/api/v1/trackerItems/${this.$route.params.trackerId}?forMap=1`
      this.query = ""
      this.fetchData()

      this.request()
        .get("/api/v1/trackers/" + this.$route.params.trackerId)
        .then(response => {
          this.tracker = response.data
          NProgress.done()
        })
    },

    showReportModal() {
      $(this.$refs.reportModal.$el).modal("show");
    },
  }
};
</script>

<style scoped></style>
