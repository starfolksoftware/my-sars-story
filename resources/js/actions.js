export const actions = {
  setActivePost(context, payload) {
    context.commit('setActivePost', payload)
  },

  updatePostBody(context, body) {
    context.commit('updatePostBody', body)
  },

  saveActivePost(context, payload) {
    context.commit('saveActivePost', payload)
  },

  setPostTags(context, payload) {
    context.commit('setPostTags', payload)
  },

  setPostPlatforms(context, payload) {
    context.commit('setPostPlatforms', payload)
  },

  setPostTopic(context, payload) {
    context.commit('setPostTopic', payload)
  },

  deletePost(context, payload) {
    context.commit('deletePost', payload)
  },

  setSubmittedAt(context, payload) {
    context.commit('setSubmittedAt', payload)
  },

  setApprovedAt(context, payload) {
    context.commit('setApprovedAt', payload)
  },

  setPublishedAt(context, payload) {
    context.commit('setPublishedAt', payload)
  },

  // for dataset
  setActiveDataset(context, payload) {
    context.commit('setActiveDataset', payload)
  },

  saveActiveDataset(context, payload) {
    context.commit('saveActiveDataset', payload)
  },

  setDatasetTopics(context, payload) {
    context.commit('setDatasetTopics', payload)
  },

  setDatasetTags(context, payload) {
    context.commit('setDatasetTags', payload)
  },

  deleteDataset(context, payload) {
    context.commit('deleteDataset', payload)
  },

  // for product
  setActiveProduct(context, payload) {
    context.commit('setActiveProduct', payload)
  },

  saveActiveProduct(context, payload) {
    context.commit('saveActiveProduct', payload)
  },

  deleteProduct(context, payload) {
    context.commit('deleteProduct', payload)
  },
}

export default {
  actions,
}
