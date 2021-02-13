<template>   
    <form @submit.prevent="storeConsignment" enctype="multipart/form-data">
    	<!--  consignment_number-->
        <div class="col-span-6 lg:col-span-2">
        	<jet-label for="consignment_number" value="Consignación" />
        	<jet-input id="consignment_number" type="text" class="mt-1 block w-full" v-model="consignment_number" />
        	<jet-input-error :message="errors" class="mt-2" />
        </div>
        <!-- imagen -->
        <div class="col-span-6 lg:col-span-2">
        	<label for="imagen" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
        		<span>Subir imagen</span>
        		<input type="file"  id="imagen"  ref="imagen" @change="uploadImagen" class="w-px h-px opacity-0 overflow-hidden absolute" accept=".pdf, .jpg, .png" />
        	</label>
        	<span v-if="uploadedImagen" class="ml-4 text-green-500">¡Hecho!</span>
        	<jet-input-error :message="errors" class="mt-2" />
        </div>
        <!-- pse_urlpse_url -->
        <div class="col-span-6 lg:col-span-3">
        	<jet-label for="pse_url" value="Link PSE" />
        	<jet-input id="pse_url" type="text" class="mt-1 block w-full" v-model="pse_url" />
        </div>
        <!-- pse_number -->
        <div class="col-span-6 lg:col-span-3">
        	<jet-label for="pse_number" value="PSE # radicado" />
        	<jet-input id="pse_number" type="text" class="mt-1 block w-full" v-model="pse_number" />
        </div>
        <div class="mt-4">

	        <jet-button>
	            Guardar
	        </jet-button>
        	
        </div>
        
    </form>
</template>
<script>
	
    import JetInput from '@/Jetstream/Input'
    import JetLabel from '@/Jetstream/Label'
    import JetInputError from '@/Jetstream/InputError'
    import JetActionMessage from '@/Jetstream/ActionMessage'
    import JetButton from '@/Jetstream/Button'

    export default {
    	components: {
          
            JetInput,
            JetLabel,
            JetInputError,
            JetActionMessage,
            JetButton
           
    	},
    	props: ['order_id'],
    	data(){
            return {
                consignment_number: null,
                pse_url: null,
                pse_number: null,
                imagen: null,
                uploadedImagen: false,
                active: false,
                errors: ''
            }
        },
        mounted(){
        	
        },
        methods: {
        	uploadImagen(e){
        		this.uploadedImagen = true
        	},
            storeConsignment(){
            	if (this.$refs.imagen.files.length) {
                    this.imagen = this.$refs.imagen.files[0]
                }
                if (!this.imagen && !this.consignment_number) {
                	this.errors = 'Debes llenar al menos uno de estos';
                }else{
                	var data = new FormData()
					data.append('consignment_number', this.consignment_number )
					data.append('pse_url', this.pse_url )
					data.append('pse_number', this.pse_number )
					data.append('imagen', this.imagen )
					data.append('order_id', this.order_id )

	                axios.post('/consignment', data)
	                .then( res => {
	                	const status = {type: res.data.type ,text: res.data.text}  
	                	this.$emit('updatingNotifications', status)
	                	this.errors = null;
	                }).catch(error => {
	                	console.log(error.response.data.errors)
	                });
                }
            },
        }
    }
</script>