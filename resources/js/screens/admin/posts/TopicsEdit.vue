<template>
  <admin-page>
    <template slot="status">
      <span v-if="form.isSaving">{{ trans.app.saving }}</span>
      <span v-if="form.hasSuccess">{{ trans.app.saved }}</span>
    </template>

    <template slot="action">
      <a
        href="#"
        v-permission="['update_posts', 'update_own_posts']"
        class="btn btn-sm btn-danger font-weight-bold my-auto"
        :class="{ disabled: form.name === '' }"
        @click="saveTopic"
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
            v-permission="['delete_posts', 'delete_own_posts']"
            class="dropdown-item text-danger"
            @click="showDeleteModal"
          >{{ trans.app.delete }}</a>
        </div>
      </div>
    </template>
    <template slot="page-title">
      {{ id == 'create' ? trans.app.new_topic : topic.name }}
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
              @keyup.enter="saveTopic"
              class="form-control"
              :placeholder="trans.app.give_your_topic_a_name"
            />

            <div v-if="form.errors.name" class="invalid-feedback d-block">
              <strong>{{ form.errors.name[0] }}</strong>
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="col-lg-12">
            <p class="lead text-muted">
              <span
                v-if="!form.slug"
                class="text-success"
              >{{ trans.app.give_your_topic_a_name_slug }}</span>
              <span v-else class="text-success">{{ form.slug }}</span>
            </p>
            <div v-if="form.errors.slug" class="invalid-feedback d-block">
              <strong>{{ form.errors.slug[0] }}</strong>
            </div>
          </div>
        </div>
      </div>

      <delete-modal
        ref="deleteModal"
        @delete="deleteTopic"
        :header="trans.app.delete"
        :message="trans.app.deleted_topics_are_gone_forever"
      ></delete-modal>
    </template>
  </admin-page>
</template>

<script>
import $ from "jquery";
import NProgress from "nprogress";
import DeleteModal from "../../../components/global/modals/DeleteModal";

export default {
  name: "topics-edit",

  components: {
    DeleteModal
  },

  data() {
    return {
      topic: null,
      id: this.$route.params.id || "create",
      form: {
        id: "",
        name: "",
        slug: "",
        errors: [],
        isSaving: false,
        hasSuccess: false
      },
      isReady: false,
      trans: JSON.parse(CurrentTenant.translations),
      breadcrumbLinks: [
        {
          title: JSON.parse(CurrentTenant.translations).app.topics,
          url: '/admin/posts/topics',
        },
        {
          title: JSON.parse(CurrentTenant.translations).app.topic,
          url: '/admin/posts/topics/create',
        }
      ]
    };
  },

  mounted() {
    this.fetchData();
  },

  watch: {
    "form.name"(val) {
      this.form.slug = this.slugify(val);
    }
  },

  methods: {
    fetchData() {
      this.request()
        .get("/api/v1/topics/" + this.id)
        .then(response => {
          this.topic = response.data;
          this.form.id = response.data.id;

          if (this.id !== "create") {
            this.form.name = response.data.name;
            this.form.slug = response.data.slug;
          }

          this.isReady = true;

          NProgress.done();
        })
        .catch(error => {
          this.$router.push({ name: "topics" });
        });
    },

    saveTopic() {
      this.form.errors = [];
      this.form.isSaving = true;
      this.form.hasSuccess = false;

      this.request()
        .post("/api/v1/topics/" + this.id, this.form)
        .then(response => {
          this.form.isSaving = false;
          this.form.hasSuccess = true;
          this.id = response.data.id;
          this.topic = response.data;
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

    deleteTopic() {
      this.request()
        .delete("/api/v1/topics/" + this.id)
        .then(response => {
          $(this.$refs.deleteModal.$el).modal("hide");

          this.$router.push({ name: "topics" });
        })
        .catch(error => {
          // Add any error debugging...
        });
    },

    showDeleteModal() {
      $(this.$refs.deleteModal.$el).modal("show");
    }
  }
};
</script>
