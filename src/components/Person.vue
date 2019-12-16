<template>
  <div class="cmp-person">
    <layer class='card'>
      <div slot-scope="layer" class="center-align">
        <div class="person">
          <br>
          <div>
            <img src="https://visualpharm.com/assets/217/Person%20Female-595b40b85ba036ed117da7ea.svg"/>
            <a @click="(e) => layer.set(e, 'description', 'white')" class='waves-effect waves-light'>
              <i class='material-icons white-text'>add</i>
            </a>
          </div>
        </div>
        <br>
        <p class="flow-text grey-text text-darken-3">
          STEFANIA ANNOVAZZI
          <small>
            <br>
            <a style='display:inline-block'><i class='material-icons left'>mail_outline</i>myemail.true@gmail.com</a>
          </small>
        </p>
      </div>
      <div slot="description" slot-scope="layer" class='description left-align'>
        <i @click="(e) => layer.set(e, '', 'white')" class='waves-effect material-icons grey-text'>close</i>
        <div class="flow-text">
          <div class='center-align'><b>DIRETTORE</b></div>
          <ul class='browser-default'>
            <li>Architetto</li>
            <li>Socio Fondatore</li>
          </ul>
          <hr class='grey lighten-3'>
          <a class='color-main'><i class='material-icons'>book</i> Curriculum</a>
        </div>
      </div>
    </layer>
  </div>
</template>

<script>

import Layer from './Layer'

export default {
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
}
.person > div > * {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  margin: auto;
  display: inline-block;
  width: calc(100% - 20px);
  height: calc(100% - 20px);
  border-radius: 100%;
  transition: all .5s;
}
.person > div > a {
  opacity: 0;
  background: rgba(0,0,0,0.5);
  transition: all .5s, opacity .5s .1s;
  display: flex;
  align-items: center;
  justify-content: center;
}

.person:hover > div > a {
  opacity: 1;
  box-shadow: 0 0 10px 2px rgba(0,0,0,0.5);
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

</style>
