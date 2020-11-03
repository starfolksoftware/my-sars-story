<template>
  <div>
    <vue-headful
      v-if="isReady"
      :title="post.title + ' - ' + CurrentTenant.platform.name"
      :description="post.summary"
      :image="post.featured_image"
      :url="meta.canonical_link"
    />

    <page-header></page-header>

    <div v-if="isReady" class="container-fluid">
      <section v-if="post">
        <div class="row">
          <div class="col-12 col-md-6">
            <img :src="post.featured_image" class="img-fluid" alt="" srcset="">
          </div>
          <div class="col-12 col-md-6 p-5">
            <div class="text-md-center">
              <h1 class="font-weight-700 text-primary">
                {{ post.title }}
              </h1>
              <router-link :to="{name: 'blog-user', params: { identifier: publicIdentifier(post) }}">
                <img
                  :src="avatar"
                  class="mr-1 rounded-circle shadow-inner"
                  style="width: 25px"
                  :alt="user.name"
                />
              </router-link>
              <small class="text-primary">by {{ post.user.name }} on {{ post.published_at }}</small>
              <p class="lead text-primary">
                {{ post.summary }}
              </p>
            </div>
          </div>
        </div>
      </section>
      <div class="col col-md-10 mx-auto">
        <div class="row">
          <div class="col-12 col-xl-8">
            <div class="d-flex justify-content-between mt-5">
              <div class="flex-column">
                <font-awesome-icon
                  :icon="['fab', 'facebook-f']"
                  class="mr-3 share-icons"
                  @click="facebookShare(post.title)"
                />
                <font-awesome-icon
                  :icon="['fab', 'twitter']"
                  class="mr-3 share-icons"
                  @click="twitterShare(post.title)"
                />
                <font-awesome-icon
                  :icon="['fab', 'telegram']"
                  class="mr-3 share-icons"
                  @click="telegramShare(post.title)"
                />
                <font-awesome-icon
                  :icon="['fab', 'linkedin']"
                  class="mr-3 share-icons"
                  @click="linkedinShare(post.title)"
                />
              </div>
              <div class="flex-column text-primary">
                {{ post.read_time }}
              </div>
            </div>

            <hr class="mb-5">

            <div
              class="post-content position-relative align-items-center overflow-y-visible font-serif mt-4"
            >
              <div v-html="post.body"></div>
            </div>

            <div v-if="tags" class="mt-5">
              <router-link
                v-for="tag in tags"
                :key="tag.id"
                :to="{ name: 'blog-tag-posts', params: { slug: tag.slug } }"
                class="badge badge-light p-2 my-1 mr-2 text-decoration-none text-uppercase text-primary"
              >{{ tag.name }}</router-link>
            </div>
          </div>

          <div class="col-12 col-xl-4 mt-5 d-none d-xl-block">
            <h1 class="text-primary">{{ trans.app.recently_published }}</h1>

            <div>
              <router-link 
                v-for="(recentPost, index) in recent_posts" :key="index"
                :to="{ name: 'blog-post', params: { identifier: publicIdentifier(recentPost), slug: recentPost.slug } }">
                <div 
                  class="card bg-dark text-white border-0 mb-2">
                  <img class="card-img" :src="recentPost.featured_image" alt="Card image">
                  <div class="card-img-overlay d-flex align-items-center">
                    <div>
                      <h5 class="card-title text-primary mb-2">
                        {{ recentPost.title }}
                      </h5>
                      <!-- <p class="card-text">
                        {{ recentPost.summary }}
                      </p> -->
                      <p class="card-text text-sm font-weight-bold">
                        {{ moment(recentPost.published_at).fromNow() }}
                      </p>
                    </div>
                  </div>
                </div>
              </router-link>
            </div>

          </div>
        </div>
      </div>

      <div
        v-if="meta.canonical_link"
        class="post-content position-relative align-items-center overflow-y-visible font-serif"
      >
        <hr />
        <p class="text-center font-italic pt-3 my-5 text-primary">
          This post was originally published on
          <a
            :href="meta.canonical_link"
            target="_blank"
            rel="noopener"
          >{{ parseURL(meta.canonical_link).hostname }}</a>
        </p>
      </div>

      <main role="main" class="col-xl-8 offset-xl-2 col-lg-10 offset-lg-1 col-md-12">
        <div v-if="related.length > 0">
          <h4 class="mb-4 border-bottom pb-2">
            <span class="border-bottom border-dark pb-2 text-primary">Related</span>
          </h4>

          <post-list :posts="related"></post-list>
        </div>
        <div v-if="post.memorial && post.memorial.id" class='comments'>
          <Disqus :shortname="'spoorafrica'" :pageConfig='disqusConfig' />
        </div>
      </main>
    </div>

    <page-footer></page-footer>
  </div>
</template>

<script>
import hljs from "highlight.js";
import PostList from "../../../components/blog/PostList";
import NProgress from "nprogress";
import vueHeadful from "vue-headful";
import mediumZoom from "medium-zoom";
import { Disqus } from 'vue-disqus'

