<template>
	<admin-layout>
		 <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Actualizar remisión
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

				
			       <jet-form-section @submitted="updateRemission">
			        <template #title>
			            Información de remisión
			        </template>

			        <template #description>
			            Edita una remisión con la información requerida.
			        </template>

			        <template #form>

			        	<!-- order -->
			            <div class="col-span-6 lg:col-span-1">
			                <jet-label for="delivered" value="No. pedido" />
			                <jet-input id="delivered" type="number" class="mt-1 block w-full" v-model="remission.order_detail.order_id" disabled/>
			            </div>
			            <!-- consignment -->
			            <div class="col-span-6 lg:col-span-1">
			                <jet-label for="consignment_id" value="No. consignación" />
			                <jet-input id="consignment_id" type="number" class="mt-1 block w-full" v-model="remission.order_detail.consignment_id" disabled/>
			            </div>
			            <!-- product -->
			            <div class="col-span-6 lg:col-span-2">
			                <jet-label for="product" value="Producto" />
			                <jet-input id="product" type="text" class="mt-1 block w-full" v-model="remission.order_detail.product.name" disabled/>
			            </div>
			            <!-- quantity -->
			            <div class="col-span-6 lg:col-span-1">
			                <jet-label for="quantity" value="Cantidad" />
			                <jet-input id="quantity" type="number" class="mt-1 block w-full" v-model="remission.order_detail.quantity" disabled/>
			            </div>
			            <div class="col-span-6 lg:col-span-6">
			        		<p class="text-blue-500 text-sm">Nota: La sección de arriba es informativa, no es posible editar los datos</p>
			        		<p class="text-sm">A continuación podra editar la cantidad entregada y el vehículo,además, de cargar los archivos requeridos </p>
			        	</div>
			           <!-- Delivered -->
			            <div class="col-span-6 lg:col-span-2">
			                <jet-label for="delivered" value="Entregar" />
			                <jet-input id="delivered" type="number" class="mt-1 block w-full" v-model="form.delivered"/>
			                <jet-input-error :message="form.errors.delivered" class="mt-2" />
			            </div>
			            <!-- Vehicle -->
			            <div class="col-span-6 lg:col-span-4">
			            	<jet-label for="vehicle_users_id" value="Vehículo" />
			            	<v-select v-if="vehicles.length"
			            	class="w-72"
					        label="license_plate" 
					        :options="vehicles" 
					        v-model="form.vehicle_users_id"
					        :reduce= "vehicles => vehicles.pivot.id"
					        >
						        <template slot="option" slot-scope="option">
							      <div class="d-center">
							        <p> Placa #: {{ option.license_plate }}</p>
							        <cite>Conductor: {{ option.pivot.carrier }}</cite>
							        </div>
							    </template>
							    <template slot="selected-option" slot-scope="option">
							      <div class="selected d-center">
							      	 <p> Placa #: {{ option.license_plate }}</p>
							      	 <cite>Conductor: {{ option.pivot.carrier }}</cite>
							      </div>
							    </template>
							</v-select>
							<span v-else>No hay vehículos</span>
			            </div>
			            <div class="col-span-6 lg:col-span-1">
				            <label for="firm" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150 cursor-pointer">
				        		<span>Subir firma</span>
				        		<input type="file"  id="firm"  ref="firm" @change="uploadFirm" class="w-px h-px opacity-0 overflow-hidden absolute" accept=".jpg, .png" />
				        	</label>
				        	<p class="mt-2 text-xs text-gray-500">JPG, PNG</p>
				        	<span v-if="uploadedFirm" class="ml-4 text-green-500">¡Hecho!</span>
			            	
			            </div>
			            <div class="col-span-6 lg:col-span-1">
			            	<label for="plate" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150 cursor-pointer">
				        		<span>Subir foto placa</span>
				        		<input type="file"  id="plate"  ref="plate" @change="uploadPlate" class="w-px h-px opacity-0 overflow-hidden absolute" accept=".jpg, .png" />
				        	</label>
				        	<p class="mt-2 text-xs text-gray-500">JPG, PNG</p>
				        	<span v-if="uploadedPlate" class="ml-4 text-green-500">¡Hecho!</span>
			            </div>
			            <div class="col-span-6 lg:col-span-2">
			            	<label for="delivery" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150 cursor-pointer">
				        		<span>Subir foto entrega</span>
				        		<input type="file"  id="delivery"  ref="delivery" @change="uploadDelivery" class="w-px h-px opacity-0 overflow-hidden absolute" accept=".jpg, .png" />
				        	</label>
				        	<p class="mt-2 text-xs text-gray-500">JPG, PNG</p>
				        	<span v-if="uploadedDelivery" class="ml-4 text-green-500">¡Hecho!</span>
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
			    <div class="mt-8 relative">
	            	<iframe src="http://szimek.github.io/signature_pad/" class="inset-0 w-full h-screen"></iframe>
	            </div>	
            </div>
        </div>

	</admin-layout>

	
</template>
<script>
	import { FormComponentMixin} from '@/Mixins/FormComponentMixin'
	export default {
		mixins: [FormComponentMixin],
    	props: {
    		remission: {
    			type: Object,
    			required: true
    		}
    	},
    	mounted() {
    		this.getVehiclesByUserId();
    	},
    	data() {
    		return {
    			vehicles: [],
    			uploadedPlate: false,
    			uploadedFirm: false,
    			uploadedDelivery: false,
    			form: this.$inertia.form({
    				_method: 'put',
                    delivered: this.remission.delivered,
                    vehicle_users_id: this.remission.vehicle_users_id,
                    firm: null,
            		plate: null,
            		delivery: null
                }),
    		}
    	},
    	methods: {
    		updateRemission(){
    			if (this.$refs.firm.files[0]) {
                    this.form.firm = this.$refs.firm.files[0]
                }
                if (this.$refs.plate.files[0]) {
                    this.form.plate = this.$refs.plate.files[0]
                }
                if (this.$refs.delivery.files[0]) {
                    this.form.delivery = this.$refs.delivery.files[0]
                }

				this.form.post(route('remission.update', { id: this.remission.id }), {
                    errorBag: 'updateRemission',
                    preserveScroll: true,
                    onStart: () => { 
                        this.startLoading();
                    },
                    onSuccess: () => {
                        this.loader.text = "¡Hecho!";
                    },
                    onFinish: () => {
                        this.endLoading();
                    },
                });	
            },
    		getVehiclesByUserId(){
        		axios.get(`/getVehiclesByUserId/${this.remission.order_detail.order.user_id}/client`)
        		.then(res => {
        			this.vehicles = res.data.vehicles;
        		});
        	},
        	
		    uploadFirm(){
		    	this.uploadedFirm = true;
		    },
		    uploadDelivery(){
		    	this.uploadedDelivery = true;
		    },
		    uploadPlate(){
		    	this.uploadedPlate = true;
		    },
    	}

	}
</script>