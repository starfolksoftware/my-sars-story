<template>
  <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
    <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
      <li class="breadcrumb-item">
        <router-link to="/admin">
          <i class="fas fa-home"></i>
        </router-link>
      </li>
      <li v-for="(link, index) in allLinks" :key="index" class="breadcrumb-item">
        <router-link :to="link.url" :class="{'active': index == links.length}">
          {{ link.title }}
        </router-link>
      </li>
    </ol>
  </nav>
</template>

<script>
export default {
  props: {
    links: {
      type: Array,
      required: true
    }
  },

  data() {
    return {
      allLinks: []
    }
  },

  created() {
    this.allLinks = this.links
  }
}
</script>

<style>

</style>