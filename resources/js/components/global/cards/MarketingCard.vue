<template>
  <div>
    <div class="mt-5 mb-5" v-for="(marketing, index) in marketings" :key="index">
      <hr class="featurette-divider">

      <div class="row featurette">
        <div class="col-md-7" :class="index % 2 == 0 ? 'order-md-1' : 'order-md-2'">
          <h2 class="featurette-heading">
            {{ marketing.title }}
          </h2>
          <p class="lead" v-html="marketing.description"></p>
          <p>
            <button
              v-if="hasDelete"
              type="button"
              class="btn btn-danger"
              @click="deleteMarketing(index, marketings)">
              {{ trans.app.delete }}
            </button>
          </p>
        </div>
        <div class="col-md-5" :class="index % 2 == 0 ? 'order-md-2' : 'order-md-1'">
          <img 
            v-if="marketing.thumbnail"
            height="500" 
            width="500" 
            :src="marketing.thumbnail" 
            class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" 
            alt="...">
          <svg v-else class="bd-placeholder-img bd-placeholder-img-lg featurette-image img-fluid mx-auto" width="500" height="500" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 500x500"><title>Placeholder</title><rect width="100%" height="100%" fill="#eee"/><text x="50%" y="50%" fill="#aaa" dy=".3em">500x500</text></svg>
        </div>
      </div>
    </div>
  </div><!-- /.row -->
</template>

<script>
export default {
  props: {
    marketings: {
      type: Array,
      required: true
    },

    hasDelete: {
      type: Boolean,
      default: false
    }
  },

  data() {
    return {
      trans: JSON.parse(CurrentTenant.translations),
    };
  },

  watch: {
    marketings: function (val) {
      this.$emit('update:marketings', val)
    }
  },

  methods: {
    deleteMarketing(id, marketing) {
      if (confirm(this.trans.app.are_you_sure)) {
        this.deleteMedia(marketing[id].thumbnail).then((response) => {
          return marketing.splice(id, 1)
        })
      }
    }
  }
}
</script>

<style>

</style>