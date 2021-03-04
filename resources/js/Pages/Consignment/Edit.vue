<template>
	<admin-layout>
		 <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Crear consignación
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
				<jet-form-section @submitted="updateConsignment">
			        <template #title>
			            Información de consignación
			        </template>
			        <template #description>
			            Crea un consignación con la información requerida.
			        </template>
			        <template #form>
			        	<div class="col-span-6">
			        		<jet-label for="user_id" class="text-red-500" :value="`Consecutivo actual: ${form.order_id}`"/>
			        	</div>
			            <!-- user id or cliente -->
			            <div class="col-span-6 lg:col-span-2">
			                <jet-label for="user_id" value="Consecutivo pedido"/>
			                <v-select 
					        label="name" 
					        class="mt-1"
					        :filterable="false" 
					        :options="orders" 
					        v-model="form.order_id"
					        :reduce= "orders => orders.id"
					        @search="onSearch">
							    <template slot="no-options">
							      Escribe el consecutivo del pedido
							    </template>
							    <template slot="option" slot-scope="option">
							      <div class="d-center">
							        <p> Consecutivo: #{{ option.id }}</p>
							        <cite>Client: {{ option.name }}</cite>
							        </div>
							    </template>
							    <template slot="selected-option" slot-scope="option">
							      <div class="selected d-center">
							      	 <p> #{{ option.id }}</p>
							      </div>
							    </template>
							</v-select>
			                <jet-input-error :message="form.errors.user_id" class="mt-2" />
			            </div>
			           	<!--  consignment_number-->
			            <div class="col-span-6 lg:col-span-2">
			            	<jet-label for="consignment_number" value="Consignación" />
			            	<jet-input id="consignment_number" type="text" class="mt-1 block w-full" v-model="form.consignment_number" />
			            </div>
			            <!-- imagen -->
			            <div class="col-span-6 lg:col-span-2">
			            	<label for="imagen" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
			            		<span>Subir imagen</span>
			            		<input type="file"  id="imagen"  ref="imagen" @change="uploadImagen" class="w-px h-px opacity-0 overflow-hidden absolute" accept=".pdf, .jpg, .png" />
			            	</label>
			            	<span v-if="uploadedImagen" class="ml-4 text-green-500">¡Hecho!</span>
			            </div>
			        </template>
			        <template #actions>
			            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
			                Guardado.
			            </jet-action-message>

			            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
			                Guardar
			            </jet-button>
			        </template>
			    </jet-form-section>
            </div>
        </div>
	</admin-layout>

	
</template>
<script>
	import AdminLayout from '@/Layouts/AdminLayout'
	import JetFormSection from '@/Jetstream/FormSection'
    import JetInput from '@/Jetstream/Input'
    import JetLabel from '@/Jetstream/Label'
    import JetInputError from '@/Jetstream/InputError'
    import JetActionMessage from '@/Jetstream/ActionMessage'
    import JetButton from '@/Jetstream/Button'
    import vSelect from "vue-select"
    import 'vue-select/dist/vue-select.css'

    export default {
    	components: {
            JetFormSection,
            JetInput,
            JetLabel,
            JetInputError,
            JetActionMessage,
            JetButton,
            AdminLayout,
            vSelect
    	},
    	props: {
    		consignment: {
    			type: Object
    		}
    	},
    	data(){
            return {
                form: this.$inertia.form({
                	_method: 'put',
                    consignment_number: this.consignment.consignment_number,
                    order_id: this.consignment.order_id,
                    imagen: this.consignment.imagen,
                }),
                orders: [],
                uploadedImagen: false
            }
        },
        mounted(){

        },
        methods: {
        	uploadImagen(){

        	},
            updateConsignment(){
            	if (this.$refs.imagen) {
                    this.form.imagen = this.$refs.imagen.files[0]
                }
                this.form.post(route('consignment.update', {id: this.consignment.id}), {
                    errorBag: 'updateConsignment',
                    preserveScroll: true
                });
            },
           
            onSearch(search, loading) {
		      if(search.length) {
		        loading(true);
		        this.search(loading, search, this);
		      }
		    },
		    search: _.debounce((loading, search, vm) => {
		      axios.get(
		        `/getOrderByConsecutiveOrClient/order?q=${search}`
		      ).then(res => {
		      	vm.orders = res.data;
		        loading(false);
		      });
		    }, 350)
        }

    }
</script>