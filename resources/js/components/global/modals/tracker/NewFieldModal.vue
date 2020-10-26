<template>
  <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" ref="modal" role="document">
      <div class="modal-content">
        <div
          class="modal-header d-flex align-items-center justify-content-between"
        >
          <label for="">{{ trans.app.add_field }}</label>
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
              <div v-if="fieldNames" class="form-group row">
                <label class="font-weight-bold text-uppercase text-muted small">{{ trans.app.field_type }}</label>
                <select 
                  :class="!CurrentTenant.darkMode ? 'bg-light': 'bg-darker'"
                  class="form-control border-0"
                  v-model="fieldType">
                  <option value="" disabled>Select field type</option>
                  <option v-for="(fieldName, index) in fieldNames" :key="index" :value="fieldName">
                    {{ fieldName }}
                  </option>
                </select>
                <div v-if="errors.type" class="invalid-feedback d-block">
                  <strong>{{ errors.type[0] }}</strong>
                </div>
              </div>
              <div v-if="form.label != undefined" class="form-group row">
                <label class="font-weight-bold text-uppercase text-muted small">{{trans.app.label}}</label>
                <input
                  type="text"
                  :class="!CurrentTenant.darkMode ? 'bg-light': 'bg-darker'"
                  class="form-control border-0"
                  v-model="form.label"
                  :placeholder="trans.app.type_label_for_field"
                  ref="label"
                />
                <div v-if="errors.label" class="invalid-feedback d-block">
                  <strong>{{ errors.label[0] }}</strong>
                </div>
              </div>
              <div v-if="form.model != undefined" class="form-group row">
                <label class="font-weight-bold text-uppercase text-muted small">{{trans.app.model}}</label>
                <input
                  type="text"
                  :class="!CurrentTenant.darkMode ? 'bg-light': 'bg-darker'"
                  class="form-control border-0"
                  v-model="form.model"
                  :placeholder="trans.app.type_model_for_field"
                  ref="model"
                />
                <div v-if="errors.model" class="invalid-feedback d-block">
                  <strong>{{ errors.model[0] }}</strong>
                </div>
              </div>
              <div v-if="form.default != undefined" class="form-group row">
                <label class="font-weight-bold text-uppercase text-muted small">{{trans.app.default}}</label>
                <select 
                  :class="!CurrentTenant.darkMode ? 'bg-light': 'bg-darker'"
                  class="form-control border-0"
                  v-model="form.default">
                  <option value="" disabled>{{trans.app.select_default_for_field}}</option>
                  <option value="1">
                    {{ trans.app.true }}
                  </option>
                  <option value="0">
                    {{ trans.app.false }}
                  </option>
                </select>
                <div v-if="errors.default" class="invalid-feedback d-block">
                  <strong>{{ errors.default[0] }}</strong>
                </div>
              </div>
              <div v-if="form.listBox != undefined" class="form-group row">
                <label class="font-weight-bold text-uppercase text-muted small">{{trans.app.list_box}}</label>
                <select 
                  :class="!CurrentTenant.darkMode ? 'bg-light': 'bg-darker'"
                  class="form-control border-0"
                  v-model="form.listBox">
                  <option value="" disabled>{{trans.app.select_list_box_value_for_field}}</option>
                  <option value="1">
                    {{ trans.app.true }}
                  </option>
                  <option value="0">
                    {{ trans.app.false }}
                  </option>
                </select>
                <div v-if="errors.listBox" class="invalid-feedback d-block">
                  <strong>{{ errors.listBox[0] }}</strong>
                </div>
              </div>
              <div v-if="form.values != undefined" class="form-group row">
                <label class="font-weight-bold text-uppercase text-muted small">{{trans.app.values}}</label>
                <input
                  type="text"
                  :class="!CurrentTenant.darkMode ? 'bg-light': 'bg-darker'"
                  class="form-control border-0"
                  v-model="form.values"
                  :placeholder="trans.app.type_values_for_field"
                  ref="values"
                />
                <div v-if="errors.values" class="invalid-feedback d-block">
                  <strong>{{ errors.values[0] }}</strong>
                </div>
              </div>
              <div v-if="form.inputType != undefined" class="form-group row">
                <label class="font-weight-bold text-uppercase text-muted small">{{trans.app.input_type}}</label>
                <input
                  type="text"
                  :class="!CurrentTenant.darkMode ? 'bg-light': 'bg-darker'"
                  class="form-control border-0"
                  v-model="form.inputType"
                  :placeholder="trans.app.type_input_type_for_field"
                  ref="inputType"
                />
                <div v-if="errors.inputType" class="invalid-feedback d-block">
                  <strong>{{ errors.inputType[0] }}</strong>
                </div>
              </div>
              <div v-if="form.required != undefined" class="form-group row">
                <label class="font-weight-bold text-uppercase text-muted small">{{trans.app.required}}</label>
                <select 
                  :class="!CurrentTenant.darkMode ? 'bg-light': 'bg-darker'"
                  class="form-control border-0"
                  v-model="form.required">
                  <option value="" disabled>{{trans.app.select_required_value_for_field}}</option>
                  <option value="1">
                    {{ trans.app.true }}
                  </option>
                  <option value="0">
                    {{ trans.app.false }}
                  </option>
                </select>
                <div v-if="errors.required" class="invalid-feedback d-block">
                  <strong>{{ errors.required[0] }}</strong>
                </div>
              </div>
              <div v-if="form.placeholder != undefined" class="form-group row">
                <label class="font-weight-bold text-uppercase text-muted small">{{trans.app.placeholder}}</label>
                <input
                  type="text"
                  :class="!CurrentTenant.darkMode ? 'bg-light': 'bg-darker'"
                  class="form-control border-0"
                  v-model="form.placeholder"
                  :placeholder="trans.app.type_placeholder_for_field"
                  ref="placeholder"
                />
                <div v-if="errors.placeholder" class="invalid-feedback d-block">
                  <strong>{{ errors.placeholder[0] }}</strong>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button
            class="btn btn-link btn-block text-muted font-weight-bold text-decoration-none"
            @click="submit"
            data-dismiss="modal"
          >{{ trans.app.submit }}</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import _ from "lodash"
