<template>
	<div>
		<h3>Pré-cadastrar usuário</h3>
		<div v-if="error">{{ error }}</div>
		<form @submit.prevent="createUser">
			Nome<br>
			<input class="form-control" v-model="name" type="text">

			Área<br>
			<input class="form-control" v-model="area" type="number">

			DDD<br>
			<input class="form-control" v-model="ddd" type="number">

			Número<br>
			<input class="form-control" v-model="number" type="number">
			<input class="btn btn-primary" type="submit" value="Pré-Cadastrar">
		</form>

		<h3>Usuários pré-cadastrados</h3>
		<div v-for="user in preRegistredUsers">
			<h5>{{ user.name }}</h5>
			<h6>{{ user.activation_code | activation_code }}</h6>
			<div>{{ user.area }} {{ user.ddd }} {{ user.number }}</div>
		</div>
	</div>
</template>
<script>
	export default {
		props: ['do'],

		created () {
			this.getUser();
		},

		data () {
			return {
				error: '',
				name: '',
				area: 55,
				ddd: '',
				number: '',
				preRegistredUsers: [],
			}
		},

		methods: {
			createUser () {
				let data = new FormData();

				data.append('name', this.name)
				data.append('area', this.area)
				data.append('ddd', this.ddd)
				data.append('number', this.number)

				this.error = '';
				this.do.createUser(data, (body) => {
					if (body.error) {
						this.error = body.error;
					} else {
						this.getUser();
					}
				});
			},

			getUser () {
				let data = {
					type: 'pre registred',
				}

				this.error = '';
				this.do.getUser(data, (body) => {
					if (body.error) {
						this.error = body.error;
					} else {
						this.preRegistredUsers = body;
					}
				});
			},
		},

		filters: {
			activation_code (input) {
				return input.replace(/(.{4})(.{4})/, '$1-$2');
			}
		},
	}
</script>