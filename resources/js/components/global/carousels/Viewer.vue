<template>
  <div>
    <vue-flux
      :options="vfOptions"
      :images="vfImages"
      :transitions="vfTransitions"
      :captions="vfCaptions"
      ref="slider"
    >
      <template v-slot:preloader>
        <flux-preloader />
      </template>

      <template v-slot:caption>
        <flux-caption />
      </template>

      <template v-slot:controls>
        <flux-controls />
      </template>

      <template v-slot:pagination>
        <flux-pagination />
      </template>

      <template v-slot:index>
        <flux-index />
      </template>
    </vue-flux>

    <!-- <button @click="$refs.slider.show('next')">NEXT</button> -->
  </div>
</template>

<script>
import {
  VueFlux,
  FluxCaption,
  FluxControls,
  FluxIndex,
  FluxPagination,
  FluxPreloader,
} from "vue-flux";

export default {
  name: "Viewer",

  props: {
    images: {
      type: Array,
      required: true,
    },
    captions: {
      type: Array,
      required: true,
    }
  },

  components: {
    VueFlux,
    FluxCaption,
    FluxControls,
    FluxIndex,
    FluxPagination,
    FluxPreloader,
  },

  data: () => ({
    vfOptions: {
      autoplay: true,
    },
    vfTransitions: ["fade", "cube", "book", "wave"]
  }),

  computed: {
    vfImages() {
      return this.images
    },

    vfCaptions() {
      return this.captions
    }
  }
};
</script>

<style></style>
