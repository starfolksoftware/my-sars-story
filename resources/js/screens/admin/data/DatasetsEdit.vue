<template>
  <admin-page>
    <template slot="status">
      <div v-if="!dataset.isSaving && !dataset.hasSuccess">
        <span v-if="isDraft">{{ trans.app.draft }}</span>
        <span v-if="isSubmitted">{{ trans.app.submitted }}</span>
        <span v-if="isApproved">{{ trans.app.approved }}</span>
        <span v-if="isPublished">{{ trans.app.published }}</span>
      </div>

      <div v-if="dataset.isSaving">
        <span>{{ trans.app.saving }}</span>
      </div>

      <div v-if="dataset.hasSuccess">
        <span >{{ trans.app.saved }}</span>
      </div>
    </template>

    <template slot="action">
      <a
        v-if="isDraft"
        v-permission="['update_datasets', 'update_own_datasets']"
        href="#"
        class="btn btn-sm btn-danger font-weight-bold my-auto"
        @click="showSubmitModal"
      >
        <span class="d-block d-lg-none">{{ trans.app.submit }}</span>
        <span class="d-none d-lg-block">{{ trans.app.submit_for_approval }}</span>
      </a>

      <a
        v-if="isSubmitted"
        v-permission="['approve_datasets']"
        href="#"
        class="btn btn-sm btn-danger font-weight-bold my-auto"
        @click="showApproveModal"
      >
        <span class="d-block d-lg-none">{{ trans.app.approve }}</span>
        <span class="d-none d-lg-block">{{ trans.app.approve }}</span>
      </a>

      <a
        v-if="isApproved"
        v-permission="['publish_datasets']"
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
            :to="{ name: 'stats-show', params: { id: id, className: 'App\\Model\\Data\\Dataset' } }"
            class="dropdown-item"
          >{{ trans.app.view_stats }}</router-link>
          <div v-if="isPublished" class="dropdown-divider"></div>
          <a
            v-if="canEdit"
            v-permission="['update_datasets', 'update_own_datasets']"
            href="#"
            class="dropdown-item"
            @click="showSettingsModal"
          >{{ trans.app.general_settings }}</a>
          <a
            v-if="canEdit"
            v-permission="['update_datasets', 'update_own_datasets']"
            href="#"
            class="dropdown-item"
            @click="showNewResourceModal()"
          >{{ trans.app.new_resource }}</a>
          <a
            v-if="canEdit"
            v-permission="['update_datasets', 'update_own_datasets']"
            href="#"
            class="dropdown-item"
            @click="showDatasetSeoModal"
          >{{ trans.app.seo_settings }}</a>
          <a
            v-if="canConvertToDraft"
            v-permission="['update_datasets', 'update_own_datasets']"
            href="#"
            class="dropdown-item"
            @click.prevent="convertToDraft"
          >{{ trans.app.convert_to_draft }}</a>
          <a
            v-if="canDelete"
            v-permission="['delete_datasets', 'delete_own_datasets']"
            href="#"
            class="dropdown-item text-danger"
            @click="showDeleteModal"
          >{{ trans.app.delete }}</a>
        </div>
      </div>
    </template>
    <template slot="page-title">
      {{ trans.app.datasets }}
    </template>
    <template slot="breadcrumb">
      <breadcrumb :links="breadcrumbLinks" />
    </template>
    <template slot="main">
      <div class="col">
        <div class="form-group row">
          <textarea-autosize
            :placeholder="trans.app.title"
            class="form-control border-0 font-serif bg-transparent"
            @input.native="update"
            rows="1"
            v-model="dataset.title"
            :disabled="!canEdit"
          />
        </div>

        <quill-editor :value.sync="dataset.description" :readOnly="!canEdit"></quill-editor>

        <h3>{{ trans.app.data_and_resources }}</h3>

        <div class="mt-2">
          <div
            v-for="(resource, $index) in dataset.resources"
            :key="$index"
            class="d-flex border-top py-3 align-items-center"
          >
            <div class="mr-auto py-1">
              <p class="mb-1">
                <a
                  href="#"
                  class="font-weight-bold text-lg lead text-decoration-none"
                  @click.prevent="showNewResourceModal(resource.id)"
                >{{ resource.title }}</a>
              </p>
              <p class="mb-1">{{ `${resource.description.substring(0, 50)}...` }}</p>
              <p class="text-muted mb-0">
                <span>{{ trans.app.curator }} {{ resource.user.name }} |</span>
                <span>{{ moment(resource.created_at).locale(CurrentTenant.locale).fromNow() }}</span>
              </p>
              <p class="text-muted mb-0">
                <span >{{ `.${resource.format.extension}` }}</span>
              </p>
            </div>
            <div class="ml-auto pl-3">
              <a
                :href="resource.path"
                class="btn btn-outline-info"
                @click="downloadResource(resource.id)"
              :download="resource.title">
                Download
              </a>
              <button
                href=""
                class="btn btn-outline-danger"
                @click="deleteResource(resource.id)">
                Delete
              </button>
            </div>
          </div>
        </div>


        <div v-if="id !== 'create'" class="list-group mt-5">

          <a class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">{{ trans.app.created }}</h5>
            </div>
            <p class="mb-1">{{ response.created_at }}</p>
            <small></small>
          </a>

          <a class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">{{ trans.app.updated }}</h5>
            </div>
            <p class="mb-1">{{ response.updated_at }}</p>
            <small></small>
          </a>

          <a class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">{{ trans.app.unique_identifier }}</h5>
            </div>
            <p class="mb-1">{{ response.id }}</p>
            <small></small>
          </a>

          <a v-if="response.license" class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">{{ trans.app.license }}</h5>
            </div>
            <p class="mb-1">
              <a 
                :href="response.license.link" 
                target="_blank" 
                rel="noopener noreferrer"
              >{{ response.license.name }}</a>
            </p>
            <small></small>
          </a>

          <a v-if="response.user" class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">{{ trans.app.author }}</h5>
            </div>
            <p class="mb-1">
              {{ response.user.name }}
            </p>
            <small></small>
          </a>

          <a class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">{{ trans.app.topics }}</h5>
            </div>
            <p class="mb-1">
              <span
                v-for="(topic, index) in response.topics"
                :key="index"
                class="badge badge-success mr-1"
              >{{ topic.name }}</span>
            </p>
            <small></small>
          </a>

          <a class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">{{ trans.app.tags }}</h5>
            </div>
            <p class="mb-1">
              <span
                v-for="(tag, index) in response.tags"
                :key="index"
                class="badge badge-success mr-1"
              >{{ tag.name }}</span>
            </p>
            <small></small>
          </a>

        </div>


      </div>

      <publish-dataset-modal v-if="isReady" ref="publishModal" />

      <dataset-settings-modal
        v-if="isReady"
        ref="datasetSettingsModal"
        :licenses="licenses"
        :topics="topics"
        :tags="tags"
      />

      <new-resource-modal 
        v-if="isReady" 
        ref="newResourceModal" 
        :formats="formats" 
        :resource_id="resource_id"
      />

      <dataset-seo-modal v-if="isReady" ref="datasetSeoModal" />

      <delete-modal
        v-if="isReady"
        ref="deleteModal"
        @delete="deleteDataset"
        :header="trans.app.delete"
        :message="trans.app.deleted_datasets_are_gone_forever"
      />

      <approve-modal
        v-if="isReady"
        ref="approveModal"
        @approve="approve"
        :header="trans.app.approve"
        :message="trans.app.approved_datasets_can_be_published"
      />

      <submit-modal
        v-if="isReady"
        ref="submitModal"
        @submitForApproval="submitForApproval"
        :header="trans.app.submit"
        :message="trans.app.submitted_datasets_are_no_longer_editable"
      />
    </template>
  </admin-page>
