<template>
  <admin-page>
    <template slot="status">
      <div v-if="!post.isSaving && !post.hasSuccess">
        <span v-if="isDraft">{{ trans.app.draft }}</span>
        <span v-if="isSubmitted">{{ trans.app.submitted }}</span>
        <span v-if="isApproved">{{ trans.app.approved }}</span>
        <span v-if="isPublished">{{ trans.app.published }}</span>
      </div>

      <div v-if="post.isSaving">
        <span>{{ trans.app.saving }}</span>
      </div>

      <div v-if="post.hasSuccess">
        <span class="text-white">{{ trans.app.saved }}</span>
      </div>
    </template>

    <template slot="action">
      <a
        v-if="isDraft"
        v-permission="['update_posts', 'update_own_posts']"
        href="#"
        class="btn btn-sm btn-danger font-weight-bold my-auto"
        @click="showSubmitModal"
      >
        <span class="d-block d-lg-none">{{ trans.app.submit }}</span>
        <span class="d-none d-lg-block">{{ trans.app.submit_for_approval }}</span>
      </a>

      <a
        v-if="isSubmitted"
        v-permission="['approve_posts']"
        href="#"
        class="btn btn-sm btn-danger font-weight-bold my-auto"
        @click="showApproveModal"
      >
        <span class="d-block d-lg-none">{{ trans.app.approve }}</span>
        <span class="d-none d-lg-block">{{ trans.app.approve }}</span>
      </a>

      <a
        v-if="isApproved"
        v-permission="['publish_posts']"
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
          <router-link
            v-if="isPublished"
            :to="{ name: 'stats-show', params: { id: id, className: 'App\\Models\\Blog\\Post' } }"
            class="dropdown-item"
          >{{ trans.app.view_stats }}</router-link>
          <div v-if="isPublished" class="dropdown-divider"></div>
          <a
            v-if="canEdit"
            v-permission="['update_posts', 'update_own_posts']"
            href="#"
            class="dropdown-item"
            @click="showSettingsModal"
          >{{ trans.app.general_settings }}</a>
          <a
            v-if="canEdit"
            v-permission="['update_posts', 'update_own_posts']"
            href="#"
            class="dropdown-item"
            @click="showFeaturedImageModal"
          >{{ trans.app.featured_image }}</a>
          <a
            v-if="canEdit"
            v-permission="['update_posts', 'update_own_posts']"
            href="#"
            class="dropdown-item"
            @click="showSeoModal"
          >{{ trans.app.seo_settings }}</a>
          <a
            v-if="canConvertToDraft"
            v-permission="['update_posts', 'update_own_posts']"
            href="#"
            class="dropdown-item"
            @click.prevent="convertToDraft"
          >{{ trans.app.convert_to_draft }}</a>
          <a
            v-if="canDelete"
            v-permission="['delete_posts', 'delete_own_posts']"
            href="#"
            class="dropdown-item text-danger"
            @click="showDeleteModal"
          >{{ trans.app.delete }}</a>
        </div>
      </div>
    </template>

    <template slot="page-title">
      {{ id == 'create' ? trans.app.new_post : post.title }}
    </template>
    <template slot="breadcrumb">
      <breadcrumb :links="breadcrumbLinks" />
    </template>

    <template v-if="isReady" slot="main"> 
      <div class="col">
        <div class="form-group my-3">
          <textarea-autosize
            :placeholder="trans.app.title"
            class="form-control form-control-flush"
            @input.native="update"
            rows="1"
            v-model="post.title"
            :disabled="!canEdit"
          />
        </div>

        <quill-editor :readOnly="!canEdit"></quill-editor>
      </div>

      <publish-modal v-if="isReady" ref="publishModal" />

      <settings-modal
        v-if="isReady"
        ref="settingsModal"
        :post="post"
        :tags="tags"
        :topics="topics"
      />

      <featured-image-modal v-if="isReady" ref="featuredImageModal" />

      <seo-modal v-if="isReady" ref="seoModal" />

      <delete-modal
        v-if="isReady"
        ref="deleteModal"
        @delete="deletePost"
        :header="trans.app.delete"
        :message="trans.app.deleted_posts_are_gone_forever"
      />

      <approve-modal
        v-if="isReady"
        ref="approveModal"
        @approve="approve"
        :header="trans.app.approve"
        :message="trans.app.approved_posts_can_be_published"
      />

      <submit-modal
        v-if="isReady"
        ref="submitModal"
        @submitForApproval="submitForApproval"
        :header="trans.app.submit"
        :message="trans.app.submitted_posts_are_no_longer_editable"
      />
    </template>
  </admin-page>
</template>

