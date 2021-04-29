<template>
	<div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
		<dt class="text-sm font-medium text-gray-500">
			{{title}}
		</dt>
		<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
			<ul class="border border-gray-200 rounded-md divide-y divide-gray-200">
				<li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm"
				v-for="(item, key) in files" :key="key">
					<vue-image
	            	:title="item.filename"
	            	:path="item.path"
	            	:description="item.reason"></vue-image>
					<div class="ml-4 flex-shrink-0">
						<div class="grid grid-flow-col auto-cols-max">
							<div>
								<vs-button
						        icon
						        border
						        color="success"
						       :href="`/public/${item.path}`"
						        blank
						      	>
							        <i class='bx bxs-show' ></i>
							    </vs-button>
							</div>
							<div>
								<vs-button
						        icon
						        border
						        :href="`/download/${item.id}/multimedia`"
						      	>
						        	<i class='bx bxs-download' ></i>
						     	</vs-button>
							</div>
							<div>
								<vs-button
						        icon
						        color="danger"
						        border
						        @click="confirm(item, key)"
						      	>
							        <i class='bx bxs-trash-alt' ></i>
						     	</vs-button>
							</div>
						</div>
					</div>
				</li>
			</ul>
		</dd>
		<vs-dialog width="550px" not-center v-model="showModal">
	        <template #header>
	          <h4 class="not-margin">
	            Confirma la <b>eliminación</b>
	          </h4>
	        </template>

	        <div class="con-content">
	          <p>
	            ¿Esta seguro que desea eliminar este contenido multimedia? <b>{{filename}}</b>
	          </p>
	        </div>

	        <template #footer>
	          <div class="con-footer">
	            <vs-button @click="destroyMultimedia()" transparent>
	              Si, confirmar
	            </vs-button>
	            <vs-button @click="showModal=false" dark transparent>
	              Cancelar
	            </vs-button>
	          </div>
	        </template>
	    </vs-dialog>
	</div>
</template>
<script>
	import VueImage from '@/Components/VueImage'
	export default { 
		components: {
			VueImage
		},
		props: ['files','title'],
		data() {
			return {
				file_id: null,
				showModal: false,
				filename: null,
				key: null
			}
		},
		methods: {
			confirm(item, key){
				this.file_id = item.id;
				this.filename = item.filename;
				this.key = key;
				this.showModal = true;
			},
			destroyMultimedia(){
				axios.delete(`/multimedia/${this.file_id}`)
				.then( res => {
					this.files.splice(this.key,1);
					const status = {
						type: res.data.type,
						text: res.data.text,
					}
					this.$emit('updatingNotifications', status);
				})
				.finally( () => {
					this.file_id = null;
					this.showModal = false;
					this.filename = null;
					this.key = null;
				});
			}
		}
	}
</script>