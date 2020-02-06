<template>
  <div class="pg-registration">
    <div id="private" class="container section">
      <h2 class="center-align title text-important">{{$t('pages.registration.sections.private.title')}}</h2>
      <p class="flow-text">
        <b>{{$t('pages.registration.content.private.students')}}</b>
        <ul class="browser-default">
          <li>{{$t('pages.registration.content.private.sbenefits[0]')}}</li>
          <li>{{$t('pages.registration.content.private.sbenefits[1]')}}</li>
          <li>{{$t('pages.registration.content.private.sbenefits[2]')}}</li>
          <li>{{$t('pages.registration.content.private.sbenefits[3]')}}</li>
        </ul>
        <br>
        <b>{{$t('pages.registration.content.private.professionals')}}</b>
        <ul class="browser-default">
          <li>{{$t('pages.registration.content.private.pbenefits[0]')}}</li>
          <li>{{$t('pages.registration.content.private.pbenefits[1]')}}</li>
          <li>{{$t('pages.registration.content.private.pbenefits[2]')}}</li>
          <li>{{$t('pages.registration.content.private.pbenefits[3]')}}</li>
          <li>{{$t('pages.registration.content.private.pbenefits[4]')}}</li>
          <li>{{$t('pages.registration.content.private.pbenefits[5]')}}</li>
        </ul>
      </p>
      <br>
			<router-link to="registration" class="btn btn-large bkg-main white-text">REGISTRATI</router-link>
    </div>
    <parallax height="400px" :img="require('@/assets/imgs/slideshow-02.jpg')"></parallax>
    <!--
    <div id="society" class="container section">
      <h3 class="center-align title text-important">AZIENDE</h3>
      <p class="flow-text">
        Il partner IG PH Lombardia ha la possibilità di:
        <ul class="browser-default">
          <li>Fare pubblicità durante i corsi organizzati e promossi da IGP Lombardia con l’inserimento delle proprie brochure e gadget all'interno del materiale fornito ai corsisti</li>
          <li>Inserire pubblicità sul sito IGP Lombardia (logo e breve descrizione attività dell'azienda)</li>
          <li>Inserire link sul sito IGP Lombardia</li>
          <li>Avere agevolazioni per iscrizione dipendenti nel caso di corsi organizzati e promossi da IG PH Lombardia</li>
          <li>Ottenere la disponibilità a organizzare eventi congiunti (corsi o seminari di aggiornamento) presso la sede del partner con relatore a pagamento di €. 250,00 che potrà essere un tecnico IG PH Lombardia o tecnici scelti da IG PH Lombardia</li>
          <li>Utilizzare il logo “AZIENDA PARTNER” di IGP Lombardia rinnovato ogni anno, da utilizzare sul proprio sito o sulle proprie brochure/depliant</li>
          <li>Ricevere copie di dispense e/o materiale pubblicitario riguardante il PASSIVHAUS preparate da IG PH Lombardia</li>
          <li>Informare IG PH Lombardia del contenuto delle comunicazioni che le aziende partner vogliono trasmettere ai contatti gestiti da IG PH Lombardia, in modo da poterli verificare ed inviare così l’informativa</li>
          <li>Inserire pubblicità delle aziende partner nelle newsletter inviate ai professionisti in collegamento con IG PH Lombardia</li>
          <li>Usufruire dei vantaggi della Membership ad iPHA</li>
        </ul>
      </p>
    </div>
    -->
		<div id="registration" class="container section">
			<h2 class="center-align title text-important">{{$t('pages.registration.sections.registration.title')}}</h2>
			<div class="row">
				<p class="flow-text">
					{{$t('pages.registration.content.registration.explanation')}}
				</p>
				<form>
					<div class="row">
						<div class="input-field col s6">
							<i class="material-icons prefix">account_circle</i>
							<input id="name" type="text" class="validate">
							<label for="name">{{$t('pages.registration.content.registration.name')}}</label>
						</div>
						<div class="input-field col s6">
							<input id="surname" type="text" class="validate">
							<label for="surname">{{$t('pages.registration.content.registration.surname')}}</label>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s12">
							<i class="material-icons prefix">mail</i>
							<input id="email" type="email" class="validate">
							<label for="email">{{$t('pages.registration.content.registration.email')}}</label>
						</div>
					</div>
					<div class="row">
						<div class="input-field col s12">
							<select>
								<option disabled selected>{{$t('pages.registration.content.registration.default_status')}}</option>
								<option v-for="el in $t('pages.registration.content.registration.status')" :key="el">{{el}}</option>
							</select>
							<label>Status</label>
						</div>
					</div>
					<div class="row">
						<p class="flow-text">
							<small>{{$t('pages.registration.content.registration.disclaimer')}}</small>
						</p>
					</div>
					<div class="row">
						<a class="btn btn-large bkg-main white-text right waves-effect waves-light">INVIA <i class="material-icons right">send</i></a>
					</div>
				</form>
			</div>
		</div>
  </div>
</template>

<script>

import Parallax from '@/components/Parallax'

export default {
	components: {
		Parallax
	},
	mounted() {
		
		let elems = this.$el.querySelectorAll('select')
    M.FormSelect.init(elems, {});
	}
}
</script>

<style scoped>

</style>
