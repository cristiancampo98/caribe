<template>
	<div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
		<dt class="text-sm font-medium text-gray-500">
			{{title}}
		</dt>
		<dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
			<ul class="border border-gray-200 rounded-md divide-y divide-gray-200">
				<li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm"
				v-for="(item, key) in files" :key="key">
					<div class="w-0 flex-1 flex items-center">
						<!-- Heroicon name: solid/paper-clip -->
						<svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
							<path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd" />
						</svg>
						<span class="ml-2 flex-1 w-0 truncate">
							{{item.filename}}
							<button class="border-2 border-blue-500 text-sm py-1 px-2 ml-2 rounded-lg"># {{item.model_id}}</button>
						</span>

					</div>
					<div class="ml-4 flex-shrink-0">
						<div class="grid grid-flow-col auto-cols-max">
							<div>
								<vs-button
						        icon
						        border
						        color="success"
						       :href="`/storage/${item.path}`"
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
	export default{
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