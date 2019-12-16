<template>
  <div class="bull">
    <div class="absolute-center-aligned"></div>
  </div>
</template>

<script>
export default {
}
</script>

<style scoped>

.bull {
  display: inline-block;
  height: 1.2rem;
  width: 1.2rem;
  margin: 1px;
  border: 2px solid #FFF;
  border-radius: 1px;
  transition: .5s;
}
.bull > div {
  background: #FFF !important;
  border-radius: 1px;
  transform: scale(0);
  transition: .5s;
}

.bull.dark {
  border: 2px solid #000;
}
.bull.dark > div {
  background: #000 !important;
}

*:hover > .bull {
  transform: scale(0.8);
}
*:hover > .bull > div {
  transform: scale(0.6);
}

*.active > .bull {
  transform: rotate(135deg) scale(0.8) !important;
}
*.active > .bull > div {
  transform: scale(0.6);
}
*.active > .bull.to-top {
  transform: translateY(-50%) rotate(135deg) scale(0.8) !important;
}
*.active > .bull.to-right {
  transform: translateX(50%) rotate(135deg) scale(0.8) !important;
}

</style>
