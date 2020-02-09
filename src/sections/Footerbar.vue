<template>
  <footer class="page-footer bkg-main">
    <div class="row">
      <div class="col l4 s12 center-align">
        <h4 class="text-important"><router-link class="white-text" to="/!">IG Passivhaus Lombardia</router-link></h4>
        <div>
          <span class="flow-text">
            <ul>
              <li v-for="link in pages" :key="link.id">
                <router-link v-if="link.visible" :to="link.href + '/!'" class="text-important white-text highlight-oh dark">{{$t(`pages.${link.id}.title`)}}</router-link>
              </li>
            </ul>
          </span>
        </div>
      </div>
      <div class="col l4 s12 grey-text text-lighten-2 center-align">
        <br>
        <div class="left-align no-wrap flow-text v-flex inline space-between">
          <p>
            <i class="left material-icons circle-halo-white">email</i>
            info@igplombardia.it
          </p>
          <p>
            <i class="left material-icons circle-halo-white">bookmark</i>
            P.IVA 01574330195
          </p>
          <p>
            <i class="left material-icons circle-halo-white">label</i>
            C.F. 91036940194
          </p>
        </div>
      </div>
      <div class="col l4 s12 center-align">
         <br>
        <div class="left-align no-wrap flow-text v-flex inline space-between">
          <p>
            <i class="left material-icons circle-halo-white">location_on</i>
            Via XX Settembre 68
            <br>
            26013 - Crema (Cr)
          </p>
        </div>
        <div class="description container">
          <p class="no-wrap center-align">
            <a class="fa fa-facebook square-halo-white highlight-oh dark" href="https://www.facebook.com/igplombardia.it"><i></i></a>&nbsp;
            <!--<i class="fa fa-linkedin square-halo-white highlight-oh dark"></i>-->
          </p>
        </div>
      </div>
    </div>
    <div class="footer-copyright">
      <div class="container">
        © 2019 Made by Luca Pinchetti - Matteo Ranzetti
      </div>
    </div>
  </footer>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  computed: {
    ...mapGetters('app', ['pages'])
  }
}
</script>

<style scoped>

footer {
  margin-top: auto;
}

@media screen and (min-width: 993px) {
  .description {
    text-align: left;
  }
}

</style>
