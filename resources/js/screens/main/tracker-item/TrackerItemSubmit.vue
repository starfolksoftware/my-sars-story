<template>
  <div>
    <vue-headful
      :title="metaTitle"
      :description="metaDescription"
      :image="metaImageUrl"
      :url="metaUrl"
    />
    <page-header>
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
          @click="saveTrackedItem"
          :aria-label="trans.app.save"
        >{{ trans.app.save }}</a>
      </template>
    </page-header>

    <main v-if="isReady" class="py-4" v-cloak>
      <div class="col-md-10 my-auto mx-auto">
        <div class="row mt-5">
          <div class="col-md-6 text-center">
            <h4 class="display-4 mb-5">{{ trans.app.submit_to_us }}</h4>
            <img width="300" src="/images/undraw_collection_u2np.png" alt="" class="img-fluid">
            <p class="mt-5" v-html="tracker.description"></p>
          </div>
          <div class="col-md-6 border rounded">
            <div class="form-group">
              <div class="col-lg-12">
                <div v-for="(error, index) in form.errors" :key="index" class="invalid-feedback d-block">
                  <strong>{{ error[0] }}</strong>
                </div>
              </div>
            </div>
            <vue-form-generator :schema="schema" :model="form" :options="formOptions"></vue-form-generator>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script>
import $ from "jquery";
import NProgress from "nprogress";
import VueFormGenerator from 'vue-form-generator/dist/vfg-core.js'

export default {
  name: "incident-submit",

  components: {
    VueFormGenerator: VueFormGenerator.component
  },

  data() {
    return {
      status: null,
      id: "create",
      form: {
        id: '',
        user_id: '',
        errors: [],
        isSaving: false,
        hasSuccess: false
      },
      tracker: {},
      isReady: false,
      trans: JSON.parse(CurrentTenant.translations),
      formOptions: {
        validateAfterLoad: true,
        validateAfterChanged: true
      }
    };
  },

  computed: {
    schema() {
      return {
        fields: this.tracker.fields
      }
    }
  },

  created() {
    if (!this.isLoggedIn) {
      window.location.href('/login')
    }
  },

  mounted() {

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
        })
    })
  },

  watch: {},

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
          }

          this.isReady = true;

          NProgress.done();
        })
        .catch(error => {
          console.log(error)
          // this.$router.push({ name: "designations" });
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
        confirmed: 0,
        meta,
        user_id: this.form.user_id,
      }

      this.request()
        .post(`/api/v1/trackerItems/${this.$route.params.trackerId}/${this.id}`, formData)
        .then(response => {
          this.form.isSaving = false;
          this.form.hasSuccess = true;
          this.id = this.form.id = response.data.id;
          this.status = response.data;

          alert("successfully submitted")

          this.clearForm()
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

    clearForm() {
      this.status = null
      this.id = "create"
      this.form = {
        id: '',
        user_id: '',
        errors: [],
        isSaving: false,
        hasSuccess: false
      }

      this.tracker.fields.forEach((field) => {
        this.form[field.model] = field.default || ''
      })
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
    }
  }
};
</script>
