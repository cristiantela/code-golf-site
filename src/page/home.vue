<template>
	<div>
		<div v-if="error">{{ error }}</div>

		<form @submit.prevent="updateCode">
			<modal title="Submeter">
				<div slot="body" class="modal-body">
					Linguagem
					<select class="form-control">
						<option>JavaScript</option>
					</select>

					Código<br>
					<textarea @keydown="onInput" rows="10" class="form-control" v-model="description"></textarea>
				</div>
				<div slot="footer" class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
					<button type="submit" class="btn btn-primary">
						Submeter
					</button>
				</div>
			</modal>
		</form>

		<div v-if="challenge">
			<h2>
				<router-link :to="'challenge/' + challenge.id">
					{{ challenge.title }}
				</router-link>
			</h2>
			<p>{{ challenge.description }}</p>
			<div>
				{{ challenge.start }}
				—
				{{ challenge.finish }}
			</div>

			<button @click="openModal" type="button" class="btn btn-success">
				Submeter
			</button>
		</div>
	</div>
</template>

<script>

	import Modal from '../component/modal.vue'

	export default {
		props: ['do'],

		components: {
			'modal': Modal,
		},

		created () {
			this.getChallenge();
		},

		data () {
			return {
				error: '',
				challenge: null,
			}
		},

		methods: {
			getChallenge () {
				this.error = '';
				this.do.getChallenge(null, (body) => {
					if (body.error) {
						this.error = body.error;
					} else {
						this.challenge = body;
					}
				});
			},

			updateCode () {

			},

			openModal (modal) {
				this.activeModal = modal;
				$('#myModal').modal('show')
			},

			onInput (event) {
				console.log(event)
				if (event.key === 'Tab') {
					event.preventDefault()
					return false;
				}
			},
		},
	}
</script>