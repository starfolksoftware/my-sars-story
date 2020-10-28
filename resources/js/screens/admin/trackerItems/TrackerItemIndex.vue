<template>
  <admin-page>
    <template v-if="trackerId !== 'select'" slot="action">
      <router-link
        v-permission="['create_tracker_items']"
        :to="{ name: 'trackerItems-create', params: { trackerId: trackerId } }"
        class="btn btn-sm btn-danger font-weight-bold my-auto"
      >{{ trans.app.new_tracker_item }}</router-link>
    </template>
    <template slot="page-title">
      {{ trans.app.trackers }}
    </template>
    <template slot="breadcrumb">
      <breadcrumb :links="breadcrumbLinks" />
    </template>
    <template slot="main">
      <div v-if="trackerId === 'select'" class="col">
        <div class="d-flex justify-content-between my-3">
          <h1>{{ trans.app.select_trackers }}</h1>
        </div>
        <div
          v-for="(tracker, $index) in trackers"
          :key="$index"
          class="d-flex border-top py-3 align-items-center"
        >
          <div class="mr-auto">
            <p class="mb-0 py-1">
              <router-link
                :to="{name: 'trackerItems', params: { trackerId: tracker.id }}"
                class="font-weight-bold text-lg lead text-decoration-none"
              >{{ tracker.name }}</router-link>
            </p>
          </div>
          <div class="ml-auto">
            <span
              class="d-none d-md-inline-block"
            >
              {{ trans.app.created }} {{ moment(tracker.created_at).locale(CurrentTenant.locale).fromNow() }}
            </span>
          </div>
        </div>
      </div>
      <div v-else class="col">
        <div class="d-flex justify-content-between my-3">
          <h1>
            {{ trans.app.tracker_items }}
          </h1>

          <select
            name
            id
            v-model="confirmationStatus"
            @change="refreshInfiniteLoader"
            class="my-auto bg-transparent appearance-none border-0 text-muted"
          >
            <option value="confirmed">{{ trans.app.confirmed }} ({{ confirmedCount }})</option>
            <option value="notConfirmed">{{ trans.app.not_confirmed }} ({{ notConfirmedCount }})</option>
          </select>
        </div>

        <div class="mt-2">
          <div
            v-for="(trackerItem, $index) in trackerItems"
            :key="$index"
            class="d-flex border-top py-3 align-items-center"
          >
            <div class="mr-auto">
              <p class="mb-0 py-1">
                <router-link
                  :to="{name: 'trackerItems-edit', params: { id: trackerItem.id }}"
                  class="font-weight-bold text-lg lead text-decoration-none"
                  v-if="trackerItem.description" v-html="trim(trackerItem.description, 200)"
                ></router-link>
              </p>
              <!-- <p class="mb-1" v-if="trackerItem.description" v-html="trim(trackerItem.description, 200)"></p> -->
            </div>
            <div class="ml-auto">
              <span class="text-muted mr-3">{{  }}</span>
              <span
                class="d-none d-md-inline-block"
              >
                {{ trans.app.created }} {{ moment(trackerItem.created_at).locale(CurrentTenant.locale).fromNow() }}
              </span>
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
  name: "trackerItems-index",

  components: {
    InfiniteLoading
  },

  data() {
    return {
      trackerId: this.$route.params.trackerId || "select",
      trackers: [],
      page: 1,
      infiniteId: +new Date(),
      trackerItems: [],
      trans: JSON.parse(CurrentTenant.translations),
      isReady: false,
      confirmationStatus: 'confirmed',
      confirmedCount: 0,
      notConfirmedCount: 0,
      breadcrumbLinks: [
        {
          title: JSON.parse(CurrentTenant.translations).app.trackers,
          url: '/admin/trackers',
        },
        {
          title: JSON.parse(CurrentTenant.translations).app.select_trackers,
          url: '/admin/trackerItems/select'
        }
      ]
    };
  },

  watch: {
    $route(to, from) {
      // react to route changes...
      if (!this.$route.params.id) {
        this.request()
          .get("/api/v1/trackers?all=1")
          .then(response => {
            this.trackers = response.data
            this.isReady = true
            NProgress.done();
          })
      }

      this.trackerId = this.$route.params.trackerId || "select"
      this.refreshInfiniteLoader()
    }
  },

  beforeRouteEnter(to, from, next) {
    next(vm => {
      if (!vm.$route.params.id) {
        vm.request()
          .get("/api/v1/trackers?all=1")
          .then(response => {
            vm.trackers = response.data
            vm.isReady = true
            NProgress.done();
          })
      }
    })
  },

  created() {
    
  },

  methods: {
    fetchData($state) {
      this.request()
        .get("/api/v1/trackerItems/" + this.trackerId, {
          params: {
            page: this.page,
            confirmationStatus: this.confirmationStatus
          }
        })
        .then(response => {
          this.confirmedCount = response.data.confirmedCount
          this.notConfirmedCount = response.data.notConfirmedCount

          if (!_.isEmpty(response.data) && !_.isEmpty(response.data.trackerItems.data)) {
            this.page += 1;
            this.trackerItems.push(...response.data.trackerItems.data);

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

    refreshInfiniteLoader() {
      this.page = 1;
      this.trackerItems = [];
      this.infiniteId += 1;
    }
  }
};
</script>
