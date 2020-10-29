<template>
  <div>
    <vue-headful
      :title="metaTitle"
      :description="metaDescription"
      :image="metaImageUrl"
      :url="metaUrl"
    />
    <page-header></page-header>

    <main>
      <div class="container">
        <section class="section section-lg mt-5 mb-9 text-center">
          <h1 class="col-12 mb-1 font-weight-700 text-primary">
            Those We've Lost
          </h1>
          <p class="lead col-12 col-md-6 mx-auto font-weight-500 text-secondary mb-9">
            The #EndSARS protest has taken a death toll. 
            We are putting names and faces to the numbers.
          </p>
          <div class="col-10 mx-auto">
            <div 
              v-for="(memo, $index) in memorial"
              :key="$index" 
              class="col-12 mb-5">
              <div class="row">
                <div class="col-md-6">
                  <img
                    :src="memo.avatar" 
                    class="img-fluid rounded-circle w-75" 
                    alt="..."
                    v-if="memo.avatar"
                  >
                  <img
                    v-else
                    src="/images/male_avatar.svg" 
                    class="img-fluid rounded-circle w-75" 
                    alt="..."
                  >
                </div>
                <div class="col-md-6 text-md-left mt-5 mt-md-0">
                  <h3 class="font-weight-800 text-primary">{{ `${memo.name}, ${memo.age}` }}</h3>
                  <div class="font-weight-500 text-primary">{{ memo.profession }}</div>
                  <p v-if="memo.post.published_at" class="lead">
                    <router-link
                      :to="{ name: 'blog-post', params: { identifier: publicIdentifier(memo.post), slug: memo.post.slug } }"
                      class="font-weight-400 text-primary"
                    >
                      <i>{{ trans.app.read_more }}</i>
                    </router-link>
                  </p>
                </div>
              </div>
            </div>

            <infinite-loading 
              :identifier="infiniteId"
              @infinite="fetchData" 
              spinner="spiral">
              <span slot="no-more"></span>
              <div slot="no-results" class="text-left">
                <div class="mt-5">
                  <p class="lead text-center text-muted mt-5 pt-5">
                    <span>
                      {{trans.app.you_have_no_results}}
                    </span>
                  </p>
                </div>
              </div>
            </infinite-loading>
          </div>
        </section>
      </div>
    </main>
    <page-footer></page-footer>
  </div>
</template>

<script>
import moment from "moment";
import NProgress from "nprogress";
import InfiniteLoading from "vue-infinite-loading";

export default {
  name: "memorial-index",
  components: {
    InfiniteLoading,
  },
  data() {
    return {
      page: 1,
      memorial: [],
      trans: JSON.parse(CurrentTenant.translations),
      infiniteId: +new Date(),
      // currentFilters: [],
      // filter: "",
      // filterId: "",
      // query: "",
      url: "/api/v1/memorial",
      // from: "",
      // to: "",
      // total: "",
    };
  },
  watch: {
    // filter: function (val) {
    //   this.filterId = ""
    //   switch (val) {
    //     case "designation":
    //       this.currentFilters = this.designations
    //       break;
    //     case "":
    //       this.currentFilters = []
    //       break;
    //     default:
    //       break;
    //   }
    // },
    // filterId: function (val) {
    //   if (val === "") {
    //     this.url = "/api/v1/members"
    //   } else {
    //     this.url = `/api/v1/members?filter=${this.filter}&&filterId=${this.filterId}`
    //   }
    //   this.page = 1;
    //   this.members = [];
    //   this.infiniteId += 1;
    // },
    // query: function (val) {
    //   if (val === "") {
    //     this.url = this.filterId ? 
    //       `/api/v1/members?filter=${this.filter}&&filterId=${this.filterId}` :
    //       "/api/v1/members"
    //   } else {
    //     this.url = this.filterId ? 
    //       `/api/v1/members?filter=${this.filter}&&filterId=${this.filterId}&&query=${this.query}` :
    //       `/api/v1/members?query=${this.query}`
    //   }
    //   this.page = 1;
    //   this.members = [];
    //   this.infiniteId += 1;
    // }
  },
  methods: {
    fetchData(
      $state
    ) {
      this.request()
        .get(this.url, {
          params: {
            page: this.page
          }
        })
        .then(response => {
          if (!_.isEmpty(response.data) && !_.isEmpty(response.data.data)) {
            this.page += 1;
            this.memorial.push(...response.data.data);
            // this.from = response.data.from
            // this.to = response.data.to
            // this.total = response.data.total
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
    // fetchFilters() {
    //   // fetch designations
    //   this.request()
    //     .get("/api/v1/designations?all=1")
    //     .then(response => {
    //       this.designations = response.data;
    //       NProgress.done();
    //     })
    //     .catch(() => {
    //       NProgress.done();
    //     })
    // }
  }
};
</script>

<style scoped></style>
