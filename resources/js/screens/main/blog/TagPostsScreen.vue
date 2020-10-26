<template>
  <div>
    <vue-headful v-if="isReady" :title="tag.name + ' — ' + CurrentTenant.platform.name" />

    <page-header></page-header>

    <!-- <navbar>
      <router-link
        slot="extra"
        :to="{name: 'home'}"
        class="btn btn-sm btn-outline-secondary"
      >Go home</router-link>
    </navbar> -->

    <div v-if="isReady" class="pt-5">
      <div class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-md-12 mt-3">
        <h1 class="font-serif">{{ tag.name }}</h1>

        <main role="main" class="mt-5">
          <h4 class="my-4 border-bottom mt-5 pb-2">
            <span class="border-bottom border-dark pb-2">All Posts</span>
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
  name: "tag-posts-screen",

  components: {
    PostList,
    vueHeadful
  },

  data() {
    return {
      posts: [],
      tag: null,
      isReady: false
    };
  },

  mounted() {
    this.fetchData();
  },

  methods: {
    fetchData() {
      this.request()
        .get("/api/v1/blog/tags/" + this.$route.params.slug)
        .then(response => {
          this.tag = response.data.tag;
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
