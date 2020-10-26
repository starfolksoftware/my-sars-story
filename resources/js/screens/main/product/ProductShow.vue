<template>
  <div>
    <page-header></page-header>

    <main v-if="isReady" class="py-4 text-center">
      <div class="row col-xl-10 offset-xl-1 px-xl-5 col-md-12">

        <div class="container marketing">
          <div class="row featurette mb-5">
            <div class="col-md-5 order-md-2">
              <h2 class="featurette-heading">
                {{ product.name }}
              </h2>
              <p class="lead" v-html="product.description"></p>
            </div>
            <div class="col-md-7 my-auto order-md-1">
              <img 
                v-if="product.logo"
                height="500" 
                width="500" 
                :src="product.logo" 
                class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" 
                alt="...">
              <svg v-else class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 500x500"><title>Placeholder</title><rect width="100%" height="100%" fill="#eee"/><text x="50%" y="50%" fill="#aaa" dy=".3em">500x500</text></svg>
            </div>
          </div>

          <div>
            <feature-card :features="product.features" />
          </div><!-- /.row -->

          <div>
            <marketing-card :marketings="product.marketing" />
          </div>

          <!-- /END THE FEATURETTES -->

        </div><!-- /.container -->

      </div>
    </main>
  </div>
</template>

<script>
import moment from "moment";
import NProgress from "nprogress";
import FeatureCard from "../../../components/global/cards/FeatureCard"
import MarketingCard from "../../../components/global/cards/MarketingCard"
export default {
  name: "products-show",
  components: {
    FeatureCard,
    MarketingCard
  },
  data() {
    return {
      id: this.$route.params.id,
      trans: JSON.parse(CurrentTenant.translations),
      products: CurrentTenant.products || [],
      product: {},
      isReady: false,
    };
  },
  beforeRouteEnter(to, from, next) {
    next(vm => {
      vm.product = vm.findProduct(vm.id)
    });
  },
  watch: {
    $route(to, from) {
      this.isReady = false
      this.id = to.params.id
      this.product = this.findProduct(this.id)
    }
  },
  mounted() {
    NProgress.done()
  },
  methods: {
    findProduct (id) {
      let product = this.products.find((product) => product.id == id)
      this.isReady = true
      NProgress.done()
      return product
    } 
  }
};
</script>

<style scoped></style>
