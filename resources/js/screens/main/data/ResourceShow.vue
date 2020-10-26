<template>
  <div>
    <vue-headful
      :title="metaTitle"
      :description="metaDescription"
      :image="metaImageUrl"
      :url="metaUrl"
    />
    <page-header></page-header>

    <main class="py-4">
      <vue-element-loading :active="!isReady" :is-full-screen="true"/>
      <div class="col-12 col-md-10 mx-auto">
        <h1 class="my-3">{{ dataresource.title }}</h1>
        <div class="content-body mt-4 mb-3" v-html="dataresource.description"></div>
        <p v-if="dataresource.format" class="text-muted">
          <span class="text-success">{{ `.${dataresource.format.extension}` }}</span>
        </p>
        <div class="row">
          <div class="col-md-12">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active" id="v-pills-table-tab" data-toggle="pill" href="#v-pills-table" role="tab" aria-controls="v-pills-table" aria-selected="true">
                  {{ trans.app.table }}
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="v-pills-chart-tab" data-toggle="pill" href="#v-pills-chart" role="tab" aria-controls="v-pills-chart" aria-selected="false">
                  {{ trans.app.chart }}
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="v-pills-map-tab" data-toggle="pill" href="#v-pills-map" role="tab" aria-controls="v-pills-map" aria-selected="false">
                  {{ trans.app.map }}
                </a>
              </li>
              <li class="ml-3">
                <form class="form-inline">
                  <div class="form-group mb-2">
                    <label for="sheets" class="sr-only mr-3">Worksheets</label>
                    <select 
                      @change="load($event.target.value)" 
                      v-model="activeSheetName" 
                      id="sheets" 
                      class="form-control">
                      <option v-for="(sheetName, index) in sheetNames" :key="index" :value="sheetName">
                        {{ sheetName }}
                      </option>
                    </select>
                  </div>
                </form>
              </li>
            </ul>
            <div style="width: 100%; min-height: 400px" class="tab-content" id="v-pills-tabContent">
              <div class="tab-pane fade show active" id="v-pills-table" role="tabpanel" aria-labelledby="v-pills-table-tab">
                <tabular-preview
                  :isReady="isReady"
                  :data="worksheet"
                  :columns="columns"
                  :resource="dataresource"
                  :activeSheetName="activeSheetName"
                />
              </div>
              <div class="tab-pane fade" id="v-pills-chart" role="tabpanel" aria-labelledby="v-pills-chart-tab">
                <chart-preview 
                  v-if="isReady"
                  :data="worksheet" 
                  :columns="columns"
                  :resource="dataresource"
                  :activeSheetName="activeSheetName"
                />
              </div>
              <div class="tab-pane fade" id="v-pills-map" role="tabpanel" aria-labelledby="v-pills-map-tab">
                <map-preview
                  :data="worksheet" 
                  :columns="columns"
                  :resource="dataresource"
                  :activeSheetName="activeSheetName"
                />
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12 col-md-6">
            <div class="list-group mt-5">

              <h1>
                {{ trans.app.resources }}
                <hr>
              </h1>
              

              <router-link
                v-for="(resource, index) in dataset.resources"
                :key="index"
                class="list-group-item list-group-item-action"
                :to="{ name: 'resource-show', params: { id: dataset.id, resourceId: resource.id } }">
                <div class="d-flex w-100 justify-content-between">
                  <h5 class="mb-1">{{ resource.title }}</h5>
                </div>
                <small></small>
              </router-link>

            </div>
          </div>
          <div class="col-12 col-md-6">
            <div class="list-group mt-5">
              
              <h1>
                {{ trans.app.resource_meta }}
                <hr>
              </h1>

              <a class="list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-between">
                  <h5 class="mb-1">{{ trans.app.file_extension }}</h5>
                </div>
                <p class="mb-1" v-if="dataresource.format">{{ dataresource.format.extension }}</p>
                <small></small>
              </a>

              <a class="list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-between">
                  <h5 class="mb-1">{{ trans.app.mime_type }}</h5>
                </div>
                <p class="mb-1" v-if="dataresource.format">{{ dataresource.format.mime_type }}</p>
                <small></small>
              </a>

              <a class="list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-between">
                  <h5 class="mb-1">{{ trans.app.created }}</h5>
                </div>
                <p class="mb-1">{{ dataresource.created_at }}</p>
                <small></small>
              </a>

              <a class="list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-between">
                  <h5 class="mb-1">{{ trans.app.updated }}</h5>
                </div>
                <p class="mb-1">{{ dataresource.updated_at }}</p>
                <small></small>
              </a>

            </div>
          </div>
        </div>
      </div>
    </main>
    <page-footer></page-footer>
  </div>
</template>

<script>
import moment from "moment"
import NProgress from "nprogress"
import TabularPreview from "../../../components/global/previews/TabularPreview"
import ChartPreview from "../../../components/global/previews/ChartPreview"
import MapPreview from "../../../components/global/previews/MapPreview"
import VueElementLoading from 'vue-element-loading'

export default {
  name: "dataresource-show",

  components: {
    TabularPreview,
    ChartPreview,
    MapPreview,
    VueElementLoading
  },

  data() {
    return {
      dataresource: {},
      dataset: {},
      worksheet: [],
      columns: [],
      sheetNames: [],
      activeSheetName: '',
      trans: JSON.parse(CurrentTenant.translations),
      id: this.$route.params.resourceId,
      isReady: false,
      hasSuccess: false
    };
  },

  beforeRouteEnter(to, from, next) {
    next(vm => {
      vm.load()
    });
  },

  watch: {
    '$route' (to, from) {
      this.load()
    }
  },

  methods: {
    downloadResource(id) {
      if (!id) return
      
      this.request()
        .get("/api/v1/dataresources/download/" + id)
        .then(response => {
          NProgress.done()
        })
        .catch(error => {

        })
    },

    load(sheetName = null) {
      NProgress.start()
      this.isReady = false
      let method = 'get'
      let token = this.getToken()
      let url = `/api/v1/dataresources/${this.$route.params.resourceId}?previewData=1`
      if (sheetName) url += `&sheetName=${sheetName}`

      let updateEssentials = (response) => {
        this.dataresource = response.dataresource
        this.dataset = response.dataresource.dataset
        this.activeSheetName = response.activeSheetName
        this.worksheet = response.worksheet
        this.sheetNames = response.sheetNames
        this.columns = JSON.parse(response.columns)
        this.isReady = true
        this.hasSuccess = true
      }

      if (window.Worker) {
        console.info('worker available !!! using worker')
        let queryableWorker = new this.QueryableWorker('/workers/tasks.worker.js')

        try {
          queryableWorker.addListener('success', (response) => {
            updateEssentials(response)
            NProgress.done()
            queryableWorker.terminate()
          })

          queryableWorker.addListener('error', (error) => {
            this.$router.push({ name: "data" })
            NProgress.done()
            queryableWorker.terminate()
          })

          queryableWorker.sendQuery('makeRequest', method, token, url)
        } catch (error) {
          queryableWorker.terminate()
          NProgress.done()
        }
      } else {
        console.warn('Worker not available. at a risk of window freeze')

        this.request()
          .get(url, {
            params: {
              sheetName: sheetName ?? null
            }
          }).then(response => {
            updateEssentials(response.data)
            NProgress.done()
          }).catch(error => {
            this.$router.push({ name: "data" })
            NProgress.done()
          })
      }
    }
  }
};

</script>

<style scoped></style>
