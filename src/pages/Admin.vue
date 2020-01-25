<template>
	<div class="pg-admin">
		<div id="users" class="section" v-if="user.access.su == true">
			<h2 class="title text-important">Gestione Account</h2>
			<div class="row h-flex center">
				<div class="input-field col s12 l4">
					<div class="input-field col s12">
						<i class="material-icons prefix">person</i>
						<input type="text" id="autocomplete-input" class="autocomplete">
						<label for="autocomplete-input">Autocomplete</label>
					</div>
				</div>
				<div class="col s12 l8">
					<div v-for="(el, index) in ['VIEW', 'CREATE', 'EDIT', 'DELETE', 'ADMIN']" :key="index" class="switch col">
						<label>
							<input type="checkbox">
							<span class="lever"></span>
							{{el}}
						</label>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col s12 l6">
					<div class="chips"></div>
				</div>
				<div class="col s6 l3">
					<form action="#">
						<div class="file-field input-field">
							<div class="btn bkg-main">
								<span>Picture</span>
								<input type="file">
							</div>
							<div class="file-path-wrapper">
								<input class="file-path validate" type="text">
							</div>
						</div>
					</form>
				</div>
				<div class="col s6 l3">
					<form action="#">
						<div class="file-field input-field">
							<div class="btn bkg-main">
								<span>Curriculum</span>
								<input type="file">
							</div>
							<div class="file-path-wrapper">
								<input class="file-path validate" type="text">
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="row">
				<div class="input-field col s6 l3">
					<i class="material-icons prefix">account_circle</i>
          <input id="name" type="text" class="validate">
          <label for="name">First Name</label>
        </div>
				<div class="input-field col s6 l4">
          <input id="surname" type="text" class="validate">
          <label for="surname">Last Name</label>
        </div>
				<div class="input-field col s8 l4">
					<i class="material-icons prefix">mail</i>
          <input id="email" type="email" class="validate">
          <label for="email">Email</label>
        </div>
				<div class="col s4 l1">
					<button class="btn btn-large bkg-main">
						<i class="material-icons">lock</i>
					</button>
				</div>
			</div>
			<div class="row">
				<div class="col s12">
					<div class="col"><button class="btn btn-large bkg-main">NEW</button></div>
					<div class="col"><button class="btn btn-large bkg-main">EDIT</button></div>
					<div class="col"><button class="btn btn-large bkg-main">DELETE</button></div>
				</div>
			</div>
		</div>
		<div id="articles" class="section" v-if="user.access.su == true">
			<h2 class="title text-important">Gestione Articoli</h2>
		</div>
	</div>
</template>

<script>
import { mapGetters } from 'vuex'

// import { mapGetters, mapActions } from 'vuex'

export default {
	computed: {
		...mapGetters('user', { _user: 'get'}),
		user() {
			return { access: { 'su': true }} // this._user()
		}
	},
	mounted() {
		let elems = this.$el.querySelectorAll('select')
		M.FormSelect.init(elems, {})
		elems = this.$el.querySelectorAll('.chips')
		M.Chips.init(elems, { placeholder: 'Roles' })
		/* if (!this.user || this.user.access.v == false) {
			this.$router.push('/!')
		} */
	}
}
</script>