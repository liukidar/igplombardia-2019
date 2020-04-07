<template>
  <div class="pg-admin container">
    <div id="users" class="section" v-if="user.access.su == true">
      <h2 class="title text-important">{{$t('pages.admin.sections.users.title')}}</h2>
      <div class="row h-flex center">
        <div class="input-field col s12 l4">
          <i class="material-icons prefix">person</i>
          <input @change="selectPerson" ref="userAutocomplete" type="text" id="username-autocomplete" class="username-autocomplete" />
          <label for="username-autocomplete">Search</label>
        </div>
        <div class="col s12 l8">
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
        <div class="input-field col s6 l4">
          <i class="material-icons prefix">account_circle</i>
          <input v-model="selectedUser.username" id="username" type="text" />
          <label for="username">Username</label>
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
        <div class="col s12 l12">
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
    <div id="articles" class="section" v-if="user.access.su == true">
      <h2 class="title text-important">{{$t('pages.admin.sections.posts.title')}}</h2>
      <div class="row">
        <div class="input-field col s12 l4">
          <i class="material-icons prefix">title</i>
          <input @change="selectPost" type="text" id="post-title" class="post-autocomplete" />
          <label for="post-title">Title</label>
        </div>
        <div class="input-field col s12 l4">
          <i class="material-icons prefix">link</i>
          <input type="text" id="post-link" />
          <label for="post-link">Passivhaus link</label>
        </div>
        <div class="input-field col s12 l4">
          <i class="material-icons prefix">person</i>
          <input type="text" id="post-author" class="username-autocomplete" />
          <label for="post-author">Author</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12 l6">
          <i class="material-icons prefix">location_on</i>
          <input type="text" id="post-location" />
          <label for="post-location">Location</label>
        </div>
        <div class="col s12 l6">
          <form action="#">
            <div class="file-field input-field">
              <div class="btn bkg-main">
                <span>Picture</span>
                <input type="file" />
              </div>
              <div class="file-path-wrapper">
                <input class="file-path validate" type="text" />
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="row">
        <div class="col s12">
          <div class="col">
            <button class="btn btn-large bkg-main">NEW</button>
          </div>
          <div class="col">
            <button class="btn btn-large bkg-main">EDIT</button>
          </div>
          <div class="col">
            <button class="btn btn-large bkg-main">DELETE</button>
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
      selectedPost: {

      },
    }
  },
  computed: {
    ...mapState("people", ['types', 'access']),
    ...mapGetters("user", { _user: "get" }),
    ...mapGetters("people", { getPeople: "get" }),
    ...mapGetters("posts", { getPosts: "get" }),
    user() {
      return { access: { su: true } } // this._user()
    }
  },
  methods: {
    ...mapActions("people", { listPeople: "_list", _createPerson: '_create', _editPerson: '_edit', _removePerson: '_remove' }),
    ...mapActions("posts", { listPosts: "_list" }),
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
    updateUserAutocomplete() {
      let data = {}
      for (let user of Object.values(this.getPeople())) {
        data[user.id + '. ' + user.username] = user.picture || null
      }
      for (let autocomplete of this.userAutocomplete) {
        autocomplete.updateData(data)
      }
    },
    selectPost(e) {
      // TODO fix
      let p = this.getPosts(e.target.value.substr(0, e.target.value.indexOf('.')))
      if (p) {
        for (let k in this.selectedPost) {
          this.selectedPost[k] = p[k]
        }
        this.$nextTick(M.updateTextFields)
      }
    },
    selectPerson(e) {
      let is_id = e.target.value.indexOf('.')
      if (is_id != -1) {
        let u = this.getPeople(e.target.value.substr(0, is_id))
        if (u) {
          this.selectedUser = Object.assign({}, u);
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
        })
        this.selectedUser = this.newUser()
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
        })
      }
    },
    removePerson() {
      if (this.selectedUser.id) {
        this._removePerson({ id: this.selectedUser.id }).then(() => {
          this.updateUserAutocomplete()
        })
        this.selectedUser = this.newUser()
      }
    }
  },
  mounted() {
    this.userAutocomplete = M.Autocomplete.init(this.$el.querySelectorAll(".username-autocomplete"), { onAutocomplete: () => { this.userPicture = null } })
    this.listPeople().then(() => {
      this.updateUserAutocomplete()
    })
    
    this.listPosts().then(() => {
      let data = {}
      let autocomplete = this.$el.querySelectorAll(".post-autocomplete")
      
      for (let post of Object.values(this.getPosts())) {
        data[post.title] = null
      }
      M.Autocomplete.init(autocomplete, { data })
    })

    let elems = this.$el.querySelectorAll("select")
    M.FormSelect.init(elems, {})
    this.selectedUser.roles = this.$el.querySelectorAll(".chips-role")
    M.Chips.init(this.selectedUser.roles, { placeholder: "Roles", secondaryPlaceholder: "" })
    this.selectedUser.qualifications = this.$el.querySelectorAll(".chips-qualification")
    M.Chips.init(this.selectedUser.qualifications, { placeholder: "Qualifications", secondaryPlaceholder: "" })
    /* if (!this.user || this.user.access.v == false) {
      this.$router.push('/!')
    } */
  },
  components: {
    Chips
  }
}
</script>