import VueFormGenerator from "vue-form-generator"

export default {
  name: "new-field-modal",

  components: {
    
  },

  data() {
    return {
      form: {},
      errors: [],
      fieldType: "",
      coreFields: {
        checkbox: {
          type: "checkbox",
          label: "",
          model: "",
          required: 1,
          default: 1
        },
        checklist: {
          type: "checklist",
          label: "",
          model: "",
          required: 1,
          listBox: 0,
          values: [] 
        },
        input: {
          type: "input",
          inputType: "",
          label: "",
          model: "",
          required: 1,
          placeholder: "",
          validator: VueFormGenerator.validators.string
        },
        radios: {
          type: "radios",
          label: "",
          model: "",
          required: 1,
          values: []
        },
        select: {
          type: "select",
          label: "",
          model: "",
          required: 1,
          values: []
        },
        textArea: {
          type: "textArea",
          label: "",
          model: "",
          required: 1,
          placeholder: "",
          validator: VueFormGenerator.validators.string
        }
      },
      fieldNames: [
        'checkbox',
        'checklist',
        'input',
        'radios',
        'select',
        'textArea'
      ],
      trans: JSON.parse(CurrentTenant.translations)
    }
  },

  computed: {
    
  },

  mounted() {
    
  },

  watch: {
    fieldType: function (val) {
      this.form = {}
      this.errors = []
      this.form = Object.assign({}, this.coreFields[val] || {})
    }
  },

  methods: {
    submit() {
      let vErrors = this.validate(this.form);

      if (Object.keys(vErrors).length > 0) {
        this.errors = vErrors;
        return false;
      }

      if (this.form.values != undefined) {
        this.form.values = this.form.values.replace(/\s/g, '').split(',')
      }

      this.form.model = this.makeVariable(this.form.model)

      this.$emit('new-field', this.form)

      this.closeModal()
    },

    clearAndResetComponent() {
      this.form = {}
      this.fieldType = ""
    },

    closeModal() {
      this.clearAndResetComponent();
      this.$refs.modal.hide
    },

    validate(form) {
      let errors = {}

      if (!form.type) {
        errors.type = ["type can not be empty"]
      }

      if (!form.label) {
        errors.label = ["label can not be empty"]
      }

      if (!form.model) {
        errors.model = ["model can not be empty"]
      }

      if (form.default != undefined && form.default === "") {
        errors.default = ["default can not be empty"]
      }

      if (form.listBox != undefined && form.listBox === "") {
        errors.listBox = ["listbox can not be empty"]
      }

      if (form.values != undefined && !form.values) {
        errors.values = ["values can not be empty"]
      }

      if (form.inputType != undefined && !form.inputType) {
        errors.inputType = ["input type can not be empty"]
      }

      if (form.required != undefined && form.required === "") {
        errors.required = ["required can not be empty"]
      }

      if (form.placeholder != undefined && !form.placeholder) {
        errors.placeholder = ["placeholder can not be empty"]
      }

      return errors;
    }
  },

  computed: {
    
  }
};
</script>
