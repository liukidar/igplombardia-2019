<template>
  <div class="pg-home">
		<div class="full-screen v-flex flex-filler">
      <slider :indicators="false" class="flex-filler">
				<tile class="flex-filler" :bkg="require('@/assets/imgs/slideshow-01.jpg')">
				</tile>
				<tile class="flex-filler" :bkg="require('@/assets/imgs/slideshow-02.jpg')">
				</tile>
				<tile class="flex-filler" :bkg="require('@/assets/imgs/slideshow-03.jpg')">
				</tile>
				<tile class="flex-filler" :bkg="require('@/assets/imgs/slideshow-04.jpg')">
				</tile>
				<tile class="flex-filler" :bkg="require('@/assets/imgs/slideshow-05.jpg')">
				</tile>
				<tile class="flex-filler" :bkg="require('@/assets/imgs/slideshow-06.jpg')">
				</tile>
			</slider>
			<page-header to="description" class="absolute-center-aligned v-flex center white-text text-important center-align">
				<template slot="title">{{$t('pages.home.sections.slider.title')}}</template>
				<template slot="subtitle">Costruire bene per il tuo benessere</template>
				<!--<template slot="subtitle">{{$t('phst')}}</template>
				<template slot="description">{{$t('phd')}}</template>
				-->
			</page-header>
    </div>
		<div id="description" class="container section">
      <h2 class="center-align title text-important">{{$t('pages.home.sections.description.title')}}</h2>
      <p class="flow-text center-align" v-html="$t(`pages.home.content.description.data`)">
      </p>
      <br />
      <div class="center-align"><logo type="ipaw" width="256px" /></div>
    </div>
	<!--
		<div id="news" class="section">
      <h2 class="center-align title text-important">{{$t('pht')}}</h2>
      <masonry class="row">
				<card class="card-flat grey-text text-darken-3 col s12 m6 l4" ratio="r4-3">
					<template slot="title">Title</template>
					<template slot="description">Lorem ipsum dolor sit amet</template>
					<template slot="action">
						<router-link to="/article/!">MORE</router-link>
					</template>
				</card>
				<card class="card-flat grey-text text-darken-3 col s12 m6 l4" ratio="r4-3">>
					<template slot="title">Title</template>
					<template slot="description">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Adipisci suscipit cum id!</template>
					<template slot="action">
						<router-link to="/"></router-link>
					</template>
				</card>
				<card class="card-flat grey-text text-darken-3 col s12 m6 l4" ratio="r4-3">>
					<template slot="title">Title</template>
					<template slot="description">Lorem ipsum dolor sit amet</template>
					<template slot="action">
						<router-link to="/article/!"><i class="material-icons left inline">add</i><span>ADD</span></router-link>
					</template>
				</card>
			</masonry>
    </div>
	-->
	</div>
</template>

<script>

//import Card from '@/components/Card'
import Tile from '@/components/Tile'
import Slider from '@/components/Slider'
//import Masonry from '@/components/Masonry'
import PageHeader from '@/sections/PageHeader'
import Logo from '@/components/Logo'

export default {
	components: {
		//Card, 
		Tile, 
		Slider,
		//Masonry, 
    PageHeader,
    Logo
	}
}

</script>

<style scoped>

.cmp-page-header {
	z-index: 900;
}

</style>