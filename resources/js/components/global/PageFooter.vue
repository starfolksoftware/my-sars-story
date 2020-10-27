<template>
  <footer class="footer">
    <div class="container">
      <hr>
      <div class="row align-items-center justify-content-md-between">
        <div class="col-md-6">
          <div class="copyright text-primary">
            © 2020 <a>Tiger Eye Foundation</a>.
          </div>
        </div>
        <div class="col-md-6">
          <ul class="nav nav-footer justify-content-end">
            <li class="text-primary">
              <router-link to="/blog" class="nav-link text-primary">
                {{ trans.app.blog }}
              </router-link>
            </li>
            <!-- <li class="text-primary">
              <router-link to="/about" class="nav-link text-primary">
                {{ trans.app.about }}
              </router-link>
            </li> -->
            <li class="text-primary">
              <router-link to="/contact" class="nav-link text-primary">
                {{ trans.app.contact }}
              </router-link>
            </li>
            <li class="text-primary">
              <router-link to="/terms" class="nav-link text-primary">
                {{ trans.app.terms }}
              </router-link>
            </li>
            <li class="text-primary">
              <router-link to="/privacy-policy" class="nav-link text-primary">
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
