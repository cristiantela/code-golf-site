import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import App from './App.vue'

import Home from './page/home.vue'
import About from './page/about.vue'
import NotFound from './page/not-found.vue'

const routes = [
 	{
 		path: '/',
 		component: Home
 	}, {
 		path: '/about',
 		component: About
 	}, {
 		path: '*',
 		component: NotFound,
 	}
]

const router = new VueRouter({
  routes
})

new Vue({
	router,
	el: '#app',
	render: h => h(App)
})
