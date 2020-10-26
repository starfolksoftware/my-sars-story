<template>
  <admin-page>
    <template slot="action">
      <router-link
        :to="{ name: 'products-create' }"
        class="btn btn-sm btn-danger font-weight-bold my-auto"
      >{{ trans.app.new_product }}</router-link>
    </template>
    <template slot="page-title">
      {{ trans.app.products }}
    </template>
    <template slot="breadcrumb">
      <breadcrumb :links="breadcrumbLinks" />
    </template>
    <template slot="main">
      <div class="col">
        <div class="d-flex justify-content-between my-3">
          <h1>{{ trans.app.products }}</h1>

          <select
            name
            id
            v-model="productType"
            @change="changeType"
            class="my-auto bg-transparent appearance-none border-0 text-muted"
          >
            <option value="published">{{ trans.app.published }} ({{ publishedCount }})</option>
            <option value="approved">{{ trans.app.approved }} ({{ approvedCount }})</option>
            <option value="forApproval">{{ trans.app.submitted }} ({{ submittedCount }})</option>
            <option value="draft">{{ trans.app.draft }} ({{ draftCount }})</option>
          </select>
        </div>

        <div class="mt-2">
          <div
            v-for="(product, $index) in products"
            :key="$index"
            class="d-flex border-top py-3 align-items-center"
          >
            <div class="mr-auto py-1">
              <p class="mb-1">
                <router-link
                  :to="{name: 'products-edit', params: { id: product.id }}"
                  class="font-weight-bold text-lg lead text-decoration-none"
                >{{ product.name || 'name' }}</router-link>
              </p>
              <p class="mb-1" v-if="product.description" v-html="trim(product.description, 200)"></p>
              <p class="text-muted mb-0">
                <span>{{ trans.app.author }} {{ product.user.name }} |</span>
                <span
                  v-if="(isApproved || isPublished) && product.editor"
                >{{ trans.app.approved_by }} {{ product.editor.name }} {{ moment(product.approved_at).locale(CurrentTenant.locale).fromNow() }}</span>
              </p>
              <p class="text-muted mb-0">
                <span
                  v-if="isPublished(product)"
                >{{ trans.app.published}} {{ moment(product.published_at).locale(CurrentTenant.locale).fromNow() }}</span>

                <span v-if="isSubmitted(product)" class="text-danger">{{ trans.app.submitted }}</span>

                <span v-if="isDraft(product)" class="text-danger">{{ trans.app.draft }}</span>

                <span v-if="isScheduled(product)" class="text-danger">{{ trans.app.scheduled }}</span>
                ― {{ trans.app.updated }} {{ moment(product.updated_at).locale(CurrentTenant.locale).fromNow() }}
              </p>
            </div>
            <div class="ml-auto pl-3">
              
            </div>
          </div>

          <infinite-loading :identifier="infiniteId" @infinite="fetchData" spinner="spiral">
            <span slot="no-more"></span>
            <div slot="no-results" class="text-left">
              <div class="mt-5">
                <p class="lead text-center text-muted mt-5 pt-5">
                  <span v-if="productType === 'published'">{{ trans.app.you_have_no_published }}</span>
                  <span v-else-if="productType === 'draft'">{{ trans.app.you_have_no_draft }}</span>
                  <span
                    v-else-if="productType === 'forApproval'"
                  >{{ trans.app.you_have_no_for_approval }}</span>
                  <span
                    v-else-if="productType === 'approved'"
                  >{{ trans.app.you_have_no_recently_approved }}</span>
                </p>
              </div>
            </div>
          </infinite-loading>
        </div>
      </div>
    </template>
  </admin-page>
</template>

<script>
import moment from "moment";
import NProgress from "nprogress";
import InfiniteLoading from "vue-infinite-loading";
export default {
  name: "products-index",
  components: {
    InfiniteLoading
  },
  data() {
    return {
      page: 1,
      products: [],
      publishedCount: 0,
      draftCount: 0,
      submittedCount: 0,
      approvedCount: 0,
      productType: this.isEditor ? "forApproval" : "published",
      infiniteId: +new Date(),
      trans: JSON.parse(CurrentTenant.translations),
      breadcrumbLinks: [
        {
          title: 'All Products',
          url: '#',
        },
      ]
    };
  },
  methods: {
    fetchData($state) {
      this.request()
        .get("/api/v1/products", {
          params: {
            page: this.page,
            productType: this.productType
          }
        })
        .then(response => {
          this.publishedCount = response.data.publishedCount;
          this.submittedCount = response.data.submittedCount;
          this.draftCount = response.data.draftCount;
          this.approvedCount = response.data.approvedCount;
          if (
            !_.isEmpty(response.data) &&
            !_.isEmpty(response.data.products.data)
          ) {
            this.page += 1;
            this.products.push(...response.data.products.data);
            $state.loaded();
          } else {
            $state.complete();
          }
          NProgress.done();
        })
        .catch(error => {
          // Add any error debugging...
          NProgress.done();
        });
    },
    isDraft(product) {
      return (
        product.approved_at === null &&
        product.published_at === null &&
        product.submitted_at === null
      );
    },
    isSubmitted(product) {
      return (
        product.approved_at === null &&
        product.published_at === null &&
        product.submitted_at !== null
      );
    },
    isApproved(product) {
      return (
        product.approved_at !== null &&
        product.published_at === null &&
        product.submitted_at !== null
      );
    },
    isScheduled(product) {
      return moment(product.published_at).isAfter(
        moment(new Date())
          .format()
          .slice(0, 19)
          .replace("T", " ")
      );
    },
    isPublished(product) {
      return moment(product.published_at).isBefore(
        moment(new Date())
          .format()
          .slice(0, 19)
          .replace("T", " ")
      );
    },
    changeType() {
      this.page = 1;
      this.products = [];
      this.infiniteId += 1;
    }
  }
};
</script>

<style scoped>
#featuredImage {
  background-size: cover;
  width: 57px;
  height: 57px;
  -webkit-border-radius: 50%;
  -moz-border-radius: 50%;
  border-radius: 50%;
}
</style>
