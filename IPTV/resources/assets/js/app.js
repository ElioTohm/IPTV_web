
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
import Toasted from 'vue-toasted';

Vue.use(Toasted)
Vue.use(VueRouter)

// lazy load components
const channels = (resolve) => require(['./components/channels.vue'], resolve)
const hotelclients = (resolve) => require(['./components/hotelclients.vue'], resolve)
const devices = (resolve) => require(['./components/devices.vue'], resolve)
const monitor = (resolve) => require(['./components/monitor.vue'], resolve) 
const androidapp = (resolve) => require(['./components/androidapp.vue'], resolve)
const movies = (resolve)  => require(['./components/movies.vue'], resolve)

// Create and mount root instance.
// Make sure to inject the router.
// Route components will be rendered inside <router-view>.
new Vue({
  router,
  components : {
    monitor,
    channels,
    hotelclients,
    devices,
    androidapp,
    movies,
  }
}).$mount('#app')
