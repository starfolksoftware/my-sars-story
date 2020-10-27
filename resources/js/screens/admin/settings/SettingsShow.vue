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
    <template slot="page-title">
      {{ trans.app.settings }}
    </template>
    <template slot="breadcrumb">
      <breadcrumb :links="breadcrumbLinks" />
    </template>
    <template slot="main">
      <div class="col">
        <div class="d-flex justify-content-between">
          <h1>{{ trans.app.your_profile }}</h1>
        </div>

          <div class="mt-2 card shadow border-0" v-if="isReady">
            <div class="card-body p-0">
              <div class="d-flex p-3 align-items-center">
                <div class="mr-auto py-1">
                  <p class="mb-1 font-weight-bold text-lg lead">{{ trans.app.your_profile }}</p>
                  <p class="mb-1 d-none d-lg-block">{{ trans.app.choose_a_unique_username }}</p>
                </div>
                <div class="ml-auto pl-3">
                  <div class="align-middle">
                    <button
                      class="btn btn-sm btn-outline-primary font-weight-bold"
                      @click="showProfileModal"
                    >{{ trans.app.edit_profile }}</button>
                  </div>
                </div>
              </div>

              <!-- <div class="d-flex border-top p-3 align-items-center">
                <div class="mr-auto py-1">
                  <p class="mb-1 font-weight-bold text-lg lead">{{ trans.app.weekly_digest }}</p>
                  <p class="mb-1 d-none d-lg-block">{{ trans.app.toggle_digest }}</p>
                </div>
                <div class="ml-auto pl-3">
                  <div class="align-middle">
                    <div class="form-group my-auto">
                      <span class="switch switch-sm">
                        <input
                          type="checkbox"
                          class="switch"
                          id="digest"
                          @change="toggleDigest"
                          :checked="form.digest"
                          v-model="form.digest"
                        />
                        <label for="digest" class="mb-0 sr-only">{{ trans.app.weekly_digest }}</label>
                      </span>
                    </div>
                  </div>
                </div>
              </div> -->

              <!-- <div class="d-flex border-top p-3 align-items-center">
                <div class="mr-auto py-1">
                  <p class="mb-1 font-weight-bold text-lg lead">{{ trans.app.dark_mode }}</p>
                  <p class="mb-1 d-none d-lg-block">{{ trans.app.toggle_dark_mode }}</p>
                </div>
                <div class="ml-auto pl-3">
                  <div class="align-middle">
                    <div class="form-group my-auto">
                      <span class="switch switch-sm">
                        <input
                          type="checkbox"
                          class="switch"
                          id="darkMode"
                          @change="toggleDarkMode"
                          :checked="form.darkMode"
                          v-model="form.darkMode"
                        />
                        <label for="darkMode" class="mb-0 sr-only">{{ trans.app.dark_mode }}</label>
                      </span>
                    </div>
                  </div>
                </div>
              </div> -->

              <div class="d-flex border-top p-3 align-items-center">
                <div class="mr-auto py-1">
                  <p class="mb-1 font-weight-bold text-lg lead">{{ trans.app.locale }}</p>
                  <p class="mb-1 d-none d-lg-block">{{ trans.app.select_your_language_or_region }}</p>
                </div>
                <div class="ml-auto pl-3">
                  <div class="align-middle">
                    <div class="form-group row mt-3">
                      <div class="col-12">
                        <select
                          :class="!CurrentTenant.darkMode ? 'bg-light': 'bg-darker'"
                          class="custom-select border-0"
                          @change="updateLocale"
                          v-model="form.locale"
                          name="locale"
                        >
                          <option
                            v-for="(locale, code) in CurrentTenant.languageCodes"
                            :key="code"
                            :value="code"
                            :selected="CurrentTenant.locale === code"
                          >{{ locale }}</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      <profile-modal v-if="isReady" ref="profileModal" :form="form" />
    </template>
  </admin-page>
</template>

<script>
import $ from "jquery";
import NProgress from "nprogress";
import ProfileModal from "../../../components/global/modals/ProfileModal";

