<template>
  <div class="pg-information">
    <div id="igp" class="container section">
			<h2 class="center-align title text-important">{{$t('pht')}}</h2>
      <p class="flow-text">
        IGPLombardia persegue esclusivamente scopi immediatamente fruibili, con i quali la società comune si arricchisce sul piano intellettuale, culturale, ecologico ed economico. IGPLombardia  non ha scopi di lucro e ispira le proprie attività ai principi di sostenibilità, indipendenza, imparzialità, cooperazione, creazione di reti. Lo standard Passivhaus è in grado di soddisfare i requisiti di benessere abitativo e comfort sia in edifici residenziali sia non residenziali, nelle nuove costruzioni e nelle ristrutturazioni. La realizzazione di edifici Passivhaus presuppone elevata attenzione alla progettazione architettonica, alla bioclimatica, alla cura dei dettagli, accuratezza nell’esecuzione e garanzia di professionalità da parte di Tecnici ed Esecutori. L’IGPLombardia  vuole contribuire a diffondere questo sapere e a garantire criteri di qualità, perseguendo i seguenti obiettivi:
        <ul class="browser-default">
          <li>Divulgazione della cultura architettonica e urbanistica finalizzata al benessere abitativo degli edifici a “energia quasi zero”</li>
          <li>Diffusione di informazioni e know-how principalmente secondo gli standard costruttivi Passivhaus ed Enerphit</li>
          <li>Definizione della qualità da rispettare nella costruzione di edifici Passivhaus, stimolando lo sviluppo e la produzione di componenti passivi</li>
          <li>Sviluppo di strategie per una rapida diffusione mirata degli standard costruttivi Passivhaus</li>
          <li>Creazione di reti e collaborazioni fra le persone, Enti pubblici, Istituzioni, Ditte di Consulenza, Studi di Progettazione, Ditte Artigiane ed Edili e Associazioni</li>
          <li>Consulenza professionale e strategica, corsi di formazione, collaborazioni commerciali ecc</li>
          <li>Diffusione dello standard costruttivo Passivhaus e azioni mirate alla costruzione di edifici Passivhaus</li>
        </ul>
      </p>
      <hr class="grey lighten-3">
    </div>
    <div id="executive" class="container section">
      <h2 class="center-align title text-important">{{$t('pht')}}</h2>
      <p class="flow-text grey-text">Per maggiori informazioni clicca sulle immagini.</p>
      <masonry class="section row">
				<person class="col l4 m6 s12"></person>
        <person class="col l4 m6 s12"></person>
        <person class="col l4 m6 s12"></person>
      </masonry>
      <hr class="grey lighten-3">
    </div>
    <div id="partner">
      <div class="container">
        <h2 class="center-align title text-important">{{$t('pht')}}</h2>
        <p class="flow-text grey-text">Per maggiori informazioni clicca sui loghi.</p>
      </div>
      <masonry class="section row" :fit="true">
        <img v-for="(el, index) in logos" :key="index" class="col logo" :src="require('../assets/logos/' + el)">
      </masonry>
    </div>
  </div>
</template>

<script>
import Person from '@/components/Person'
import Masonry from '@/components/Masonry'
import { listFiles } from '../lib/js/script'

export default {
  components: {
		Person,
    Masonry
  },
  computed: {
    logos() {
      return listFiles(require.context('../assets/logos/', false))
    }
  }
}
</script>

<style scoped>

.logo {
	display: block;
	margin: 2rem;
}

</style>
