<template>
	<div class="cmp-logo">
		<img :src="images[type]" :style="{ width, height: 'auto' }"/>
	</div>
</template>

<script>
export default {
	props: ['type', 'width'],
	data: function() {
		return {
			images: {
				igp: require('@/assets/imgs/igp.png'),
				igpl: require('@/assets/imgs/igpl.png'),
				ipa: require('@/assets/imgs/ipa.png'),
				igpw: require('@/assets/imgs/igp-wide.jpg'),
				igplw: require('@/assets/imgs/igpl-wide.png'),
				ipaw: require('@/assets/imgs/ipa-wide.jpg'),
			}
		}
	}
}
</script>