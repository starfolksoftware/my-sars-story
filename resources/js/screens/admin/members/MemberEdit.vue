<template>
  <admin-page>
    <template slot="status">
      <ul class="navbar-nav mr-auto flex-row float-right">
        <li class="text-muted font-weight-bold">
          <span v-if="form.isSaving">{{ trans.app.saving }}</span>
          <span v-if="form.hasSuccess" class="text-success">{{ trans.app.saved }}</span>
        </li>
      </ul>
    </template>

    <template slot="action">
      <a
        href="#"
        class="btn btn-sm btn-outline-success font-weight-bold my-auto"
        :class="{ disabled: form.name === '' }"
        @click="saveMember"
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
          >{{ trans.app.upload_thumbnail }}</a>
          <a
            href="#"
            class="dropdown-item text-danger"
            @click="showDeleteModal"
          >{{ trans.app.delete }}</a>
        </div>
      </div>
    </template>
    <template slot="page-title">
      {{ id == 'create' ? trans.app.new_member : form.name }}
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
              @keyup.enter="saveMember"
              class="form-control-lg form-control border-0 px-0 bg-transparent"
              :placeholder="trans.app.give_your_member_a_name"
            />

            <div v-if="form.errors.name" class="invalid-feedback d-block">
              <strong>{{ form.errors.name[0] }}</strong>
            </div>
          </div>

          <div class="col-lg-12">
            <label for="">{{ trans.app.bio }}</label>
            <ckeditor :editor="editor" v-model="form.bio" :config="editorConfig"></ckeditor>
            <div v-if="form.errors.bio" class="invalid-feedback d-block">
              <strong>{{ form.errors.bio[0] }}</strong>
            </div>
          </div>

          <div class="col-lg-12">
            <select
              name="role"
              v-model="form.designations"
              title="Role"
              @keyup.enter="saveMember"
              multiple
              class="form-control-lg form-control border-0 px-0 bg-transparent"
              :placeholder="trans.app.give_your_member_designations"
            >
              <option value disabled>{{trans.app.give_your_member_designations}}</option>
              <option 
                v-for="(designation, index) in designations" 
                :value="designation.id"
                :key="index"
              >{{designation.title}}</option>
            </select>

            <div v-if="form.errors.designation" class="invalid-feedback d-block">
              <strong>{{ form.errors.designation[0] }}</strong>
            </div>
          </div>

          <div class="col-lg-12">
            <input
              type="email"
              name="email"
              autofocus
              autocomplete="off"
              v-model="form.email"
              title="Email"
              @keyup.enter="saveMember"
              class="form-control-lg form-control border-0 px-0 bg-transparent"
              :placeholder="trans.app.give_your_member_an_email"
            />

            <div v-if="form.errors.email" class="invalid-feedback d-block">
              <strong>{{ form.errors.email[0] }}</strong>
            </div>
          </div>

          <div class="col-lg-12">
            <input
              type="phone_number"
              name="phone_number"
              autofocus
              autocomplete="off"
              v-model="form.phone_number"
              title="Email"
              @keyup.enter="saveMember"
              class="form-control-lg form-control border-0 px-0 bg-transparent"
              :placeholder="trans.app.give_your_member_a_phone_number"
            />

            <div v-if="form.errors.phone_number" class="invalid-feedback d-block">
              <strong>{{ form.errors.phone_number[0] }}</strong>
            </div>
          </div>

          <div class="col-lg-12">
            <input
              type="twitter_url"
              name="twitter_url"
              autofocus
              autocomplete="off"
              v-model="form.socials_meta.twitter_url"
              title="Email"
              @keyup.enter="saveMember"
              class="form-control-lg form-control border-0 px-0 bg-transparent"
              :placeholder="trans.app.give_your_member_a_twitter_url"
            />

            <div v-if="form.errors.twitter_url" class="invalid-feedback d-block">
              <strong>{{ form.errors.twitter_url[0] }}</strong>
            </div>
          </div>

          <div class="col-lg-12">
            <input
              type="instagram_url"
              name="instagram_url"
              autofocus
              autocomplete="off"
              v-model="form.socials_meta.instagram_url"
              title="Email"
              @keyup.enter="saveMember"
              class="form-control-lg form-control border-0 px-0 bg-transparent"
              :placeholder="trans.app.give_your_member_a_instagram_url"
            />

            <div v-if="form.errors.instagram_url" class="invalid-feedback d-block">
              <strong>{{ form.errors.instagram_url[0] }}</strong>
            </div>
          </div>

          <div class="col-lg-12">
            <input
              type="facebook_url"
              name="facebook_url"
              autofocus
              autocomplete="off"
              v-model="form.socials_meta.facebook_url"
              title="Email"
              @keyup.enter="saveMember"
              class="form-control-lg form-control border-0 px-0 bg-transparent"
              :placeholder="trans.app.give_your_member_a_facebook_url"
            />

            <div v-if="form.errors.facebook_url" class="invalid-feedback d-block">
              <strong>{{ form.errors.facebook_url[0] }}</strong>
            </div>
          </div>

          <div class="col-lg-12">
            <input
              type="linkedin_url"
              name="linkedin_url"
              autofocus
              autocomplete="off"
              v-model="form.socials_meta.linkedin_url"
              title="Email"
              @keyup.enter="saveMember"
              class="form-control-lg form-control border-0 px-0 bg-transparent"
              :placeholder="trans.app.give_your_member_a_linkedin_url"
            />

            <div v-if="form.errors.linkedin_url" class="invalid-feedback d-block">
              <strong>{{ form.errors.linkedin_url[0] }}</strong>
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
        @delete="deleteMember"
        :header="trans.app.delete"
        :message="trans.app.deleted_types_are_gone_forever"
      ></delete-modal>

      <image-upload-modal 
        v-if="isReady" ref="uploadImageModal"
        :defaultImageUrl="form.avatar"
        :imageUrl="form.avatar"
        @update:imageUrl="form.avatar = $event"
      />
    </template>
  </admin-page>
