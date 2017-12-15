import VueRouter    from 'vue-router'

//Define route components
const Home = { template: '<div>home</div>' }
const Foo = { template: '<div>Foo</div>' }
const Bar = { template: '<div>Bar</div>' }

// lazy load components
const channels = (resolve) => require(['./components/channels.vue'], resolve)
const movies = (resolve)  => require(['./components/movies.vue'], resolve)

export default new VueRouter({
    mode: 'history',
    base: __dirname,
	routes: [
		{ path: '/channels', component: channels},
		{ path: '/movies', component: movies}
	]
});
