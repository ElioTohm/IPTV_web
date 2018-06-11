
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * We will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */
import VueRouter  from 'vue-router'
import router     from './router'
import Toasted from 'vue-toasted'
import VModal from 'vue-js-modal'

Vue.use(VModal)
Vue.use(Toasted)
Vue.use(VueRouter)

// always load XmsPlayer
import MonitorComponent from './components/monitor.vue'
import Messaging from './components/messaging.vue'

// Create and mount root instance.
// Make sure to inject the router.
// Route components will be rendered inside <router-view>.
new Vue({
  components: {
    "monitor": MonitorComponent,
    "messaging" : Messaging
  },
  router,
}).$mount('#app')
