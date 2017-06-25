<template>
	<div>
		<div v-if="error">{{ error }}</div>

		<form @submit.prevent="updateCode">
			<modal title="Submeter">
				<div slot="body" class="modal-body">
					<div v-if="errorCode">{{ errorCode }}</div>

					Linguagem
					<select v-model="language" class="form-control">
						<option v-for="language in languages" :value="language.id">{{ language.name }}</option>
					</select>

					Código<br>
					<textarea v-model="content" @keydown="onInput" rows="10" class="form-control"></textarea>
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

			<button @click="openModal(challenge.id)" type="button" class="btn btn-success">
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
			this.getLanguage();
		},

		data () {
			return {
				error: '',
				errorCode: '',
				languages: [],
				challenge: null,
				language: '',
				content: '',
				challengeId: null,
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

			getLanguage () {
				this.do.getLanguage(null, (body) => {
					if (body.error) {

					} else {
						this.languages = body;
					}
				})
			},

			updateCode () {
				let data = new FormData();

				data.append('challenge', this.challengeId)
				data.append('language', this.language)
				data.append('content', this.content)
				
				this.errorCode = '';
				this.do.updateCode(data, (body) => {
					if (body.error) {
						this.errorCode = body.error;
					} else {
						console.log(body);
					}
				})
			},

			getCode () {
				this.do.getCode({ challenge: this.challengeId }, (body) => {
					if (body.error) {

					} else {
						this.language = body.language;
						this.content = body.content;
					}
				})
			},

			openModal (challengeId) {
				this.challengeId = challengeId;
				this.getCode();
				$('#myModal').modal('show')
			},

			onInput (event) {
				if (event.key === 'Tab') {
					event.preventDefault()
					return false;
				}
			},
		},
	}
</script>