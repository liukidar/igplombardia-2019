<template>
  <div class="cmp-designer h-flex center">
    <div class="cmp-body left-align flow-text">
      <div class="cmp-name capitalize">
        <b>{{data.username}} </b>
        <i v-for="(q, index) in data.qualifications" :key="index"><span v-if="q">- {{q}}</span></i>
      </div>
      <div style="padding: 8px;">
        <div v-if="data.mail"><i class="material-icons inline middle color-main">email</i> {{data.mail}}</div>
        <div v-if="data.location"><i class="material-icons inline middle color-main">location_on</i> {{data.location}}</div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['data'],
  mounted() {
    // eslint-disable-next-line
    console.log(this.data.qualifications)
  }
}
</script>

<style scoped>

.cmp-designer {
  padding: 4px 8px;
  margin-bottom: 4px !important;
}

.cmp-body {
  width: 100%;
  padding: 8px 16px;
  border: 1px solid #ddd;
}

</style>