<template>
  <div>
    <vue-headful
      :title="metaTitle"
      :description="metaDescription"
      :image="metaImageUrl"
      :url="metaUrl"
    />
    <page-header></page-header>

    <main class="py-4">
      <div v-if="isReady" class="col-xl-8 offset-xl-2 px-xl-5 col-md-12">
        <h1 class="my-3">{{ dataset.title }}</h1>

        <div class="content-body mt-4 pb-3" v-html="dataset.description"></div>

        <h3>{{ trans.app.data_and_resources }}</h3>

        <div class="mt-2">
          <div
            v-for="(resource, $index) in dataset.resources"
            :key="$index"
            class="d-flex border-top py-3 align-items-center"
          >
            <div class="mr-auto py-1">
              <p class="mb-1">
                <router-link
                  :to="{ name: 'resource-show', params: { id: dataset.id, resourceId: resource.id } }"
                  class="font-weight-bold text-lg lead text-decoration-none"
                >{{ resource.title }}</router-link>
              </p>
              <p class="mb-1">{{ `${resource.description.substring(0, 50)}...` }}</p>
              <p class="text-muted mb-0">
                <span>{{ trans.app.curator }} {{ resource.user.name }} |</span>
                <span>{{ moment(resource.created_at).locale(CurrentTenant.locale).fromNow() }}</span>
              </p>
              <p class="text-muted mb-0">
                <span class="text-success">{{ `.${resource.format.extension}` }}</span>
              </p>
            </div>
            <div class="ml-auto pl-3">
              <router-link
                v-if="isPreviewable(resource.format.extension)"
                :to="{ name: 'resource-show', params: { id: dataset.id, resourceId: resource.id } }"
                class="btn btn-outline-info"
              >
                {{ trans.app.preview }}
              </router-link>
              <a
                v-if="isLoggedIn"
                :href="resource.path"
                class="btn btn-outline-info"
                @click="downloadResource(resource.id)"
                :download="resource.title">
                Download
              </a>
              <a 
                v-else
                href="/login"
                class="btn btn-outline-info"
              >
                Login to download
              </a>
            </div>
          </div>
        </div>


        <div class="list-group mt-5">

          <a class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">{{ trans.app.created }}</h5>
            </div>
            <p class="mb-1">{{ dataset.created_at }}</p>
            <small></small>
          </a>

          <a class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">{{ trans.app.updated }}</h5>
            </div>
            <p class="mb-1">{{ dataset.updated_at }}</p>
            <small></small>
          </a>

          <a class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">{{ trans.app.unique_identifier }}</h5>
            </div>
            <p class="mb-1">{{ dataset.id }}</p>
            <small></small>
          </a>

          <a class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">{{ trans.app.license }}</h5>
            </div>
            <p v-if="dataset.license" class="mb-1">
              <a 
                :href="dataset.license.link" 
                target="_blank" 
                rel="noopener noreferrer"
              >{{ dataset.license.name }}</a>
            </p>
            <small></small>
          </a>

          <a class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">{{ trans.app.author }}</h5>
            </div>
            <p class="mb-1">
              {{ dataset.user.name }}
            </p>
            <small></small>
          </a>

          <a class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">{{ trans.app.topics }}</h5>
            </div>
            <p class="mb-1">
              <span
                v-for="(topic, index) in dataset.topics"
                :key="index"
                class="badge badge-success mr-1"
              >{{ topic.name }}</span>
            </p>
            <small></small>
          </a>

        </div>


      </div>
    </main>
    <page-footer></page-footer>
  </div>
</template>

<script>
import moment from "moment";
import NProgress from "nprogress"

export default {
  name: "dataset-show",

  components: {
    
  },

  data() {
    return {
      dataset: {},
      trans: JSON.parse(CurrentTenant.translations),
      id: this.$route.params.id,
      isReady: false
    };
  },

  mounted() {
    NProgress.done()
  },

  beforeRouteEnter(to, from, next) {
    next(vm => {
      vm.request()
        .get("/api/v1/data/" + vm.id)
        .then(response => {
          vm.dataset = response.data.dataset
          vm.isReady = true

          NProgress.done();
        })
        .catch(error => {
          console.log(error);
          vm.$router.push({ name: "data" });
        });
    });
  },

  methods: {
    downloadResource(id) {
      if (!id) return
      
      this.request()
        .get("/api/v1/dataresources/download/" + id)
        .then(response => {
          NProgress.done()
        })
        .catch(error => {

        });
    },
  }
};
</script>

<style scoped></style>
