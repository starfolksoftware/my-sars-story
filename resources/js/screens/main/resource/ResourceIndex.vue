<template>
  <div>
    <page-header></page-header>
    <main class="text-center text-primary">
      <h1 class="display-1">Resource</h1>
    </main>
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
