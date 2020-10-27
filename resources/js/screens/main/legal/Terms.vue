<template>
  <div class="d-md-flex">
    <page-header class="d-md-none"></page-header>
    <vue-headful
      :title="metaTitle"
      :description="metaDescription"
      :image="metaImageUrl"
      :url="metaUrl"
    />
    <div class="d-none d-md-block flex-column col-md-4 vh-100 position-fixed bg-secondary">
      <section class="section section-lg mt-3">
        <h1 class="display-4 font-weight-700 text-white">
          #MySarsStory
        </h1>
      </section>
    </div>
    <div class="col-12 flex-column col-md-8 vh-100 overflow-auto position-absolute right-0">
      <router-link 
        class="btn btn-outline-primary mt-3" 
        :to="{ name: 'home' }">
        <span class="fas fa-long-arrow-alt-left ml-2"></span>
        {{ trans.app.home }}
      </router-link>
      <section class="section section-lg text-center mt-3">
        <h1 class="display-4 font-weight-700">
          {{ trans.app.terms_of_service }}
        </h1>
        <p class="lead">
          {{ moment(platform.updated_at).fromNow() }}
        </p>
      </section>
      <div class="section section-lg pt-0">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-12" v-html="platform.terms"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import moment from "moment";
import NProgress from "nprogress";
export default {
  name: "privacy-policy",
  data() {
    return {
      trans: JSON.parse(CurrentTenant.translations),
      platform: CurrentTenant.platform
    };
  },
  mounted() {
    NProgress.done();
  },
};
</script>

<style scoped></style>
