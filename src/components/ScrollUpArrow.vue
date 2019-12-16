<template>
  <transition name="fade">
    <router-link to="!" v-if="active" class="waves-effect waves-dark white z-depth-3">
      <i class="material-icons">keyboard_arrow_up</i>
    </router-link>
  </transition>
</template>

<script>

export default {
  data: function() {
    return {
      active: false
    }
  },
  created() {
    window.addEventListener('scroll', this.handleScroll)
  },
  destroyed() {
    window.removeEventListener('scroll', this.handleScroll)
  },
  methods: {
    handleScroll: function() {
      this.active = window.pageYOffset > window.innerWidth / 4
    }
  }
}

</script>

<style scoped>

a {
  position: fixed;
  bottom: 36px;
  left: 30px;
  border-radius: 100%;
  cursor: pointer;
  padding: 7px;
  box-sizing: content-box;
  height: 24px;
  width: 24px;
}

.fade-enter-active, .fade-leave-active {
  transition: 0.75s;
}
.fade-enter, .fade-leave-to {
  transform: translateX(-40px) translateY(100px) scale(0.1);
}

</style>
