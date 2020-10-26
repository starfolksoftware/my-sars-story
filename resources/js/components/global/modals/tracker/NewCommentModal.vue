<template>
  <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" ref="modal" role="document">
      <div class="modal-content">
        <div
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
          <div class="form-group mb-5">
            <div class="col-lg-12">
              <label>{{ trans.app.type_something_here }}</label>
              <quill-editor :value.sync="form.comment"></quill-editor>
              <div v-if="form.errors.comment" class="invalid-feedback d-block">
                <strong>{{ form.errors.comment[0] }}</strong>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button
            class="btn btn-link btn-block text-muted font-weight-bold text-decoration-none"
            @click="saveComment"
          >{{ trans.app.save }}</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import $ from "jquery"
import ClassicEditor from '@ckeditor/ckeditor5-build-classic'
import QuillEditor from "../../../../components/global/basic-editor/QuillEditor"

export default {
  name: "new-comment-modal",

  props: {
    trackerId: {
      required: true
    },
    trackerItemId: {
      required: true
    }
  },

  components: {
    QuillEditor,
  },

  data() {
    return {
      editor: ClassicEditor,
      editorConfig: {},
      form: {
        comment: '',
        errors: [],
        isSaving: false,
        hasSuccess: false
      },
      trans: JSON.parse(CurrentTenant.translations),
    };
  },

  methods: {
    saveComment() {
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
        .post(`/api/v1/trackerItems/${this.trackerId}/${this.trackerItemId}`, this.form)
        .then(response => {
          this.form.isSaving = false
          this.form.hasSuccess = true
          alert('submitted successfully and under review. thank you')
          this.closeModal()
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
      this.form.comment = ''
    },

    closeModal() {
      this.clearAndResetComponent();
      $(this.$parent.$refs.newCommentModal.$el).modal("hide")
    },

    validate(form) {
      let errors = {}

      if (form.comment.length < 200) {
        errors.comment = ["text should be at least 200 chars"]
      }

      return errors
    }
  },

  computed: {

  }
};
</script>
