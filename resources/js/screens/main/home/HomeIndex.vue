<template>
  <div>
    <page-header></page-header>

    <section class="section" style="height: 50vh">
      <div class="container h-100 w-100">
        <div class="row h-100">
          <div class="mx-auto my-auto text-center">
            <h1 class="font-weight-700">We don't gather requirements</h1>
            <span class="font-weight-lighter display-4">We dig for them</span>
          </div>
        </div>
      </div>
    </section>

    <section class="section d-md-flex bg-gradient-gray">
      <div class="col-12 col-md-4 flex-column h-100vh p-5 p-md-5">
        <div class="row h-100 w-100">
          <div class="mx-auto my-auto text-center">
            <h1 class="font-weight-700">Feel the quality</h1>
            <p class="lead">We craft usable products.</p>
            <router-link class="btn btn-sm btn-outline-default" to="/contact">
              {{ trans.app.contact_us }}
              <span class="fas fa-long-arrow-alt-right mr-2"></span>
            </router-link>
          </div>
        </div>
      </div>
      <div
        class="col-12 col-md-8 flex-column h-100vh"
        style="
          background-image: url('/images/feel_the_quality.jpg');
          background-position: right top;
        "
      ></div>
    </section>

    <section class="section pt-9 pb-9">
      <div class="container">
        <div class="container">
          <div class="row mb-9">
            <div>
              <h1 class="font-weight-700 text-info">
                We have a <i>thing</i> for turning ideas
              </h1>
              <span class="font-weight-lighter display-4">into reality</span>
            </div>
          </div>
          <div class="row">
            <div class="col-12 col-md-6 mb-5 mb-md-0">
              <div class="info">
                <h6 class="text-uppercase text-xl font-weight-700">
                  User is king
                </h6>
                <p class="lead opacity-8">
                  We build products around customer experience. We like to work
                  with users at every stage of development. We believe it is the
                  best way to gain insight into how the system will really be
                  used.
                </p>
                <router-link to="/services" class="btn btn-link">
                  Learn about our services
                  <span class="fas fa-long-arrow-alt-right"></span>
                </router-link>
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="info">
                <h6 class="text-uppercase text-xl font-weight-700">
                  Beautifully-crafted Products
                </h6>
                <p class="lead opacity-8">
                  We understand you just don't want a product that works. You
                  want a solution that reminds you of the beauty of life. Design
                  is at the heart of everything we do! We setup workshops to
                  make sure we capture the brand of our clients' businesses.
                </p>
                <router-link to="/contact" class="btn btn-link">
                  Get in touch
                  <span class="fas fa-long-arrow-alt-right"></span>
                </router-link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="section pb-9">
      <div class="container">
        <div class="mb-9">
          <h4>We have had the pleasure to work with:</h4>
        </div>
        <div class="row">
          <div class="col-12 col-md-8 mx-auto my-auto">
            <div class="row">
              <div v-for="(partner, index) in partners" :key="index" class="col-12 col-md-3 mx-auto my-auto">
                <a
                  target="_blank"
                  :href="partner.url"
                  ><img
                    :src="partner.logo"
                    alt=""
                    class="img-grayscale img-fluid mb-5 mt-5"
                /></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="section pt-9 pb-9">
      <div class="container">
        <div class="container">
          <div class="row">
            <div class="col-12 col-md-6 mb-5 mb-md-0">
              <div class="info">
                <h6 class="text-uppercase text-xl font-weight-700">
                  Meet the team
                </h6>
                <p class="lead opacity-8">
                  The saying is as it goes: "Behind every great product is an even
                  greater team". Get to know us!
                </p>
                <router-link to="/members" class="btn btn-outline-dark">
                  Meet our team
                  <span class="fas fa-long-arrow-alt-right"></span>
                </router-link>
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="info">
                <h6 class="text-uppercase text-xl font-weight-700">
                  Let's work together
                </h6>
                <p class="lead opacity-8">
                  We'd love to discuss your ideas and problems. Let's build the
                  future together!
                </p>
                <router-link to="/contact" class="btn btn-outline-info">
                  Get in touch
                  <span class="fas fa-long-arrow-alt-right"></span>
                </router-link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <page-footer></page-footer>
  </div>
</template>

<script>
import moment from "moment";
import NProgress from "nprogress";

export default {
  name: "contact-index",

  components: {},

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

  methods: {},
};
</script>

<style scoped>
.img-grayscale {
  filter: grayscale(100%);
}
</style>
