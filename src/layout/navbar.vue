<template>
	<div class="row column">
		<div v-if="Store.user == null">Entrar</div>
		<div v-if="Store.user != null && Store.user != 'loading'">
			<div>{{ Store.user.name }}</div>
			Sair
		</div>
		{{ Store.user }}
		Navbar
	</div>
</template>

<script>
	export default {
		props: ['Store'],

		data () {
			return {}
		}
	}
</script>