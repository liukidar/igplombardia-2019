<template>
  <div class="pg-passivhaus">
    <div class="section grey darken-4 white-text">
      <h2 class="center-align title text-important no-margin">{{$t('pht')}}</h2>
    </div>
    <iframe style="width:100%" height="600" src="https://www.youtube.com/embed/Lr1XbRaR3gM" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
    <div id="description" class="container section">
      <h2 class="center-align title">{{$t('pht')}}</h2>
      <p class="flow-text"><!-- usare v-html per mettere i tag p direttamente nel testo della lingua -->
        Lo standard Passivhaus è nato nel maggio 1988 da una collaborazione tra Bo Adamson dell'Università di Lund in Svezia e Wolfgang Feist dell'Institut für Umwelt und Wohnen (Istituto per l'Ambiente e l'Edilizia) in Germania. La loro idea è stata poi sviluppata attraverso un numero di progetti di ricerca, col sostegno finanziario da parte dello Stato tedesco di Hessen.
      </p>
      <p class="flow-text">
        Le prime abitazioni Passivhaus furono costruite a Darmstadt in Germania nel 1990, e occupate dai proprietari l'anno successivo.
      </p>
      <p class="flow-text">
        Il Passivhaus Institut è stato fondato nel settembre 1996, sempre a Darmstadt, per promuovere e controllare gli standard. Da allora sono state costruiti migliaia di edifici Passivhaus, fino a superare le 25.000 unità nel 2010, ma si presume che il numero si attesti intorno alle 40.000 unità. La maggior parte si trova in Germania ed Austria, ma ne sono state realizzate moltissime in svariati altri Paesi del mondo. La città di Heidelberg in Germania ha recentemente avviato il progetto Bahnstadt, che consiste nella realizzazione dell'area più grande al mondo con edifici costruiti secondo lo standard Passivhaus.
      </p>
    </div>
    <div id="designers" class="section container">
      <h2 class="center-align title">{{$t('pht')}}</h2>
      <p class="flow-text grey-text">Per maggiori informazioni clicca sulle immagini.</p>
      <masonry class="section row">
        <person class="col l4 m6 s12"></person>
        <person class="col l4 m6 s12"></person>
        <person class="col l4 m6 s12"></person>
      </masonry>
    </div>
    <div id="projects" class="grey darken-4">
      <div class="section">
        <h2 class="center-align title text-important white-text">{{$t('pht')}}</h2>
        <masonry class="row">
          <card class="card-flat grey-text text-darken-3 col s12 m4 l3" ratio="r4-3">
            <template slot="title">Title</template>
            <template slot="description">Lorem ipsum dolor sit amet</template>
            <template slot="action">
              <router-link to="/article/!">MORE</router-link>
            </template>
          </card>
          <card class="card-flat grey-text text-darken-3 col s12 m4 l3" ratio="r4-3">
            <template slot="title">Title</template>
            <template slot="description">Lorem ipsum dolor sit amet</template>
            <template slot="action">
              <router-link to="/article/!">MORE</router-link>
            </template>
          </card>
        </masonry>
      </div>
    </div>
  </div>
</template>

<script>

import Card from '@/components/Card'
import Masonry from '@/components/Masonry'
import Person from '@/components/Person'

export default {
  components: {
    Card, Masonry, Person
  }
}

</script>

<style>

</style>
