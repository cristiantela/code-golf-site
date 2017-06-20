<template>
	<div id="app">
		<navbar
			:Store="Store"
			:do="this.do"
		/>
		<router-view class="container" :do="this.do"></router-view>
	</div>
</template>

<script>
	import Navbar from './layout/navbar.vue'

	export default {
		name: 'app',

		components: {
			'navbar': Navbar,
		},

		created () {
			this.do.navbar();
		},

		data () {
			return {
				Store: {
					user: null,
				},
				Action: this.$resource('someItem{/id}', {}, {
					createUser: {
						method: 'POST',
						url: 'user.php',
					},
					getUser: {
						method: 'GET',
						url: 'user.php',
					},
					createCredential: {
						method: 'POST',
						url: 'credential.php',
					},
					createSession: {
						method: 'POST',
						url: 'session.php',
					},
					deleteSession: {
						method: 'DELETE',
						url: 'session.php',
					},
				}),
				do: {
					navbar: () => {
						this.Store.user = 'loading';

						this.Action.getUser().then(response => {
							let body = response.body;

							if (body.error) {
								this.Store.user = null;
							} else {
								this.Store.user = body;
							}
						});
					},

					login: (data, callback) => {
						this.Action.createSession(data).then(response => {
							let body = response.body;

							if (callback) {
								callback(body);
							}
						});
					},

					signup: (data, callback) => {
						this.Action.createCredential(data).then(response => {
							let body = response.body;

							if (callback) {
								callback(body);
							}
						});
					},

					logout: (callback) => {
						this.Action.deleteSession().then(response => {
							let body = response.body;

							if (callback) {
								callback(body);
							}
						})
					},

					createUser: (data, callback) => {
						this.Action.createUser(data).then(response => {
							let body = response.body;

							if (callback) {
								callback(body);
							}
						});
					},

					getUser: (data, callback) => {
						this.Action.getUser(data).then(response => {
							let body = response.body;

							if (callback) {
								callback(body);
							}
						});
					},
				}
			}
		},

		methods: {},
	}
</script>

<style src="../node_modules/bootstrap/dist/css/bootstrap.css"></style>

<style scoped>
</style>