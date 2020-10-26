<template>
  <div>
    <vue-headful
      :title="metaTitle"
      :description="metaDescription"
      :image="metaImageUrl"
      :url="metaUrl"
    />
    <page-header></page-header>

    <main class="mt-5">
      <div class="container">

        <section class="section section-lg mt-9 mb-9 d-md-flex justify-content-between">
          <h1 class="col-12 col-md-6 display-4 font-weight-700 flex-column">
            The People
          </h1>
          <p class="col-12 col-md-6 lead flex-column my-auto">
            We believe that to produce a great product, we have to 
            start from the customer experience. To be the company that accomplishes just that, it 
            takes an eclectic group experienced, driven and passionate about it. 
            Get to know the people at Starfolk!
          </p>
        </section>

        <section class="section section-lg mt-9 mb-9">
          <h1 class="col-12 col-md-6 mb-5 font-weight-700">
            Team
          </h1>
          <div class="row">
            <div 
              v-for="(member, $index) in members"
              :key="$index" 
              class="col-12 col-md-6 mb-4">
              <div class="card border-0">
                <img
                  :src="member.avatar" 
                  class="card-img-top" 
                  alt="..."
                  v-if="member.avatar"
                >
                <img
                  v-else
                  src="/images/male_avatar.svg" 
                  class="card-img-top img-thumbnail" 
                  alt="..."
                >
                <div class="card-body mt-3 border-top">
                  <h5 class="card-title mb-0">{{ member.name }}</h5>
                  <div class="card-text text-black-50">{{ member.designations.map((d) => d.title).toString() }}</div>
                </div>
              </div>
            </div>
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
// import InfiniteLoading from "vue-infinite-loading";
export default {
  name: "memorial-index",
  components: {
    // InfiniteLoading,
  },
  data() {
    return {
      // page: 1,
      members: [],
      trans: JSON.parse(CurrentTenant.translations),
      // infiniteId: +new Date(),
      // designations: [],
      // currentFilters: [],
      // filter: "",
      // filterId: "",
      // query: "",
      url: "/api/v1/members?all=1",
      // from: "",
      // to: "",
      // total: "",
    };
  },
  created() {
    this.fetchData()
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
      // $state
    ) {
      this.request()
        .get(this.url, {
          params: {
            page: this.page
          }
        })
        .then(response => {
          this.members = response.data
          // if (!_.isEmpty(response.data) && !_.isEmpty(response.data.data)) {
          //   this.page += 1;
          //   this.members.push(...response.data.data);
          //   // this.from = response.data.from
          //   // this.to = response.data.to
          //   // this.total = response.data.total
          //   // $state.loaded();
          // } else {
          //   // $state.complete();
          // }
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
