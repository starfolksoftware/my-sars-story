<template>
  <div class="col-md-4 mb-5">
    <div class="img img-center mb-3 container-fluid">
      <img :src="service.thumbnail" class="rounded mx-auto d-block img-fluid" alt="...">
    </div>
    <div class="info">
      <h6 class="text-uppercase text-xl font-weight-700">
        {{ service.name }}
      </h6>
      <p class="lead opacity-8" v-html="service.description"></p>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    service: {
      type: Object,
      required: true
    }
  },
}
</script>

<style>

</style>