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
          <file-pond
            v-if="isReadyToAcceptUploads"
            name="uploadFilePond"
            ref="pond"
            max-files="1"
            :maxFileSize="maxUploadFilesize"
            :iconRemove="getRemoveIcon"
            :iconRetry="getRetryIcon"
            :label-idle="getPlaceholderLabel"
            accepted-file-types=".doc,.docx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,image/jpeg,image/png,image/gif,application/pdf"
            :server="getServerOptions"
            :allow-multiple="false"
            :files="selectedFilesForPond"
            @processfile="processedFromFilePond"
            @removefile="removedFromFilePond"
          />

          <div >
            <div
              v-if="selectedFileUrl && !selectedFilesForPond.length && !isReadyToAcceptUploads"
              class="selected-image"
            >
              <button
                type="button"
                class="close"
                data-dismiss="modal"
                aria-label="Close"
                @click.prevent="clearAndResetComponent"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 24 24"
                  width="24"
                  class="icon-trash"
                >
                  <path
                    class="primary"
                    d="M5 5h14l-.89 15.12a2 2 0 0 1-2 1.88H7.9a2 2 0 0 1-2-1.88L5 5zm5 5a1 1 0 0 0-1 1v6a1 1 0 0 0 2 0v-6a1 1 0 0 0-1-1zm4 0a1 1 0 0 0-1 1v6a1 1 0 0 0 2 0v-6a1 1 0 0 0-1-1z"
                  />
                  <path
                    class="primary"
                    d="M8.59 4l1.7-1.7A1 1 0 0 1 11 2h2a1 1 0 0 1 .7.3L15.42 4H19a1 1 0 0 1 0 2H5a1 1 0 1 1 0-2h3.59z"
                  />
                </svg>
              </button>
              <img :src="selectedFileUrl" class="w-100 rounded mb-3" />
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button
            class="btn btn-link btn-block text-muted font-weight-bold text-decoration-none"
            @click="clickDone"
            data-dismiss="modal"
          >{{ trans.app.done }}</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import _ from "lodash";
import { mapState } from "vuex";
import vueFilePond from "vue-filepond";

import "filepond/dist/filepond.min.css";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css";

import FilePondPluginImageValidateSize from "filepond-plugin-image-validate-size";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import FilePondPluginImageExifOrientation from "filepond-plugin-image-exif-orientation";
import FilePondPluginFileValidateSize from "filepond-plugin-file-validate-size";

const FilePond = vueFilePond(
  FilePondPluginFileValidateType,
  FilePondPluginImagePreview,
  FilePondPluginImageValidateSize,
  FilePondPluginFileValidateSize,
  FilePondPluginImageExifOrientation
);

export default {
  name: "resource-upload-modal",

  props: {
    defaultFileUrl: {
      type: String,
      required: false
    }
  },

  components: {
    FilePond
  },

  data() {
    return {
      isReadyToAcceptUploads: true,
      selectedFileUrl: null,
      selectedFilesForPond: [],
      maxUploadFilesize: CurrentTenant.maxUpload,
      path: CurrentTenant.path,
      trans: JSON.parse(CurrentTenant.translations)
    };
  },

  mounted() {
    this.selectedFileUrl = this.defaultFileUrl || ''
    this.isReadyToAcceptUploads = _.isEmpty(this.selectedFileUrl);

    if (this.defaultFileUrl) {
      this.selectedFilesForPond = [
        {
          source: this.defaultFileUrl,
          options: {
            type: 'local'
          }
        }
      ]
    }
  },

  watch: {
    selectedFileUrl: function (val) {
      if (val) {
        this.$emit('update:path', val)
      } else {
        this.$emit('update:path', '')
      }
    }
  },

  methods: {
    processedFromFilePond() {
      this.isReadyToAcceptUploads = true;
      this.selectedFileUrl = document.getElementsByName(
        "uploadFilePond"
      )[0].value;
    },

    removedFromFilePond() {
      this.isReadyToAcceptUploads = true;
      this.selectedFilesForPond = [];
      this.selectedFileUrl = null;
    },

    clickDone() {
      if (this.selectedFileUrl) {
        this.$emit('update:path', this.selectedFileUrl)
      } else {
        this.$emit('update:path', '')
      }
    },

    clearAndResetComponent() {
      this.selectedFilesForPond = [];
      this.selectedFileUrl = null;
      this.isReadyToAcceptUploads = true;
    },

    closeModal() {
      this.clearAndResetComponent();
      this.$refs.modal.hide;
    }
  },

  computed: {
    getServerOptions() {
      return {
        url: this.mediaUploadPath(),
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
              vm.selectedFileUrl = source
            });
          });         
        }
      };
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
