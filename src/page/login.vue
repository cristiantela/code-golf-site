<template>
	<div>
		<h4>Entrar</h4>
		<div>
			Se você ainda não tem uma conta, <router-link to="signup">cadastre-se aqui</router-link>
		</div>
		<div v-if="error">{{ error }}</div>
		<form @submit.prevent="login">
			Nome de usuário
			<input class="form-control" v-model="username" type="text">
			Senha
			<input class="form-control" v-model="password" type="password">
			<input class="btn btn-primary" type="submit">
		</form>
	</div>
</template>

<script>
	export default {
		props: ['do'],

		created () {
		},

		data () {
			return {
				error: '',
				username: '',
				password: '',
			}
		},

		methods: {
			login () {
				let data = new FormData();

				data.append('username', this.username)
				data.append('password', this.password)

				this.error = '';
				this.do.login(data, (body) => {
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