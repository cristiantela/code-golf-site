<template>
	<div class="bg-faded">
		<nav class="container sticky-top navbar navbar-toggleable-md">
			<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<router-link class="navbar-brand" to="/">
				<img src="https://v4-alpha.getbootstrap.com/assets/brand/bootstrap-solid.svg" width="30" height="30" class="d-inline-block align-top" alt="">
				Code Golf
			</router-link>
			<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
				<div class="navbar-nav">
					<li v-if="Store.user && Store.user != 'loading'" class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#/" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							{{ Store.user.name }}
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
							<router-link class="dropdown-item" :to="'/user/' + Store.user.id">
								Perfil
							</router-link>
							<router-link class="dropdown-item" to="/logout">
								Sair
							</router-link>
						</div>
					</li>
					<li v-if="Store.user === null" class="nav-item">
						<router-link class="nav-link" to="/login">Entrar</router-link>
					</li>
					<li class="nav-item">
						<router-link class="nav-link" to="/about">Sobre</router-link>
					</li>
				</div>
			</div>
		</nav>
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

<style scoped>
	.navbar-toggler-icon {
		background-image: url("data:image/svg+xml;charset=utf8,<svg viewBox='0 0 32 32' xmlns='http://www.w3.org/2000/svg'><path stroke='rgba(0, 0, 0, 0.5)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 8h24M4 16h24M4 24h24'/></svg>");
	}
</style>