<script>
import Vue from "vue";
import $ from "jquery";
import moment from "moment";
import { mapGetters } from "vuex";
import NProgress from "nprogress";
import SeoModal from "../../../components/global/modals/SeoModal";
import DeleteModal from "../../../components/global/modals/DeleteModal";
import ApproveModal from "../../../components/global/modals/ApproveModal";
import SubmitModal from "../../../components/global/modals/SubmitModal";
import VueTextAreaAutosize from "vue-textarea-autosize";
import PublishModal from "../../../components/global/modals/PublishModal";
import SettingsModal from "../../../components/global/modals/SettingsModal";
import QuillEditor from "../../../components/global/editor/QuillEditor";
import FeaturedImageModal from "../../../components/global/modals/FeaturedImageModal";

Vue.use(VueTextAreaAutosize);

export default {
  name: "posts-edit",

  components: {
    PublishModal,
    FeaturedImageModal,
    DeleteModal,
    ApproveModal,
    SubmitModal,
    QuillEditor,
    SeoModal,
    SettingsModal
  },

  data() {
    return {
      post: {},
      tags: [],
      topics: [],
      id: this.$route.params.id || "create",
      isReady: false,
      trans: JSON.parse(CurrentTenant.translations),
      breadcrumbLinks: [
        {
          title: JSON.parse(CurrentTenant.translations).app.posts,
          url: '/admin/posts',
        },
        {
          title: JSON.parse(CurrentTenant.translations).app.post,
          url: '/admin/posts/create',
        }
      ]
    };
  },

  beforeRouteEnter(to, from, next) {
    next(vm => {
      vm.request()
        .get("/api/v1/posts/" + vm.id)
        .then(response => {
          vm.$store.dispatch("setActivePost", response.data.post);
          vm.$store.dispatch("setSubmittedAt", response.data.post.submitted_at);
          vm.$store.dispatch("setApprovedAt", response.data.post.approved_at);
          vm.$store.dispatch("setPublishedAt", response.data.post.published_at);

          vm.post = vm.$store.getters.activePost;
          vm.tags = response.data.tags;
          vm.topics = response.data.topics;
          vm.isReady = true;

          NProgress.done();
        })
        .catch(error => {
          console.log(error);
          vm.$router.push({ name: "posts" });
        });
    });
  },

  beforeRouteLeave(to, from, next) {
    // Reset the form status to avoid it flashing on the next screen load
    this.post.isSaving = false;
    this.post.hasSuccess = false;

    next();
  },

  computed: {
    ...mapGetters(["isDraft", "isSubmitted", "isApproved", "isPublished"]),

    canEdit() {
      return (
        this.id === "create" ||
        this.isDraft ||
        (this.isSubmitted && (this.isEditor || this.isAdmin))
      );
    },

    canConvertToDraft() {
      return this.isSubmitted || this.isApproved || this.isPublished;
    },

    canDelete() {
      return (
        this.id !== "create" &&
        (this.post.user_id == this.CurrentTenant.user.id || this.isAdmin)
      );
    }
  },

  methods: {
    save() {
      this.post.errors = [];
      this.post.isSaving = true;
      this.post.hasSuccess = false;

      this.$store.dispatch("saveActivePost", {
        data: this.post,
        id: this.id
      });

      this.$store.dispatch("setSubmittedAt", this.post.submitted_at);
      this.$store.dispatch("setApprovedAt", this.post.approved_at);
      this.$store.dispatch("setPublishedAt", this.post.published_at);

      if (this.id === "create") {
        this.id = this.post.id;
      }

      setTimeout(() => {
        this.post.hasSuccess = false;
        this.post.isSaving = false;
      }, 3000);
    },

    update: _.debounce(function(e) {
      this.save();
    }, 3000),

    convertToDraft() {
      this.post.published_at = ""
      this.post.submitted_at = ""
      this.post.approved_at = ""

      this.post.editor_id = ""
      this.save();

      this.$router.push({ name: "posts" });
    },

    submitForApproval() {
      this.post.submitted_at = moment().format("YYYY-MM-DD hh:mm:ss");
      this.save();

      $(this.$refs.submitModal.$el).modal("hide");
    },

    approve() {
      this.post.approved_at = moment().format("YYYY-MM-DD hh:mm:ss");
      this.post.editor_id = "approved";
      this.save();

      $(this.$refs.approveModal.$el).modal("hide");
    },

    deletePost() {
      this.$store.dispatch("deletePost", this.post.id);

      $(this.$refs.deleteModal.$el).modal("hide");
    },

    showPublishModal() {
      $(this.$refs.publishModal.$el).modal("show");
    },

    showSettingsModal() {
      $(this.$refs.settingsModal.$el).modal("show");
    },

    showFeaturedImageModal() {
      $(this.$refs.featuredImageModal.$el).modal("show");
    },

    showSeoModal() {
      $(this.$refs.seoModal.$el).modal("show");
    },

    showDeleteModal() {
      $(this.$refs.deleteModal.$el).modal("show");
    },

    showApproveModal() {
      $(this.$refs.approveModal.$el).modal("show");
    },

    showSubmitModal() {
      $(this.$refs.submitModal.$el).modal("show");
    }
  }
};
</script>

<style scoped>
textarea {
  font-size: 42px;
}
</style>
