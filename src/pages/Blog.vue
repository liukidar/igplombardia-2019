<template>
  <div class="pg-blog">
    <div id ="projects" class="container">
      <div class="row">
        <post v-for="el in getPosts()" class="col s12 m6 l4 center-align" :key="el.id" :data="el" :image="el.picture" :title="el.title" :author="el.author" :qualifications="el.qualifications" :to="el.link" :location="el.location" />
      </div>
    </div>
  </div>
</template>

<script>

import Post from '@/components/Post'
import { mapGetters, mapActions } from 'vuex'

export default {
  computed: {
    ...mapGetters('posts', { getPosts: 'get' }),
  },
  methods: {
    ...mapActions('posts', { listPosts: '_list' })
  },
  mounted() {
    this.listPosts()
  },
  components: {
    Post
  }
}
</script>
