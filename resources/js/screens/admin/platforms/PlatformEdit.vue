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
        @click="savePlatform"
        :aria-label="trans.app.save"
      >{{ trans.app.save }}</a>
    </template>

    <template slot="menu">
      <!-- <div class="dropdown" v-if="id !== 'create'">
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
      </div> -->
    </template>
    <template slot="page-title">
      {{ id == 'create' ? trans.app.new_platform : platform.name }}
    </template>
    <template slot="breadcrumb">
      <breadcrumb :links="breadcrumbLinks" />
    </template>
    <template slot="main">
      <div class="col">
        <div class="row">
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
                  @keyup.enter="savePlatform"
                  class="form-control"
                  :placeholder="trans.app.give_your_platform_a_name"
                  disabled
                />

                <div v-if="form.errors.name" class="invalid-feedback d-block">
                  <strong>{{ form.errors.name[0] }}</strong>
                </div>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="form-group mb-5">
              <div class="col-lg-12">
                <input
                  type="text"
                  name="display_name"
                  autofocus
                  autocomplete="off"
                  v-model="form.display_name"
                  title="Name"
                  @keyup.enter="savePlatform"
                  class="form-control"
                  :placeholder="trans.app.give_your_platform_a_display_name"
                />

                <div v-if="form.errors.display_name" class="invalid-feedback d-block">
                  <strong>{{ form.errors.display_name[0] }}</strong>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- <div class="form-group mb-5">
          <div class="col-lg-12">
            <label class="text-muted">{{ trans.app.give_your_platform_a_description }}</label>
            <ckeditor :editor="editor" v-model="form.description" :config="editorConfig"></ckeditor>
            <div v-if="form.errors.description" class="invalid-feedback d-block">
              <strong>{{ form.errors.description[0] }}</strong>
            </div>
          </div>
        </div> -->
        <div class="form-group mb-5">
          <div class="col-lg-12">
            <textarea
              type="text"
              name="description"
              autofocus
              autocomplete="off"
              v-model="form.description"
              title="Description"
              @keyup.enter="savePlatform"
              class="form-control"
              :placeholder="trans.app.give_your_platform_a_description"
            ></textarea>

            <div v-if="form.errors.description" class="invalid-feedback d-block">
              <strong>{{ form.errors.description[0] }}</strong>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col">
            <div class="form-group mb-5">
              <div class="col-lg-12">
                <input
                  type="text"
                  name="tag_line"
                  autofocus
                  autocomplete="off"
                  v-model="form.tag_line"
                  title="Name"
                  @keyup.enter="savePlatform"
                  class="form-control"
                  :placeholder="trans.app.give_your_platform_a_tag_line"
                />

                <div v-if="form.errors.tag_line" class="invalid-feedback d-block">
                  <strong>{{ form.errors.tag_line[0] }}</strong>
                </div>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="form-group mb-5">
              <div class="col-lg-12">
                <input
                  type="text"
                  name="email"
                  autofocus
                  autocomplete="off"
                  v-model="form.email"
                  title="Name"
                  @keyup.enter="savePlatform"
                  class="form-control"
                  :placeholder="trans.app.give_your_platform_an_email"
                />

                <div v-if="form.errors.email" class="invalid-feedback d-block">
                  <strong>{{ form.errors.email[0] }}</strong>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group mb-5">
          <div class="col-lg-12">
            <textarea
              type="text"
              name="physical_address"
              autofocus
              autocomplete="off"
              v-model="form.physical_address"
              title="Name"
              @keyup.enter="savePlatform"
              class="form-control"
              :placeholder="trans.app.give_your_platform_a_physical_address"
            ></textarea>

            <div v-if="form.errors.physical_address" class="invalid-feedback d-block">
              <strong>{{ form.errors.physical_address[0] }}</strong>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <div class="form-group mb-5">
              <div class="col-lg-12">
                <input
                  type="text"
                  name="phone_number"
                  autofocus
                  autocomplete="off"
                  v-model="form.phone_number"
                  title="Name"
                  @keyup.enter="savePlatform"
                  class="form-control"
                  :placeholder="trans.app.give_your_platform_a_phone_number"
                />

                <div v-if="form.errors.phone_number" class="invalid-feedback d-block">
                  <strong>{{ form.errors.phone_number[0] }}</strong>
                </div>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="form-group mb-5">
              <div class="col-lg-12">
                <input
                  type="text"
                  name="twitter_url"
                  autofocus
                  autocomplete="off"
                  v-model="form.twitter_url"
                  title="Name"
                  @keyup.enter="savePlatform"
                  class="form-control"
                  :placeholder="trans.app.give_your_platform_a_twitter_url"
                />

                <div v-if="form.errors.twitter_url" class="invalid-feedback d-block">
                  <strong>{{ form.errors.twitter_url[0] }}</strong>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <div class="form-group mb-5">
              <div class="col-lg-12">
                <input
                  type="text"
                  name="facebook_url"
                  autofocus
                  autocomplete="off"
                  v-model="form.facebook_url"
                  title="Name"
                  @keyup.enter="savePlatform"
                  class="form-control"
                  :placeholder="trans.app.give_your_platform_a_facebook_url"
                />

                <div v-if="form.errors.facebook_url" class="invalid-feedback d-block">
                  <strong>{{ form.errors.facebook_url[0] }}</strong>
                </div>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="form-group mb-5">
              <div class="col-lg-12">
                <input
                  type="text"
                  name="instagram_url"
                  autofocus
                  autocomplete="off"
                  v-model="form.instagram_url"
                  title="Name"
                  @keyup.enter="savePlatform"
                  class="form-control"
                  :placeholder="trans.app.give_your_platform_a_instagram_url"
                />

                <div v-if="form.errors.instagram_url" class="invalid-feedback d-block">
                  <strong>{{ form.errors.instagram_url[0] }}</strong>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <div class="form-group mb-5">
              <div class="col-lg-12">
                <input
                  type="text"
                  name="linkedin_url"
                  autofocus
                  autocomplete="off"
                  v-model="form.linkedin_url"
                  title="Name"
                  @keyup.enter="savePlatform"
                  class="form-control"
                  :placeholder="trans.app.give_your_platform_a_linkedin_url"
                />

                <div v-if="form.errors.linkedin_url" class="invalid-feedback d-block">
                  <strong>{{ form.errors.linkedin_url[0] }}</strong>
                </div>
              </div>
            </div>
          </div>
          <div class="col">
            
          </div>
        </div>

        <div>
          <h3 class="title">{{ trans.app.terms + ' & ' + trans.app.privacy_policy }}</h3>
          <hr>
        </div>

        <div class="form-group mb-5">
          <div class="col-lg-12">
            <label for="">{{ trans.app.terms }}</label>
            <quill-editor :value.sync="form.terms"></quill-editor>

            <div v-if="form.errors.terms" class="invalid-feedback d-block">
              <strong>{{ form.errors.terms[0] }}</strong>
            </div>
          </div>
        </div>

        <div class="form-group mb-5">
          <div class="col-lg-12">
            <label for="">{{ trans.app.privacy_policy }}</label>
            <quill-editor :value.sync="form.privacy_policy"></quill-editor>

            <div v-if="form.errors.privacy_policy" class="invalid-feedback d-block">
              <strong>{{ form.errors.privacy_policy[0] }}</strong>
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
        @delete="deletePlatform"
        :header="trans.app.delete"
        :message="trans.app.deleted_platforms_are_gone_forever"
      ></delete-modal>
    </template>
  </admin-page>
