<template>
  <admin-page>
    <template slot="status">
      <span v-if="form.isSaving">{{ trans.app.saving }}</span>
      <span v-if="form.hasSuccess">{{ trans.app.saved }}</span>
    </template>

    <template slot="action">
      <a
        href="#"
        v-permission="['update_users', 'update_own_users']"
        class="btn btn-sm btn-danger font-weight-bold my-auto"
        :class="{ disabled: form.name === '' }"
        @click="saveUser"
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
          <!-- <router-link
            :to="{ name: 'users-create' }"
            class="dropdown-item"
          >{{ trans.app.new_user }}</router-link> -->
          <a
            href="#"
            v-permission="['delete_users', 'delete_own_users']"
            class="dropdown-item text-danger"
            @click="showDeleteModal"
          >{{ trans.app.delete }}</a>
        </div>
      </div>
    </template>
    <template slot="page-title">
      {{ trans.app.users }}
    </template>
    <template slot="breadcrumb">
      <breadcrumb :links="breadcrumbLinks" />
    </template>
    <template slot="main">
      <div class="col">
        <div class="row">
          <div class="col">
            <div class="form-group">
              <div class="col-lg-12">
                <input
                  type="text"
                  name="name"
                  autofocus
                  autocomplete="off"
                  v-model="form.name"
                  title="Name"
                  @keyup.enter="saveUser"
                  class="form-control"
                  :placeholder="trans.app.give_your_user_a_name"
                />

                <div v-if="form.errors.name" class="invalid-feedback d-block">
                  <strong>{{ form.errors.name[0] }}</strong>
                </div>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="form-group">
              <div class="col-lg-12">
                <input
                  type="text"
                  name="email"
                  autofocus
                  autocomplete="off"
                  v-model="form.email"
                  title="Email"
                  @keyup.enter="saveUser"
                  class="form-control"
                  :placeholder="trans.app.give_your_user_an_email"
                  :disabled="id !== 'create'"
                />

                <div v-if="form.errors.email" class="invalid-feedback d-block">
                  <strong>{{ form.errors.email[0] }}</strong>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-12">
          <select
            name="role"
            v-model="form.role"
            title="Role"
            @keyup.enter="saveUser"
            multiple
            class="form-control mb-4"
            :placeholder="trans.app.give_your_user_a_role"
          >
            <option value disabled>Select role</option>
            <option 
              v-for="(role, index) in roles" 
              :value="role"
              :key="index"
            >{{role}}</option>
          </select>

          <div v-if="form.errors.role" class="invalid-feedback d-block">
            <strong>{{ form.errors.roles[0] }}</strong>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <div class="form-group">
              <div class="col-lg-12">
                <input
                  type="text"
                  name="password"
                  autofocus
                  autocomplete="off"
                  v-model="form.password"
                  title="Email"
                  @keyup.enter="saveUser"
                  class="form-control"
                  :placeholder="id === 'create' ? trans.app.give_your_user_an_password : trans.app.change_user_password"
                />

                <div v-if="form.errors.password" class="invalid-feedback d-block">
                  <strong>{{ form.errors.password[0] }}</strong>
                </div>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="form-group">
              <div class="col-lg-12">
                <input
                  type="text"
                  name="password_confirmation"
                  autofocus
                  autocomplete="off"
                  v-model="form.password_confirmation"
                  title="Email"
                  @keyup.enter="saveUser"
                  class="form-control"
                  :placeholder="trans.app.give_your_user_an_password_confirmation"
                />

                <div v-if="form.errors.password_confirmation" class="invalid-feedback d-block">
                  <strong>{{ form.errors.password_confirmation[0] }}</strong>
                </div>
              </div>
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
      </div>

      <delete-modal
        ref="deleteModal"
        @delete="deleteUser"
        :header="trans.app.delete"
        :message="trans.app.deleted_users_are_gone_forever"
      ></delete-modal>
    </template>
  </admin-page>
</template>

<script>
import $ from "jquery";
import NProgress from "nprogress";
import DeleteModal from "../../../components/global/modals/DeleteModal";

export default {
  name: "users-edit",

  components: {
    DeleteModal
  },

  data() {
    return {
      user: null,
      id: this.$route.params.id || "create",
      form: {
        id: "",
        name: "",
        email: "",
        role: [],
        password: "",
        password_confirmation: "",
        errors: [],
        isSaving: false,
        hasSuccess: false
      },
      isReady: false,
      trans: JSON.parse(CurrentTenant.translations),
      roles: [],
      breadcrumbLinks: [
        {
          title: 'All Users',
          url: '/admin/users',
        },
        {
          title: 'User',
          url: '#',
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
        .get("/api/v1/users/" + this.id)
        .then(response => {
          this.user = response.data;
          this.form.id = response.data.id;

          if (this.id !== "create") {
            this.form.name = response.data.name;
            this.form.email = response.data.email;
            this.form.role = response.data.roles;
          }

          this.isReady = true;

          NProgress.done();
        })
        .catch(error => {
          this.$router.push({ name: "users" });
        });

      this.request()
        .get("/api/v1/roles?all=1")
        .then(response => {
          this.roles = response.data;
          NProgress.done();
        })
        .catch(() => {
          NProgress.done();
        })
    },

    saveUser() {
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
        .post("/api/v1/users/" + this.id, this.form)
        .then(response => {
          this.form.isSaving = false;
          this.form.hasSuccess = true;
          this.id = response.data.id;
          this.user = response.data;
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

    deleteUser() {
      this.request()
        .delete("/api/v1/users/" + this.id)
        .then(response => {
          $(this.$refs.deleteModal.$el).modal("hide");

          this.$router.push({ name: "users" });
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

      if (!form.email) {
        errors.email = ["email can not be empty"];
      }

      if (!form.password && this.id === "create") {
        errors.password = ["password can not be empty"];
      }

      if (!form.password_confirmation && this.id === "create") {
        errors.password_confirmation = [
          "password confirmation can not be empty"
        ];
      }

      if (form.password !== form.password_confirmation) {
        if (Array.isArray(errors.password_confirmation)) {
          errors.password_confirmation.push("passwords do not match");
        } else {
          errors.password_confirmation = ["passwords do not match"];
        }
      }

      return errors;
    }
  }
};
</script>
