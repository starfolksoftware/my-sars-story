<template>
  <div>
    <vue-headful
      :title="CurrentTenant.platform.name + ' - ' + trans.app.stories"
      :description="CurrentTenant.platform.description"
    />

    <page-header></page-header>

    <div v-if="posts.length > 0">
      <section v-if="featuredPost" class="section d-md-flex" style="height: 80vh">
        <div class="col-12 col-md-6 flex-column h-100" :style="{'background-image': 'url(' + featuredPost.featured_image + ')'}">
        </div>
        <div class="col-12 col-md-6 flex-column p-5 p-md-9 text-primary">
          <div class="row h-100 text-primary">
            <div class="mx-auto my-auto text-center text-primary">
              <h1 class="font-weight-700 text-primary">
                {{ featuredPost.title }}
              </h1>
              <small class="text-primary">by {{ featuredPost.user.name }} on {{ moment(featuredPost.published_at).format('MMM D, Y') }} — {{ featuredPost.read_time }}</small>
              <p class="lead text-primary">
                {{ featuredPost.summary }}
              </p>
              <router-link
                class="btn btn-sm btn-outline-primary" 
                :to="{ name: 'blog-post', params: { identifier: publicIdentifier(featuredPost), slug: featuredPost.slug } }">
                {{ trans.app.view_story }}
                <span class="fas fa-long-arrow-alt-right mr-2"></span>
              </router-link>
            </div>
          </div>
        </div>
      </section>

      <div class="col-12 col-md-10 mt-3 mx-auto">
        <!-- <h1 class="font-serif">{{ trans.app.recently_published }}</h1>
        <p class="lead text-secondary">
          {{ trans.app.browse_by }} : 
          <router-link :to="{name:'blog-tags'}" class="text-muted text-decoration-none ml-3 mr-3">
            Tags
          </router-link>
          <router-link :to="{name:'blog-topics'}" class="text-muted text-decoration-none">
            Topics
          </router-link>
        </p> -->

        <main role="main" class="mt-5">
          <div v-if="posts.length > 0">
            <h4 class="mb-4 border-bottom pb-2">
              <span class="border-bottom border-dark pb-2">Featured</span>
            </h4>

            <featured-post-list :posts="posts.slice(0, featuredPostCount)"></featured-post-list>

            <h4
              v-if="posts.slice(featuredPostCount).length > 0"
              class="my-4 border-bottom mt-5 pb-2"
            >
              <span class="border-bottom border-dark pb-2">All Posts</span>
            </h4>

            <post-list :posts="posts.slice(featuredPostCount)"></post-list>
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

<div class="card">
  <!-- Card image -->
  <img class="card-img-top" src="../assets/img/theme/img-1-1000x900.jpg" alt="Image placeholder">
  <!-- Card body -->
  <div class="card-body">
    <h5 class="h2 card-title mb-0">Get started with Argon</h5>
    <small class="text-muted">by John Snow on Oct 29th at 10:23 AM</small>
    <p class="card-text mt-4">Argon is a great free UI package based on Bootstrap 4 that includes the most important components and features.</p>
    <a href="#!" class="btn btn-link px-0">View article</a>
  </div>
</div>

<script>
import NProgress from "nprogress";
import vueHeadful from "vue-headful";
import PostList from "../../../components/blog/PostList";
import FeaturedPostList from "../../../components/blog/FeaturedPostList";
import moment from "moment"

export default {
  name: "home-screen",

  components: {
    FeaturedPostList,
    PostList,
    vueHeadful
  },

  data() {
    return {
      featuredPostCount: 1,
      posts: [],
      trans: JSON.parse(CurrentTenant.translations)
    };
  },

  computed: {
    featuredPost() {
      return this.posts.length > 0 ? this.posts[0] : {}
    }
  },

  mounted() {
    this.fetchPosts();
  },

  methods: {
    fetchPosts() {
      this.request()
        .get("/api/v1/blog/posts")
        .then(response => {
          this.posts = response.data.posts;

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
