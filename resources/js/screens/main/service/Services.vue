<template>
  <div class="section features-1">
    <div class="container">
      <div class="row">
        <service v-for="(service, index) in services" :key="index" :service="service" />
      </div>
    </div>
  </div>
</template>

<script>
import Service from './Service'

export default {
  props: {
    services: {
      type: Array,
      required: true
    }
  },

  components: {
    Service
  }
}
</script>

<style>

</style>