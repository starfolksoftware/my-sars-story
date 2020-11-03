<template>
  <div>
    <page-header></page-header>
    

    <div class="container-fluid">
      <div class="row">


        <div class="col-12 col-md-7">
          <!-- Protest Images -->
          <div class="page-title w-full">
            <h2 class="font-weight-900 display-4 text-primary mt-5">
              {{ trans.app.about }}
            </h2>
            <p class="lead">
              The Special Anti-Robbery Squad (SARS), a unit of the Nigerian Police has a long record 
              of human rights abuses and violations. Many lives have been lost, dreams shattered 
              and many others have experienced incalculable losses as a result of their activities. 
              As part of the #ENDSARS movement, we’re documenting the toll of SARS across Nigeria - 
              putting names and faces to the numbers.
            </p>
            <slider :images="protest_images" />
            <hr>
          </div>


          <!-- Partners section -->
          <div>
            <div class="page-title w-full">
              <h2 class="font-weight-900 display-4 text-primary mt-5">
                {{ trans.app.partners }}
              </h2>
              <div class="row">
                <div v-for="(partner, index) in partners" :key="index" class="col-12 col-sm-4 col-md-3 text-center">
                  <a
                    target="_blank"
                    :href="partner.url"
                    ><img
                      :src="partner.logo"
                      alt=""
                      class="img-fluid mb-5 mt-5"
                  /></a>
                </div>
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
              <div class="text-center my-5">
                <router-link
                  :to="{ name: 'add-your-voice' }"
                  class="btn btn-lg btn-outline-secondary w-50">
                  <i>{{ trans.app.add_your_voice }}</i>
                </router-link>
                <div class="clearfix"></div>
              </div>
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
  name: "about-index",

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
      vm.fetchMemorial()
    })
  },

  methods: {
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
.page-title h2:after {
  background-image: linear-gradient(180deg,transparent,transparent 6.25%,rgb(190, 169, 81) 0,rgb(190, 169, 81) 25%,transparent 0,transparent 40.625%,rgb(190, 169, 81) 0,rgb(190, 169, 81) 59.375%,transparent 0,transparent 75%,rgb(190, 169, 81) 0,rgb(190, 169, 81) 93.75%,transparent 0,transparent);
  content: "";
  height: .75em;
  /* left: .2em; */
  display: inline-block;
  width: 100%;
}
</style>
