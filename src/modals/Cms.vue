<template>
  <div id="cms-modal" class="md-cms modal bottom-sheet">
    <div class="modal-content">
			<div class="row">
				<div class="search-bar col s12 m12 l6">
					<div class="input-field">
						<i class="material-icons prefix">search</i>
						<input id="first_name" type="text" class="validate">
						<label for="first_name">Search Bar</label>
					</div>
				</div>
				<div class="action-bar col s12 m12 l6">
					<a class="right transparent btn btn-flat btn-large waves-effect color-main"><span class="hide-on-small-only">NEXT</span><i class="material-icons hide-on-med-and-up">chevron_right</i></a>
					<a class="right transparent btn btn-flat btn-large waves-effect color-main"><span class="hide-on-small-only">PREV</span><i class="material-icons hide-on-med-and-up">chevron_left</i></a>
					<a class="right white-text btn btn-flat btn-large waves-effect bkg-main">DELETE <i class="material-icons right hide-on-small-only">delete</i></a>
					<a @click="selectAll" class="right transparent btn btn-flat btn-large waves-effect color-main hide-on-small-only">Select All <i class="material-icons right">select_all</i></a>
					<div style="clear:both;"></div>
				</div>
			</div>
      <transition-group name="grid" tag="div" class="file-previews row">
				<div v-for="img in files" :key="img.id" class="col s4 m2 l1">
					<div v-hold="() => selectMode = true" @click="toggle(img.id)" class="r1-1 img-preview" :class="{ selected: isSelected(img.id) }">
						<i class="material-icons color-main">check_circle</i>
					</div>
				</div>
			</transition-group>
    </div>
		<div class="upload-content bkg-main white-text vertical-flex center center-align" @dragover.prevent="status = 1" @dragleave.prevent="status = 0" @drop.prevent="upload($event)">
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
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
  props: ['prefix'],
  data: function() {
    return {
      info: ['drag & drop', 'ready', 'uploading...'],
      filter: '',
			status: 0,
			selectMode: false,
			selected: {}
    }
  },
  created: function() {
    this.list()
  },
  computed: {
		...mapGetters('cms', { _files: 'get', _target: 'target' }),
    files() {
      return [{id: 1},{id: 2},{id: 3},{id: 4},{id: 5}]
    },
    target() {
			// TODO
			return null
		},
		isSelected() {
			return (_id) => this.selected[_id]
		}
  },
  methods: {
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
			for (let el of this.files) {
				this.$set(this.selected, el.id, true)
			}
		},
		...mapActions('cms', { setTarget: 'target', upload: 'create', delete: 'delete', list: 'list'}),
    upload(e) {
      this.status = 2
      this.$store.dispatch('filemanager/upload', {
        prefix: this.prefix,
        files: e.dataTransfer.files,
        callback: (r) => {
          for (let img of r.success) {
            M.toast({html: 'File caricato correttamente: ' + img.id, classes: 'green'})
          }
          for (let img of r.error) {
            M.toast({html: 'Errore: ' + img, classes: 'red'})
          }
          this.status = 0
        }
      })
    },
    remove() {
      if (this.selected) {
        this.$store.dispatch('filemanager/remove', {files: [this.selected],
          callback: (r) => {
            for (let img of r.error) {
              M.toast({html: 'Errore: ' + img, classes: 'red'})
            }
          }
        })
      }
    }
  }
}
</script>

<style scoped>

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

.img-preview {
	border: 1px solid #DDD;
	transition: .5s;
	position: relative;
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
