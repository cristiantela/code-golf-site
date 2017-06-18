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

		data () {
			return {
				Store: {
					user: null,
				},
				Action: this.$resource('someItem{/id}', {}, {
					getUser: {
						method: 'GET',
						url: 'user.php',
					},
					createSession: {
						method: 'POST',
						url: 'session.php',
					}
				}),
				do: {
					login: (data, callback) => {
						this.Action.createSession(data).then(response => {
							let body = response.body;

							if (callback) {
								callback(body);
							}
						});
					}
				}
			}
		},

		methods: {},
	}
</script>

<style src="../node_modules/bootstrap/dist/css/bootstrap.css"></style>

<style scoped>
</style>