
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

Vue.use(VueRouter)

// lazy load components
const Example = (resolve) => require(['./components/Example.vue'], resolve)
const channels = (resolve) => require(['./components/channels.vue'], resolve)
const clients = (resolve) => require(['./components/passport/Clients.vue'], resolve)
const authorizedclients = (resolve) => require(['./components/passport/AuthorizedClients.vue'], resolve)
const personalaccesstokens = (resolve) => require(['./components/passport/PersonalAccessTokens.vue'], resolve)


// Create and mount root instance.
// Make sure to inject the router.
// Route components will be rendered inside <router-view>.
new Vue({

  router,

  components : {
    clients,
    authorizedclients,
    personalaccesstokens,
    channels
  },

  data : {

  }
 
}).$mount('#app')
