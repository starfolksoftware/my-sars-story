<template>
  <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div
          class="modal-header d-flex align-items-center justify-content-between border-0"
        >
          <h4 class="modal-title">{{ trans.app.report }}</h4>

          <button
            type="button"
            class="close"
            data-dismiss="modal"
            aria-label="Close"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 24 24"
              width="24"
              class="icon-close-circle"
            >
              <circle cx="12" cy="12" r="10" class="primary" />
              <path
                class="fill-bg"
                d="M13.41 12l2.83 2.83a1 1 0 0 1-1.41 1.41L12 13.41l-2.83 2.83a1 1 0 1 1-1.41-1.41L10.59 12 7.76 9.17a1 1 0 0 1 1.41-1.41L12 10.59l2.83-2.83a1 1 0 0 1 1.41 1.41L13.41 12z"
              />
            </svg>
          </button>
        </div>
        <div class="modal-body">
          <div class="col mx-auto">
            <h1>
              {{ trans.app.location }}
              <hr />
            </h1>
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
                    v-for="(state, index) in states"
                    :key="index"
                  >
                    {{ state.name }}
                  </option>
                </select>

                <div
                  v-if="form.errors.state_id"
                  class="invalid-feedback d-block"
                >
                  <strong>{{ form.errors.state_id }}</strong>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-lg-12">
                <select
                  name="local_government_id"
                  id="local_government_id"
                  v-model="form.local_government_id"
                  class="form-control"
                >
                  <option value="" disabled>
                    {{ trans.app.local_governments }}
                  </option>
                  <option
                    :value="localGovernment.id"
                    v-for="(localGovernment, index) in localGovernments"
                    :key="index"
                  >
                    {{ localGovernment.name }}
                  </option>
                </select>

                <div
                  v-if="form.errors.local_government_id"
                  class="invalid-feedback d-block"
                >
                  <strong>{{ form.errors.local_government_id }}</strong>
                </div>
              </div>
            </div>
            <h1>
              {{ trans.app.contact_information }}
              <hr />
            </h1>
            <div class="form-group">
              <div class="col-lg-12">
                <input type="text"
                  name="email"
                  autofocus
                  autocomplete="off"
                  v-model="form.email"
                  title="Email"
                  class="form-control"
                  :placeholder="trans.app.email" />

                <div
                  v-if="form.errors.email"
                  class="invalid-feedback d-block"
                >
                  <strong>{{ form.errors.email }}</strong>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-lg-12">
                <input type="text"
                  name="phone_number"
                  autofocus
                  autocomplete="off"
                  v-model="form.phone_number"
                  title="Phone Number"
                  class="form-control"
                  :placeholder="trans.app.phone_number" />

                <div
                  v-if="form.errors.phone_number"
                  class="invalid-feedback d-block"
                >
                  <strong>{{ form.errors.phone_number }}</strong>
                </div>
              </div>
            </div>
            <FormulateForm
              @submit="saveTrackedItem"
              v-model="form"
              :schema="tracker.fields"
            />
          </div>
        </div>
        <!-- <div class="modal-footer">
          <button
            type="button"
            class="btn btn-link btn-block font-weight-bold text-muted text-decoration-none"
            data-dismiss="modal"
          >
            {{ trans.app.done }}
          </button>
        </div> -->
      </div>
    </div>
  </div>
</template>

<script>
import Vue from "vue";
import NProgress from "nprogress";

const VueFormulate = require("@braid/vue-formulate");
Vue.use(VueFormulate.default, {
  classes: {
    outer: "mb-4",
    input(context) {
      switch (context.classification) {
        case "button":
          return "btn btn-primary";
        case "box":
          return "";
        default:
          return "form-control";
      }
    },
    label: "form-label text-primary",
    help: "help helper helpText",
    error: "invalid-feedback d-block",
  },
});

