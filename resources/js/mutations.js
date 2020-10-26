import _ from 'lodash'

export const mutations = {
  setActivePost(state, data) {
    let payload = {}

    payload.id = _.get(data, 'id', 'create')
    payload.title = _.get(data, 'title', '')
    payload.slug = _.get(data, 'slug', '')
    payload.summary = _.get(data, 'summary', '')
    payload.body = _.get(data, 'body', '')
    payload.submitted_at = _.get(data, 'submitted_at', '')
    payload.approved_at = _.get(data, 'approved_at', '')
    payload.editor_id = _.get(data, 'editor_id', '')
    payload.published_at = _.get(data, 'published_at', '')
    payload.featured_image = _.get(data, 'featured_image', '')
    payload.featured_image_caption = _.get(data, 'featured_image_caption', '')
    payload.user_id = _.get(data, 'user_id', '')

    payload.meta = {}
    payload.meta.description = _.get(data, 'meta.description', '')
    payload.meta.title = _.get(data, 'meta.title', '')
    payload.meta.canonical_link = _.get(data, 'meta.canonical_link', '')

    payload.topic = _.get(data, 'topic.0', [])
    payload.tags = _.get(data, 'tags', [])
    payload.errors = []
    payload.isSaving = false
    payload.hasSuccess = false

    state.activePost = payload
  },

  updatePostBody(state, data) {
    state.activePost.body = data
  },

  saveActivePost(state, payload) {
    this.$app
      .request()
      .post('/api/v1/posts/' + payload.id, payload.data)
      .then(response => {
        if (payload.id === 'create') {
          this.$app.$router.push({
            name: 'posts-edit',
            params: { id: response.data.id },
          })
        }

        state.activePost.isSaving = false
        state.activePost.hasSuccess = true
        state.activePost.post = response.data
      })
      .catch(error => {
        state.activePost.isSaving = false
        state.activePost.errors = error.response.data.errors
      })
  },

  setPostTags(state, tags) {
    state.activePost.tags = tags
  },

  setPostTopic(state, topic) {
    state.activePost.topic = topic
  },

  deletePost(state, postId) {
    this.$app
      .request()
      .delete('/api/v1/posts/' + postId)
      .then(response => {
        state.activePost = {}

        this.$app.$router.push({ name: 'posts' })
      })
      .catch(error => {
        // Add any error debugging...
      })
  },



  // for datasets
  setActiveDataset(state, data) {
    let payload = {}

    payload.id = _.get(data, 'id', 'create')
    payload.title = _.get(data, 'title', '')
    payload.description = _.get(data, 'description', '')
    payload.datalicense_id = _.get(data, 'datalicense_id', '')
    payload.submitted_at = _.get(data, 'submitted_at', '')
    payload.approved_at = _.get(data, 'approved_at', '')
    payload.approved_by = _.get(data, 'approved_by', '')
    payload.published_at = _.get(data, 'published_at', '')
    payload.user_id = _.get(data, 'user_id', '')

    payload.meta = {}
    payload.meta.description = _.get(data, 'meta.description', '')
    payload.meta.title = _.get(data, 'meta.title', '')
    payload.meta.canonical_link = _.get(data, 'meta.canonical_link', '')

    payload.topics = _.get(data, 'topics', [])
    payload.tags = _.get(data, 'tags', [])
    payload.resources = _.get(data, 'resources', [])
    payload.errors = []
    payload.isSaving = false
    payload.hasSuccess = false

    state.activeDataset = payload
  },

  saveActiveDataset(state, payload) {
    this.$app
      .request()
      .post('/api/v1/datasets/' + payload.id, payload.data)
      .then(response => {
        if (payload.id === 'create') {
          this.$app.$router.push({
            name: 'datasets-edit',
            params: { id: response.data.id },
          })
        }

        state.activeDataset.isSaving = false
        state.activeDataset.hasSuccess = true
        state.activeDataset.dataset = response.data
      })
      .catch(error => {
        state.activeDataset.isSaving = false
        state.activeDataset.errors = error.response.data.errors
      })
  },

  setDatasetTopics(state, topics) {
    state.activeDataset.topics = topics
  },

  setDatasetTags(state, tags) {
    state.activeDataset.tags = tags
  },

  deleteDataset(state, datasetId) {
    this.$app
      .request()
      .delete('/api/v1/datasets/' + datasetId)
      .then(response => {
        state.activeDataset = {}

        this.$app.$router.push({ name: 'datasets' })
      })
      .catch(error => {
        // Add any error debugging...
      })
  },

  // for products
  setActiveProduct(state, data) {
    let payload = {}

    payload.id = _.get(data, 'id', 'create')
    payload.name = _.get(data, 'name', '')
    payload.description = _.get(data, 'description', '')

    payload.marketing = _.get(data, 'marketing', [])
    payload.features = _.get(data, 'features', [])
    payload.logo = _.get(data, 'logo', '')
    payload.external_link = _.get(data, 'external_link', '')

    payload.submitted_at = _.get(data, 'submitted_at', '')
    payload.approved_at = _.get(data, 'approved_at', '')
    payload.approved_by = _.get(data, 'approved_by', '')
    payload.published_at = _.get(data, 'published_at', '')
    payload.user_id = _.get(data, 'user_id', '')
    
    payload.errors = []
    payload.isSaving = false
    payload.hasSuccess = false

    state.activeProduct = payload
  },

  saveActiveProduct(state, payload) {
    if (payload.id === 'create') payload.data.id = ''
    this.$app
      .request()
      .post('/api/v1/products/' + payload.id, payload.data)
      .then(response => {
        if (payload.id === 'create') {
          this.$app.$router.push({
            name: 'products-edit',
            params: { id: response.data.id },
          })
        }

        state.activeProduct.isSaving = false
        state.activeProduct.hasSuccess = true
        state.activeProduct.dataset = response.data
      })
      .catch(error => {
        state.activeProduct.isSaving = false
        state.activeProduct.errors = error.response.data.errors
      })
  },

  deleteProduct(state, productId) {
    this.$app
      .request()
      .delete('/api/v1/products/' + productId)
      .then(response => {
        state.activeProduct = {}

        this.$app.$router.push({ name: 'products' })
      })
      .catch(error => {
        // Add any error debugging...
      })
  },

  setSubmittedAt(state, submittedAt) {
    state.submittedAt = submittedAt
  },

  setApprovedAt(state, approvedAt) {
    state.approvedAt = approvedAt
  },

  setPublishedAt(state, publishedAt) {
    state.publishedAt = publishedAt
  }
}

export default {
  mutations,
}
