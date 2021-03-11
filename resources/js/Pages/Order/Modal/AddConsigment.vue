<template>   

    <form @submit.prevent="storeConsignment" enctype="multipart/form-data">
        <ul class="bg-red-500 text-white py-2 px-8" v-if="Object.keys(errors).length">
            <li type="disc" v-for="error in errors">{{error[0]}}</li>
        </ul>
    	<!--  consignment_number-->
        <div class="col-span-6 lg:col-span-2">
        	<jet-label for="consignment_number" value="Consignación" />
        	<jet-input id="consignment_number" type="text" class="my-1 block w-full" v-model="consignment_number" required />
        </div>
        <!-- imagen -->
        <div class="col-span-6 lg:col-span-2">
        	<label for="imagen" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
        		<span>Subir imagen</span>
        		<input type="file"  id="imagen"  ref="imagen" @change="uploadImagen" class="w-px h-px opacity-0 overflow-hidden absolute" accept=".pdf, .jpg, .png"/>
        	</label>
            <p class="mt-2 text-xs text-gray-500">PDF, JPG, PNG</p>
        	<span v-if="uploadedImagen" class="ml-4 text-green-500">¡Hecho!</span>
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
                imagen: null,
                uploadedImagen: false,
                active: false,
                errors: {}
            }
        },
        mounted(){
        	
        },
        methods: {
        	uploadImagen(e){
        		this.uploadedImagen = true
        	},
            storeConsignment(){
                this.startLoading();

            	if (this.$refs.imagen.files.length) {
                    this.imagen = this.$refs.imagen.files[0]
                }

                var data = new FormData()
                data.append('consignment_number', this.consignment_number )
                data.append('imagen', this.imagen )
                data.append('order_id', this.order_id )

                axios.post('/consignment', data)
                .then( res => {
                    this.setStatusFlash( res.data.type ,res.data.text );
                    this.$emit('closingModal', false)
                    this.errors = null;
                }).catch(error => {
                    this.errors = error.response.data.errors;
                })
                .finally( () => this.endLoading() );
            },
        }
    }
</script>