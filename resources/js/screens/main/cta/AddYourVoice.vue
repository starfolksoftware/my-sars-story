<template>
  <div class="d-md-flex">
    <page-header class="d-md-none"></page-header>
    <vue-headful
      :title="metaTitle"
      :description="metaDescription"
      :image="metaImageUrl"
      :url="metaUrl"
    />
    <div 
        class="d-none d-md-block flex-column col-md-4 vh-100 position-fixed bg-warning"
        style="background-image: url('/images/protests/protest_6.jpg')"></div>
    <div class="col-12 flex-column col-md-8 vh-100 overflow-auto position-absolute right-0">
      <router-link 
        class="btn btn-outline-primary mt-3" 
        :to="{ name: 'home' }">
        <span class="fas fa-long-arrow-alt-left ml-2"></span>
        {{ trans.app.home }}
      </router-link>
      <div class="container mt-5 h-50">
        <h1 class="font-weight-700">
          {{ trans.app.add_your_voice }}
        </h1>

        <div class="row h-100 text-center">
            <div class="col mx-auto my-auto">
                <a
                    v-for="(tracker, index) in hasUserReporting" :key="index"
                    @click.prevent="showReportModal(tracker.id)"
                    href="#"
                    class="btn btn-lg btn-outline-secondary w-50 mb-3">
                    <i>{{ `Report ${tracker.name}` }}</i>
                </a>
            </div>
        </div>
      </div>
    </div>
    <report-modal 
      v-if="tracker.id"
      ref="reportModal"
      :tracker="tracker"
    />
  </div>
</template>

<script>
import Vue from "vue";
import $ from "jquery";
import moment from "moment";
import NProgress from "nprogress";
import ReportModal from "../../../components/global/modals/ReportModal"

export default {
  name: "add-your-voice",

  components: {
    ReportModal,
  },

  data() {
    return {
      trans: JSON.parse(CurrentTenant.translations),
      platform: CurrentTenant.platform,
      trackers: CurrentTenant.trackers || [],
      tracker: {
        id: 2
      }
    };
  },

  computed: {
    hasUserReporting() {
        return this.trackers.filter((tracker, index) => tracker.has_user_reporting == '1').reverse()
    },
  },

  mounted() {
    NProgress.done();
  },

  methods: {
    showReportModal(trackerId) {
      this.setTracker(trackerId)
      if (this.tracker.id) {
        $(this.$refs.reportModal.$el).modal("show");
      }
    },

    setTracker(id) {
      this.tracker = this.trackers.find((tracker, index) => tracker.id === id) || { id: 2 }
    }
  }
};
</script>

<style scoped></style>
