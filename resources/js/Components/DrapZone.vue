<template>
	<div>
		<label class="block text-sm font-medium text-gray-700">
			{{title}}
		</label>
		<div class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
			<div class="space-y-1 text-center">
				<svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
					<path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
				</svg>
				<div class="flex text-sm text-gray-600" @dragover="dragover" @dragleave="dragleave" @drop="drop">
					<label for="assetsFieldHandle" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
						<span>Upload a file</span>
						<input type="file" multiple name="fields[assetsFieldHandle][]" id="assetsFieldHandle" class="w-px h-px opacity-0 overflow-hidden absolute" @change="onChange" ref="file" :accept="accept" />
					</label>
					<p class="pl-1">or drag and drop</p>
				</div>

				<ul class="mt-4" v-if="this.filelist.length" v-cloak>
					<li class="text-sm p-1" v-for="file in filelist">
						{{file.name}}<button class="border border-black mx-4 bg-red-500 px-2 rounded-lg" type="button" @click="remove(filelist.indexOf(file))" title="Remove file">x</button>
					</li>
				</ul>
				<p class="text-xs text-gray-500">
					{{types}}
				</p>
			</div>
		</div>
	</div>
</template>
<script>
export default {
	data() {
		return {
			filelist: []
		}
	},
	props: ['title','accept','types'],
	methods: {
		onChange() {
			
	      this.filelist = [...this.$refs.file.files];
	      this.$emit('setFiles',this.filelist)
	    },
	    remove(i) {
	      this.filelist.splice(i, 1);
	    },
	    dragover(event) {
	      event.preventDefault();
	      // Add some visual fluff to show the user can drop its files
	      if (!event.currentTarget.classList.contains('bg-green-300')) {
	        event.currentTarget.classList.remove('bg-gray-100');
	        event.currentTarget.classList.add('bg-green-300');
	      }
	    },
	    dragleave(event) {
	      // Clean up
	      event.currentTarget.classList.add('bg-gray-100');
	      event.currentTarget.classList.remove('bg-green-300');
	    },
	    drop(event) {
	      event.preventDefault();
	      this.$refs.file.files = event.dataTransfer.files;
	      this.onChange(); // Trigger the onChange event manually
	      // Clean up
	      event.currentTarget.classList.add('bg-gray-100');
	      event.currentTarget.classList.remove('bg-green-300');
	    }
	}
}
</script>