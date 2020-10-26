<template>
  <div class="row">
    <div 
      class="col-lg-4"
      v-for="(feature, index) in features" 
      :key="index">
      <img 
        v-if="feature.thumbnail"
        height="140" 
        width="140" 
        :src="feature.thumbnail" 
        class="bd-placeholder-img rounded-circle rounded" 
        alt="...">
      <svg 
        v-else
        class="bd-placeholder-img rounded-circle" 
        width="140" 
        height="140" 
        xmlns="http://www.w3.org/2000/svg" 
        preserveAspectRatio="xMidYMid slice" 
        focusable="false" 
        role="img" 
        aria-label="Placeholder: 140x140">
        <title>Placeholder</title>
        <rect width="100%" height="100%" fill="#777"/>
        <text x="50%" y="50%" fill="#777" dy=".3em">140x140</text>
      </svg>
      <h2>{{ feature.title }}</h2>
      <p v-html="feature.description"></p>
      <p>
        <button
          v-if="hasDelete"
          type="button"
          class="btn btn-danger"
          @click="features = deleteFeature(index, features)">
          {{ trans.app.delete }}
        </button>
      </p>
    </div><!-- /.col-lg-4 -->
  </div><!-- /.row -->
</template>

<script>
export default {
  props: {
    features: {
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
    }
  },

  watch: {
    features: function (val) {
      this.$emit('update:features', val)
    }
  },

  methods: {
    deleteFeature(id, features) {
      if (confirm(this.trans.app.are_you_sure)) {
        this.deleteMedia(features[id].thumbnail)
        return features.splice(id, 1)
      }
    },
  }
}
</script>

<style>

</style>