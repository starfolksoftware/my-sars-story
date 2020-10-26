<template>
  <admin-page>
    <template slot="status">
      <ul class="navbar-nav mr-auto flex-row float-right">
        <li class="text-muted font-weight-bold">
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
        @click="savePartner"
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
            class="dropdown-item"
            @click="showImageUploadModal"
          >{{ trans.app.upload_logo }}</a>
          <a
            href="#"
            class="dropdown-item text-danger"
            @click="showDeleteModal"
          >{{ trans.app.delete }}</a>
        </div>
      </div>
    </template>
    <template slot="page-title">
      {{ id == 'create' ? trans.app.new_partner : form.name }}
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
              @keyup.enter="savePartner"
              class="form-control-lg form-control border-0 px-0 bg-transparent"
              :placeholder="trans.app.give_your_partner_a_name"
            />

            <div v-if="form.errors.name" class="invalid-feedback d-block">
              <strong>{{ form.errors.name[0] }}</strong>
            </div>
          </div>

          <div class="col-lg-12">
            <input
              type="text"
              name="url"
              autofocus
              autocomplete="off"
              v-model="form.url"
              title="URL"
              @keyup.enter="savePartner"
              class="form-control-lg form-control border-0 px-0 bg-transparent"
              :placeholder="trans.app.give_your_partner_a_url"
            />

            <div v-if="form.errors.url" class="invalid-feedback d-block">
              <strong>{{ form.errors.url[0] }}</strong>
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
        @delete="deletePartner"
        :header="trans.app.delete"
        :message="trans.app.deleted_types_are_gone_forever"
      ></delete-modal>

      <image-upload-modal 
        v-if="isReady" ref="uploadImageModal"
        :defaultImageUrl="form.logo"
        :imageUrl="form.logo"
        @update:imageUrl="form.logo = $event"
      />
    </template>
  </admin-page>
</template>

<script>
import $ from "jquery";
import NProgress from "nprogress";
import DeleteModal from "../../../components/global/modals/DeleteModal";
import ImageUploadModal from "../../../components/global/modals/ImageUploadModal";
export default {
  name: "partners-edit",
  components: {
    DeleteModal,
    ImageUploadModal,
  },
  data() {
    return {
      status: null,
      id: this.$route.params.id || "create",
      form: {
        id: "",
        name: "",
        url: "",
        logo: "",
        errors: [],
        isSaving: false,
        hasSuccess: false
      },
      isReady: false,
      trans: JSON.parse(CurrentTenant.translations),
      roles: [],
      breadcrumbLinks: [
        {
          title: 'All Partners',
          url: '#',
        },
        {
          title: 'Partner',
          url: '#',
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
    'form.logo': function(val) {
      if (val) {
        this.savePartner()
      } else {
        this.form.logo = ""
        this.savePartner()
      }
    }
  },
  methods: {
    fetchData() {
      this.request()
        .get("/api/v1/partners/" + this.id)
        .then(response => {
          this.status = response.data;
          this.form.id = response.data.id;
          if (this.id !== "create") {
            this.form.name = response.data.name;
            this.form.url = response.data.url;
            this.form.logo = response.data.logo;
          }
          this.isReady = true;
          NProgress.done();
        })
        .catch(error => {
          this.$router.push({ name: "partners" });
        });
    },
    savePartner() {
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
        .post("/api/v1/partners/" + this.id, this.form)
        .then(response => {
          this.form.isSaving = false;
          this.form.hasSuccess = true;
          this.id = this.form.id = response.data.id;
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
    deletePartner() {
      this.request()
        .delete("/api/v1/partners/" + this.id)
        .then(response => {
          $(this.$refs.deleteModal.$el).modal("hide");
          this.$router.push({ name: "partners" });
        })
        .catch(error => {
          // Add any error debugging...
        });
    },
    showDeleteModal() {
      $(this.$refs.deleteModal.$el).modal("show");
    },
    showImageUploadModal() {
      $(this.$refs.uploadImageModal.$el).modal("show");
    },
    validate(form) {
      let errors = {};
      if (!form.name) {
        errors.name = ["name can not be empty"];
      }
      return errors;
    }
  }
};
</script>
