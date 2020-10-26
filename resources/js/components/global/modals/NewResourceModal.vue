<template>
  <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" ref="modal" role="document">
      <div class="modal-content">
        <div
          v-if="!selectedFileUrl"
          class="modal-header d-flex align-items-center justify-content-between"
        >
          <button
            type="button"
            class="close"
            data-dismiss="modal"
            aria-label="Close"
            @click.prevent="closeModal"
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
        <div class="modal-body pb-0">
          <div>
            <div class="col-12">
              <div class="form-group row">
                <label class="font-weight-bold text-uppercase text-muted small">{{ trans.app.title }}</label>
                <input
                  type="text"
                  :class="!CurrentTenant.darkMode ? 'bg-light': 'bg-darker'"
                  class="form-control border-0"
                  v-model="form.title"
                  :placeholder="trans.app.title"
                  ref="title"
                />
                <div v-if="form.errors.title" class="invalid-feedback d-block">
                  <strong>{{ form.errors.title[0] }}</strong>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group row">
                <label class="font-weight-bold text-uppercase text-muted small">
                  {{ trans.app.description }}
                </label>
                <textarea
                  rows="4"
                  id="description"
                  name="description"
                  style="resize: none"
                  :class="!CurrentTenant.darkMode ? 'bg-light': 'bg-darker'"
                  class="form-control border-0"
                  v-model="form.description"
                  :placeholder="trans.app.description"
                ></textarea>
                <div v-if="form.errors.description" class="invalid-feedback d-block">
                  <strong>{{ form.errors.description[0] }}</strong>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="form-group row">
                <label class="font-weight-bold text-uppercase text-muted small">
                  {{ trans.app.dataset }}
                </label>
                <select
                  id="dataset_id"
                  name="dataset_id"
                  :class="!CurrentTenant.darkMode ? 'bg-light': 'bg-darker'"
                  class="form-control border-0"
                  v-model="form.dataset_id"
                >
                  <option :value="activeDataset.id" selected>{{ activeDataset.title }}</option>
                </select>
                <div v-if="form.errors.dataset_id" class="invalid-feedback d-block">
                  <strong>{{ form.errors.dataset_id[0] }}</strong>
                </div>
              </div>
            </div>
          </div>

          <file-pond
            v-if="isReadyToAcceptUploads"
            name="resourceFilePond"
            ref="pond"
            max-files="1"
            :maxFileSize="maxUploadFilesize"
            :iconRemove="getRemoveIcon"
            :iconRetry="getRetryIcon"
            :label-idle="getPlaceholderLabel"
            :accepted-file-types="formatExtensionsOnly"
            :server="getServerOptions"
            :allow-multiple="false"
            :files="selectedFilesForPond"
            @processfile="processedFromFilePond"
            @removefile="removedFromFilePond"
          />

          <div class="col-12">
            <div class="form-group row">
              <label class="font-weight-bold text-uppercase text-muted small">{{ trans.app.path }}</label>
              <input
                type="text"
                :class="!CurrentTenant.darkMode ? 'bg-light': 'bg-darker'"
                class="form-control border-0"
                v-model="form.path"
                :placeholder="trans.app.path"
                ref="path"
                disabled
              />
              <div v-if="form.errors.path" class="invalid-feedback d-block">
                <strong>{{ form.errors.path[0] }}</strong>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button
            class="btn btn-link btn-block text-muted font-weight-bold text-decoration-none"
            @click="saveResource"
          >{{ trans.app.save }}</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import _ from "lodash"
import { EventBus } from './../../../bus'
import { mapState } from "vuex"
import vueFilePond from "vue-filepond"
import $ from "jquery"

import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css"

import FilePondPluginImageValidateSize from "filepond-plugin-image-validate-size"
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type"
import FilePondPluginImagePreview from "filepond-plugin-image-preview"
import FilePondPluginImageExifOrientation from "filepond-plugin-image-exif-orientation"
import FilePondPluginFileValidateSize from "filepond-plugin-file-validate-size"

const FilePond = vueFilePond(
  FilePondPluginFileValidateType,
  FilePondPluginImagePreview,
  FilePondPluginImageValidateSize,
  FilePondPluginFileValidateSize,
  FilePondPluginImageExifOrientation
);

