<template>
  <div>
    <vue-headful
      :title="CurrentTenant.platform.name + ' — ' + trans.app.topics"
      :description="trans.app.posts_grouped_by_topics"
    />

    <!-- <navbar>
      <router-link
        slot="extra"
        :to="{name: 'home'}"
        class="btn btn-sm btn-outline-secondary"
      >Go home</router-link>
    </navbar> -->

    <page-header></page-header>

    <div class="pt-5">
      <div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-md-12 mt-3">
        <h1 class="font-serif">{{ trans.app.topics }}</h1>
        <p class="lead text-secondary">{{ trans.app.posts_grouped_by_topics }}</p>

        <main role="main" class="mt-5">
          <div v-if="topics.length > 0">
            <taxonomy-grid :items="topics" type="topic"></taxonomy-grid>
          </div>

          <div v-else class="col-12">
            <p class="lead text-muted text-center mt-5 pt-5">{{ trans.app.you_have_no_results }}</p>
            <p class="lead text-muted text-center mt-1"></p>
          </div>
        </main>
      </div>
    </div>
    <page-footer></page-footer>
  </div>
</template>

<script>
import NProgress from "nprogress";
import vueHeadful from "vue-headful";
import TaxonomyGrid from "../../../components/blog/TaxonomyGrid";

export default {
  name: "topic-screen",

  components: {
    TaxonomyGrid,
    vueHeadful,
    trans: JSON.parse(CurrentTenant.translations)
  },

  data() {
    return {
      topics: [],
      trans: JSON.parse(CurrentTenant.translations)
    };
  },

  mounted() {
    this.fetchTopics();
  },

  methods: {
    fetchTopics() {
      this.request()
        .get("/api/v1/blog/topics")
        .then(response => {
          this.topics = response.data;

          NProgress.done();
        })
        .catch(error => {
          // Add any error debugging...
          this.$router.push({ name: "blog" });

          NProgress.done();
        });
    }
  }
};
</script>
