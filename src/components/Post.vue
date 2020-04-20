<template>
  <div class="cmp-cmp-event-card col s12 m6 l4">
    <layer class="cmp-card z-depth-2" >
      <div slot-scope="layer" class="cmp-body white" :style="{'background-image': 'url(\'' + data.picture + '\')'}" @click="(e) => layer.set(e, 'description', 'white')">
        <div class=" flex-fill white-text waves-effect waves-light" >
          <h4>{{data.title}}</h4>
          <i class="material-icons">link</i>
        </div>
      </div>
      <div class="cmp-description capitalize white card-padding waves-effect left-align" slot="description" slot-scope="layer" @click="(e) => layer.set(e, '', 'white')">
        <h5>{{data.title}}</h5>
        <h4>{{data.author}}</h4>
        <h6>{{data.qualifications.split(';').join(' - ')}}</h6>
        <div class="right-align">
          <br>
          <p v-if="data.year" class="flow-text capitalize">
            {{data.year}} <i class="material-icons">today</i>
          </p>
          <p v-if="data.location" class="flow-text capitalize">
            {{data.location}} <i class="material-icons inline">location_on</i>
          </p>
          <p v-if="data.material" class="flow-text capitalize">
            {{data.material}} <i class="material-icons inline">house</i>
          </p>
          <p v-if="data.area" class="flow-text capitalize">
            {{data.area}} <i class="material-icons inline">crop</i>
          </p>
        </div>
        <div class="cmp-learnmore center-align">
          <a :href="data.link" target="_blank" class="btn-hm accent waves-effect color-main">
            LEARN MORE
          </a>
        </div>
      </div>
    </layer>
  </div>
</template>

<script>
import Layer from './Layer'
export default {
  props: ['data'],
  components: { Layer }
}
</script>

<style scoped>

.cmp-card {
  margin: 16px;
  border-radius: 24px;
  overflow: hidden;
  transition: .35s;
}
.cmp-card:hover {
  box-shadow: 0 12px 40px 0 rgba(0,0,0,0.8);
  z-index: 1;
}

.cmp-body {
  background-size: cover !important;
  background-repeat: no-repeat !important;
  background-position: 50% 50% !important;
  padding-top: 100%;
  cursor: pointer;
}

.cmp-body > div {
  width: 100%;
  padding: 12px 16px;
  background: rgba(0,0,0,0.4);
  transition: .5s;
}
.cmp-body > div:hover {
  background: rgba(0,0,0,0.6);
}

.cmp-description {
  position: relative;
  padding: 2rem 3rem;
}
.cmp-description i.material-icons {
  position: relative;
  top: 3px;
}

.cmp-learnmore {
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  padding: 5rem 1rem 2rem 1rem;
  background: linear-gradient(rgba(255,255,255,0), rgba(255,255,255,0.95), rgba(255,255,255,1.0));
}

.btn-hm {
  display: inline-block;
  border: none;
  padding: .75rem 1.5rem;
  background: transparent !important;
  color: #FFF !important;
  transition: .7s ease-out !important;
  cursor: pointer;
  box-shadow: none !important;
  font-size: 14px !important;
}
.btn.btn-hm {
  padding: 0 1rem;
  line-height: calc(2rem + 14px);
  height: calc(2rem + 14px);
}

.btn-hm:hover {
  background: #FFF !important;
  color: #000 !important;
  border-radius: 32px;
  box-shadow: 0 8px 17px 2px rgba(0,0,0,0.14), 0 3px 14px 2px rgba(0,0,0,0.12), 0 5px 5px -3px rgba(0,0,0,0.2);
}

.btn-hm.accent{
  color: var(--var-color-main) !important;
}

.btn-hm.accent:hover {
  background: var(--var-color-main) !important;
  color: #FFF !important;
}

</style>
