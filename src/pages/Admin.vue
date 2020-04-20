<template>
  <div class="pg-admin container">
    <div id="users" class="section" v-if="user.access.su == true">
      <h2 class="title text-important">{{$t('pages.admin.sections.users.title')}}</h2>
      <div class="row">
        <div class="input-field col s12 l4">
          <i class="material-icons prefix">person</i>
          <input onfocus="this.select()" @change="selectPerson" v-model="selectedUser.username" ref="userAutocomplete" type="text" id="username-autocomplete" class="username-autocomplete" />
          <label for="username-autocomplete">Username</label>
        </div>
        <div class="input-field col s6 l4">
          <i class="material-icons prefix">mail</i>
          <input v-model="selectedUser.mail" id="email" type="email" />
          <label for="email">Email</label>
        </div>
        <div class="col s12 l4">
          <form action="#">
            <div class="file-field input-field">
              <div class="btn bkg-main">
                <span>Picture</span>
                <input ref="userPicture" @change="(e) => { userPicture = e.target.files[0]; }" type="file" />
              </div>
              <div class="file-path-wrapper">
                <input ref="userPictureWrapper" class="file-path validate" type="text" />
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="row">
        <div class="col s12 l6">
          <chips :value.sync="selectedUser.roles" placeholder="Roles" />
        </div>
        <div class="col s12 l6">
          <chips :value.sync="selectedUser.qualifications" placeholder="Qualifications" />
        </div>
        <div class="col s12 l5">
          <div
            v-for="(el, k) in types"
            :key="k"
            class="switch col"
          >
            <label class="capitalize">
              <input type="checkbox" v-model="selectedUser.types[el]"/>
              <span class="lever"></span>
              <big>{{k}}</big>
            </label>
          </div>
        </div>
        <div class="col s12 l7">
          <div
            v-for="(el, k) in access"
            :key="k"
            class="switch col"
          >
            <label class="uppercase">
              <input type="checkbox" v-model="selectedUser.access[el]"/>
              <span class="lever"></span>
              {{k}}
            </label>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12 l6">
          <i class="material-icons prefix">location_on</i>
          <input v-model="selectedUser.location" id="user-location" type="text" />
          <label for="user-location">Location</label>
        </div>
        <div class="col s12 l6">
          <div class="col">
            <button @click="createPerson" class="btn btn-large bkg-main">NEW</button>
          </div>
          <div class="col">
            <button @click="editPerson" class="btn btn-large bkg-main">EDIT</button>
          </div>
          <div class="col">
            <button @click="removePerson" class="btn btn-large bkg-main">DELETE</button>
          </div>
        </div>
      </div>
    </div>
    <div id="articles" class="section">
      <h2 class="title text-important">{{$t('pages.admin.sections.posts.title')}}</h2>
      <div class="row">
        <div class="input-field col s12 l4">
          <i class="material-icons prefix">title</i>
          <input onfocus="this.select()" @change="selectPost" v-model="selectedPost.title" type="text" id="post-title" class="post-autocomplete" />
          <label for="post-title">Title</label>
        </div>
        <div class="input-field col s12 l4">
          <i class="material-icons prefix">link</i>
          <input v-model="selectedPost.link" type="text" id="post-link" />
          <label for="post-link">Passivhaus link</label>
        </div>
        <div class="input-field col s12 l4">
          <i class="material-icons prefix">person</i>
          <input onfocus="this.value = ''" @change="selectAuthor" v-model="selectedPost.author" type="text" id="post-author" class="username-autocomplete" />
          <label for="post-author">Author</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12 l6">
          <i class="material-icons prefix">location_on</i>
          <input v-model="selectedPost.location" type="text" id="post-location" />
          <label for="post-location">Location</label>
        </div>
        <div class="col s12 l6">
          <form action="#">
            <div class="file-field input-field">
              <div class="btn bkg-main">
                <span>Picture</span>
                <input ref="postPicture" @change="(e) => { postPicture = e.target.files[0]; }" type="file" />
              </div>
              <div class="file-path-wrapper">
                <input ref="postPictureWrapper" class="file-path validate" type="text" />
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s6 l2">
          <i class="material-icons prefix">today</i>
          <input v-model="selectedPost.year" type="text" id="post-year" />
          <label for="post-year">Year</label>
        </div>
        <div class="input-field col s6 l2">
          <i class="material-icons prefix">crop</i>
          <input v-model="selectedPost.area" type="text" id="post-area" />
          <label for="post-area">Area</label>
        </div>
        <div class="input-field col s12 l8">
          <i class="material-icons prefix">house</i>
          <input v-model="selectedPost.material" type="text" id="post-material" />
          <label for="post-material">Material</label>
        </div> 
      </div>
      <div class="row">
        <div class="col s12">
          <div class="col">
            <button v-if="user.access.c == true" @click="createPost" class="btn btn-large bkg-main">NEW</button>
          </div>
          <div class="col">
            <button v-if="user.access.e == true" @click="editPost" class="btn btn-large bkg-main">EDIT</button>
          </div>
          <div class="col">
            <button v-if="user.access.d == true" @click="removePost" class="btn btn-large bkg-main">DELETE</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

