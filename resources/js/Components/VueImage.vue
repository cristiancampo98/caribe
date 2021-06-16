<template>
	<vs-card type="5">
	    <template #title>
	      <h3>{{title}}</h3>
	    </template>
	    <template #img>
	      <img :src="`/public/${path}`" alt="Imagen" @error="imageLoadError">
	    </template>
	    <template #text>
	      <p>
	        {{explode_description}}
	      </p>
	    </template>
	  </vs-card>
    </div>
</template>
<script>
	export default {

		props: ['title','path','description'],
		computed: {
			explode_description() {
				return this.description.split('_').join(' ');
			}
		},
		methods: {
			imageLoadError (event) {
				event.target.src = '/default/no-image-available.jpg';
			},
		}
	}
</script>