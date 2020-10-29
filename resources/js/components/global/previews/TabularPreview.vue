<template>
  <table id="datatable" class="table">
    <thead></thead>
    <tbody></tbody>
  </table>
</template>

<script>
var $ = require( 'jquery' )
require( 'datatables.net-bs4' )
require( 'datatables.net-fixedheader-bs4' )
require( 'datatables.net-responsive-bs4' )

export default {
  name: "TabularPreview",

  props: {
    isReady: {
      type: Boolean,
      required: true
    },
    data: {
      type: Array,
      required: true
    },
    columns: {
      type: Array,
      required: true  
    }
  },

  components: {},

  data() {
    return {
      datatable: null,
      dataChanged: false,
      columnChanged: false
    };
  },

  watch: {
    isReady: function (val) {
      if (val) {
        if ($.fn.dataTable.isDataTable('#datatable')) {
          $('#datatable').DataTable().clear().destroy()
          $('#datatable').html('<thead></thead><tbody></tbody>')
        }

        this.initDatatable(
          this.data,
          this.columns
        )
      }
    }
  },

  methods: {
    initDatatable (data, columns) {
      $('#datatable').DataTable({
        destroy: true,
        data: data,
        columns: columns,
        responsive: true,
        pagingType: 'simple'
      })
    }
  }
};
</script>

<style>
</style>
