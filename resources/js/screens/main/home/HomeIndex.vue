<template>
  <div>
    <page-header></page-header>
    
    <div class="container-fluid">
      <div class="row">


        <div class="col-12 col-md-7">
          <!-- Protest Images -->
          <div>
            <slider :images="protest_images" />
            <h1 class="font-weight-700 text-primary">#EndSARS #EndSWAT</h1>
            <p class="lead">
              Now is the time to demand bold, radical, 
              systemic changes for Nigeria's betterment, 
              and our own good.
            </p>
            <hr>
          </div>

          <!-- Latest Posts -->
          <div>
            <div v-for="(post, index) in featuredPosts" :key="index">
              <h1 class="font-weight-700 text-primary">
                <router-link :to="{ name: 'blog-post', params: { identifier: publicIdentifier(post), slug: post.slug } }">
                  {{ post.title }}
                </router-link>
              </h1>
              <div class="d-block d-md-flex flex-wrap-reverse flex-md-nowrap">
                <div>
                  <small class="text-muted">by {{ post.user.name }} on {{ moment(post.published_at).format('MMM D, Y') }} — {{ post.read_time }}</small>
                  <p class="lead">
                    {{ post.summary }}
                  </p>
                </div>
                <div class="">
                  <img :src="post.featured_image" class="img-fluid" alt="" srcset="">
                </div>
              </div>
            </div>
          </div>


          <!-- Memorial -->
          <div>
            <div class="page-title w-full">
              <h2 class="font-weight-900 display-4 text-primary mt-5">
                {{ trans.app.memorial }}
              </h2>

              <viewer :images="memorialImages" :captions="memorialCaptions" />

              <div class="w-full mt-5">
                <router-link
                  :to="{ name: 'memorial-main' }"
                  class="btn btn-lg btn-outline-secondary w-50 float-right">
                  <i>{{ trans.app.view_all }}</i>
                </router-link>
                <div class="clearfix"></div>
              </div>
            </div>
          </div>
        </div>



        <div class="col-12 col-md-5">
          <!-- Take Action -->
          <div>
            <div class="page-title w-full">
              <h2 class="font-weight-900 display-4 text-primary mt-5">
                {{ trans.app.take_action }}
              </h2>
              <p class="lead">
                You can tell me what you want written here. You can tell me what you want written here. 
                You can tell me what you want written here. You can tell me what you want written here.
              </p>
              <p class="lead">
                You can tell me what you want written here. You can tell me what you want written here. 
                You can tell me what you want written here. You can tell me what you want written here.
              </p>
            </div>
          </div>

          <!-- Donate -->
          <div>
            <div class="page-title w-full">
              <h2 class="font-weight-900 display-4 text-primary mt-5">
                {{ trans.app.donate }}
              </h2>
              <p class="lead">
                We appreciate your support of the movement and our ongoing 
                fight to end police brutality in Nigeria.
              </p>
              <p class="lead">
                For corporate/foundation grants or other partnership questions, 
                please email {{ platform.email }}.
              </p>
            </div>
          </div>

          <!-- Help us fight disinformation -->
          <div>
            <div class="page-title w-full">
              <h2 class="font-weight-900 display-4 text-primary mt-5">
                {{ trans.app.factcheck_with_us }}
              </h2>
              <p class="lead">
                We need to see what you see. #EndSARS is a central target 
                of disinformation and you are a key line of defense. Report 
                suspicious sites, stories, ads, social accounts, and posts about BLM.
              </p>
              <div class="mt-5">
                <router-link
                  :to="{ name: 'contact' }"
                  class="btn btn-lg btn-outline-secondary w-50 float-right">
                  <i>{{ trans.app.contact }}</i>
                </router-link>
                <div class="clearfix"></div>
              </div>
            </div>
          </div>

          <!-- Follow us on socials -->
          <div>
            <div class="page-title w-full">
              <h2 class="font-weight-900 display-4 text-primary mt-5">
                {{ trans.app.we_are_social }}
              </h2>
              <div class="text-center btn-wrapper">
                <a target="_blank" :href="platform.twitter_url || '#'" rel="nofollow" class="btn btn-icon-only btn-twitter rounded-circle" data-toggle="tooltip" data-original-title="Follow us">
                  <span class="btn-inner--icon"><i class="fab fa-twitter"></i></span>
                </a>
                <a target="_blank" :href="platform.facebook_url || '#'" rel="nofollow" class="btn-icon-only rounded-circle btn btn-facebook" data-toggle="tooltip" data-original-title="Like us">
                  <span class="btn-inner--icon"><i class="fab fa-facebook"></i></span>
                </a>
                <a target="_blank" :href="platform.instagram_url || '#'" rel="nofollow" class="btn btn-icon-only btn-instagram rounded-circle" data-toggle="tooltip" data-original-title="Follow us">
                  <span class="btn-inner--icon"><i class="fab fa-instagram"></i></span>
                </a>
                <a target="_blank" :href="platform.github_url || '#'" rel="nofollow" class="btn btn-icon-only btn-github rounded-circle" data-toggle="tooltip" data-original-title="Star on Github">
                  <span class="btn-inner--icon"><i class="fab fa-github"></i></span>
                </a>
                <a target="_blank" :href="platform.linkedin_url || '#'" rel="nofollow" class="btn btn-icon-only btn-twitter rounded-circle" data-toggle="tooltip" data-original-title="Star on Github">
                  <span class="btn-inner--icon"><i class="fab fa-linkedin"></i></span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <page-footer></page-footer>
  </div>
</template>

<script>
import moment from "moment";
import NProgress from "nprogress";
import Viewer from "../../../components/global/carousels/Viewer"
import Slider from "../../../components/global/carousels/Slider"

export default {
  name: "home-index",

  components: {
    Viewer,
    Slider
  },

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
