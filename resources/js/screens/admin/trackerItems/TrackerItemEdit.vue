<template>
  <admin-page>
    <template slot="status">
      <span v-if="form.isSaving">{{ trans.app.saving }}</span>
      <span v-if="form.hasSuccess">{{ trans.app.saved }}</span>
    </template>
    <template slot="page-title">
      {{ trans.app.trackers }}
    </template>
    <template slot="breadcrumb">
      <breadcrumb :links="breadcrumbLinks" />
    </template>
    <template slot="action">
      <a
        href="#"
        v-permission="['update_tracker_items']"
        class="btn btn-sm btn-danger font-weight-bold my-auto mr-3"
        @click="saveTrackedItem"
        :aria-label="trans.app.save"
      >{{ trans.app.save }}</a>

      <a
        v-if="!form.confirmed"
        href="#"
        v-permission="['update_tracker_items']"
        class="btn btn-sm btn-danger font-weight-bold my-auto"
        @click="() => {form.confirmed = true; saveTrackedItem()}"
        :aria-label="trans.app.verify"
      >{{ trans.app.verify }}</a>
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
            v-permission="['create_tracker_items', 'update_tracker_items']"
            class="dropdown-item"
            @click="showImageUploadModal">
            {{ trans.app.featured_image }}
          </a>
          <a
            href="#"
            v-if="id !== 'create'"
            v-permission="['delete_tracker_items']"
            class="dropdown-item text-danger"
            @click="showDeleteModal"
          >{{ trans.app.delete }}</a>
        </div>
      </div>
    </template>
    <template slot="main" v-if="isReady">
      <div class="col">
        <div class="form-group">
          <div class="col-lg-12">
            <div v-for="(error, index) in form.errors" :key="index" class="invalid-feedback d-block">
              <strong>{{ error[0] }}</strong>
            </div>
          </div>
        </div>
        <h1>
          {{ trans.app.general_information }}
          <hr/>
        </h1>
        <div class="form-group">
          <textarea-autosize
            :placeholder="trans.app.title"
            class="form-control"
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
        <div class="row">
          <div class="col">
            <div class="form-group">
              <div class="col-lg-12">
                <select 
                  name="state_id" 
                  id="state_id"
                  v-model="form.state_id"
                  class="form-control"
                >
                  <option value="" disabled>{{ trans.app.states }}</option>
                  <option 
                    :value="state.id"
                    v-for="(state,index) in states" :key="index">
                    {{ state.name }}
                  </option>
                </select>

                <div v-if="form.errors.state_id" class="invalid-feedback d-block">
                  <strong>{{ form.errors.state_id[0] }}</strong>
                </div>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="form-group">
              <div class="col-lg-12">
                <select 
                  name="local_government_id" 
                  id="local_government_id"
                  v-model="form.local_government_id"
                  class="form-control"
                >
                  <option value="" disabled>{{ trans.app.local_governments }}</option>
                  <option 
                    :value="localGovernment.id"
                    v-for="(localGovernment,index) in localGovernments" :key="index">
                    {{ localGovernment.name }}
                  </option>
                </select>

                <div v-if="form.errors.local_government_id" class="invalid-feedback d-block">
                  <strong>{{ form.errors.local_government_id[0] }}</strong>
                </div>
              </div>
            </div>
          </div>
        </div>
        <h1>
          {{ trans.app.meta }}
          <hr/>
        </h1>
        <vue-form-generator :schema="schema" :model="form" :options="formOptions"></vue-form-generator>
      </div>

      <delete-modal
        ref="deleteModal"
        @delete="deleteTrackerItem"
        :header="trans.app.delete"
        :message="trans.app.deleted_tracked_items_are_gone_forever"
      ></delete-modal>

      <image-upload-modal 
        v-if="isReady" ref="uploadImageModal"
        :defaultImageUrl="form.featured_image"
        :imageUrl="form.featured_image"
        @update:imageUrl="form.featured_image = $event"
      />
    </template>
  </admin-page>
</template>

<script>
import Vue from "vue"
import $ from "jquery"
import NProgress from "nprogress"
import DeleteModal from "../../../components/global/modals/DeleteModal"
import VueFormGenerator from 'vue-form-generator/dist/vfg-core.js'
import ImageUploadModal from "../../../components/global/modals/ImageUploadModal"
// import 'vue-form-generator/dist/vfg-core.css'
import VueTextAreaAutosize from "vue-textarea-autosize"
import QuillEditor from "../../../components/global/basic-editor/QuillEditor"

Vue.use(VueTextAreaAutosize)

