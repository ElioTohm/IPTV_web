import VueRouter    from 'vue-router'

// lazy load components
const channels = (resolve) => require(['./components/channels.vue'], resolve)
const hotelclients = (resolve) => require(['./components/hotelclients.vue'], resolve)
const devices = (resolve) => require(['./components/devices.vue'], resolve)
const monitor = (resolve) => require(['./components/monitor.vue'], resolve) 
const androidapp = (resolve) => require(['./components/androidapp.vue'], resolve)
const movies = (resolve)  => require(['./components/movies.vue'], resolve)
const sections = (resolve) => require(['./components/sections.vue'], resolve)

export default new VueRouter({
    mode: 'history',
    base: __dirname,
	routes: [
		{ path: '/channelindex', component: channels},
		{ path: '/deviceindex', component: devices},
		{ path: '/hotelclientindex', component: hotelclients},
		{ path: '/movieindex', component: movies},
		{ path: '/adminindex', component: androidapp},
		{ path: '/sectionsindex', component: sections}
	]
});
