<template>
  <admin-page>
    <template slot="status">
      <span v-if="form.isSaving">{{ trans.app.saving }}</span>
      <span v-if="form.hasSuccess">{{ trans.app.saved }}</span>
    </template>

    <template slot="action">
      <a
        href="#"
        v-permission="['update_trackers']"
        class="btn btn-sm btn-danger font-weight-bold my-auto"
        :class="{ disabled: form.name === '' }"
        @click="saveTracker"
        :aria-label="trans.app.save"
      >{{ trans.app.save }}</a>
    </template>

    <template slot="menu">
      <div class="dropdown" v-if="id !== 'create'">
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
            v-permission="['delete_trackers']"
            class="dropdown-item text-danger"
            @click="showDeleteModal"
          >{{ trans.app.delete }}</a>
        </div>
      </div>
    </template>
    <template slot="page-title">
      {{ trans.app.trackers }}
    </template>
    <template slot="breadcrumb">
      <breadcrumb :links="breadcrumbLinks" />
    </template>
    <template slot="main">
      <div class="col">
        <div class="form-group mb-5">
          <div class="col-lg-12">
            <input
              type="text"
              name="name"
              autofocus
              autocomplete="off"
              v-model="form.name"
              title="Name"
              @keyup.enter="saveTracker"
              class="form-control-lg form-control border-0 px-0 bg-transparent"
              :placeholder="trans.app.give_your_tracker_a_name"
            />

            <div v-if="form.errors.name" class="invalid-feedback d-block">
              <strong>{{ form.errors.name[0] }}</strong>
            </div>
          </div>

          <div class="col-lg-12">
            <label class="display-6">{{ trans.app.give_your_tracker_a_description }}</label>
            <ckeditor :editor="editor" v-model="form.description" :config="editorConfig"></ckeditor>
            <div v-if="form.errors.description" class="invalid-feedback d-block">
              <strong>{{ form.errors.description[0] }}</strong>
            </div>
          </div>

          <div class="col-lg-12">
            <select
              name="has_location"
              v-model="form.has_location"
              title="Has Location"
              @keyup.enter="saveTracker"
              class="form-control-lg form-control border-0 px-0 bg-transparent"
              :placeholder="trans.app.give_your_tracker_has_location"
            >
              <option value disabled>{{trans.app.give_your_tracker_has_location}}</option>
              <option 
                value="1"
              >{{ trans.app.true }}</option>
              <option 
                value="0"
              >{{ trans.app.false }}</option>
            </select>

            <div v-if="form.errors.has_location" class="invalid-feedback d-block">
              <strong>{{ form.errors.has_location[0] }}</strong>
            </div>
          </div>

          <div class="col-lg-12">
            <select
              name="has_user_reporting"
              v-model="form.has_user_reporting"
              title="Has User Reporting"
              @keyup.enter="saveTracker"
              class="form-control-lg form-control border-0 px-0 bg-transparent"
              :placeholder="trans.app.give_your_tracker_has_user_reporting"
            >
              <option value disabled>{{trans.app.give_your_tracker_has_user_reporting}}</option>
              <option 
                value="1"
              >{{ trans.app.true }}</option>
              <option 
                value="0"
              >{{ trans.app.false }}</option>
            </select>

            <div v-if="form.errors.has_user_reporting" class="invalid-feedback d-block">
              <strong>{{ form.errors.has_user_reporting[0] }}</strong>
            </div>
          </div>

          <div class="col-lg-12">
            <select
              name="has_bot"
              v-model="form.has_bot"
              title="Has Bot"
              @keyup.enter="saveTracker"
              class="form-control-lg form-control border-0 px-0 bg-transparent"
              :placeholder="trans.app.give_your_tracker_has_bot"
            >
              <option value disabled>{{trans.app.give_your_tracker_has_bot}}</option>
              <option 
                value="1"
              >{{ trans.app.true }}</option>
              <option 
                value="0"
              >{{ trans.app.false }}</option>
            </select>

            <div v-if="form.errors.has_bot" class="invalid-feedback d-block">
              <strong>{{ form.errors.has_bot[0] }}</strong>
            </div>
          </div>

          <div class="col-lg-12">
            <input
              type="text"
              name="bot_name"
              autofocus
              autocomplete="off"
              v-model="form.bot_name"
              title="Bot name"
              @keyup.enter="saveTracker"
              class="form-control-lg form-control border-0 px-0 bg-transparent"
              :placeholder="trans.app.give_your_tracker_bot_a_name"
            />

            <div v-if="form.errors.bot_name" class="invalid-feedback d-block">
              <strong>{{ form.errors.bot_name[0] }}</strong>
            </div>
          </div>

        </div>

        <div class="form-group">
          <h1>
            {{trans.app.fields}} 
            <button
              class="btn btn-info btn-sm"
              @click="showNewFieldModal"
            >
              {{ trans.app.add_field }}
            </button>
            <hr>
          </h1>
          <div class="row">
            <div class="col">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Type</th>
                    <th scope="col">Label</th>
                    <th scope="col">Model</th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(field, index) in form.fields" :key="index">
                    <th scope="row">{{ index + 1 }}</th>
                    <td>{{ field.type }}</td>
                    <td>{{ field.label }}</td>
                    <td>{{ field.model }}</td>
                    <td>
                      <button
                        class="btn btn-danger btn-sm"
                        @click="removeField(index)"
                      >
                        {{ trans.app.delete }}
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="col-lg-12">
            <div v-if="form.errors.fields" class="invalid-feedback d-block">
              <strong>{{ form.errors.fields[0] }}</strong>
            </div>
            <div v-if="form.errors.server" class="invalid-feedback d-block">
              <strong>{{ form.errors.server[0] }}</strong>
            </div>
          </div>
        </div>

        <div class="panel panel-default">
          <div class="panel-heading">Fields Schema</div>
          <div class="panel-body">
            <pre v-if="form" v-html="prettyJSON(form.fields)"></pre>
          </div>
        </div>
      </div>

      <delete-modal
        ref="deleteModal"
        @delete="deleteTracker"
        :header="trans.app.delete"
        :message="trans.app.deleted_tracker_are_gone_forever"
      ></delete-modal>

      <new-field-modal 
        v-if="isReady" ref="newFieldModal"
        @new-field="addField"
      />
    </template>
  </admin-page>
