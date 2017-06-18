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
import Login from './page/login.vue'
import NotFound from './page/not-found.vue'

const routes = [
 	{
 		path: '/',
 		component: Home
 	}, {
 		path: '/about',
 		component: About
 	}, {
 		path: '/login',
 		component: Login,
 	}, {
 		path: '*',
 		component: NotFound,
 	}
]

const router = new VueRouter({
  routes
})

Vue.http.options.root = 'api';
Vue.http.interceptors.push(function(request, next) {
	let token = localStorage.getItem('cgs-token');
	if (token) {
		request.headers.set('Authorization', token)
	}
	next();
});

new Vue({
	router,
	el: '#app',
	render: h => h(App)
})

window.$ = $;
window.jQuery = jQuery;