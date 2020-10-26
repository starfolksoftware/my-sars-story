<template>
  <admin-page>
    <template slot="action">
      <router-link
        v-permission="['create_posts']"
        :to="{ name: 'posts-create' }"
        class="btn btn-sm btn-danger font-weight-bold my-auto"
      >{{ trans.app.new_post }}</router-link>
    </template>
    <template slot="page-title">
      {{ trans.app.posts_simple }}
    </template>
    <template slot="breadcrumb">
      <breadcrumb :links="breadcrumbLinks" />
    </template>
    <template slot="main">
      <div class="col">
        <div class="d-flex justify-content-between my-3">
          <h1>{{ trans.app.posts_simple }}</h1>

          <select
            name
            id
            v-model="postType"
            @change="changeType"
            class="my-auto ml-auto w-auto bg-transparent custom-select border-0"
          >
            <option value="published">{{ trans.app.published }} ({{ publishedCount }})</option>
            <option value="approved">{{ trans.app.approved }} ({{ approvedCount }})</option>
            <option value="forApproval">{{ trans.app.submitted }} ({{ submittedCount }})</option>
            <option value="draft">{{ trans.app.draft }} ({{ draftCount }})</option>
          </select>
        </div>

        <div class="mt-2">
          <div
            v-for="(post, $index) in posts"
            :key="$index"
            class="d-flex border-top py-3 align-items-center"
          >
            <div class="mr-auto py-1">
              <p class="mb-1">
                <router-link
                  :to="{name: 'posts-edit', params: { id: post.id }}"
                  class="font-weight-bold text-lg lead text-decoration-none"
                >{{ post.title }}</router-link>
              </p>
              <p class="mb-1" v-if="post.summary">{{ trim(post.summary, 200) }}</p>
              <p class="text-muted mb-0">
                <span>{{ trans.app.author }} {{ post.user.name }} |</span>
                <span
                  v-if="(isApproved || isPublished) && post.editor"
                >{{ trans.app.approved_by }} {{ post.editor.name }} {{ moment(post.approved_at).locale(CurrentTenant.locale).fromNow() }}</span>
              </p>
              <p class="text-muted mb-0">
                <span
                  v-if="isPublished(post)"
                >{{ trans.app.published}} {{ moment(post.published_at).locale(CurrentTenant.locale).fromNow() }}</span>

                <span v-if="isSubmitted(post)" class="text-danger">{{ trans.app.submitted }}</span>

                <span v-if="isDraft(post)" class="text-danger">{{ trans.app.draft }}</span>

                <span v-if="isScheduled(post)" class="text-danger">{{ trans.app.scheduled }}</span>
                ― {{ trans.app.updated }} {{ moment(post.updated_at).locale(CurrentTenant.locale).fromNow() }}
              </p>
            </div>
            <div class="ml-auto d-none d-lg-block pl-3">
              <router-link :to="{name: 'posts-edit', params: { id: post.id }}">
                <div
                  v-if="post.featured_image"
                  id="featuredImage"
                  class="mr-2 ml-3 shadow-inner"
                  :style="{backgroundImage:'url(' + post.featured_image +')',}"
                ></div>
                <div v-else class="mx-3 align-middle">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="45"
                    viewBox="0 0 24 24"
                    class="icon-camera"
                  >
                    <path
                      class="primary"
                      d="M6.59 6l2.7-2.7A1 1 0 0 1 10 3h4a1 1 0 0 1 .7.3L17.42 6H20a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V8c0-1.1.9-2 2-2h2.59zM19 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm-7 8a5 5 0 1 0 0-10 5 5 0 0 0 0 10z"
                    />
                    <path class="primary" d="M12 16a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                  </svg>
                </div>
              </router-link>
            </div>
          </div>

          <infinite-loading :identifier="infiniteId" @infinite="fetchData" spinner="spiral">
            <span slot="no-more"></span>
            <div slot="no-results" class="text-left">
              <div class="mt-5">
                <p class="lead text-center text-muted mt-5 pt-5">
                  <span
                    v-if="postType === 'published'"
                  >{{ trans.app.you_have_no_published_posts }}</span>
                  <span v-else-if="postType === 'draft'">{{ trans.app.you_have_no_draft_posts }}</span>
                  <span
                    v-else-if="postType === 'forApproval'"
                  >{{ trans.app.you_have_no_for_approval_posts }}</span>
                  <span
                    v-else-if="postType === 'approved'"
                  >{{ trans.app.you_have_no_recently_approved_posts }}</span>
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
  name: "posts-index",

  components: {
    InfiniteLoading,
  },

  data() {
    return {
      page: 1,
      posts: [],
      publishedCount: 0,
      draftCount: 0,
      submittedCount: 0,
      approvedCount: 0,
      postType: this.isEditor ? "forApproval" : "published",
      infiniteId: +new Date(),
      trans: JSON.parse(CurrentTenant.translations),
      breadcrumbLinks: [
        {
          title: 'All Posts',
          url: '/admin/posts',
        }
      ]
    };
  },

  methods: {
    fetchData($state) {
      this.request()
        .get("/api/v1/posts", {
          params: {
            page: this.page,
            postType: this.postType,
          },
        })
        .then((response) => {
          this.publishedCount = response.data.publishedCount;
          this.submittedCount = response.data.submittedCount;
          this.draftCount = response.data.draftCount;
          this.approvedCount = response.data.approvedCount;
          if (
            !_.isEmpty(response.data) &&
            !_.isEmpty(response.data.posts.data)
          ) {
            this.page += 1;
            this.posts.push(...response.data.posts.data);

            $state.loaded();
          } else {
            $state.complete();
          }

          NProgress.done();
        })
        .catch((error) => {
          // Add any error debugging...
          NProgress.done();
        });
    },

    isDraft(post) {
      return (
        post.approved_at === null &&
        post.published_at === null &&
        post.submitted_at === null
      );
    },

    isSubmitted(post) {
      return (
        post.approved_at === null &&
        post.published_at === null &&
        post.submitted_at !== null
      );
    },

    isApproved(post) {
      return (
        post.approved_at !== null &&
        post.published_at === null &&
        post.submitted_at !== null
      );
    },

    isScheduled(post) {
      return moment(post.published_at).isAfter(
        moment(new Date()).format().slice(0, 19).replace("T", " ")
      );
    },

    isPublished(post) {
      return moment(post.published_at).isBefore(
        moment(new Date()).format().slice(0, 19).replace("T", " ")
      );
    },

    changeType() {
      this.page = 1;
      this.posts = [];
      this.infiniteId += 1;
    },
  },
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
