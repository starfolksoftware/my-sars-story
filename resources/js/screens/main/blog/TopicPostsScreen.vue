<template>
  <div>
    <vue-headful v-if="isReady" :title="topic.name + ' — Studio'" />

    <!-- <navbar>
      <router-link
        slot="extra"
        :to="{name: 'home'}"
        class="btn btn-sm btn-outline-secondary"
      >Go home</router-link>
    </navbar> -->

    <page-header></page-header>

    <div v-if="isReady" class="pt-5">
      <div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-md-12 mt-3">
        <h1 class="font-serif">{{ topic.name }}</h1>

        <main role="main" class="mt-5">
          <h4 class="my-4 border-bottom mt-5 pb-2">
            <span class="border-bottom border-dark pb-2">{{ trans.app.all_posts }}</span>
          </h4>

          <post-list :posts="posts"></post-list>
        </main>
      </div>
    </div>
    <page-footer></page-footer>
  </div>
</template>

<script>
import NProgress from "nprogress";
import vueHeadful from "vue-headful";
import PostList from "../../../components/blog/PostList";

export default {
  name: "topic-posts-screen",

  components: {
    PostList,
    vueHeadful
  },

  data() {
    return {
      posts: [],
      topic: null,
      isReady: false,
      trans: JSON.parse(CurrentTenant.translations)
    };
  },

  mounted() {
    this.fetchData();
  },

  watch: {
    $route(to, from) {
      this.fetchData()
    }
  },

  methods: {
    fetchData() {
      this.request()
        .get("/api/v1/blog/topics/" + this.$route.params.slug)
        .then(response => {
          this.topic = response.data.topic;
          this.posts = response.data.posts;
          this.isReady = true;

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