</template>

<script>
import $ from "jquery"
import NProgress from "nprogress"
import DeleteModal from "../../../components/global/modals/DeleteModal"
import NewFieldModal from "../../../components/global/modals/tracker/NewFieldModal"
import ClassicEditor from '@ckeditor/ckeditor5-build-classic'

export default {
  name: "trackers-edit",

  components: {
    DeleteModal,
    NewFieldModal,
  },

  data() {
    return {
      editor: ClassicEditor,
      editorConfig: {},
      status: null,
      id: this.$route.params.id || "create",
      form: {
        id: "",
        name: "",
        description: "",
        fields: [],
        has_location: "0",
        has_user_reporting: "0",
        has_bot: "0",
        bot_name: "",
        user_id: "",
        errors: [],
        isSaving: false,
        hasSuccess: false
      },
      isReady: false,
      trans: JSON.parse(CurrentTenant.translations),
      breadcrumbLinks: [
        {
          title: JSON.parse(CurrentTenant.translations).app.trackers,
          url: '/admin/trackers',
        }
      ]
    };
  },

  created() {
    
  },

  mounted() {
    this.fetchData();
  },

  watch: {
    
  },

  methods: {
    fetchData() {
      this.request()
        .get("/api/v1/trackers/" + this.id)
        .then(response => {
          this.status = response.data
          this.form.id = response.data.id

          if (this.id !== "create") {
            this.form.name = response.data.name
            this.form.description = response.data.description
            this.form.fields = response.data.fields
            this.form.has_location = response.data.has_location
            this.form.has_user_reporting = response.data.has_user_reporting
            this.form.has_bot = response.data.has_bot
            this.form.bot_name = response.data.bot_name
            this.form.user_id = response.data.user_id
          }

          this.isReady = true;

          NProgress.done();
        })
        .catch(error => {
          // this.$router.push({ name: "trackers" });
        });
    },

    saveTracker() {
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
        .post("/api/v1/trackers/" + this.id, this.form)
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

    deleteTracker() {
      this.request()
        .delete("/api/v1/trackers/" + this.id)
        .then(response => {
          $(this.$refs.deleteModal.$el).modal("hide");

          this.$router.push({ name: "trackers" });
        })
        .catch(error => {
          // Add any error debugging...
        });
    },

    showDeleteModal() {
      $(this.$refs.deleteModal.$el).modal("show");
    },

    showNewFieldModal() {
      $(this.$refs.newFieldModal.$el).modal("show");
    },

    addField(val) {
      this.form.fields.push(val)
    },

    removeField(index) {
      this.form.fields.splice(index, 1)
    },

    validate(form) {
      let errors = {}

      if (!form.name) {
        errors.name = ["name can not be empty"]
      }

      if (!form.fields) {
        errors.fields = ["fields can not be empty"]
      }

      if (form.fields.length <= 0) {
        errors.fields = ["add some fields please"]
      }

      if (form.has_location === "") {
        errors.has_location = ["please indicate if tracker has location"]
      }

      if (form.has_user_reporting === "") {
        errors.has_user_reporting = ["please indicate if tracker has user reporting"]
      }

      if (form.has_bot === "") {
        errors.has_bot = ["please indicate if tracker has bot"]
      }

      return errors;
    }
  }
};
</script>