import Chips from '@/components/materialize/Chips'
import { mapState, mapGetters, mapActions } from "vuex"

export default {
  data: function() {
    return {
      userAutocomplete: null,
      selectedUser: this.newUser(),
      userPicture: null,
      selectedPost: this.newPost(),
      postPicture: null,
      postAuthor: null
    }
  },
  computed: {
    ...mapState("people", ['types', 'access']),
    ...mapGetters("user", { _user: "get" }),
    ...mapGetters("people", { getPeople: "get" }),
    ...mapGetters("posts", { getPosts: "get" }),
    user() {
      return this._user()
    }
  },
  methods: {
    ...mapActions("people", { listPeople: "_list", _createPerson: '_create', _editPerson: '_edit', _removePerson: '_remove' }),
    ...mapActions("posts", { listPosts: "_list", _createPost: '_create', _editPost: '_edit', _removePost: '_remove' }),
    newUser() {
      if (this.$refs.userAutocomplete) this.$refs.userAutocomplete.value = null

      return {
        username: '',
        mail: '',
        roles: [],
        qualifications: [],
        types: {},
        location: '',
        access: {},
        picture: '',
        curriculum: ''
      }
    },
    newPost() {
      if (this.$refs.postAutocomplete) this.$refs.postAutocomplete.value = null

      return {
        title: '',
        link: '',
        author: '',
        location: '',
        picture: '',
        year: '',
        material: '',
        area: ''
      }
    },
    updateUserAutocomplete() {
      let data = {}
      for (let user of Object.values(this.getPeople())) {
        data[user.id + '. ' + user.username] = user.picture || null
      }
      for (let autocomplete of this.userAutocomplete) {
        autocomplete.updateData(data)
      }
    },
    updatePostAutocomplete() {
      let data = {}
      for (let post of Object.values(this.getPosts())) {
        data[post.id + '. ' + post.title] = post.picture || null
      }
      for (let autocomplete of this.postAutocomplete) {
        autocomplete.updateData(data)
      }
    },
    /* MANAGE PEOPLE */
    selectPerson(e) {
      let is_id = e.target.value.indexOf('.')
      if (is_id != -1) {
        let u = this.getPeople(e.target.value.substr(0, is_id))
        if (u) {
          this.selectedUser = Object.assign({}, u)
        } else {
          this.selectedUser = this.newUser()
        }
        this.$nextTick(M.updateTextFields)
      }
    },
    createPerson() {
      if (this.selectedUser.username) {
        let picture = null;
        if (this.$refs.userPicture.files.length == 1) {
          picture = this.$refs.userPicture.files[0]
          this.selectedUser.picture = picture.name
          this.$refs.userPicture.value = null
          this.$refs.userPictureWrapper.value = null
        } else {
          this.selectedUser.picture = null
        }
        this._createPerson({ user: this.selectedUser, picture }).then(() => {
          this.updateUserAutocomplete()
          M.toast({ html: 'PERSON_CREATED'})
        })
        this.selectedUser = this.newUser()
      } else {
          M.toast({ html: 'NO_PERSON_USERNAME', classes:'red' })
      }
    },
    editPerson() {
      if (this.selectedUser.id) {
        let picture = null
        if (this.$refs.userPicture.files.length == 1) {
          picture = this.$refs.userPicture.files[0]
          this.selectedUser.picture = picture.name
          this.$refs.userPicture.value = null
          this.$refs.userPictureWrapper.value = null
        }
        this._editPerson({ user: this.selectedUser, picture }).then(() => {
          this.updateUserAutocomplete()
          M.toast({ html: 'PERSON_EDITED'})
        })
      } else {
          M.toast({ html: 'NO_PERSON_SELECTED', classes:'red' })
      }
    },
    removePerson() {
      if (this.selectedUser.id) {
        this._removePerson({ id: this.selectedUser.id }).then(() => {
          this.updateUserAutocomplete()
          M.toast({ html: 'PERSON_REMOVED'})
        })
        this.selectedUser = this.newUser()
      } else {
          M.toast({ html: 'NO_PERSON_SELECTED', classes:'red' })
      }
    },
    /* MANAGE POSTS */
    selectPost(e) {
      let is_id = e.target.value.indexOf('.')
      if (is_id != -1) {
        let p = this.getPosts(e.target.value.substr(0, is_id))
        if (p) {
          this.selectedPost = Object.assign({}, p)
        } else {
          this.selectedPost = this.newPost()
        }
        this.$nextTick(M.updateTextFields)
      }
    },
    selectAuthor(e) {
      let is_id = e.target.value.indexOf('.')
      if (is_id != -1) {
        let u = this.getPeople(e.target.value.substr(0, is_id))
        if (u) {
          this.selectedPost.authorid = u.id
          this.selectedPost.author = u.username
        } else {
          this.selectedPost.authorid = null
        }
        this.$nextTick(M.updateTextFields)
      } else if (this.selectedPost.authorid && this.selectedPost.author != this.getPeople(this.selectedPost.authorid).username) {
        this.selectedPost.authorid = null
      }
    },
    createPost() {
      if (this.selectedPost.title) {
        let picture = null;
        if (this.$refs.postPicture.files.length == 1) {
          picture = this.$refs.postPicture.files[0]
          this.selectedPost.picture = picture.name
          this.$refs.postPicture.value = null
          this.$refs.postPictureWrapper.value = null
        } else {
          this.selectedPost.picture = null
        }
        this._createPost({ post: this.selectedPost, picture }).then(() => {
          this.updatePostAutocomplete()
          M.toast({ html: 'POST_CREATED'})
        })
        this.selectedPost = this.newPost()
      } else {
          M.toast({ html: 'NO_POST_TITLE', classes:'red' })
      }
    },
    editPost() {
      if (this.selectedPost.id) {
        let picture = null
        if (this.$refs.postPicture.files.length == 1) {
          picture = this.$refs.postPicture.files[0]
          this.selectedPost.picture = picture.name
          this.$refs.postPicture.value = null
          this.$refs.postPictureWrapper.value = null
        }
        this._editPost({ post: this.selectedPost, picture }).then(() => {
          this.updatePostAutocomplete()
          M.toast({ html: 'POST_EDITED'})
        })
      } else {
          M.toast({ html: 'NO_POST_SELECTED', classes:'red' })
      }
    },
    removePost() {
      if (this.selectedPost.id) {
        this._removePost({ id: this.selectedPost.id }).then(() => {
          this.updatePostAutocomplete()
          M.toast({ html: 'POST_REMOVED'})
        })
        this.selectedPost = this.newPost()
      } else {
          M.toast({ html: 'NO_POST_SELECTED', classes:'red' })
      }
    }
  },
  mounted() {
    this.userAutocomplete = M.Autocomplete.init(this.$el.querySelectorAll(".username-autocomplete"), { onAutocomplete: () => { this.userPicture = null } })
    this.listPeople().then(() => {
      this.updateUserAutocomplete()
    })
    
    this.postAutocomplete = M.Autocomplete.init(this.$el.querySelectorAll(".post-autocomplete"), { onAutocomplete: () => { this.postPicture = null } })
    this.listPosts().then(() => {
      this.updatePostAutocomplete()
    })
  },
  components: {
    Chips
  }
}
</script>