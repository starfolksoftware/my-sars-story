import Vue from 'vue'
import Routes from './routes'
import { store } from './store'
import NProgress from 'nprogress'
import { library } from '@fortawesome/fontawesome-svg-core'
import { fab } from '@fortawesome/free-brands-svg-icons'
import { fas } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import VueRouter from 'vue-router'
import moment from 'moment-timezone'
import ComponentMixin from "./mixins/ComponentMixin"
import HelperMixin from "./mixins/HelperMixin"
import RequestMixin from "./mixins/RequestMixin"
import MetaMixin from "./mixins/MetaMixin"
import VueHolder from 'vue-holderjs'
import Permission from './directives/Permission'

// https://ckeditor.com/blog/best-wysiwyg-editor-for-vue/
import CKEditor from '@ckeditor/ckeditor5-vue';

/** Core */
window.$ = require('jquery')
require('bootstrap')
window.Popper = require('popper.js').default

/**
* Vendor JS
**/
window.Cookies = require('./argon/js-cookie/js.cookie.js')
require('./argon/argon.min.js')

Vue.mixin(ComponentMixin)
Vue.mixin(HelperMixin)
Vue.mixin(RequestMixin)
Vue.mixin(MetaMixin)

library.add(fab, fas);
Vue.component('font-awesome-icon', FontAwesomeIcon);

Vue.directive('permission', Permission)

// Set the default timezone
moment.tz.setDefault(CurrentTenant.timezone)

// Prevent the production tip on Vue startup
Vue.config.productionTip = false

Vue.use(VueRouter)
Vue.use(VueHolder)
Vue.use(CKEditor)

const router = new VueRouter({
  routes: Routes,
  mode: 'history',
  base: CurrentTenant.path,
  scrollBehavior (to, from, savedPosition) {
    return { x: 0, y: 0 }
  },
})

NProgress.configure({
  showSpinner: false,
  easing: 'ease',
  speed: 300,
})

router.beforeEach((to, from, next) => {
  NProgress.start()
  next()
})

const app = new Vue({
  el: '#app',
  router,
  store,

  data: {
    avatar: CurrentTenant.avatar
  },

  mounted () {
    this.$root.$on('updateAvatar', this.updateAvatar)
  },

  methods: {
    updateAvatar (url) {
      this.$root.avatar = url
    }
  }
})

// Give the store access to the root Vue instance
store.$app = app
