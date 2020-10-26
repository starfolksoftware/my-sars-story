<template>
  <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header d-flex align-items-center justify-content-between border-0">
          <h4 class="modal-title">{{ trans.app.general_settings }}</h4>

          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
        <div class="modal-body">
          <div class="form-group row">
            <div class="col-12">
              <label class="font-weight-bold text-uppercase text-muted small">{{ trans.app.title }}</label>
              <input
                type="text"
                :class="!CurrentTenant.darkMode ? 'bg-light': 'bg-darker'"
                class="form-control border-0"
                @input="update"
                name="title"
                v-model="activeDataset.title"
                :title="trans.app.title"
                :placeholder="trans.app.title"
              />
              <div v-if="activeDataset.errors.title" class="invalid-feedback d-block">
                <strong>{{ activeDataset.errors.title[0] }}</strong>
              </div>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-12">
              <label
                class="font-weight-bold text-uppercase text-muted small"
              >{{ trans.app.description }}</label>
              <textarea
                rows="4"
                id="settings"
                name="description"
                style="resize: none"
                :class="!CurrentTenant.darkMode ? 'bg-light': 'bg-darker'"
                class="form-control resize-none border-0"
                v-model="activeDataset.description"
                @input="update"
                :placeholder="trans.app.description"
              ></textarea>
              <div v-if="activeDataset.errors.description" class="invalid-feedback d-block">
                <strong>{{ activeDataset.errors.description[0] }}</strong>
              </div>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-12">
              <label
                class="font-weight-bold text-uppercase text-muted small"
              >{{ trans.app.license }}</label>
              <select 
                name="datalicense_id"
                id="settings"
                :class="!CurrentTenant.darkMode ? 'bg-light': 'bg-darker'"
                class="form-control resize-none border-0"
                v-model="activeDataset.datalicense_id"
                @input="update"
                :placeholder="trans.app.license"
              >
                <option value="" disabled>{{ trans.app.license }}</option>
                <option 
                  v-for="(license, index) in allLicenses" 
                  :key="index" 
                  :value="license.id">{{ license.name }}</option>
              </select>
              <div v-if="activeDataset.errors.datalicense_id" class="invalid-feedback d-block">
                <strong>{{ activeDataset.errors.datalicense_id[0] }}</strong>
              </div>
            </div>
          </div>
          <div class="form-group row">
            <div class="col-12">
              <label class="font-weight-bold text-uppercase text-muted small">{{ trans.app.topics }}</label>
              <datatopic-select :topics="topics" :tagged="activeDataset.topics" />
            </div>
          </div>
          <div class="form-group row">
            <div class="col-12">
              <label class="font-weight-bold text-uppercase text-muted small">{{ trans.app.tags }}</label>
              <datatag-select :tags="tags" :tagged="activeDataset.tags" />
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-link btn-block font-weight-bold text-muted text-decoration-none"
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
import DatatopicSelect from "../../data/DatatopicSelect";
import DatatagSelect from "../../data/DatatagSelect";
import Tooltip from "../../../directives/Tooltip";

export default {
  name: "dataset-settings-modal",

  props: {
    topics: {
      type: Array,
      required: true
    },
    tags: {
      type: Array,
      required: true
    },
    licenses: {
      type: Array,
      required: true
    }
  },

  components: {
    DatatopicSelect,
    DatatagSelect
  },

  directives: {
    Tooltip
  },

  data() {
    return {
      allTopics: [],
      allTags: [],
      allLicenses: [],
      trans: JSON.parse(CurrentTenant.translations)
    };
  },

  computed: mapState(["activeDataset"]),

  mounted() {
    this.allTopics = this.topics
    this.allTags = this.tags
    this.allLicenses = this.licenses
  },

  methods: {
    update: _.debounce(function(e) {
      this.$parent.$parent.save()
    }, 3000)
  }
};
</script>