export default {
  name: "post-screen",

  components: {
    PostList,
    vueHeadful,
    Disqus
  },

  data () {
    return {
      user: null,
      post: null,
      tags: null,
      topic: null,
      username: null,
      avatar: null,
      meta: null,
      related: [],
      isReady: false,
      trans: JSON.parse(CurrentTenant.translations),
      postUrl: window.location.toString(),
      disqus_shortname: process.env.MIX_DISQUS_SHORTNAME,
      recent_posts: [],
    };
  },

  created () {
    this.fetchData();
    this.fetchPosts();
  },

  updated () {
    document.querySelectorAll(".embedded_image img").forEach(image => {
      mediumZoom(image);
    });
    document.querySelectorAll("pre").forEach(block => {
      hljs.highlightBlock(block);
    });
  },

  watch: {
    "$route.params.slug": function (slug) {
      this.isReady = false;
      this.related = [];
      this.fetchData();
    },

    $route(to, from) {
      this.fetchData();
      this.fetchPosts();
    }
  },

  methods: {
    fetchData () {
      this.request()
        .get(
          "/api/v1/blog/posts/" +
          this.$route.params.identifier +
          "/" +
          this.$route.params.slug
        )
        .then(response => {
          this.user = response.data.user;
          this.post = response.data.post;
          this.tags = response.data.post.tags;
          this.topic = response.data.post.topic;
          this.username = response.data.username;
          this.avatar = response.data.avatar;
          this.meta = response.data.meta;
          this.related = response.data.related;
          this.isReady = true;

          NProgress.done();
        })
        .catch(error => {
          // Add any error debugging...
          this.$router.push({ name: "blog" });

          NProgress.done();
        });
    },
    fetchPosts() {
      this.request()
        .get("/api/v1/blog/posts/5")
        .then(response => {
          this.recent_posts = response.data.posts;

          NProgress.done();
        })
        .catch(error => {
          // Add any error debugging...
          this.$router.push({ name: "blog" });

          NProgress.done();
        });
    },
    facebookShare (title) {
      const url = encodeURI(`https://www.facebook.com/sharer.php?href=${this.postUrl}&quote=${title}`);
      return window.open(url, '_blank');
    },
    twitterShare (title) {
      const url = encodeURI(`https://twitter.com/intent/tweet?text=${title}\n${this.postUrl}`);
      return window.open(url, '_blank');
    },
    telegramShare (title) {
      const url = encodeURI(`https://t.me/share/url?url=${this.postUrl}&text=${title}`);
      return window.open(url, '_blank');
    },
    linkedinShare (title) {
      const url = encodeURI(`https://www.linkedin.com/sharing/share-offsite/?url=${this.postUrl}`);
      return window.open(url, '_blank');
    },

  },

  computed: {
    postBelongsToAuthUser () {
      if (CurrentTenant.user) {
        return this.user.id === CurrentTenant.user.id;
      } else {
        return false;
      }
    },

    disqusConfig() {
      return {
        title: this.trans.app.comments,
        slug: this.post.slug
      }
    }
  }
};
</script>

<style lang="scss">
.share-icons {
  cursor: pointer;
  font-size: 21px;
  color: #808080;
}
.post-content::first-letter {
  font-size: 52px;
  line-height: 0;
}

.featured-image-caption {
  text-align: center;
  // color: $text-muted;
  margin-top: 0.5em;
  font-size: 0.9rem;
  // font-family: $font-family-sans-serif, sans-serif;
}

.featured-image-caption a {
  text-decoration: underline;
}

.post-content {
  font-size: 1.1rem;
  line-height: 2;
  -webkit-box-align: center;
  -ms-flex-align: center;
}

.post-content p {
  margin: 2em 0 0 0;
}

.post-content a {
  text-decoration: underline;
}

.post-content h1,
.post-content h2,
.post-content h3 {
  margin: 1.5em 0 0 0;
}

.post-content blockquote {
  margin-top: 2em;
  font-style: italic;
  font-size: 28px;
  // color: $text-muted;
  padding-left: 1.5em;
  line-height: 1.5;
}

div.embedded_image {
  margin-top: 2em;
}

div.embedded_image > img {
  width: 100%;
  height: auto;
  display: block;
}

div.embedded_image > p {
  text-align: center;
  // color: $text-muted;
  margin-top: 0.5em;
  font-size: 0.9rem;
  // font-family: $font-family-sans-serif, sans-serif;
}

div.embedded_image[data-layout="wide"] img {
  max-width: 1024px;
  margin: 0 auto 30px;
}

div.embedded_image[data-layout="wide"] {
  width: 100vw;
  position: relative;
  left: 50%;
  margin-left: -50vw;
}

div.post-content hr {
  border: none;
  margin: 3em 0 4em 0;
  // color: $gray-900;
  letter-spacing: 1em;
  text-align: center;
}

div.post-content hr:before {
  content: "...";
}

// .post-content > p > code {
//   background-color: $text-muted;
// }

pre.ql-syntax {
  margin-top: 2em;
  padding: 1em;
  // border-radius: $border-radius;
}

@media screen and (max-width: 1024px) {
  .post-content > .embedded_image[data-layout="wide"] >>> img {
    max-width: 100%;
  }
}
</style>