export default {
  name: "new-resource-modal",

  props: {
    formats: {
      type: Array,
      required: true
    }
  },

  components: {
    FilePond
  },

  data() {
    return {
      id: '',
      form: {
        id: '',
        title: '',
        description: '',
        path: '',
        dataformat_id: '',
        dataset_id: '',
        downloadable: true,
        user_id: '',
        errors: [],
        isSaving: false,
        hasSuccess: false
      },
      isReadyToAcceptUploads: false,
      selectedFileUrl: null,
      selectedFilesForPond: [],
      galleryModalClasses: ["modal-xl", "modal-dialog-scrollable"],
      maxUploadFilesize: CurrentTenant.maxUpload,
      path: CurrentTenant.path,
      trans: JSON.parse(CurrentTenant.translations),
      allFormats: [],
    };
  },

  created() {
    EventBus.$on("NEW_RESOURCE_MODAL_OPENED", (val) => {
      this.id = val
      this.fetchData(this.id)
    })
  },

  mounted() {
    this.allFormats = this.formats
    this.form.dataset_id = this.activeDataset.id
  },

  watch: {
    form: {
      handler(val) {
        if (val.title && val.description && val.dataset_id) {
          this.isReadyToAcceptUploads = true
        } else {
          this.isReadyToAcceptUploads = false
        }
      },
      deep: true
    },

    selectedFileUrl: function(val) {
      /**
       * this gets called twice
       * perhaps first when mounted and secondly when
       * filepond `load` returns
       */
      if (val) {
        this.form.path = val
      }
    }
  },

  methods: {
    fetchData(id) {
      this.request()
        .get("/api/v1/dataresources/" + id)
        .then(response => {
          this.form.id = response.data.id
          this.form.errors = []
          this.selectedFilesForPond = []
          this.selectedFileUrl = ''

          if (id !== "create") {
            this.form.title = response.data.title
            this.form.description = response.data.description
            this.form.path = response.data.path
            this.form.dataformat_id = response.data.dataformat_id
            this.form.dataset_id = response.data.dataset_id
            this.form.downloadable = response.data.downloadable
            this.form.user_id = response.data.user_id

            this.selectedFileUrl = this.form.path
            this.isReadyToAcceptUploads = false
            
            this.selectedFilesForPond = [
              {
                source: response.data.path,
                options: {
                  type: 'local'
                }
              }
            ]
          } else {
            this.form = {
              id: '',
              title: '',
              description: '',
              path: '',
              dataformat_id: '',
              dataset_id: '',
              downloadable: true,
              user_id: '',
              errors: [],
              isSaving: false,
              hasSuccess: false
            }
          }

          this.isReady = true

          NProgress.done()
        })
        .catch(error => {
          this.closeModal()
        });
    },
    
    processedFromFilePond() {
      this.isReadyToAcceptUploads = true;
      this.form.path = this.selectedFileUrl = document.getElementsByName(
        "resourceFilePond"
      )[0].value
    },

    removedFromFilePond() {
      this.isReadyToAcceptUploads = true;
      this.selectedFilesForPond = [];
      this.form.path = this.selectedFileUrl = null;
    },

    saveResource() {
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
        .post("/api/v1/dataresources/" + this.id, this.form)
        .then(response => {
          this.id = response.id
          $(this.$parent.$parent.$refs.newResourceModal.$el).modal("hide")
          this.$parent.$parent.loadDataset()
          this.$parent.$parent.save()
        })
        .catch(error => {
          console.log(error)
          this.form.isSaving = false
        });

      setTimeout(() => {
        this.form.hasSuccess = false
        this.form.isSaving = false
      }, 3000);
    },

    clearAndResetComponent() {
      this.selectedFilesForPond = [];
      this.selectedFileUrl = null;
      this.isReadyToAcceptUploads = true;
    },

    closeModal() {
      this.clearAndResetComponent();
      this.$refs.modal.hide;
    },

    validate(form) {
      let errors = {}

      if (!form.title) {
        errors.title = ["title can not be empty"]
      }

      if (!form.description) {
        errors.description = ['description can not be empty']
      }

      if (!form.path) {
        errors.path = ['path can not be empty']
      }

      if (!form.dataset_id) {
        errors.dataset_id = ['dataset id can not be empty']
      }

      return errors
    }
  },

  computed: {
    ...mapState(["activeDataset"]),

    getServerOptions() {
      let vm = this
      return {
        url: this.resourceUploadPath(),
        headers: {
          "X-CSRF-TOKEN": this.getToken()
        },
        load: (source, load, error, progress, abort, headers) => {
          var myRequest = new Request(source);
          fetch(myRequest).then(function(response) {
            response.blob().then(function(myBlob) {
              load(myBlob)
              vm.selectedFilesForPond = [
                {
                  source: source,
                  options: {
                    type: 'local'
                  }
                }
              ]
              vm.form.path = source
            });
          });         
        }
      };
    },

    formatExtensionsOnly() {
      return this.allFormats.map((format) => {
        return format.mime_type
      })
    },

    getRetryIcon() {
      return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="icon-refresh" width="26"><circle style="fill:none" cx="12" cy="12" r="10"/><path style="fill:white" d="M8.52 7.11a5.98 5.98 0 0 1 8.98 2.5 1 1 0 1 1-1.83.8 4 4 0 0 0-5.7-1.86l.74.74A1 1 0 0 1 10 11H7a1 1 0 0 1-1-1V7a1 1 0 0 1 1.7-.7l.82.81zm5.51 8.34l-.74-.74A1 1 0 0 1 14 13h3a1 1 0 0 1 1 1v3a1 1 0 0 1-1.7.7l-.82-.81A5.98 5.98 0 0 1 6.5 14.4a1 1 0 1 1 1.83-.8 4 4 0 0 0 5.7 1.85z"/></svg>';
    },

    getRemoveIcon() {
      return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="26" class="icon-close-circle"><circle style="fill:none" cx="12" cy="12" r="10"/><path style="fill:white" d="M13.41 12l2.83 2.83a1 1 0 0 1-1.41 1.41L12 13.41l-2.83 2.83a1 1 0 1 1-1.41-1.41L10.59 12 7.76 9.17a1 1 0 0 1 1.41-1.41L12 10.59l2.83-2.83a1 1 0 0 1 1.41 1.41L13.41 12z"/></svg>';
    },

    getPlaceholderLabel() {
      return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="35" class="icon-cloud-upload mr-3"><path class="secondary" d="M18 14.97c0-.76-.3-1.51-.88-2.1l-3-3a3 3 0 0 0-4.24 0l-3 3A3 3 0 0 0 6 15a4 4 0 0 1-.99-7.88 5.5 5.5 0 0 1 10.86-.82A4.49 4.49 0 0 1 22 10.5a4.5 4.5 0 0 1-4 4.47z"/><path class="secondary" d="M11 14.41V21a1 1 0 0 0 2 0v-6.59l1.3 1.3a1 1 0 0 0 1.4-1.42l-3-3a1 1 0 0 0-1.4 0l-3 3a1 1 0 0 0 1.4 1.42l1.3-1.3z"/></svg> Drop files or click here to upload';
    }
  }
};
</script>
