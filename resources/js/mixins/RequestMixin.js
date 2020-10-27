import axios from 'axios'

export default {
  methods: {
    getToken() {
      return document.head.querySelector('meta[name="csrf-token"]').content
    },

    request() {
      let instance = axios.create()

      instance.defaults.headers.common['X-CSRF-TOKEN'] = this.getToken()
      instance.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
      instance.defaults.baseURL = '/'

      const requestHandler = request => {
        // Add any request modifiers...
        return request
      }

      const errorHandler = error => {
        // Add any error modifiers...
        switch (error.response.status) {
          case 405:
          case 401:
            this.logout()
          case 419:
            window.location.replace("/");
            break
          default:
            break
        }

        return Promise.reject({ ...error })
      }

      const successHandler = response => {
        // Add any response modifiers...
        return response
      }

      instance.interceptors.request.use(request =>
        requestHandler(request)
      )

      instance.interceptors.response.use(
        response => successHandler(response),
        error => errorHandler(error)
      )

      return instance
    },

    logout() {
      // let instance = axios.create()

      // instance.defaults.headers.common['X-CSRF-TOKEN'] = this.getToken()
      // instance.defaults.baseURL = '/'

      // instance.post('/logout').then(response => {
      //     window.location.href = '/login'
      // }).catch((error) => {
      //     alert(error)
      //     console.log('error', error)
      // })


      let logoutForm = document.createElement('Form')
      logoutForm.id = 'logout-form'
      logoutForm.action = '/logout'
      logoutForm.method = 'POST'

      let tokenField = document.createElement('input')
      tokenField.value = this.getToken()
      tokenField.name = '_token'

      logoutForm.appendChild(tokenField)

      document.body.appendChild(logoutForm);

      logoutForm.submit()

      logoutForm.removeEventListener("submit", l.close, false);
    }
  },
}
