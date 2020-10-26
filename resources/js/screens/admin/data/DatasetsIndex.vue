<template>
  <admin-page>
    <template slot="action">
      <router-link
        v-permission="['create_datasets']"
        :to="{ name: 'datasets-create' }"
        class="btn btn-sm btn-danger font-weight-bold my-auto"
      >{{ trans.app.new_dataset }}</router-link>
    </template>
    <template slot="page-title">
      {{ trans.app.datasets }}
    </template>
    <template slot="breadcrumb">
      <breadcrumb :links="breadcrumbLinks" />
    </template>
    <template slot="main">
      <div class="col">
        <div class="d-flex justify-content-between">
          <h1>{{ trans.app.datasets }}</h1>

          <select
            name
            id
            v-model="datasetType"
            @change="changeType"
            class="my-auto bg-transparent appearance-none border-0 text-muted"
          >
            <option value="published">{{ trans.app.published }} ({{ publishedCount }})</option>
            <option value="approved">{{ trans.app.approved }} ({{ approvedCount }})</option>
            <option value="forApproval">{{ trans.app.submitted }} ({{ submittedCount }})</option>
            <option value="draft">{{ trans.app.draft }} ({{ draftCount }})</option>
          </select>
        </div>

        <div class="mt-2">
          <div
            v-for="(dataset, $index) in datasets"
            :key="$index"
            class="d-flex border-top py-3 align-items-center"
          >
            <div class="mr-auto py-1">
              <p class="mb-1">
                <router-link
                  :to="{name: 'datasets-edit', params: { id: dataset.id }}"
                  class="font-weight-bold text-lg lead text-decoration-none"
                >{{ dataset.title }}</router-link>
              </p>
              <p class="mb-1" v-if="dataset.description" v-html="trim(dataset.description, 200)"></p>
              <p class="text-muted mb-0">
                <span>{{ trans.app.author }} {{ dataset.user.name }} |</span>
                <span
                  v-if="(isApproved || isPublished) && dataset.editor"
                >{{ trans.app.approved_by }} {{ dataset.editor.name }} {{ moment(dataset.approved_at).locale(CurrentTenant.locale).fromNow() }}</span>
              </p>
              <p class="text-muted mb-0">
                <span
                  v-if="isPublished(dataset)"
                >{{ trans.app.published}} {{ moment(dataset.published_at).locale(CurrentTenant.locale).fromNow() }}</span>

                <span v-if="isSubmitted(dataset)" class="text-danger">{{ trans.app.submitted }}</span>

                <span v-if="isDraft(dataset)" class="text-danger">{{ trans.app.draft }}</span>

                <span v-if="isScheduled(dataset)" class="text-danger">{{ trans.app.scheduled }}</span>
                ― {{ trans.app.updated }} {{ moment(dataset.updated_at).locale(CurrentTenant.locale).fromNow() }}
              </p>
            </div>
            <div class="ml-auto pl-3">
              <span class="text-muted">
                {{ dataset.resources ? dataset.resources.length : 0 }} {{ trans.app.resources }}
              </span>
            </div>
          </div>

          <infinite-loading :identifier="infiniteId" @infinite="fetchData" spinner="spiral">
            <span slot="no-more"></span>
            <div slot="no-results" class="text-left">
              <div class="mt-5">
                <p class="lead text-center text-muted mt-5 pt-5">
                  <span v-if="datasetType === 'published'">{{ trans.app.you_have_no_published }}</span>
                  <span v-else-if="datasetType === 'draft'">{{ trans.app.you_have_no_draft }}</span>
                  <span
                    v-else-if="datasetType === 'forApproval'"
                  >{{ trans.app.you_have_no_for_approval }}</span>
                  <span
                    v-else-if="datasetType === 'approved'"
                  >{{ trans.app.you_have_no_recently_approved }}</span>
                </p>
              </div>
            </div>
          </infinite-loading>
        </div>
      </div>
    </template>
  </admin-page>
</template>

<script>
import moment from "moment";
import NProgress from "nprogress";
import InfiniteLoading from "vue-infinite-loading";

export default {
  name: "datasets-index",

  components: {
    InfiniteLoading
  },

  data() {
    return {
      page: 1,
      datasets: [],
      publishedCount: 0,
      draftCount: 0,
      submittedCount: 0,
      approvedCount: 0,
      datasetType: this.isEditor ? "forApproval" : "published",
      infiniteId: +new Date(),
      trans: JSON.parse(CurrentTenant.translations),
      breadcrumbLinks: [
        {
          title: 'All Datasets',
          url: '/admin/data/datasets',
        }
      ]
    };
  },

  methods: {
    fetchData($state) {
      this.request()
        .get("/api/v1/datasets", {
          params: {
            page: this.page,
            datasetType: this.datasetType
          }
        })
        .then(response => {
          this.publishedCount = response.data.publishedCount;
          this.submittedCount = response.data.submittedCount;
          this.draftCount = response.data.draftCount;
          this.approvedCount = response.data.approvedCount;
          if (
            !_.isEmpty(response.data) &&
            !_.isEmpty(response.data.datasets.data)
          ) {
            this.page += 1;
            this.datasets.push(...response.data.datasets.data);

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

    isDraft(dataset) {
      return (
        dataset.approved_at === null &&
        dataset.published_at === null &&
        dataset.submitted_at === null
      );
    },

    isSubmitted(dataset) {
      return (
        dataset.approved_at === null &&
        dataset.published_at === null &&
        dataset.submitted_at !== null
      );
    },

    isApproved(dataset) {
      return (
        dataset.approved_at !== null &&
        dataset.published_at === null &&
        dataset.submitted_at !== null
      );
    },

    isScheduled(dataset) {
      return moment(dataset.published_at).isAfter(
        moment(new Date())
          .format()
          .slice(0, 19)
          .replace("T", " ")
      );
    },

    isPublished(dataset) {
      return moment(dataset.published_at).isBefore(
        moment(new Date())
          .format()
          .slice(0, 19)
          .replace("T", " ")
      );
    },

    changeType() {
      this.page = 1;
      this.datasets = [];
      this.infiniteId += 1;
    }
  }
};
</script>

<style scoped>
#featuredImage {
  background-size: cover;
  width: 57px;
  height: 57px;
  -webkit-border-radius: 50%;
  -moz-border-radius: 50%;
  border-radius: 50%;
}
</style>