</template>

<script>
import $ from "jquery"
import NProgress from "nprogress"
import DeleteModal from "../../../components/global/modals/DeleteModal"
// import ClassicEditor from '@ckeditor/ckeditor5-build-classic'
import QuillEditor from "../../../components/global/basic-editor/QuillEditor"

export default {
  name: "platforms-edit",

  components: {
    DeleteModal,
    QuillEditor,
  },

  data() {
    return {
      // editor: ClassicEditor,
      editorConfig: {},
      platform: {
        name: ''
      },
      id: this.$route.params.id || "create",
      form: {
        id: "",
        name: "",
        website_id: "",
        display_name: "",
        description: "",
        tag_line: "",
        physical_address: "",
        email: "",
        phone_number: "",
        terms: "",
        privacy_policy: "",
        twitter_url: "",
        facebook_url: "",
        instagram_url: "",
        linkedin_url: "",
        errors: [],
        isSaving: false,
        hasSuccess: false
      },
      isReady: false,
      trans: JSON.parse(CurrentTenant.translations),
      breadcrumbLinks: [
        {
          title: JSON.parse(CurrentTenant.translations).app.platforms,
          url: '#',
        },
        {
          title: JSON.parse(CurrentTenant.translations).app.platforms,
          url: '#',
        }
      ]
    }
  },

  beforeRouteEnter(to, from, next) {
    next(vm => {
      vm.fetchData()
    });
  },

  methods: {
    fetchData() {
      this.request()
        .get("/api/v1/platforms/" + this.id)
        .then(response => {
          this.platform = response.data
          this.form.id = response.data.id

          if (this.id !== "create") {
            this.form.name = response.data.name
            this.form.display_name = response.data.display_name
            this.form.description = response.data.description
            this.form.tag_line = response.data.tag_line
            this.form.physical_address = response.data.physical_address
            this.form.email = response.data.email
            this.form.phone_number = response.data.phone_number
            this.form.terms = response.data.terms
            this.form.privacy_policy = response.data.privacy_policy
            this.form.twitter_url = response.data.twitter_url
            this.form.facebook_url = response.data.facebook_url
            this.form.instagram_url = response.data.instagram_url
            this.form.linkedin_url = response.data.linkedin_url
          }

          this.isReady = true

          NProgress.done()
        })
        .catch(error => {
          // this.$router.push({ name: "platforms" })
        })
    },

    savePlatform() {
      this.form.errors = []
      this.form.isSaving = true
      this.form.hasSuccess = false

      let vErrors = this.validate(this.form)

      if (Object.keys(vErrors).length > 0) {
        this.form.errors = vErrors
        this.form.isSaving = false
        return false
      }

      this.request()
        .post("/api/v1/platforms/" + this.id, this.form)
        .then(response => {
          this.form.isSaving = false
          this.form.hasSuccess = true
          this.id = response.data.id
          this.platform = response.data
        })
        .catch(error => {
          this.form.isSaving = false
          this.form.errors = error.response.data.errors
        })

      setTimeout(() => {
        this.form.hasSuccess = false
        this.form.isSaving = false
      }, 3000)
    },

    deletePlatform() {
      this.request()
        .delete("/api/v1/platforms/" + this.id)
        .then(response => {
          $(this.$refs.deleteModal.$el).modal("hide")

          this.$router.push({ name: "platforms" })
        })
        .catch(error => {
          // Add any error debugging...
        })
    },

    showDeleteModal() {
      $(this.$refs.deleteModal.$el).modal("show")
    },

    validate(form) {
      let errors = {}

      if (!form.name) {
        errors.name = ["name can not be empty"]
      }

      return errors
    }
  }
}
</script>
