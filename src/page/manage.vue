<template>
	<div>
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" @click="openModal('create-user')">
			Pré-cadastrar
		</button>
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" @click="openModal('create-challenge')">
			Adicionar desafio
		</button>

		<form @submit.prevent="tigger">
			<modal :title="modalContent[activeModal] && modalContent[activeModal].title">
				<div v-if="activeModal == 'create-user'" slot="body" class="modal-body">
					<div v-if="error">{{ error }}</div>
					Nome<br>
					<input class="form-control" v-model="name" type="text">

					Área<br>
					<input class="form-control" v-model="area" type="number">

					DDD<br>
					<input class="form-control" v-model="ddd" type="number">

					Número<br>
					<input class="form-control" v-model="number" type="number">
				</div>

				<div v-if="activeModal == 'create-challenge'" slot="body" class="modal-body">
					<div v-if="error">{{ error }}</div>
					Título<br>
					<input class="form-control" v-model="title" type="text">

					Description<br>
					<textarea class="form-control" v-model="description"></textarea>

					Ínicio<br>
					<input class="form-control" v-model="start" type="text">

					Fim<br>
					<input class="form-control" v-model="finish" type="text">
				</div>
				<div slot="footer" class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
					<button type="submit" class="btn btn-primary">
						{{ modalContent[activeModal] && modalContent[activeModal].button }}
					</button>
				</div>
			</modal>
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
	import Modal from '../component/modal.vue';

	export default {
		props: ['do'],

		components: {
			'modal': Modal,
		},

		created () {
			this.getUser();
		},

		data () {
			return {
				modalContent: {
					'create-user': {
						title: 'Pré-cadastrar Usuário',
						button: 'Pré-Cadastrar',
					},
					'create-challenge': {
						title: 'Adicionar Desafio',
						button: 'Adicionar',
					},
				},
				activeModal: '',
				error: '',
				name: '',
				area: 55,
				ddd: '',
				number: '',
				preRegistredUsers: [],
				title: '',
				description: '',
				start: '',
				finish: '',
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

			createChallenge () {
				let data = new FormData();

				data.append('title', this.title)
				data.append('description', this.description)
				data.append('start', this.start)
				data.append('finish', this.finish)

				this.error = '';
				this.do.createChallenge(data, (body) => {
					if (body.error) {
						this.error = body.error;
					} else {
						console.log(body);
					}
				});
			},

			openModal (modal) {
				this.activeModal = modal;
				$('#myModal').modal('show')
			},

			tigger () {
				this.error = '';

				if (this.activeModal === 'create-user') {
					this.createUser();
				} else if (this.activeModal === 'create-challenge') {
					this.createChallenge();
				}
			},
		},

		filters: {
			activation_code (input) {
				return input.replace(/(.{4})(.{4})/, '$1-$2');
			}
		},
	}
</script>