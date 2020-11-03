<template>
  <div>
    <page-header></page-header>
    
    <main class="container mt-5 mb-9">
      <div class="page-title w-full text-center">
        <h2 class="font-weight-900 display-4 text-primary mt-5">
          #MySarsStory
        </h2>
        <p class="lead">
          The Special Anti-Robbery Squad (SARS), a unit of the Nigerian Police has a long record 
          of human rights abuses and violations. Many lives have been lost, dreams shattered 
          and many others have experienced incalculable losses as a result of their activities. 
          As part of the #ENDSARS movement, we’re documenting the toll of SARS across Nigeria - 
          putting names and faces to the numbers.
        </p>
        <div class="text-center my-5">
          <router-link
            :to="{ name: 'add-your-voice' }"
            class="btn btn-lg btn-outline-secondary w-50">
            <i>{{ trans.app.add_your_voice }}</i>
          </router-link>
          <div class="clearfix"></div>
        </div>
      </div>
    </main>

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
    };
  },

  mounted() {
    NProgress.done();
  },

  beforeRouteEnter(to, from, next) {
    next(vm => {})
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