export default {
  name: "trackerItems-edit",

  components: {
    DeleteModal,
    ImageUploadModal,
    VueFormGenerator: VueFormGenerator.component,
    QuillEditor
  },

  data() {
    return {
      status: null,
      id: this.$route.params.id || "create",
      form: {
        id: '',
        title: '',
        description: '',
        confirmed: true,
        featured_image: '',
        user_id: '',
        state_id: '',
        local_government_id: '',
        errors: [],
        isSaving: false,
        hasSuccess: false
      },
      tracker: {},
      states: [],
      localGovernments: [],
      isReady: false,
      trans: JSON.parse(CurrentTenant.translations),
      formOptions: {
        validateAfterLoad: true,
        validateAfterChanged: true
      },
      breadcrumbLinks: [
        {
          title: JSON.parse(CurrentTenant.translations).app.trackers,
          url: '/admin/trackers',
        },
        {
          title: JSON.parse(CurrentTenant.translations).app.select_trackers,
          url: '/admin/trackerItems/select'
        },
        {
          title: JSON.parse(CurrentTenant.translations).app.tracker_item,
          url: '#'
        }
      ]
    };
  },

  computed: {
    schema() {
      return {
        fields: this.tracker.fields
      }
    }
  },

  beforeRouteEnter(to, from, next) {
    next(vm => {
      vm.request()
        .get("/api/v1/trackers/" + vm.$route.params.trackerId)
        .then(response => {
          vm.tracker = response.data

          vm.tracker.fields.forEach((field) => {
            vm.form[field.model] = field.default || ''
          });

          vm.fetchData()
          vm.loadStates()
        })
    })
  },

  watch: {
    "form.featured_image": function(val) {
      if (val && (this.id != 'create')) {
        this.saveTrackedItem()
      }
    },
    "form.state_id": function (val) {
      this.loadLocalGovernments(val)
    }
  },

  methods: {
    fetchData() {
      this.request()
        .get("/api/v1/trackerItems/" + this.$route.params.trackerId + "/" + this.id)
        .then(response => {
          this.status = response.data
          this.form.id = response.data.id

          if (this.id !== "create") {
            Object.assign(this.form, response.data.meta)
            this.form.user_id = response.data.user_id
            this.form.confirmed = response.data.confirmed
            this.form.featured_image = response.data.featured_image
            this.form.title = response.data.title
            this.form.description = response.data.description
            this.form.state_id = response.data.state_id
            this.form.local_government_id = response.data.local_government_id
          }

          this.isReady = true;

          NProgress.done();
        })
        .catch(error => {
          console.log(error)
        });
    },

    saveTrackedItem() {
      this.form.errors = [];
      this.form.isSaving = true;
      this.form.hasSuccess = false;

      let vErrors = this.validate(this.form);

      if (Object.keys(vErrors).length > 0) {
        this.form.errors = vErrors;
        this.form.isSaving = false;
        return false;
      }

      let meta = {}

      this.tracker.fields.forEach((field) => {
        meta[field.model] = this.form[field.model]
      });

      let formData = {
        id: this.form.id,
        tracker_id: this.$route.params.trackerId,
        title: this.form.title,
        description: this.form.description,
        confirmed: this.form.confirmed,
        featured_image: this.form.featured_image,
        meta,
        user_id: this.form.user_id,
        state_id: this.form.state_id,
        local_government_id: this.form.local_government_id
      }

      this.request()
        .post(`/api/v1/trackerItems/${this.$route.params.trackerId}/${this.id}`, formData)
        .then(response => {
          this.form.isSaving = false;
          this.form.hasSuccess = true;
          this.id = this.form.id = response.data.id;
          this.form.confirmed = response.data.confirmed
          this.status = response.data;
        })
        .catch(error => {
          this.form.isSaving = false;
          this.form.errors = error.response.data.errors
        });

      setTimeout(() => {
        this.form.hasSuccess = false;
        this.form.isSaving = false;
      }, 3000);
    },

    deleteTrackerItem() {
      this.request()
        .delete(`/api/v1/trackerItems/${this.$route.params.trackerId}/${this.id}`)
        .then(response => {
          $(this.$refs.deleteModal.$el).modal("hide");

          this.$router.push({ name: "trackerItems", params: { trackerItem: this.$route.params.trackerId } });
        })
        .catch(error => {
          // Add any error debugging...
        });
    },

    showDeleteModal() {
      $(this.$refs.deleteModal.$el).modal("show");
    },

    validate(form) {
      let errors = {}

      let formKeyArr = Object.keys(form)

      this.tracker.fields.forEach((field) => {
        if (!form[field.model] && field.required == 1) {
          errors[field.model] = [`${field.model} can not be empty`]
        }
      })

      return errors
    },

    showImageUploadModal() {
      $(this.$refs.uploadImageModal.$el).modal("show");
    },

    loadStates() {
      this.request()
        .get("/api/v1/states?all=1")
        .then(response => {
          this.states = response.data
          NProgress.done();
        })
        .catch(error => {
          NProgress.done();
        });
    },

    loadLocalGovernments(stateId = null) {
      this.request()
        .get("/api/v1/localGovernments?all=1", {
          params: {
            state: stateId
          }
        })
        .then(response => {
          this.localGovernments = response.data.data
          NProgress.done();
        })
        .catch(error => {
          NProgress.done();
        });
    }
  }
};
</script>
