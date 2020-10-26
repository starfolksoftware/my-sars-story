import moment from 'moment'

export const getters = {
  activePost(state) {
    return state.activePost
  },

  activeDataset(state) {
    return state.activeDataset
  },

  activeProduct(state) {
    return state.activeProduct
  },

  isDraft(state) {
    let submittedAt = state.submittedAt
    let approvedAt = state.approvedAt
    let publishedAt = state.publishedAt

    return (
      (publishedAt === null ||
        publishedAt === '' ||
        moment(publishedAt).isAfter(
          moment(new Date())
            .format()
            .slice(0, 19)
            .replace('T', ' ')
        )) && submittedAt === null &&
      approvedAt === null
    )
  },

  isApproved(state) {
    let submittedAt = state.submittedAt
    let approvedAt = state.approvedAt
    let publishedAt = state.publishedAt

    return (
      (moment(submittedAt).isBefore(
        moment(new Date())
          .format()
          .slice(0, 19)
          .replace('T', ' ')
      ) || moment(submittedAt).isSame(
        moment(new Date())
          .format()
          .slice(0, 19)
          .replace('T', ' ')
      )) && (moment(approvedAt).isBefore(
        moment(new Date())
          .format()
          .slice(0, 19)
          .replace('T', ' ')
      ) || moment(approvedAt).isSame(
        moment(new Date())
          .format()
          .slice(0, 19)
          .replace('T', ' ')
      )) && publishedAt === null
    )
  },

  isSubmitted(state) {
    let submittedAt = state.submittedAt
    let approvedAt = state.approvedAt
    let publishedAt = state.publishedAt

    return (
      (moment(submittedAt).isBefore(
        moment(new Date())
          .format()
          .slice(0, 19)
          .replace('T', ' ')
      ) || moment(submittedAt).isSame(
        moment(new Date())
          .format()
          .slice(0, 19)
          .replace('T', ' ')
      )) && approvedAt === null && publishedAt === null
    )
  },

  isPublished(state) {
    let submittedAt = state.submittedAt
    let approvedAt = state.approvedAt
    let publishedAt = state.publishedAt

    return (
      (moment(submittedAt).isBefore(
        moment(new Date())
          .format()
          .slice(0, 19)
          .replace('T', ' ')
      ) || moment(submittedAt).isSame(
        moment(new Date())
          .format()
          .slice(0, 19)
          .replace('T', ' ')
      )) && (moment(approvedAt).isBefore(
        moment(new Date())
          .format()
          .slice(0, 19)
          .replace('T', ' ')
      ) || moment(approvedAt).isSame(
        moment(new Date())
          .format()
          .slice(0, 19)
          .replace('T', ' ')
      )) && (moment(publishedAt).isBefore(
        moment(new Date())
          .format()
          .slice(0, 19)
          .replace('T', ' ')
      ) || moment(publishedAt).isSame(
        moment(new Date())
          .format()
          .slice(0, 19)
          .replace('T', ' ')
      ))
    )
  }
}

export default {
  getters,
}
