<template>
  <div class="row">
    <div class="col-12 col-md-10">
      <l-map
        style="height: 600px; width: 100%"
        :zoom="zoom"
        :center="center"
      >
        <l-tile-layer :url="url"></l-tile-layer>
        <!-- <l-geo-json :geojson="geojson"></l-geo-json> -->
        <l-marker 
          v-for="(marker, index) in markers" 
          :key="index" 
          :lat-lng="marker.latLng">
          <l-popup>
            <p>{{ marker.label }}</p>
          </l-popup>
        </l-marker>
      </l-map>
    </div>
    <div class="col-12 col-md-2">
      <form>
        <div class="form-group">
          <label for="label">{{ $parent.trans.app.label_field }}</label>
          <select v-model="labelField" class="form-control" id="label">
            <option value="" disabled>{{ $parent.trans.app.select_label_field }}</option>
            <option 
              v-for="(column, index) in columns" 
              :key="index"
              :value="column.index">
              {{ column.title }}
            </option>
          </select>
        </div>
        <div class="form-group">
          <label for="latitude">{{ $parent.trans.app.latitude_field }}</label>
          <select v-model="latitudeField" class="form-control" id="latitude">
            <option value="" disabled>{{ $parent.trans.app.select_latitude_field }}</option>
            <option 
              v-for="(column, index) in columns" 
              :key="index"
              :value="column.index">
              {{ column.title }}
            </option>
          </select>
        </div>
        <div class="form-group">
          <label for="longitude">{{ $parent.trans.app.longitude_field }}</label>
          <select v-model="longitudeField" class="form-control" id="longitude">
            <option value="" disabled>{{ $parent.trans.app.select_longitude_field }}</option>
            <option 
              v-for="(column, index) in columns" 
              :key="index"
              :value="column.index">
              {{ column.title }}
            </option>
          </select>
        </div>
        <div class="form-group">
          <vue-element-loading :active="loading" />
          <button @click.prevent="loadMap" type="button" class="btn btn-info">
            {{ $parent.trans.app.load_map }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import L from 'leaflet'
import { 
  LMap, 
  LTileLayer, 
  LMarker, 
  LPopup, 
  // LGeoJson 
} from 'vue2-leaflet'
import { Icon, latLng } from 'leaflet'
import VueElementLoading from 'vue-element-loading'
delete Icon.Default.prototype._getIconUrl
Icon.Default.mergeOptions({
  iconRetinaUrl: require('leaflet/dist/images/marker-icon-2x.png'),
  iconUrl: require('leaflet/dist/images/marker-icon.png'),
  shadowUrl: require('leaflet/dist/images/marker-shadow.png'),
})

export default {
  name: 'MapPreview',

  props: {
    data: {
      type: Array,
      required: true
    },
    columns: {
      type: Array,
      required: true  
    },
    resource: {
      type: Object,
      required: true
    },
    activeSheetName: {
      type: String,
      required: true
    }
  },

  components: {
    LMap,
    LTileLayer,
    LMarker,
    LPopup,
    // LGeoJson,
    VueElementLoading
  },

  data() {
    return {
      loading: false,
      latitudeField: '',
      longitudeField: '',
      labelField: '',
      url: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
      zoom: 4,
      center: [9.0765, 7.3986],
      // geojson: null,
      withPopup: latLng(9.0765, 7.3986),
      markers: []
    }
  },

  mounted() {
    this.$nextTick(() => {
      
    });
  },

  methods: {
    loadMap() {
      this.loading = true
      let queryableWorker = new this.QueryableWorker('/workers/tasks.worker.js')

      let updateEssentials = (response) => {
        console.log(response)
        this.markers = response
        this.loading = false
      }

      if (window.Worker) {
        this.validate()
        console.info('worker available !!! using worker')
        let queryableWorker = new this.QueryableWorker('/workers/tasks.worker.js')

        try {
          queryableWorker.addListener('success', (response) => {
            updateEssentials(response)
            queryableWorker.terminate()
            this.loading = false
          })

          queryableWorker.addListener('error', (error) => {
            queryableWorker.terminate()
            this.loading = false
          })

          queryableWorker.sendQuery(
            'buildMarkers', 
            this.labelField, 
            this.latitudeField, 
            this.longitudeField,
            this.data,
            this.columns
          )
        } catch (error) {
          queryableWorker.terminate()
          this.loading = false
        }
      }
    },

    validate() {
      if (this.labelField == null || !this.latitudeField || !this.longitudeField) {
        console.log(this.labelField, this.latitudeField, this.longitudeField)
        throw new TypeError('error - some required parameters are not provided')
        this.loading = false
      }
    }
  }
}
</script>

<style>

</style>