export default {
  name: "settings-show",

  components: {
    ProfileModal
  },

  metaInfo() {
    let metaTitle = this.metaTitle;
    let metaSiteName = this.metaSiteName;
    return {
      // Children can override the title.
      title: metaTitle + " - " + metaSiteName,
      // Result: My Page Title ← My Site
      // If a child changes the title to "My Other Page Title",
      // it will become: My Other Page Title ← My Site
      titleTemplate: "%s",
      // Define meta tags here.
      meta: [
        {
          vid: "http-equiv",
          "http-equiv": "Content-Type",
          content: "text/html; charset=utf-8"
        },
        {
          vid: "viewport",
          name: "viewport",
          content: "width=device-width, initial-scale=1"
        },
        {
          vid: "description",
          name: "description",
          content: this.metaDescription
        },
        // OpenGraph data (Most widely used)
        { vid: "og:title", property: "og:title", content: this.metaTitle },
        {
          vid: "og:site_name",
          property: "og:site_name",
          content: this.metaSiteName
        },
        // The list of types is available here: http://ogp.me/#types
        { vid: "og:type", property: "og:type", content: "website" },
        // Should the the same as your canonical link, see below.
        { vid: "og:url", property: "og:url", content: this.metaUrl },
        { vid: "og:image", property: "og:image", content: this.metaImageUrl },
        // Often the same as your meta description, but not always.
        {
          vid: "og:description",
          property: "og:description",
          content: this.metaDescription
        },

        // Twitter card
        {
          vid: "twitter:card",
          name: "twitter:card",
          content: this.metaDescription
        },
        { vid: "twitter:site", name: "twitter:site", content: this.metaUrl },
        {
          vid: "twitter:title",
          name: "twitter:title",
          content: this.metaTitle
        },
        {
          vid: "twitter:description",
          name: "twitter:description",
          content: this.metaDescription
        },
        // Your twitter handle, if you have one.
        {
          vid: "twitter:creator",
          name: "twitter:creator",
          content: "@starfolksoftware"
        },
        {
          vid: "twitter:image:src",
          name: "twitter:image:src",
          content: this.metaImageUrl
        },

        // Google / Schema.org markup:
        { vid: "ipname", itemprop: "name", content: this.metaSiteName },
        {
          vid: "ipdescription",
          itemprop: "description",
          content: this.metaDescription
        },
        { vid: "ipimage", itemprop: "image", content: this.metaImageUrl }
      ],
      link: [
        { vid: "canonical", rel: "canonical", href: this.metaCanonicalLink }
      ]
    };
  },

  data() {
    return {
      form: {
        username: null,
        summary: null,
        avatar: null,
        locale: CurrentTenant.locale,
        digest: false,
        darkMode: 0,
        errors: [],
        isSaving: false,
        hasSuccess: false
      },
      user: CurrentTenant.user,
      isReady: false,
      trans: JSON.parse(CurrentTenant.translations),
      breadcrumbLinks: [
        {
          title: JSON.parse(CurrentTenant.translations).app.settings,
          url: '#',
        }
      ]
    };
  },

  mounted() {
    this.fetchData();
  },

  methods: {
    fetchData() {
      this.request()
        .get("/api/v1/settings")
        .then(response => {
          this.form.username = response.data.username;
          this.form.summary = response.data.summary;
          this.form.avatar = response.data.avatar;
          this.form.digest = response.data.digest;
          this.form.darkMode = response.data.dark_mode;

          this.isReady = true;

          NProgress.done();
        })
        .catch(error => {
          // Add any error debugging...
          NProgress.done();
        });
    },

    saveData(data, withNotification) {
      this.form.errors = [];

      if (withNotification) {
        this.form.isSaving = true;
        this.form.hasSuccess = false;
      }

      this.request()
        .post("/api/v1/settings", data)
        .then(response => {
          if (withNotification) {
            this.form.isSaving = false;
            this.form.hasSuccess = true;
          }

          this.form.username = response.data.username;
          this.form.summary = response.data.summary;
          this.form.avatar = response.data.avatar;
          this.form.digest = response.data.digest;
          this.form.darkMode = response.data.dark_mode;
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

    toggleDigest() {
      this.saveData(
        {
          digest: this.form.digest
        },
        false
      );
    },

    toggleDarkMode() {
      this.$root.CurrentTenant.darkMode = this.form.darkMode;
      let screen = $("#app");
      let isDark = this.form.darkMode;

      screen.animate(
        {
          opacity: 0,
          backgroundColor: "rgb(38, 50, 56)"
        },
        300,
        function() {
          // todo: There has to be a better way to swap stylesheets than this
          if (isDark) {
            $("#baseStylesheet").attr("href", "/css/app-dark.css");
            $("#highlightStylesheet").attr(
              "href",
              "//cdn.jsdelivr.net/gh/highlightjs/cdn-release@9.17.1/build/styles/sunburst.min.css"
            );
          } else {
            $("#baseStylesheet").attr("href", "/css/app.css");
            $("#highlightStylesheet").attr(
              "href",
              "//cdn.jsdelivr.net/gh/highlightjs/cdn-release@9.17.1/build/styles/github.min.css"
            );
          }
        }
      );

      screen.animate(
        {
          opacity: 1,
          backgroundColor: "rgb(38, 50, 56)"
        },
        300,
        function() {
          //
        }
      );

      this.saveData(
        {
          dark_mode: isDark
        },
        false
      );
    },

    showProfileModal() {
      this.$emit("openingProfileModal", { trans: this.trans });
      $(this.$refs.profileModal.$el).modal("show");
    },

    updateLocale() {
      this.request()
        .post("/api/v1/locale", { locale: this.form.locale })
        .then(response => {
          this.trans = response.data;
          this.$root.CurrentTenant.translations = JSON.stringify(response.data);
          this.$root.CurrentTenant.locale = this.form.locale;
        })
        .catch(error => {
          //
        });
      this.saveData(
        {
          locale: this.form.locale
        },
        false
      );
    }
  }
};
</script>
