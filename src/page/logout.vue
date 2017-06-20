<template>
	<div>
		<div v-if="error">{{ error }}</div>
		Saindo...
	</div>
</template>

<script>
	export default {
		props: ['do'],

		created () {
			this.error = '';
			this.do.logout(body => {
				if (body.error) {
					this.error = body.error;
				} else {
					localStorage.removeItem('cgs-token');
					this.do.navbar();
					this.$router.push('/');
				}
			})
		},

		data () {
			return {
				error: '',
			}
		},
	}
</script>