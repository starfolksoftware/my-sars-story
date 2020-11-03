<template>
  <carousel-3d>
    <slide v-for="(image, index) in images" :key="index" :index=index>
      <img :src="image" class="img-fluid">
    </slide>
  </carousel-3d>
</template>

<script>
import { Carousel3d, Slide } from 'vue-carousel-3d'

export default {
  name: "Slider",

  props: {
    images: {
      type: Array,
      required: true,
    }
  },

  components: {
    Carousel3d,
    Slide,
  }
}
</script>

<style>

</style>