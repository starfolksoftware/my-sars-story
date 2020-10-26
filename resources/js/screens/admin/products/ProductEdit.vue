<template>
  <admin-page>
    <template slot="status">
      <ul class="navbar-nav mr-auto flex-row float-right">
        <li class="text-white font-weight-bold">
          <div v-if="!product.isSaving && !product.hasSuccess">
            <span v-if="isDraft">{{ trans.app.draft }}</span>
            <span v-if="isSubmitted">{{ trans.app.submitted }}</span>
            <span v-if="isApproved">{{ trans.app.approved }}</span>
            <span v-if="isPublished">{{ trans.app.published }}</span>
          </div>

          <div v-if="product.isSaving">
            <span>{{ trans.app.saving }}</span>
          </div>

          <div v-if="product.hasSuccess">
            <span class="text-white">{{ trans.app.saved }}</span>
          </div>
        </li>
      </ul>
    </template>

    <template slot="action">
      <a
        v-if="isDraft"
        href="#"
        class="btn btn-sm btn-danger font-weight-bold my-auto"
        @click="showSubmitModal"
      >
        <span class="d-block d-lg-none">{{ trans.app.submit }}</span>
        <span class="d-none d-lg-block">{{ trans.app.submit_for_approval }}</span>
      </a>

      <a
        v-if="isSubmitted && (isDataEditor || isAdmin)"
        href="#"
        class="btn btn-sm btn-danger font-weight-bold my-auto"
        @click="showApproveModal"
      >
        <span class="d-block d-lg-none">{{ trans.app.approve }}</span>
        <span class="d-none d-lg-block">{{ trans.app.approve }}</span>
      </a>

      <a
        v-if="isApproved"
        href="#"
        class="btn btn-sm btn-danger font-weight-bold my-auto"
        @click="showPublishModal"
      >
        <span class="d-block d-lg-none">{{ trans.app.publish }}</span>
        <span class="d-none d-lg-block">{{ trans.app.ready_to_publish }}</span>
      </a>

      <a
        v-if="isPublished"
        href="#"
        class="btn btn-sm btn-danger font-weight-bold my-auto"
        @click="save"
      >{{ trans.app.save }}</a>
    </template>

    <template slot="menu">
      <div class="dropdown">
        <a
          id="navbarDropdown"
          class="nav-link pr-0"
          href="#"
          role="button"
          data-toggle="dropdown"
          aria-haspopup="true"
          aria-expanded="false"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            width="25"
            class="icon-dots-horizontal"
          >
            <path
              class="primary"
              fill-rule="evenodd"
              d="M5 14a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm7 0a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm7 0a2 2 0 1 1 0-4 2 2 0 0 1 0 4z"
            />
          </svg>
        </a>

        <div class="dropdown-menu dropdown-menu-right">
          <a
            v-if="canEdit"
            href="#"
            class="dropdown-item"
            @click="showNewFeatureModal"
          >{{ trans.app.new_feature }}</a>
          <a
            v-if="canEdit"
            href="#"
            class="dropdown-item"
            @click="showNewMarketingModal"
          >{{ trans.app.new_marketing }}</a>
          <a
            v-if="canEdit"
            href="#"
            class="dropdown-item"
            @click="showLogoUploadModal"
          >{{ trans.app.upload_logo }}</a>
          <a
            v-if="canConvertToDraft"
            href="#"
            class="dropdown-item"
            @click.prevent="convertToDraft"
          >{{ trans.app.convert_to_draft }}</a>
          <a
            v-if="canDelete"
            href="#"
            class="dropdown-item text-danger"
            @click="showDeleteModal"
          >{{ trans.app.delete }}</a>
        </div>
      </div>
    </template>
    <template slot="page-title">
      {{ id == 'create' ? trans.app.new_product : product.name }}
    </template>
    <template slot="breadcrumb">
      <breadcrumb :links="breadcrumbLinks" />
    </template>
    <template slot="main">
      <div class="col">
        <div class="form-group row my-3">
          <textarea-autosize
            :placeholder="trans.app.title"
            class="form-control-lg form-control border-0 font-serif bg-transparent"
            @input.native="update"
            rows="1"
            v-model="product.name"
            :disabled="!canEdit"
          />
        </div>

        <quill-editor :value.sync="product.description" :readOnly="!canEdit"></quill-editor>

        <div class="features">
          <h3>{{ trans.app.features }}</h3>
          <hr>
          <feature-card :features="product.features" hasDelete />
        </div>

        <div class="marketing">
          <h3>{{ trans.app.marketing }}</h3>
          <hr>
          <marketing-card :marketings="product.marketing" hasDelete />
        </div>
      </div>

      <publish-modal v-if="isReady" ref="publishModal" />

      <delete-modal
        v-if="isReady"
        ref="deleteModal"
        @delete="deleteDataset"
        :header="trans.app.delete"
        :message="trans.app.deleted_products_are_gone_forever"
      />

      <approve-modal
        v-if="isReady"
        ref="approveModal"
        @approve="approve"
        :header="trans.app.approve"
        :message="trans.app.approved_products_can_be_published"
      />

      <submit-modal
        v-if="isReady"
        ref="submitModal"
        @submitForApproval="submitForApproval"
        :header="trans.app.submit"
        :message="trans.app.submitted_products_are_no_longer_editable"
      />

      <logo-upload-modal ref="logoUploadModal" />

      <new-feature-modal @new-feature="addFeature" ref="newFeatureModal" />

      <new-marketing-modal @new-feature="addMarketing" ref="newMarketingModal" />
    </template>
  </admin-page>
</template>

