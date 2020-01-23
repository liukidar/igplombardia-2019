<template>
  <div class="tile-wrap" @click="active = !active && hasDescription">
    <div class="tile" :class="[ratio, {active: active}]" :style="{background: 'url(' + bkg + ')'}">
      <div class="information absolute-center-aligned" v-if="hasTitle">
        <div class="padding">
          <router-link :to="to" v-if="to"><i class="material-icons teal-text text-accent-4">link</i></router-link>
        </div>
        <div class="title">
          <div><slot name="title"></slot></div>
          <i class="material-icons right" v-if="hasDescription">more_vert</i>
        </div>
        <div class="description" v-if="hasDescription">
          <div class="small"><slot name="desc"></slot></div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  props: ['bkg', 'to', 'ratio'],
  data: function() {
    return {
      active: false
    }
  },
  computed: {
    hasTitle: function() {
      return !!this.$slots['title']
    },
    hasDescription: function() {
      return !!this.$slots['desc']
    }
  }
}
</script>

<style scoped>

.tile-wrap {
  margin: 0;
  padding: 0;
  position: relative;
}
.tile-wrap.border {
  border:1px solid transparent;
  box-sizing: border-box;
}
.tile {
  position: relative;
  overflow: hidden;
  background-size: cover !important;
  background-repeat: no-repeat !important;
  background-position: 50% 50% !important;
  height: 100%;
}

.information {
  background: rgba(0,0,0,0);
  transition: .5s;
  display: flex;
  flex-flow: column;
}
.information > .padding {
  flex: 1;
  transition: .5s;
}
.tile.active > .information > .padding {
  flex:0;
}
.tile:hover > .information {
  /* background: rgba(0,0,0,0.4); */
}
.tile.active > .information {
  background: rgba(255,255,255,0.8);
}

.title {
  color:#FFF;
  transition: .2s;
  text-align: left;
}
.tile.active .title {
  color:#000;
}

.padding > a {
  position:absolute;
  top:20px;
  right:60px;
  transform: translateY(-200%);
  transition: .5s;
}
.tile.active .padding > a {
  transform: translateY(0%);
  transition: .5s .35s;
}

.title > i {
  transform: translateY(240%);
  transition: .5s;
}
.tile:hover .title > i {
  transform: translateY(0);
}
.tile.active .title > i {
  transform: translateY(0) rotate(90deg);
}

.title > div {
	display: inline-block;
  transform: translateX(-200%);
  transition: .5s;
}
.tile:hover .title > div, .tile.active .title > div {
  transform: translateX(16%);
}

.description {
  padding:0 20px;
  max-height:0;
  opacity:0;
  transition: .5s;
}
.tile.active > .information > .description {
  opacity: 1;
  max-height: 100%;
}

.tile-wrap.important:not(.masonry-active){
  transition: z-index .5s;
}

.tile-wrap.important:not(.masonry-active) {
  position: relative;
  z-index:0;
  box-shadow: none;
}
.tile-wrap.important:not(.masonry-active) > .tile {
  box-shadow: none;
  transition: .5s;
}
.tile-wrap.important:hover:not(.masonry-active) {
  z-index: 10;
}
.tile-wrap.important:hover:not(.masonry-active) > .tile {
  box-shadow: 0px 2px 10px 0px rgba(0,0,0,0.25);
  z-index: 10;
  transform: scale(1.1);
}

</style>
