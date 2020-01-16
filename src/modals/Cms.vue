<template>
  <div id="cms-modal" class="md-cms modal bottom-sheet">
    <div class="v-flex" style="height: 100%;">
      <div class="modal-content flex-filler">
        <div class="row">
          <div class="search-bar h-flex center col s12 m12 l5">
            <div class="input-field flex-filler">
              <i class="material-icons prefix">search</i>
              <input id="first_name" type="text" class="validate">
              <label for="first_name">Search Bar</label>
            </div>
            <i class="material-icons right">refresh</i>
          </div>
          <div class="action-bar col s12 m12 l7">
            <a @click="list" class="right transparent btn btn-flat btn-large waves-effect color-main"><span class="hide-on-small-only">NEXT</span><i class="material-icons hide-on-med-and-up">chevron_right</i></a>
            <a class="right transparent btn btn-flat btn-large waves-effect color-main"><span class="hide-on-small-only">PREV</span><i class="material-icons hide-on-med-and-up">chevron_left</i></a>
            <a @click="remove" class="right white-text btn btn-flat btn-large waves-effect bkg-main">DELETE <i class="material-icons right hide-on-small-only">delete</i></a>
            <a @click="selectAll" class="right transparent btn btn-flat btn-large waves-effect color-main hide-on-small-only">Select All <i class="material-icons right">select_all</i></a>
            <div style="clear:both;"></div>
          </div>
        </div>
        <transition-group name="grid" tag="div" ref="wrap" class="file-previews row flex-filler">
          <div v-for="img in files" :key="img.id" class="col" :style="{width: previewWidth + 'px'}">
            <div v-hold="() => selectMode = true" @click="toggle(img.id)" class="r1-1 img-preview" :style="{ 'background-image': 'url(\'' + img.preview['128'] + '\')' }" :class="{ selected: isSelected(img.id) }">
              <i class="material-icons color-main bkg-white">check_circle</i>
            </div>
          </div>
        </transition-group>
      </div>
      <div class="upload-content bkg-main white-text vertical-flex center center-align" @dragover.prevent="status = 1" @dragleave.prevent="status = 0" @drop.prevent="upload">
        <div style="position: relative; pointer-events: none;">
          <div v-if="status == 2" class="preloader-wrapper big active absolute-center-aligned">
            <div class="spinner-layer">
              <div class="circle-clipper left" style="border-color: white">
                <div class="circle"></div>
              </div><div class="gap-patch">
                <div class="circle"></div>
              </div><div class="circle-clipper right" style="border-color: white">
                <div class="circle"></div>
              </div>
            </div>
          </div>
          <i class="material-icons" :style="{'transform': status > 0 ? '' : 'scale(1.4)'}">cloud_upload</i>
        </div>
        <br>
        <span class="text-important uppercase">{{info[status]}}</span>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
  props: ['env'],
  data: function() {
    return {
      info: ['drag & drop', 'ready', 'uploading...'],
      filter: '',
      status: 0,
      selectMode: false,
      selected: {},
      width: 0,
      height: 0
    }
  },
  computed: {
    ...mapGetters('cms', { _files: 'get', _target: 'target' }),
    files() {
      return Object.values(this._files()).slice(0, this.nmPreviews)
    },
    target() {
      // TODO
      return null
    },
    isSelected() {
      return (_id) => this.selected[_id]
    },
    previewWidth() {
      return 128 + ((this.width) % 128) / Math.trunc((this.width) / 128) - 1
    },
    nmPreviews() {
      return Math.trunc((this.width) / 128) * Math.trunc((this.height) / this.previewWidth)
    }
  },
  mounted() {
    window.addEventListener('resize', this.handleResize)
    this.handleResize()
  },
  beforeDestroy() {
    window.removeEventListener('resize', this.handleResize)
  },
  methods: {
    handleResize() {
      this.width = this.$refs.wrap.$el.clientWidth
      this.height = this.$refs.wrap.$el.clientHeight
    },
    toggle(_id) {
      if (this.selectMode) {
        if (this.selected[_id]) {
          this.$delete(this.selected, _id)
          if (Object.keys(this.selected).length == 0) {
            this.selectMode = false
          }
        }
        else {
          this.$set(this.selected, _id, true)
        }
      }
    },
    selectAll() {
      this.selectMode = true
      for (let el in this.files) {
        this.$set(this.selected, el, true)
      }
    },
    ...mapActions('cms', { setTarget: '_target', _upload: '_create', _remove: '_remove', list: '_list'}),
    upload(e) {
      this.status = 2
      this._upload({
        resource: {},
        body: {
          env: this.env,
          files: e.dataTransfer.files,
          previews: [128, 256]
        }
      }).then((r) => {
        for (let img of r.data.files) {
          M.toast({html: 'File caricato correttamente: ' + img.id, classes: 'green'})
        }
        for (let img of r.data.errors) {
          M.toast({html: 'Errore: ' + img, classes: 'red'})
        }
        this.status = 0
      })
    },
    remove() {
      this._remove({ resource: { id: Object.keys(this.selected) } }).then((r) => {
        this.selected = {}

        if (r.error) {
          for (let img of r.error) {
            M.toast({html: 'Errore: ' + img, classes: 'red'})
          }
        }
      })
    }
  }
}

</script>

<style scoped>

.modal {
  height: 100vh;
}

.row {
  width: 100%;
}

.action-bar > a.btn-large {
  margin-left: .5rem;
  padding-left: 20px;
  padding-right: 20px;
}

.upload-content {
  padding: 4rem;
}

.upload-content i {
  transition: .5s;
}

.file-previews {
  display: block !important;
}

.grid-move {
  transition: transform .5s !important;
}

.img-preview {
  border: 1px solid #DDD;
  transition: .5s;
  position: relative;
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center center;  
}

.img-preview.selected {
  transform: scale(0.8);
}

.img-preview > i.material-icons {
  transform: scale(0);
  transition: .5s;
  position: absolute;
  top: 8px;
  right: 8px;
  font-size: 32px;
  border-radius: 100%;
}

.img-preview.img-preview.selected > i {
  transform: scale(1);
}

.row.file-previews > .col {
  margin-bottom: 4px;
  padding: 0 2px;
}

/* TRANSITIONS */
.grid-move {
  transition: 1s;
  pointer-events: none;
}
.grid-enter, .grid-leave-to{
  opacity: 0;
}
.grid-enter-active {
  transition: 1s linear;
}
.grid-leave-active {
  transition: .5s linear;
  position: absolute;
  top: 100vh;
  left: 100%;
}

</style>
