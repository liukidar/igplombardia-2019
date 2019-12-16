<template>
  <div id="login-modal" class="modal" style="max-width:600px;">
    <div class="modal-content">
      <h4>{{$t("login.title")}}</h4>
      <template v-if="!user">
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
            <input id="login-username" :value="user.username" disabled type="text">
          </div>
          <div class="input-field col s12">
            <i class="material-icons prefix">mail</i>
            <input id="login-password" :value="user.mail" disabled type="text">
          </div>
        </div>
      </template>
    </div>
    <div v-if="!user" class="modal-footer row">
      <a class="col"><button @click="() => login({username, password})" class="btn btn-large left waves-effect waves-light bkg-main">{{$t("login.login")}} <i class="material-icons right">send</i></button></a>
      <a class="grey lighten-5 modal-close btn-large left waves-effect waves-dark btn-flat">{{$t("common.cancel")}}</a>
    </div>
    <div v-else class="modal-footer row">
      <router-link to="/admin/!" class="col"><button class="btn btn-large left waves-effect waves-light bkg-main">{{$t("login.admin")}} <i class="material-icons right">exit_to_app</i></button></router-link>
      <a class="col"><button @click="logout" class="btn btn-large left waves-effect waves-light bkg-main">{{$t("login.logout")}} <i class="material-icons right">close</i></button></a>
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
    ...mapGetters('user', {user: 'get'})
  },
  methods: {
    ...mapActions('user', {login: 'load', logout: 'delete'})
  }
}
</script>

<style>

</style>
