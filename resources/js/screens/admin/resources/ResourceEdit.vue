<template>
  <admin-page>
    <template slot="status">
      <ul class="navbar-nav mr-auto flex-row float-right">
        <li class="text-white font-weight-bold">
          <span v-if="form.isSaving">{{ trans.app.saving }}</span>
          <span v-if="form.hasSuccess" class="text-white">{{ trans.app.saved }}</span>
        </li>
      </ul>
    </template>

    <template slot="action">
      <a
        href="#"
        class="btn btn-sm btn-danger font-weight-bold my-auto"
        :class="{ disabled: form.name === '' }"
        @click="saveResource"
        :aria-label="trans.app.save"
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
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
          <a
            href="#"
            class="dropdown-item"
            @click="showFileUploadModal"
          >{{ trans.app.upload_resource }}</a>
          <a
            href="#"
            class="dropdown-item text-danger"
            @click="showDeleteModal"
            v-if="id !== 'create'"
          >{{ trans.app.delete }}</a>
        </div>
      </div>
    </template>
    <template slot="page-title">
      {{ id == 'create' ? trans.app.new_resource : form.name }}
    </template>
    <template slot="breadcrumb">
      <breadcrumb :links="breadcrumbLinks" />
    </template>
    <template slot="main">
      <div class="col" v-if="isReady">
        <div class="form-group">
          <textarea-autosize
            :placeholder="trans.app.title"
            class="form-control border-0 font-serif bg-transparent"
            rows="1"
            v-model="form.title"
          />
          <div v-if="form.errors.title" class="invalid-feedback d-block">
            <strong>{{ form.errors.title[0] }}</strong>
          </div>
        </div>
        <div class="form-group">
          <quill-editor :value.sync="form.description"></quill-editor>
          <div v-if="form.errors.description" class="invalid-feedback d-block">
            <strong>{{ form.errors.description[0] }}</strong>
          </div>
        </div>
        <div class="form-group">
          <div v-if="form.errors.path" class="invalid-feedback d-block">
            <strong>{{ form.errors.path[0] }}</strong>
          </div>
          <div v-if="form.errors.server" class="invalid-feedback d-block">
            <strong>{{ form.errors.server[0] }}</strong>
          </div>
        </div>
      </div>

      <delete-modal
        ref="deleteModal"
        @delete="deleteMemorial"
        :header="trans.app.delete"
        :message="trans.app.deleted_types_are_gone_forever"
      ></delete-modal>

      <resource-upload-modal 
        v-if="isReady" ref="uploadFileModal"
        :defaultFileUrl="form.path"
        :path="form.path"
        @update:path="form.path = $event"
      />
    </template>
  </admin-page>
</template>

<script>
import Vue from "vue"
import $ from "jquery"
import NProgress from "nprogress"
import DeleteModal from "../../../components/global/modals/DeleteModal"
import ResourceUploadModal from "../../../components/global/modals/ResourceUploadModal"
import VueTextAreaAutosize from "vue-textarea-autosize"
import QuillEditor from "../../../components/global/basic-editor/QuillEditor"

Vue.use(VueTextAreaAutosize)

export default {
  name: "resource-edit",
  components: {
    DeleteModal,
    ResourceUploadModal,
    QuillEditor,
  },
  data() {
    return {
      status: null,
      id: this.$route.params.id || "create",
      form: {
        id: "",
        title: "",
        description: "",
        path: "",
        user_id: "",
        errors: [],
        isSaving: false,
        hasSuccess: false
      },
      isReady: false,
      trans: JSON.parse(CurrentTenant.translations),
      roles: [],
      breadcrumbLinks: [
        {
          title: JSON.parse(CurrentTenant.translations).app.resources,
          url: '#',
        },
        {
          title: JSON.parse(CurrentTenant.translations).app.resource,
          url: '#',
        }
      ]
    };
  },
  mounted() {
    this.fetchData();
  },
  watch: {
    'form.path': function(val) {
      if (val) {
        this.saveResource()
      } else {
        this.form.path = ""
        this.saveResource()
      }
    }
  },
  methods: {
    fetchData() {
      this.request()
        .get("/api/v1/resources/" + this.id)
        .then(response => {
          this.status = response.data
          this.form.id = response.data.id
          if (this.id !== "create") {
            this.form.title = response.data.title
            this.form.description = response.data.description
            this.form.path = response.data.path
            this.form.user_id = response.data.user_id
            console.log(this.form);
          }

          this.isReady = true;
          NProgress.done();
        })
        .catch((error) => {
          this.$router.push({ name: "resources" });
        });
    },
    saveResource() {
      this.form.errors = [];
      this.form.isSaving = true;
      this.form.hasSuccess = false;
      let vErrors = this.validate(this.form);
      if (Object.keys(vErrors).length > 0) {
        this.form.errors = vErrors;
        this.form.isSaving = false;
        return false;
      }
      this.request()
        .post("/api/v1/resources/" + this.id, this.form)
        .then(response => {
          this.form.isSaving = false;
          this.form.hasSuccess = true;
          this.id = this.form.id = response.data.id;
          this.status = response.data;
        })
        .catch(error => {
          this.form.isSaving = false;
          console.log(error)
        });
      setTimeout(() => {
        this.form.hasSuccess = false;
        this.form.isSaving = false;
      }, 3000);
    },
    deleteMemorial() {
      this.request()
        .delete("/api/v1/resources/" + this.id)
        .then(response => {
          $(this.$refs.deleteModal.$el).modal("hide");
          this.$router.push({ name: "memorial" });
        })
        .catch(error => {
          // Add any error debugging...
        });
    },
    showDeleteModal() {
      $(this.$refs.deleteModal.$el).modal("show");
    },
    showFileUploadModal() {
      $(this.$refs.uploadFileModal.$el).modal("show");
    },
    validate(form) {
      let errors = {};

      if (!form.title) {
        errors.title = ["title can not be empty"];
      }

      if (!form.description) {
        errors.description = ["description can not be empty"];
      }

      if (!form.path) {
        errors.path = ["path can not be empty"]
      }

      return errors;
    }
  }
};
</script>
