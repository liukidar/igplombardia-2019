<template>
  <ul id="slide-out" class="sidenav">
    <li class='hide-on-large-only'>
			<language-selector class='valign-wrapper' style='justify-content:space-around;'></language-selector>
		</li>
    <li>
			<a class='waves-effect waves-dark' href='#/!'><i class="material-icons">home</i>Home</a>
		</li>
    <li>
			<a data-target="login-modal" class="modal-trigger waves-effect waves-dark"><i class="material-icons">person</i>Login</a>
		</li>
    <li>
			<div class="divider"></div>
		</li>
    <ul class="collapsible collapsible-accordion">
      <li v-for="link in pages" :key="link.id">
        <template v-if="link.visible == true">
          <a class="collapsible-header waves-effect waves-dark">{{$t(`pages.${link.id}.title`)}}<i class="material-icons">arrow_drop_down</i></a>
          <div class="collapsible-body">
            <ul>
              <li v-for="section in link.sections" :key="section" @click="sidenav.close()">
                <router-link :to="link.href + '/' + section" class="waves-effect waves-dark">{{$t(`pages.${link.id}.sections.${section}.title`)}}</router-link>
              </li>
            </ul>
          </div>
        </template>
      </li>
    </ul>
  </ul>
</template>

<script>
import LanguageSelector from '@/components/LanguageSelector'
import { mapGetters } from 'vuex'

export default {
  data: function() {
    return {
      sidenav: null
    }
  },
  computed: {
    ...mapGetters('app', ['pages']),
  },
  mounted: function() {
    this.sidenav = M.Sidenav.init(this.$el, { edge: 'right' })
    let elem = document.querySelectorAll('.collapsible')
    M.Collapsible.init(elem)
  },
  components: {
    LanguageSelector
  }
}
</script>

<style scoped>

.sidenav {
  height: 100vh;
}

</style>
