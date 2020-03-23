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
    <!-- START HERE -->
    <div id="artisan" class="container section">
      <h2 class="center-align title text-important">{{$t('pages.registration.sections.artisan.title')}}</h2>
      <p class="flow-text">
        <b>{{$t('pages.registration.content.artisan.artisans')}}</b>
        <ul class="browser-default">
          <li>{{$t('pages.registration.content.artisan.benefits[0]')}}</li>
          <li>{{$t('pages.registration.content.artisan.benefits[1]')}}</li>
          <li>{{$t('pages.registration.content.artisan.benefits[2]')}}</li>
          <li>{{$t('pages.registration.content.artisan.benefits[3]')}}</li>
          <li>{{$t('pages.registration.content.artisan.benefits[4]')}}</li>
          <li>{{$t('pages.registration.content.artisan.benefits[5]')}}</li>
          <li>{{$t('pages.registration.content.artisan.benefits[6]')}}</li>
        </ul>
      </p>
      <br>
      <router-link to="registration" class="btn btn-large bkg-main white-text">REGISTRATI</router-link>
    </div>
    <parallax height="400px" :img="require('@/assets/imgs/slideshow-03.jpg')"></parallax>
    <div id="partner" class="container section">
      <h2 class="center-align title text-important">{{$t('pages.registration.sections.partner.title')}}</h2>
      <p class="flow-text">
        <b>{{$t('pages.registration.content.partner.partners')}}</b>
        <ul class="browser-default">
          <li>{{$t('pages.registration.content.partner.benefits[0]')}}</li>
          <li>{{$t('pages.registration.content.partner.benefits[1]')}}</li>
          <li>{{$t('pages.registration.content.partner.benefits[2]')}}</li>
        </ul>
      </p>
      <br>
      <router-link to="registration" class="btn btn-large bkg-main white-text">REGISTRATI</router-link>
    </div>
    <parallax height="400px" :img="require('@/assets/imgs/slideshow-05.jpg')"></parallax>
    <!-- END HERE -->
		<div id="registration" class="container section">
			<h2 class="center-align title text-important">{{$t('pages.registration.sections.registration.title')}}</h2>
			<div class="row">
				<p class="flow-text" v-html="$t('pages.registration.content.registration.explanation')"></p>				
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
