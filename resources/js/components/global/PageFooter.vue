<template>
  <!-- Footer -->
  <footer class="page-footer font-small unique-color-dark mt-5">

    <div class="bg-secondary">
      <div class="container">

        <!-- Grid row-->
        <div class="row py-4 d-flex align-items-center">

          <!-- Grid column -->
          <div class="col-md-6 col-lg-5 text-center text-md-left mb-4 mb-md-0">
            <h6 class="mb-0">{{ trans.app.get_connected_with_us }}</h6>
          </div>
          <!-- Grid column -->

          <div class="col-md-6 col-lg-7 text-center text-md-right btn-wrapper">
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
        <!-- Grid row-->

      </div>
    </div>

    <!-- Footer Links -->
    <div class="container text-center text-md-left mt-5">

      <!-- Grid row -->
      <div class="row mt-3">

        <!-- Grid column -->
        <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">

          <!-- Content -->
          <h6 class="text-uppercase font-weight-bold">{{ platform.name }}</h6>
          <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
          <p v-if="platform.description">
            {{ trim(platform.description.replace(/(<([^>]+)>)/ig,""), 255) }}
          </p>

        </div>
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">

          <!-- Links -->
          <h6 class="text-uppercase font-weight-bold">{{ trans.app.platform }}</h6>
          <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
          
          <p>
            <router-link to="/blog">
              {{ trans.app.stories }}
            </router-link>
          </p>

        </div>
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">

          <!-- Links -->
          <h6 class="text-uppercase font-weight-bold">{{ trans.app.useful_links }}</h6>
          <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
          <p>
            <router-link to="/about">
              {{ trans.app.about }}
            </router-link>
          </p>
          <p>
            <router-link to="/contact">
              {{ trans.app.contact_us }}
            </router-link>
          </p>
          <p>
            <router-link to="/terms">
              {{ trans.app.terms }}
            </router-link>
          </p>
          <p>
            <router-link to="/privacy-policy">
              {{ trans.app.privacy_policy }}
            </router-link>
          </p>
        </div>
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">

          <!-- Links -->
          <h6 class="text-uppercase font-weight-bold">{{ trans.app.contact_information }}</h6>
          <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
          <p>
            <i class="fas fa-home mr-3"></i> {{ platform.physical_address }}
          </p>
          <p>
            <i class="fas fa-envelope mr-3"></i> {{ platform.email }}
          </p>
          <p>
            <i class="fas fa-phone mr-3"></i> {{ platform.phone_number }}
          </p>

        </div>
        <!-- Grid column -->

      </div>
      <!-- Grid row -->

    </div>
    <!-- Footer Links -->

    <!-- Copyright -->
    <div class="footer-copyright text-center py-3"> © 2020 
      <a target="_blank" href="https://tigereyefoundation.org/"> Tiger Eye Foundation</a>
    </div>
    <!-- Copyright -->

  </footer>
  <!-- Footer -->
</template>

<script>
export default {
  data() {
    return {
      trans: JSON.parse(CurrentTenant.translations),
      platform: CurrentTenant.platform,
      allPlatforms: CurrentTenant.allPlatforms
    };
  },
}
</script>

<style>
</style>