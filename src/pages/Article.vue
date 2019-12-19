<template>
  <div class="article-wrap vertical-img white">
    <div class="article">
      <div class="header row">
        <div class="header-img">
          <transition appear name="fade">
            <sourced-img style="height:100%" :value.sync="article.img">
              <moving-bkg slot-scope="{value}" :img="value">
                <div class="overlay vertical-flex center" style="background: rgba(0,0,0,0.25)">
                  <h1 class="center-align header-title white-text title text-important">
                    <sourced-text :value.sync="article.title" />
                  </h1>
                </div>
              </moving-bkg>
            </sourced-img>
          </transition>
        </div>
        <tr-slide-in class="header-content vertical-flex" stagger="1000">
          <div :key="0" data-index="1" data-from="0, -100%" class="header-content-bar flow-text">
            <span @click="back()" class="highlight-oh light"><i class="material-icons inline left">keyboard_arrow_left</i><span class="text-vertical-align"> Back</span></span>
            <span class="right">{{article.date}}</span>
          </div>
          <div :key="1" data-from="100vw, 0" class="container flex-filler vertical-flex center">
            <div class="center-align flow-text">
              <sourced-text :value.sync="article.description"/>
            </div>
          </div>
          <div :key="2" data-from="0, 100%" class="bottom-content-bar center-align grey-text text-ligthen-3">
            <sourced-list :prototypes="prototypes.tags" class="inline" :values.sync="article.tags">
              <div class="chip z-depth-1" slot-scope="{value}"><sourced-text :value.sync="value.content" /></div>
            </sourced-list>
          </div>
        </tr-slide-in>
      </div>
      <div class="body">
        <div class="body-menu grey lighten-3 grey-text text-darken-2 vertical-flex center center-align title">
          <h3 class="title"><sourced-text :value.sync="article.subtitle"/></h3>
        </div>
        <paper-container class="body-content grey darken-3">
          <template slot="paper-before"><paper class="grey lighten-3 rt" :deg='45'></paper></template>
          <sourced-list :prototypes="prototypes.paragraphs" :values.sync="article.paragraphs">
            <sourced-style slot-scope="{value}" :prototype="style" :value.sync="value" class="row" style="padding: 40px;">
              <div slot-scope="{value}" class="z-depth-2 main-paragraph" :class="value.style">
                <h4 class="title center-align container"><sourced-text :value.sync="value.title"/></h4>
                <p v-if="value.type === 'text'" class="container flow-text">
                  <sourced-text :value.sync="value.content"/>
                </p>
                <div v-if="value.type === 'gallery'" class="row">
                  <sourced-list :prototypes="prototypes.cards" :values.sync="value.content" class="float">
                    <sourced-img slot-scope="{value}" :value.sync="value" :class="value.size" class="r2-1" style="margin-bottom: 2rem;">
                      <card slot-scope="{value}" :img="value.img" class="card-flat grey-text text-darken-3">
                      </card>
                    </sourced-img>
                  </sourced-list>
                </div>
              </div>
            </sourced-style>
          </sourced-list>
          <template slot="paper-after"><paper class="grey darken-4 lb" :deg='3'></paper></template>
        </paper-container>
      </div>
    </div>
    <transition name="slide-from-right">
      <filemanager v-show="open" v-if="editable" :prefix="article.title"></filemanager>
    </transition>
    <sourced-mng :onsave="save" v-if="accessFlag == '-A-'"></sourced-mng>
  </div>
</template>

<script>
import { Card, Filemanager } from 'cmps/site'
import { Paper, PaperContainer, TrSlideIn, SourcedText, SourcedList, SourcedImg, SourcedStyle, SourcedMng } from 'cmps/lib'
import { mapState } from 'vuex'

export default {
  props: {
    id: {
      default: null
    }
  },
  data: function() {
    return {
      article: { img: null },
      prototypes: {
        paragraphs: [
          {
            type: 'text',
            title: 'Paragraph',
            content: 'Content',
            style: 'col s12 white'
          },
          {
            type: 'gallery',
            title: 'Gallery',
            content: [],
            style: 'col s12 white'
          }
        ],
        tags: [
          {
            type: 'tag',
            content: 'tag'
          }
        ],
        cards: [
          {
            type: 'card',
            img: 'sample-1.jpg',
            size: 'col s12 m6 l4',
            ratio: 'r2-1'
          }
        ]
      },
      style: {
        size: {
          default: 'col s12',
          'with-margin': 'col s10 offset-s1',
          small: 'col s10 offset-s1 m8 offset-m2 l6 offset-l3',
          'small-sx': 'col s10 offset-s1 m8 offset-m1 l6 offset-l1',
          'small-dx': 'col s10 offset-s1 m8 offset-m3 l6 offset-l5'
        },
        color: {
          default: 'white grey-text text-darken-4',
          dark: 'black white-text'
        }
      }
    }
  },
  computed: {
    ...mapState(['api', 'accessFlag']),
    editable() {
      return this.$store.state.sourcedmng.active
    },
    open() {
      return this.$store.state.filemanager.active
    }
  },
  methods: {
    back() {
      window.history.go(-1)
    },
    save() {
      M.toast({html: 'Articolo salvato', classes: 'green'})
    }
  },
  created() {
    if (this.id) {
      this.api.request('GET', 'article', {id: this.id}).then((r) => {
        r.success.tags = r.success.tags.map(el => { return {type: 'tag', content: el} })
        this.article = r.success
        this.$nextTick(() => {
          let event = new CustomEvent('resize')
          window.dispatchEvent(event)
        })
      })
    }
  },
  components: {
    Card, SourcedText, SourcedList, SourcedImg, SourcedStyle, SourcedMng, TrSlideIn, Filemanager, PaperContainer, Paper
  }
}
</script>

<style scoped>
.header-img, .header-content {
  height: 100vh;
  width: 100%;
  float: left;
}
@media all and (min-width: 1278px) {
  .article-wrap.vertical-img .header-img {
    box-shadow: rgb(0, 0, 0) -10px -5px 20px -10px inset;
    width: 40%;
  }
  .article-wrap.vertical-img .header-content {
    width: 60%;
  }
}
.header-content-bar, .bottom-content-bar {
  padding: 20px;
}
@media all and (max-width: 1278px) {
  .header-content-bar {
    position: relative;
    bottom: 100%;
    color: #FFF;
  }
}

.body {
  clear: both;
}
.body-menu {
  border-top: 1px solid #ddd;
}
.body-content {
  padding-bottom: 12rem;
}
.main-paragraph {
  padding: 4rem;
}

.fade-enter-active, .fade-leave-active {
  transition: 1.5s .5s;
}
.fade-enter, .fade-leave-to {
  opacity: 0;
}

.slide-from-right-enter, .slide-from-right-leave-to {
  transform: translateX(100%);
}
.slide-from-right-enter-active, .slide-from-right-leave-active {
  transition: 1s;
}
</style>