<script>
import Vue from "vue"
import $ from "jquery"
import moment from "moment"
import { EventBus } from './../../../bus'
import { mapGetters } from "vuex"
import NProgress from "nprogress"
import DeleteModal from "../../../components/global/modals/DeleteModal"
import ApproveModal from "../../../components/global/modals/ApproveModal"
import SubmitModal from "../../../components/global/modals/SubmitModal"
import VueTextAreaAutosize from "vue-textarea-autosize"
import PublishModal from "../../../components/global/modals/products/PublishModal"
import NewFeatureModal from "../../../components/global/modals/products/NewFeatureModal"
import LogoUploadModal from "../../../components/global/modals/products/LogoUploadModal"
import QuillEditor from "../../../components/global/basic-editor/QuillEditor"
import FeatureCard from "../../../components/global/cards/FeatureCard"
import MarketingCard from "../../../components/global/cards/MarketingCard"
Vue.use(VueTextAreaAutosize);
export default {
  name: "products-edit",
  components: {
    PublishModal,
    NewFeatureModal,
    NewMarketingModal: NewFeatureModal,
    DeleteModal,
    ApproveModal,
    SubmitModal,
    LogoUploadModal,
    QuillEditor,
    FeatureCard,
    MarketingCard
  },
  data() {
    return {
      product: {
        marketing: [],
        features: [],
      },
      id: this.$route.params.id || "create",
      isReady: false,
      trans: JSON.parse(CurrentTenant.translations),
      breadcrumbLinks: [
        {
          title: 'All Products',
          url: '#',
        },
        {
          title: 'Product',
          url: '#',
        }
      ]
    };
  },
  watch: {
    "product.description": function(val) {
      if (val) this.update()
    },
    "product.features": function(val) {
      if (val.length > 0) this.update()
    },
    "product.marketing": function(val) {
      if (val.length > 0) this.update()
    }
  },
  beforeRouteEnter(to, from, next) {
    next(vm => {
      vm.loadProduct()
    });
  },
  beforeRouteLeave(to, from, next) {
    // Reset the form status to avoid it flashing on the next screen load
    this.product.isSaving = false;
    this.product.hasSuccess = false;
    next();
  },
  computed: {
    ...mapGetters(["activeProduct", "isDraft", "isSubmitted", "isApproved", "isPublished"]),
    canEdit() {
      return (
        this.id === "create" ||
        this.isDraft ||
        (this.isSubmitted && (this.isAdmin))
      );
    },
    canConvertToDraft() {
      return this.isSubmitted || this.isApproved || this.isPublished;
    },
    canDelete() {
      return (
        this.id !== "create" &&
        (this.product.user_id == this.CurrentTenant.user.id || this.isAdmin)
      );
    }
  },
  methods: {
    save() {
      this.product.errors = [];
      this.product.isSaving = true;
      this.product.hasSuccess = false;
      this.$store.dispatch("saveActiveProduct", {
        data: this.product,
        id: this.id
      });
      this.$store.dispatch("setSubmittedAt", this.product.submitted_at);
      this.$store.dispatch("setApprovedAt", this.product.approved_at);
      this.$store.dispatch("setPublishedAt", this.product.published_at);
      if (this.id === "create") {
        this.id = this.product.id;
      }
      setTimeout(() => {
        this.product.hasSuccess = false;
        this.product.isSaving = false;
      }, 3000);
    },
    update: _.debounce(function(e) {
      this.save();
    }, 3000),
    convertToDraft() {
      this.product.published_at = "";
      this.product.submitted_at = "";
      this.product.approved_at = "";
      this.save();
      this.$router.push({ name: "products" });
    },
    submitForApproval() {
      this.product.submitted_at = moment().format("YYYY-MM-DD hh:mm:ss");
      this.save();
      $(this.$refs.submitModal.$el).modal("hide");
    },
    approve() {
      this.product.approved_at = moment().format("YYYY-MM-DD hh:mm:ss");
      this.product.editor_id = "approved";
      this.save();
      $(this.$refs.approveModal.$el).modal("hide");
    },
    deleteDataset() {
      this.$store.dispatch("deleteProduct", this.product.id);
      $(this.$refs.deleteModal.$el).modal("hide");
    },
    showPublishModal() {
      $(this.$refs.publishModal.$el).modal("show");
    },
    showDeleteModal() {
      $(this.$refs.deleteModal.$el).modal("show");
    },
    showApproveModal() {
      $(this.$refs.approveModal.$el).modal("show");
    },
    showSubmitModal() {
      $(this.$refs.submitModal.$el).modal("show");
    },
    showNewFeatureModal() {
      $(this.$refs.newFeatureModal.$el).modal("show");
    },
    showNewMarketingModal() {
      $(this.$refs.newMarketingModal.$el).modal("show");
    },
    showLogoUploadModal() {
      $(this.$refs.logoUploadModal.$el).modal("show");
    },
    loadProduct() {
      let vm = this
      vm.request()
        .get("/api/v1/products/" + vm.id)
        .then(response => {
          vm.$store.dispatch("setActiveProduct", response.data.product)
          vm.$store.dispatch("setSubmittedAt", response.data.product.submitted_at)
          vm.$store.dispatch("setApprovedAt", response.data.product.approved_at)
          vm.$store.dispatch("setPublishedAt", response.data.product.published_at)
          vm.product = vm.$store.getters.activeProduct
          vm.isReady = true
          NProgress.done()
        })
        .catch(error => {
          // vm.$router.push({ name: "products" });
        });
    },
    addFeature(feature) {
      this.product.features.push(feature)
    },
    addMarketing(marketing) {
      this.product.marketing.push(marketing)
    }
  }
};
</script>

<style scoped></style>
