import vueHeadful from "vue-headful"

export default {
  components: {
    vueHeadful
  },
  
  data() {
    return {
      metaTitle: window.CurrentTenant.platform.name,
      metaDescription: window.CurrentTenant.platform.description,
      metaUrl: `https://${window.CurrentTenant.platform.name}${this.$route.fullPath}`,
      metaImageUrl: '',
    }
  },

  methods: {
    setMetaTitle(title) {
      this.metaTitle = title
    },

    setMetaDescription(description) {
      this.metaDescription = description
    },

    setMetaUrl(metaUrl) {
      this.metaUrl = metaUrl
    },

    setMetaImageUrl(metaImageUrl) {
      this.metaImageUrl = `https://${window.CurrentTenant.platform.name}${metaImageUrl}`
    }
  }

}