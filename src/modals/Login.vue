<template>
  <div id="login-modal" class="md-login modal">
    <div class="modal-content">
      <h4>{{$t("login.title")}}</h4>
      <template v-if="!user()">
        <p class="flow-text">{{$t("login.intro")}}</p>
        <div class="row">
          <div class="input-field col s12">
            <i class="material-icons prefix">account_circle</i>
            <input id="login-username" v-model="username" type="text" class="validate">
            <label for="login-username">{{$t("login.username")}}</label>
          </div>
          <div class="input-field col s12">
            <i class="material-icons prefix">lock</i>
            <input id="login-password" v-model="password" type="password" class="validate">
            <label for="login-password">{{$t("login.password")}}</label>
          </div>
        </div>
      </template>
      <template v-else>
        <p class="flow-text">{{$t("login.introLogged")}}</p>
        <div class="row">
          <div class="input-field col s12">
            <i class="material-icons prefix">account_circle</i>
            <input id="login-username" :value="user().username" disabled type="text">
          </div>
          <div class="input-field col s12">
            <i class="material-icons prefix">mail</i>
            <input id="login-password" :value="user().mail" disabled type="text">
          </div>
        </div>
      </template>
    </div>
    <div v-if="!user()" class="modal-footer row">
      <a class="col"><button @click="login" class="btn btn-large left waves-effect waves-light bkg-main">{{$t("login.login")}} <i class="material-icons right">send</i></button></a>
      <a class="grey lighten-5 modal-close btn-large left waves-effect waves-dark btn-flat">{{$t("common.cancel")}}</a>
    </div>
    <div v-else class="modal-footer row">
      <router-link to="/admin/!" class="col"><button class="btn btn-large left waves-effect waves-light bkg-main">{{$t("login.admin")}} <i class="material-icons right hide-on-small-only">exit_to_app</i></button></router-link>
      <a class="col"><button @click="logout" class="btn btn-large left waves-effect waves-light bkg-main">{{$t("login.logout")}} <i class="material-icons right hide-on-small-only">close</i></button></a>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
  data: function() {
    return {
      username: '',
      password: ''
    }
  },
  computed: {
    ...mapGetters('user', { user: 'get' })
  },
  methods: {
		...mapActions('user', ['_login', '_logout']),
		login() {
			if (this.username && this.password) {
				this._login({ username: this.username, password: this.password })
				.then(() => { M.toast({ html: 'Login effettuato' }) })
				.catch(() => { M. toast({ html: 'Credenziali invalide', classes: 'red' }) })
				this.username = ''
				this.password = ''
			} else {
				M.toast({ html: 'Nome utente o password mancanti', classes: 'red' })
			}
		},
		logout() {
			this._logout().then(() => {
				M.toast( { html: 'Logout effettuato' })
			})
		}
  }
}
</script>

<style scoped>

.md-login {
	max-width: 600px;
}

</style>
