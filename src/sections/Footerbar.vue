<template>
  <footer class="page-footer bkg-main">
    <div class="row">
      <div class="col l4 s12 center-align">
        <h4 class="text-important"><router-link class="white-text" to="/!">IGP</router-link></h4>
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
            <i class="left material-icons circle-halo-white">location_on</i>
            16, Via Vimercati (26013)<br><b style="font-size:110%;">Crema, Italia</b>
          </p>
          <p>
            <i class="left material-icons circle-halo-white">phone</i>
            +39 000 000 0000
          </p>
          <p>
            <i class="left material-icons circle-halo-white">email</i>
            info@igplombardia.it
          </p>
        </div>
      </div>
      <div class="col l4 s12 center-align">
        <div class="description container">
          <div class="flow-text">
            <p>
              About the company<br>
              <span class="grey-text text-lighten-2">
                <p>L'IG Passivhaus Lombardia è un’Associazione composta da Professionisti, Aziende, e Imprese che condividono il desiderio di diffondere informazioni inerenti il tema delle Case Passive.</p>
              </span>
            </p>
          </div>
          <p class="no-wrap">
            <i class="fa fa-facebook square-halo-white highlight-oh dark"></i>&nbsp;
            <i class="fa fa-linkedin square-halo-white highlight-oh dark"></i>
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