export default {
  name: "report-modal",

  props: {
    tracker: {
      type: Object,
      required: true,
    },
  },

  data() {
    return {
      status: null,
      id: "create",
      form: {
        id: "",
        title: "A Report",
        description: "Description",
        confirmed: false,
        email: "",
        phone_number: "",
        featured_image: "",
        user_id: "",
        state_id: "",
        local_government_id: "",
        errors: [],
        isSaving: false,
        hasSuccess: false,
      },
      states: [],
      localGovernments: [],
      isReady: false,
      trans: JSON.parse(CurrentTenant.translations),
    };
  },

  watch: {
    "form.state_id": function (val) {
      this.loadLocalGovernments(val);
    }
  },

  mounted() {
    this.fetchData();
    this.loadStates();
  },

  methods: {
    fetchData() {
      this.request()
        .get("/api/v1/trackerItems/" + this.tracker.id + "/" + this.id)
        .then((response) => {
          this.status = response.data;
          this.form.id = response.data.id;

          if (this.id !== "create") {
            Object.assign(this.form, response.data.meta);
            this.form.user_id = response.data.user_id;
          }

          this.isReady = true;

          NProgress.done();
        })
        .catch((error) => {
          console.log(error);
        });
    },

    saveTrackedItem() {
      if (this.form.isSaving) {
        return false
      }
      
      this.form.errors = [];
      this.form.isSaving = true;
      this.form.hasSuccess = false;

      let vErrors = this.validate(this.form);

      if (Object.keys(vErrors).length > 0) {
        this.form.errors = vErrors;
        this.form.isSaving = false;
        return false;
      }

      let meta = {};

      this.tracker.fields.forEach((field) => {
        meta[field.name] = this.form[field.name];
      });

      let formData = {
        id: this.form.id,
        tracker_id: this.tracker.id,
        title: this.form.description,
        description: this.form.description,
        confirmed: this.form.confirmed,
        email: this.form.email,
        phone_number: this.form.phone_number,
        featured_image: this.form.featured_image,
        meta,
        user_id: this.form.user_id,
        state_id: this.form.state_id,
        local_government_id: this.form.local_government_id,
      };

      this.request()
        .post(`/api/v1/trackerItems/${this.tracker.id}/${this.id}`, formData)
        .then((response) => {
          this.form.isSaving = false;
          this.form.hasSuccess = true;
          this.id = this.form.id = response.data.id;
          this.status = response.data;

          NProgress.done();

          this.hideModal();

          this.clearForm();
        })
        .catch((error) => {
          this.form.isSaving = false;
          console.log(error);
        });

      setTimeout(() => {
        this.form.hasSuccess = false;
        this.form.isSaving = false;
      }, 3000);
    },

    clearForm() {
      this.status = null;
      this.id = "create";
      this.form = {
        id: "",
        user_id: "",
        errors: [],
        isSaving: false,
        hasSuccess: false,
      };

      this.tracker.fields.forEach((field) => {
        this.form[field.model] = field.default || "";
      });
    },

    validate(form) {
      let errors = {};

      this.tracker.fields.forEach((field) => {
        if (!form[field.model] && field.required == 1) {
          errors[field.model] = [`${field.model} can not be empty`];
        }
      });

      if (this.tracker.has_location === "1") {
        if (!form.state_id) {
          errors["state_id"] = "state can not be empty";
        }

        if (!form.local_government_id) {
          errors["local_government_id"] = "local government can not be empty";
        }
      }

      if (form.is_anonymous) {
        return errors
      }

      if (!form.email) {
        errors["email"] = "email can not be empty"
      }

      if (!form.phone_number) {
        errors["phone_number"] = "phone number can not be empty"
      }

      return errors
    },

    loadStates() {
      this.request()
        .get("/api/v1/states?all=1")
        .then((response) => {
          this.states = response.data;
          NProgress.done();
        })
        .catch((error) => {
          NProgress.done();
        });
    },

    loadLocalGovernments(stateId = null) {
      this.request()
        .get("/api/v1/localGovernments?all=1", {
          params: {
            state: stateId,
          },
        })
        .then((response) => {
          this.localGovernments = response.data.data;
          NProgress.done();
        })
        .catch((error) => {
          NProgress.done();
        });
    },

    hideModal() {
      $(this.$parent.$refs.reportModal.$el).modal("hide");
    },
  },
};
</script>