</template>

<script>
import Vue from "vue";
import $ from "jquery";
import moment from "moment";
import { EventBus } from './../../../bus'
import { mapGetters } from "vuex";
import NProgress from "nprogress";
import DatasetSeoModal from "../../../components/global/modals/DatasetSeoModal";
import DeleteModal from "../../../components/global/modals/DeleteModal";
import ApproveModal from "../../../components/global/modals/ApproveModal";
import SubmitModal from "../../../components/global/modals/SubmitModal";
import VueTextAreaAutosize from "vue-textarea-autosize";
import PublishDatasetModal from "../../../components/global/modals/PublishDatasetModal";
import DatasetSettingsModal from "../../../components/global/modals/DatasetSettingsModal";
import NewResourceModal from "../../../components/global/modals/NewResourceModal";
import QuillEditor from "../../../components/global/basic-editor/QuillEditor"

Vue.use(VueTextAreaAutosize);

export default {
  name: "datasets-edit",

  components: {
    PublishDatasetModal,
    NewResourceModal,
    DeleteModal,
    ApproveModal,
    SubmitModal,
    DatasetSeoModal,
    DatasetSettingsModal,
    QuillEditor,
  },

  data() {
    return {
      dataset: {},
      response: {},
      topics: [],
      tags: [],
      licenses: [],
      formats: [],
      id: this.$route.params.id || "create",
      isReady: false,
      trans: JSON.parse(CurrentTenant.translations),
      resource_id: 'create',
      breadcrumbLinks: [
        {
          title: 'All Datasets',
          url: '/admin/data/datasets',
        },
        {
          title: 'Dataset',
          url: '#',
        }
      ]
    };
  },

  beforeRouteEnter(to, from, next) {
    next(vm => {
      vm.loadDataset()
    });
  },

  beforeRouteLeave(to, from, next) {
    // Reset the form status to avoid it flashing on the next screen load
    this.dataset.isSaving = false;
    this.dataset.hasSuccess = false;

    next();
  },

  computed: {
    ...mapGetters(["activeDataset", "isDraft", "isSubmitted", "isApproved", "isPublished"]),

    canEdit() {
      return (
        this.id === "create" ||
        this.isDraft ||
        (this.isSubmitted && (this.isDataEditor || this.isAdmin))
      );
    },

    canConvertToDraft() {
      return this.isSubmitted || this.isApproved || this.isPublished;
    },

    canDelete() {
      return (
        this.id !== "create" &&
        (this.dataset.user_id == this.CurrentTenant.user.id || this.isAdmin)
      );
    }
  },

  methods: {
    save() {
      this.dataset.errors = [];
      this.dataset.isSaving = true;
      this.dataset.hasSuccess = false;

      this.$store.dispatch("saveActiveDataset", {
        data: this.dataset,
        id: this.id
      });

      this.$store.dispatch("setSubmittedAt", this.dataset.submitted_at);
      this.$store.dispatch("setApprovedAt", this.dataset.approved_at);
      this.$store.dispatch("setPublishedAt", this.dataset.published_at);

      if (this.id === "create") {
        this.id = this.dataset.id;
      }

      setTimeout(() => {
        this.dataset.hasSuccess = false;
        this.dataset.isSaving = false;
      }, 3000);
    },

    update: _.debounce(function(e) {
      this.save();
    }, 3000),

    convertToDraft() {
      this.dataset.published_at = "";
      this.dataset.submitted_at = "";
      this.dataset.approved_at = "";
      this.dataset.editor_id = "";
      this.save();

      this.$router.push({ name: "datasets" });
    },

    submitForApproval() {
      this.dataset.submitted_at = moment().format("YYYY-MM-DD hh:mm:ss");
      this.save();

      $(this.$refs.submitModal.$el).modal("hide");
    },

    approve() {
      this.dataset.approved_at = moment().format("YYYY-MM-DD hh:mm:ss");
      this.dataset.editor_id = "approved";
      this.save();

      $(this.$refs.approveModal.$el).modal("hide");
    },

    deleteDataset() {
      this.$store.dispatch("deleteDataset", this.dataset.id);

      $(this.$refs.deleteModal.$el).modal("hide");
    },

    showPublishModal() {
      $(this.$refs.publishModal.$el).modal("show");
    },

    showSettingsModal() {
      $(this.$refs.datasetSettingsModal.$el).modal("show");
    },

    showNewResourceModal(id = null) {
      this.resource_id = id ? id : 'create'
      EventBus.$emit("NEW_RESOURCE_MODAL_OPENED", this.resource_id)
      $(this.$refs.newResourceModal.$el).modal("show")
    },

    showDatasetSeoModal() {
      $(this.$refs.datasetSeoModal.$el).modal("show");
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

    loadDataset() {
      let vm = this

      vm.request()
        .get("/api/v1/datasets/" + vm.id)
        .then(response => {
          vm.$store.dispatch("setActiveDataset", response.data.dataset)
          vm.$store.dispatch("setSubmittedAt", response.data.dataset.submitted_at)
          vm.$store.dispatch("setApprovedAt", response.data.dataset.approved_at)
          vm.$store.dispatch("setPublishedAt", response.data.dataset.published_at)

          vm.dataset = vm.$store.getters.activeDataset
          vm.response = response.data.dataset
          vm.licenses = response.data.licenses
          vm.topics = response.data.topics
          vm.tags = response.data.tags
          vm.formats = response.data.formats
          vm.isReady = true

          NProgress.done()
        })
        .catch(error => {
          vm.$router.push({ name: "datasets" });
        });
    },

    downloadResource(id) {
      if (!id) return
      
      this.request()
        .get("/api/v1/dataresources/download/" + id)
        .then(response => {
          NProgress.done()
        })
        .catch(error => {

        });
    },

    deleteResource(id) {
      if (!id) return
      
      if (confirm('Are you sure?')) {
        this.request()
          .delete("/api/v1/dataresources/" + id)
          .then(response => {
            this.loadDataset()
            NProgress.done()
          })
          .catch(error => {

          });
      }
    }
  }
};
</script>

<style scoped>
textarea {
  font-size: 42px;
}
</style>
