<template>
  <ul>
    <li v-for="(lang, index) in languages" :key="index" @click="$i18n.locale=lang" class="waves-effect waves-dark">
			<a class="color-main" :class="{ disabled: lang !== activeLanguage }">
				{{lang}}
			</a>
		</li>
  </ul>
</template>

<script>

export default {
  computed: {
		languages: function() {
			return this.$i18n.availableLocales
		},
		activeLanguage: function() {
			return this.$i18n.locale.substr(0,2)
		}
  }
}
</script>

<style scoped>

a {
	text-transform: uppercase;
}

li:hover > .disabled {
  color: rgba(0,0,0,0.87) !important;
}
.disabled {
  color: #d0d0d0 !important;
}

</style>
