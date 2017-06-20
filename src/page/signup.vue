<template>
	<div>
		<h3>Cadastrar</h3>
		<div v-if="error">{{ error }}</div>
		<form @submit.prevent="signup">
			<masked-input class="form-control" v-model="activation_code" :mask="[/[0-9A-Za-z]/, /[0-9A-Za-z]/, /[0-9A-Za-z]/, /[0-9A-Za-z]/, '-', /[0-9A-Za-z]/, /[0-9A-Za-z]/, /[0-9A-Za-z]/, /[0-9A-Za-z]/]" :guide="true"/>
			<input class="form-control" v-model="username" type="text">
			<input class="form-control" v-model="password" type="password">
			<input class="btn btn-primary" type="submit" value="Cadastrar">
		</form>
	</div>
</template>

<script>
	export default {
		props: ['do'],

		data () {
			return {
				error: '',
				activation_code: '',
				username: '',
				password: '',
			}
		},

		methods: {
			signup () {
				let data = new FormData();

				data.append('activation_code', this.activation_code.replace('-', ''))
				data.append('username', this.username)
				data.append('password', this.password)

				this.error = '';
				this.do.signup(data, (body) => {
					if (body.error) {
						this.error = body.error;
					} else {
						localStorage.setItem('cgs-token', body.token);
						this.do.navbar();
						this.$router.push('/');
					}
				});
			},
		},
	}
</script>