</template>

<script>
import $ from "jquery";
import NProgress from "nprogress";
import DeleteModal from "../../../components/global/modals/DeleteModal";
import ImageUploadModal from "../../../components/global/modals/ImageUploadModal";
import ClassicEditor from '@ckeditor/ckeditor5-build-classic'
export default {
  name: "members-edit",
  components: {
    DeleteModal,
    ImageUploadModal,
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
        bio: "",
        email: "",
        phone_number: "",
        socials_meta: {
          twitter_url: "",
          instagram_url: "",
          facebook_url: "",
          linkedin_url: "",
        },
        avatar: "",
        designations: [],
        errors: [],
        isSaving: false,
        hasSuccess: false
      },
      designations: [],
      isReady: false,
      trans: JSON.parse(CurrentTenant.translations),
      roles: [],
      breadcrumbLinks: [
        {
          title: 'All Members',
          url: '#',
        },
        {
          title: 'Member',
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
    'form.avatar': function(val) {
      if (val) {
        this.saveMember()
      } else {
        this.form.avatar = ""
        this.saveMember()
      }
    }
  },
  methods: {
    fetchData() {
      this.request()
        .get("/api/v1/members/" + this.id)
        .then(response => {
          this.status = response.data
          this.form.id = response.data.member.id
          if (this.id !== "create") {
            this.form.name = response.data.member.name
            this.form.bio = response.data.member.bio
            this.form.email = response.data.member.email
            this.form.phone_number = response.data.member.phone_number
            if (response.data.member.socials_meta) {
              this.form.socials_meta.twitter_url = response.data.member.socials_meta.twitter_url || ''
              this.form.socials_meta.instagram_url = response.data.member.socials_meta.instagram_url || ''
              this.form.socials_meta.linkedin_url = response.data.member.socials_meta.linkedin_url || ''
              this.form.socials_meta.facebook_url = response.data.member.socials_meta.facebook_url || ''
            } else {
              this.form.socials_meta = {
                twitter_url: "",
                instagram_url: "",
                facebook_url: "",
                linkedin_url: "",
              }
            }
            this.form.avatar = response.data.member.avatar
            this.form.designations = response.data.member.designations.map((designation) => {
              return designation.id
            })
          }
          this.designations = response.data.designations
          this.isReady = true;
          NProgress.done();
        })
        .catch(error => {
          // this.$router.push({ name: "designations" });
        });
    },
    saveMember() {
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
        .post("/api/v1/members/" + this.id, this.form)
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
    deleteMember() {
      this.request()
        .delete("/api/v1/members/" + this.id)
        .then(response => {
          $(this.$refs.deleteModal.$el).modal("hide");
          this.$router.push({ name: "members" });
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
