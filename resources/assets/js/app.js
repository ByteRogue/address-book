
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import VueRouter from 'vue-router'
import Vuex from 'vuex'

import App from './App'
import routes from './routes'
import store from './store'
import swal from 'sweetalert2'
import VeeValidate from 'vee-validate'

Vue.use(VueRouter)
Vue.use(VeeValidate);

Vue.component('submit-button', require('./components/SubmitButton'))





// Request interceptor
axios.interceptors.request.use(request => {
  const token = store.getters['auth/token']
  if (token) {
    request.headers.common['Authorization'] = `Bearer ${token}`
  }

  return request
})

// Response interceptor
axios.interceptors.response.use(response => response, error => {
  const { status } = error.response

  if (status >= 500) {
    swal({
      type: 'error',
      title: 'Error',
      text: 'Something went wrong',
      reverseButtons: true,
      confirmButtonText: 'ok',
      cancelButtonText: 'cancel'
    })
  }

  if (status === 403) {
    swal({
      type: 'error',
      title: 'Error',
      text: 'Forbidden Access',
    })
  }
  if (status === 401 && store.getters['auth/check']) {
    swal({
      type: 'warning',
      title: 'Token expired',
      text: 'Your token has been expired please log back in',
      reverseButtons: true,
      confirmButtonText: 'ok',
      cancelButtonText: 'cancel'
    }).then(() => {
      store.commit('auth/logout')

      router.push('/login' )
    })
  }

  return Promise.reject(error)
})



let router = new VueRouter({
  routes,
  mode: 'history'
})

async function checkAuth (to, from, next) {
  if (!store.getters['auth/check'] && store.getters['auth/token']) {
    try {
      await store.dispatch('auth/fetchUser')
    } catch (e) { }
  }
  next()
}

router.beforeEach(checkAuth)

Vue.prototype.isAdmin = () => {
  return store.getters['auth/check'] && store.getters['auth/user'].role == 'admin'
}

const app = new Vue({
  el: '#app',
  router ,
  store,
  render: h => h(App)
});
