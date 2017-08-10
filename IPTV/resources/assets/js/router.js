import VueRouter    from 'vue-router'

//Define route components
const Home = { template: '<div>home</div>' }
const Foo = { template: '<div>Foo</div>' }
const Bar = { template: '<div>Bar</div>' }

// lazy load components
const Example = (resolve) => require(['./components/Example.vue'], resolve)
const channels = (resolve) => require(['./components/channels.vue'], resolve)

export default new VueRouter({
    mode: 'history',
    base: __dirname,
	routes: [
		{ path: '/', component: Example },
		{ path: '/channels', component: channels},
	]
});
