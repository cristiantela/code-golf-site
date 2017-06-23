<template>
	<div>
		<div v-if="error">{{ error }}</div>

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

			<button type="submit" class="btn btn-success">
				Submeter
			</button>
		</div>
	</div>
</template>

<script>
	export default {
		props: ['do'],

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
		},
	}
</script>