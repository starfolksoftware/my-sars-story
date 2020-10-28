<template>
  <div>
    <page-header></page-header>
    <main class="text-primary">

      <h1 class="display-4 mt-5 font-weight-700 text-center text-primary">
        {{ trans.app.contact_information }}
      </h1>
      <p class="lead text-center">
        Fill up the form and get a response within 24 hour!
      </p>

      <div class="text-center btn-wrapper">
        <a target="_blank" :href="platform.twitter_url || '#'" rel="nofollow" class="btn btn-icon-only btn-twitter rounded-circle" data-toggle="tooltip" data-original-title="Follow us">
          <span class="btn-inner--icon"><i class="fab fa-twitter"></i></span>
        </a>
        <a target="_blank" :href="platform.facebook_url || '#'" rel="nofollow" class="btn-icon-only rounded-circle btn btn-facebook" data-toggle="tooltip" data-original-title="Like us">
          <span class="btn-inner--icon"><i class="fab fa-facebook"></i></span>
        </a>
        <a target="_blank" :href="platform.instagram_url || '#'" rel="nofollow" class="btn btn-icon-only btn-instagram rounded-circle" data-toggle="tooltip" data-original-title="Follow us">
          <span class="btn-inner--icon"><i class="fab fa-instagram"></i></span>
        </a>
        <a target="_blank" :href="platform.github_url || '#'" rel="nofollow" class="btn btn-icon-only btn-github rounded-circle" data-toggle="tooltip" data-original-title="Star on Github">
          <span class="btn-inner--icon"><i class="fab fa-github"></i></span>
        </a>
        <a target="_blank" :href="platform.linkedin_url || '#'" rel="nofollow" class="btn btn-icon-only btn-twitter rounded-circle" data-toggle="tooltip" data-original-title="Star on Github">
          <span class="btn-inner--icon"><i class="fab fa-linkedin"></i></span>
        </a>
      </div>

      <div class="section section-lg">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-12 col-md-10">
              <!-- Card -->
              <div class="card border mt-5 shadow-soft p-2 p-md-4 p-lg-5">
                <div class="card-body">
                  <form>
                    <div class="row">
                      <div class="col-12 col-md-6">
                        <div class="form-group">
                          <label class="form-label text-primary" for="firstNameLabel">
                            First Name
                            <span class="text-danger">*</span>
                          </label>
                          <div class="input-group mb-4">
                            <div class="input-group-prepend">
                              <span class="input-group-text">
                                <i class="fas fa-user-alt"></i>
                              </span>
                            </div>
                            <input
                              v-model="form.first_name"
                              class="form-control"
                              id="firstNameLabel"
                              placeholder="Selase"
                              type="text"
                              required
                            />
                          </div>
                          <div v-if="form.errors.first_name" class="invalid-feedback d-block">
                            <strong>{{ form.errors.first_name[0] }}</strong>
                          </div>
                        </div>
                      </div>
                      <div class="col-12 col-md-6">
                        <div class="form-group">
                          <label class="form-label text-primary" for="lastNameLabel">
                            Last Name
                            <span class="text-danger">*</span>
                          </label>
                          <div class="input-group mb-4">
                            <div class="input-group-prepend">
                              <span class="input-group-text">
                                <i class="fas fa-user-alt"></i>
                              </span>
                            </div>
                            <input
                              class="form-control"
                              id="lastNameLabel"
                              placeholder="Kove"
                              type="text"
                              required
                              v-model="form.last_name"
                            />
                          </div>
                          <div v-if="form.errors.last_name" class="invalid-feedback d-block">
                            <strong>{{ form.errors.last_name[0] }}</strong>
                          </div>
                        </div>
                      </div>
                      <div class="col-12 col-md-6">
                        <div class="form-group">
                          <label class="form-label text-primary" for="EmailLabel">
                            Email
                            <span class="text-danger">*</span>
                          </label>
                          <div class="input-group mb-4">
                            <div class="input-group-prepend">
                              <span class="input-group-text">
                                <i class="fas fa-envelope"></i>
                              </span>
                            </div>
                            <input
                              class="form-control"
                              id="EmailLabel"
                              placeholder="selase@example.com"
                              type="email"
                              required
                              v-model="form.email"
                            />
                          </div>
                          <div v-if="form.errors.email" class="invalid-feedback d-block">
                            <strong>{{ form.errors.email[0] }}</strong>
                          </div>
                        </div>
                      </div>
                      <div class="col-12 col-md-6">
                        <div class="form-group">
                          <label class="form-label text-primary" for="phonenumberLabel">
                            Phone Number
                            <span class="text-danger">*</span>
                          </label>
                          <div class="input-group mb-4">
                            <div class="input-group-prepend">
                              <span class="input-group-text">
                                <i class="fas fa-phone-square-alt"></i>
                              </span>
                            </div>
                            <input
                              class="form-control"
                              id="phonenumberLabel"
                              placeholder="0800 000 0000"
                              type="number"
                              required
                              v-model="form.phone_number"
                            />
                          </div>
                          <div v-if="form.errors.phone_number" class="invalid-feedback d-block">
                            <strong>{{ form.errors.phone_number[0] }}</strong>
                          </div>
                        </div>
                      </div>
                      <div class="col-12 mt-4">
                        <div class="form-group">
                          <label class="form-label text-primary" for="phonenumberLabel">
                            How can we help you?
                            <span class="text-danger">*</span>
                          </label>
                          <textarea
                            class="form-control"
                            placeholder="Hi, I would like to ..."
                            id="message-2"
                            rows="8"
                            required
                            v-model="form.message"
                          ></textarea>
                        </div>
                        <div v-if="form.errors.message" class="invalid-feedback d-block">
                          <strong>{{ form.errors.message[0] }}</strong>
                        </div>
                        <div class="text-right">
                          <button @click.prevent="sendMessage" type="button" class="btn btn-primary mt-4 animate-up-2">
                            <span class="mr-2">
                              <i class="fas fa-paper-plane"></i>
                            </span> {{ trans.app.send_message }}
                          </button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>


      <div class="section section-lg pt-0 mb-9">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-12 col-md-4 text-center px-4 mb-5 mb-lg-0">
              <div class="icon icon-sm icon-shape icon-shape-primary rounded mb-4">
                <i class="fas fa-envelope-open-text"></i>
              </div>
              <h5 class="mb-3">{{ trans.app.email_us }}</h5>
              <!-- <p>{{ trans.app.email_us_explainer }}</p> -->
              <a class="font-weight-bold text-primary" href="#">{{ platform.email }}</a>
            </div>
            <div class="col-12 col-md-4 text-center px-4 mb-5 mb-lg-0">
              <div class="icon icon-sm icon-shape icon-shape-primary rounded mb-4">
                <i class="fas fa-phone-volume"></i>
              </div>
              <h5 class="mb-3">{{ trans.app.call_us }}</h5>
              <!-- <p>{{ trans.app.call_us_explainer }}</p> -->
              <a class="font-weight-bold text-primary" href="#">{{ platform.phone_number }}</a>
            </div>
          </div>
        </div>
      </div>
    </main>
    <page-footer></page-footer>
  </div>
