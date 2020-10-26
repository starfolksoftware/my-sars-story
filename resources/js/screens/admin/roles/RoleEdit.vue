<template>
  <admin-page>
    <template slot="status">
      <span v-if="form.isSaving">{{ trans.app.saving }}</span>
      <span v-if="form.hasSuccess">{{ trans.app.saved }}</span>
    </template>

    <template slot="action">
      <a
        href="#"
        class="btn btn-sm btn-danger font-weight-bold my-auto"
        :class="{ disabled: form.name === '' }"
        @click="saveRole"
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
            class="dropdown-item text-danger"
            @click="showDeleteModal"
          >{{ trans.app.delete }}</a>
        </div>
      </div>
    </template>
    <template slot="page-title">
      {{ trans.app.roles }}
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
              @keyup.enter="saveRole"
              class="form-control"
              :placeholder="trans.app.give_your_role_a_name"
            />

            <div v-if="form.errors.name" class="invalid-feedback d-block">
              <strong>{{ form.errors.name[0] }}</strong>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="col-lg-12">
            <div v-if="form.errors.server" class="invalid-feedback d-block">
              <strong>{{ form.errors.server[0] }}</strong>
            </div>
          </div>
        </div>


        <div>
          <h1>{{ trans.app.permissions }}</h1>
        </div>
        <div class="p-5">
          <div class="row">
            <div 
              v-for="(permission, index) in permissions" 
              :key="index" 
              class="form-check form-check-inline"
            >
              <input 
                class="form-check-input" 
                type="checkbox" 
                :id="permission.id" :value="permission.name"
                v-model="form.permissions"
              >
              <label class="form-check-label" :for="permission.id">
                {{ permission.name.replace('_', ' ') }}
              </label>
            </div>
          </div>
        </div>
      </div>

      <delete-modal
        ref="deleteModal"
        @delete="deleteType"
        :header="trans.app.delete"
        :message="trans.app.deleted_roles_are_gone_forever"
      ></delete-modal>
    </template>
  </admin-page>
</template>

<script>
import $ from "jquery";
import NProgress from "nprogress";
import DeleteModal from "../../../components/global/modals/DeleteModal";

export default {
  name: "roles-edit",

  components: {
    DeleteModal
  },

  data() {
    return {
      status: null,
      id: this.$route.params.id || "create",
      form: {
        id: "",
        name: "",
        permissions: [],
        errors: [],
        isSaving: false,
        hasSuccess: false
      },
      isReady: false,
      trans: JSON.parse(CurrentTenant.translations),
      permissions: [],
      breadcrumbLinks: [
        {
          title: JSON.parse(CurrentTenant.translations).app.roles,
          url: '/admin/roles',
        },
        {
          title: JSON.parse(CurrentTenant.translations).app.role,
          url: '#'
        }
      ]
    };
  },

  created() {
    if (!this.isAdmin) {
      this.$router.push({ name: "stats" });
    }
  },

  mounted() {
    this.fetchData();
  },

  watch: {},

  methods: {
    fetchData() {
      this.request()
        .get("/api/v1/roles/" + this.id)
        .then(response => {
          this.status = response.data.role
          this.form.id = response.data.role.id
          this.permissions = response.data.permissions

          if (this.id !== "create") {
            this.form.name = response.data.role.name
            this.form.permissions = response.data.role.permissions.map((permission) => {
              return permission.name
            })
          }

          this.isReady = true;

          NProgress.done();
        })
        .catch(error => {
          // this.$router.push({ name: "roles" });
        });
    },

    saveRole() {
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
        .post("/api/v1/roles/" + this.id, this.form)
        .then(response => {
          this.form.isSaving = false;
          this.form.hasSuccess = true;
          this.id = response.data.id;
          this.status = response.data;
        })
        .catch(error => {
          this.form.isSaving = false;
          this.form.errors = error.response.data.errors;
        });

      setTimeout(() => {
        this.form.hasSuccess = false;
        this.form.isSaving = false;
      }, 3000);
    },

    deleteType() {
      this.request()
        .delete("/api/v1/roles/" + this.id)
        .then(response => {
          $(this.$refs.deleteModal.$el).modal("hide");

          this.$router.push({ name: "roles" });
        })
        .catch(error => {
          // Add any error debugging...
        });
    },

    showDeleteModal() {
      $(this.$refs.deleteModal.$el).modal("show");
    },

    validate(form) {
      let errors = {};

      if (!form.name) {
        errors.name = ["name can not be empty"];
      }

      if (!Array.isArray(form.permissions)) {
        errors.permissions = ["permissions must be array"];
      }

      return errors;
    }
  }
};
</script>
