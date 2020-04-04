<template>
  <div class="pg-admin container">
    <div id="users" class="section" v-if="user.access.su == true">
      <h2 class="title text-important">{{$t('pages.admin.sections.users.title')}}</h2>
      <div class="row h-flex center">
        <div class="input-field col s12 l4">
          <i class="material-icons prefix">person</i>
          <input @change="selectUser" type="text" id="username-autocomplete" class="username-autocomplete" />
          <label for="username-autocomplete">Search</label>
        </div>
        <div class="col s12 l8">
          <div
            v-for="(el, index) in ['VIEW', 'CREATE', 'EDIT', 'DELETE', 'ADMIN']"
            :key="index"
            class="switch col"
          >
            <label>
              <input type="checkbox" />
              <span class="lever"></span>
              {{el}}
            </label>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col s12 l6">
          <div class="chips chips-role"></div>
        </div>
        <div class="col s12 l6">
          <div class="chips chips-qualification"></div>
        </div>
        <div class="col s12 l12">
          <div
            v-for="(el, index) in ['designer', 'artisan', 'executive']"
            :key="index"
            class="switch col"
          >
            <label>
              <input :id="el" type="checkbox" :value="el" v-model="selectedUser[el]"/>
              <span class="lever"></span>
              {{el}}
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
        <div class="input-field col s12 l6">
          <i class="material-icons prefix">location_on</i>
          <input v-model="selectedUser.location" id="user-location" type="text" />
          <label for="user-location">Location</label>
        </div>
        <div class="col s12 l6">
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
import { mapGetters, mapActions } from "vuex"

// import { mapGetters, mapActions } from 'vuex'

export default {
  data: function() {
    return {
      selectedUser: {
        username: '',
        mail: '',
        roles: [],
        qualifications: [],
        designer: false,
        artisan: false,
        execution: false,
        location: ''
      },
      selectedPost: {

      },
    }
  },
  computed: {
    ...mapGetters("user", { _user: "get" }),
    ...mapGetters("people", { getPeople: "get" }),
    ...mapGetters("posts", { getPosts: "get" }),
    user() {
      return { access: { su: true } } // this._user()
    }
  },
  methods: {
    ...mapActions("people", { listPeople: "_list" }),
    ...mapActions("posts", { listPosts: "_list" }),
    selectPost(e) {
      let p = this.getPosts(e.target.value.substr(0, e.target.value.indexOf('.')))
      if (p) {
        for (let k in this.selectedPost) {
          this.selectedPost[k] = p[k]
        }
      }
    },
    selectUser(e) {
      let is_id = e.target.value.indexOf('.')
      if (is_id != -1) {
        let u = this.getPeople(e.target.value.substr(0, is_id))
        if (u) {
          this.selectedUser.username = u.username
          this.selectedUser.mail = u.mail
          this.selectedUser.executive = u.executive
          this.selectedUser.designer = u.designer
          this.selectedUser.artisan = u.artisan
          this.selectedUser.location = u.location

          M.Chips.init(this.selectedUser.qualifications, { data: u.qualifications.length ? u.qualifications.map(el => ({ tag: el })) : []})
          M.Chips.init(this.selectedUser.roles, { data: u.roles.length ? u.roles.map(el => ({ tag: el })) : []})
        }
      }
    }
  },
  mounted() {
    this.listPeople().then(() => {
      let data = {}
      let autocomplete = this.$el.querySelectorAll(".username-autocomplete")
      
      for (let user of Object.values(this.getPeople())) {
        data[user.id + '. ' + user.username] = user.picture || null
      }
      M.Autocomplete.init(autocomplete, { data })
    })
    
    this.listPosts().then(() => {
      let data = {}
      let autocomplete = this.$el.querySelectorAll(".post-autocomplete")
      
      for (let post of Object.values(this.getPosts())) {
        data[post.title] = null
      }
      M.Autocomplete.init(autocomplete, { data})
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
  }
}
</script>