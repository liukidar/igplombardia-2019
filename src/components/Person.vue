<template>
  <div class="cmp-person">
    <layer class='card'>
      <div slot-scope="layer" @click="(e) => layer.set(e, 'description', 'white')" class="waves-effect center-align">
        <div class="person">
          <br>
          <div :style="{ 'background-image': 'url(' + data.picture + ')'}">
          </div>
        </div>
        <br>
        <p class="flow-text grey-text text-darken-3 capitalize">
          {{data.username}}
          <small v-if="data.mail">
            <br>
            <a style='display:inline-block'><i class='material-icons left'>mail_outline</i>{{data.mail}}</a>
          </small>
        </p>
      </div>
      <div slot="description" slot-scope="layer" class='description left-align'>
        <i @click="(e) => layer.set(e, '', 'white')" class='waves-effect waves-light material-icons grey-text'>close</i>
        <div class="flow-text">
          <div class='center-align capitalize'><b>{{data.username}}</b></div>
          <ul class='browser-default capitalize'>
            <li v-for="(el, index) in data.roles" :key="index">{{el}}</li>
          </ul>
          <hr class='grey lighten-3'>
          <a v-if="data.curriculum" class='color-main' target='_blank' :href="data.curriculum"><i class='material-icons'>book</i> Curriculum</a>
        </div>
      </div>
    </layer>
  </div>
</template>

<script>

import Layer from './Layer'

export default {
	props: {
		data: {
			default: function() {
				return {
					usernname: 'Nome Cognome',
					mail: 'myemail@mail.com',
					roles: ['Role 1', 'Role 2']
				}
			}
		}
	},
  components: {
    Layer
  }
}

</script>

<style scoped>

.person {
  max-width: 196px;
  margin: auto;
}
.person > div {
  width: auto;
  padding-top: 100%;
  position: relative;
	border-radius: 100%;
	background-size: cover;
	background-position: center center;
}

.card {
  margin: auto;
  max-width: 248px;
  box-shadow: none;
  border: 1px solid #DDD;
}

.description {
  padding: 1rem;
}

p.flow-text {
		text-align: center;
}

</style>
