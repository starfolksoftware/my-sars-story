<template>
  <footer class="footer">
    <div class="container">
      <div class="row row-grid align-items-center my-md">
        <div class="col-lg-6">
          <h3 class="text-primary font-weight-light mb-2">Thank you for checking us out!</h3>
          <h4 class="mb-0 font-weight-light">Let's get in touch on any of these platforms.</h4>
        </div>
        <div class="col-lg-6 text-lg-center btn-wrapper">
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
      <hr>
      <div class="row align-items-center justify-content-md-between">
        <div class="col-md-6">
          <div class="copyright">
            © 2020 <a>Starfolk Software Tech. Ltd</a>.
          </div>
        </div>
        <div class="col-md-6">
          <ul class="nav nav-footer justify-content-end">
            <li class="nav-item">
              <router-link to="/blog" class="nav-link">
                {{ trans.app.blog }}
              </router-link>
            </li>
            <!-- <li class="nav-item">
              <router-link to="/about" class="nav-link">
                {{ trans.app.about }}
              </router-link>
            </li> -->
            <li class="nav-item">
              <router-link to="/contact" class="nav-link">
                {{ trans.app.contact }}
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/terms" class="nav-link">
                {{ trans.app.terms }}
              </router-link>
            </li>
            <li class="nav-item">
              <router-link to="/privacy-policy" class="nav-link">
                {{ trans.app.privacy_policy }}
              </router-link>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </footer>
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
