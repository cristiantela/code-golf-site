import jQuery from 'jquery'
window.jQuery = window.$ = jQuery
import Tether from 'tether'
window.Tether = Tether
require('bootstrap')

import Vue from 'vue'
import VueRouter from 'vue-router'
import VueResource from 'vue-resource'

Vue.use(VueRouter)
Vue.use(VueResource)

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

Vue.http.options.root = 'api/static/logged-in-member';

new Vue({
	router,
	el: '#app',
	render: h => h(App)
})

window.$ = $;
window.jQuery = jQuery;