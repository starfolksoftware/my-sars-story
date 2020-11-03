<template>
  <div>
    <page-header></page-header>
    
    

    <page-footer></page-footer>
  </div>
</template>

<script>
import moment from "moment";
import NProgress from "nprogress";

export default {
  name: "home-index",

  data() {
    return {
      trans: JSON.parse(CurrentTenant.translations),
      platform: CurrentTenant.platform,
      partners: CurrentTenant.partners,
      memorial: [],
      featuredPosts: [],
      protest_images: [
        '/images/protests/protest_1.jpg',
        '/images/protests/protest_2.jpg',
        '/images/protests/protest_3.jpg',
        '/images/protests/protest_4.jpg',
        '/images/protests/protest_5.jpg',
        '/images/protests/protest_6.jpg',
        '/images/protests/protest_7.jpg',
        '/images/protests/protest_8.jpg',
        '/images/protests/protest_9.jpg',
      ],
    };
  },

  computed: {
    memorialImages() {
      return this.memorial.map((currentValue) => currentValue.avatar)
    },
    memorialCaptions() {
      return this.memorial.map((currentValue) => `${currentValue.name}, ${currentValue.profession}, ${currentValue.age}`)
    }
  },

  mounted() {
    NProgress.done();
  },

  beforeRouteEnter(to, from, next) {
    next(vm => {
      vm.fetchPosts()
      vm.fetchMemorial()
    })
  },

  methods: {
    fetchPosts() {
      this.request()
        .get("/api/v1/blog/posts/5")
        .then(response => {
          this.featuredPosts = response.data.posts;

          NProgress.done();
        })
        .catch(error => {
          NProgress.done();
        });
    },
    fetchMemorial() {
      this.request()
        .get("/api/v1/memorial")
        .then(response => {
          this.memorial = response.data.data;

          NProgress.done();
        })
        .catch(error => {
          NProgress.done();
        });
    }
  },
};
</script>

<style scoped>
.flex-post-width {
  flex: 0 0 40%
}

@media (max-width: 767.98px) { 
  .flex-post-width {
    flex: 0 0 100%
  }
}

.img-grayscale {
  filter: grayscale(100%);
}

.page-title h2:after {
  background-image: linear-gradient(180deg,transparent,transparent 6.25%,rgb(190, 169, 81) 0,rgb(190, 169, 81) 25%,transparent 0,transparent 40.625%,rgb(190, 169, 81) 0,rgb(190, 169, 81) 59.375%,transparent 0,transparent 75%,rgb(190, 169, 81) 0,rgb(190, 169, 81) 93.75%,transparent 0,transparent);
  content: "";
  height: .75em;
  /* left: .2em; */
  display: inline-block;
  width: 100%;
}
</style>
