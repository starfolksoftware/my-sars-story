<template>
  <div class="row">
    <div class="col-12 col-md-10">
      <highcharts :options="chartOptions"></highcharts>
    </div>
    <div class="col-12 col-md-2">
      <form>
        <div class="form-group">
          <label for="chart-type">{{ $parent.trans.app.chart_type }}</label>
          <select v-model="chartType" class="form-control" id="chart-type">
            <option 
              v-for="(chart,index) in availableCharts" 
              :key="index">
              {{ chart }}
            </option>
          </select>
        </div>
        <div class="form-group">
          <label for="x_axis">{{ $parent.trans.app.group_column }}</label>
          <select v-model="xColumnId" class="form-control" id="x_axis">
            <option 
              v-for="(column, index) in columns" 
              :key="index"
              :value="column.index">
              {{ column.title }}
            </option>
          </select>
        </div>
        <!-- <div class="form-group">
          <label for="x_axis_type">{{ $parent.trans.app.axis_type }}</label>
          <select class="form-control" id="x_axis_type">
            <option value="categories" selected>Categories</option>
            <option value="linear">Linear</option>
            <option value="logarithmic">Logarithmic</option>
            <option value="datetime">Datetime</option>
          </select>
        </div> -->
        <div class="form-group">
          <label for="axes">{{ $parent.trans.app.axes }}</label>
          <select v-model="yColumnIds" multiple class="form-control" id="axes">
            <option value="" disabled>{{ $parent.trans.app.you_can_select_more_than_one }}</option>
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
          <button @click.prevent="loadChart" type="button" class="btn btn-info">
            {{ $parent.trans.app.load_chart }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import {Chart} from 'highcharts-vue'
import VueElementLoading from 'vue-element-loading'

export default {
  name: 'ChartPreview',

  props: {
    data: {
      type: Array,
      required: true
    },
    columns: {
      type: Array,
      required: true  
    },
    title: {
      type: String,
      required: true
    },
  },

  components: {
    highcharts: Chart,
    VueElementLoading
  },

  data() {
    return {
      loading: false,
      availableCharts: ['line', 'spline', 'area', 'areaspline', 'column', 'bar', 'pie'],
      chartType: 'line',
      xColumnId: '',
      yColumnIds: [],
      chartOptions: {}
    }
  },

  methods: {
    loadChart() {
      this.loading = true
      let queryableWorker = new this.QueryableWorker('/workers/tasks.worker.js')

      let updateEssentials = (response) => {
        // console.log(response)
        this.chartOptions = response
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
          })

          queryableWorker.addListener('error', (error) => {
            queryableWorker.terminate()
            this.loading = false
          })

          queryableWorker.sendQuery(
            'buildChartOptions', 
            this.title, 
            this.chartType, 
            this.xColumnId,
            this.yColumnIds,
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
      if (!this.chartType || !this.xColumnId || !Array.isArray(this.yColumnIds) ||
        this.yColumnIds.length == 0) {
        throw new TypeError('error - some required parameters are not provided')
      }
    }
  }

}
</script>

<style>

</style>