</template>

<script>
import moment from "moment";
import NProgress from "nprogress";
export default {
  name: "contact-index",
  data() {
    return {
      trans: JSON.parse(CurrentTenant.translations),
      platform: CurrentTenant.platform,
      form: {
        id: "",
        first_name: "",
        last_name: "",
        email: "",
        phone_number: "",
        message: "",
        errors: [],
        isSaving: false,
        hasSuccess: false
      }
    };
  },
  mounted() {
    NProgress.done();
  },
  methods: {
    sendMessage() {
      this.form.errors = [];
      this.form.isSaving = true;
      this.form.hasSuccess = false;
      this.request()
        .post("/api/v1/contact", this.form)
        .then(response => {
          this.form.isSaving = false;
          this.form.hasSuccess = true;
          this.resetForm()
        })
        .catch(error => {
          this.form.isSaving = false;
          this.form.errors = error.response.data.errors;
        });
      setTimeout(() => {
        this.form.hasSuccess = false;
        this.form.isSaving = false;
      }, 10000);
    },
    resetForm() {
      this.form = {
        first_name: "",
        last_name: "",
        email: "",
        phone_number: "",
        message: "",
        errors: [],
        isSaving: false,
        hasSuccess: false
      }
    }
  }
};
</script>

<style scoped></style>