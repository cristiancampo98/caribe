<template>
	<admin-layout :status="status">
		 <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Crear remissión
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-md sm:px-6 lg:px-8">
            	<div class="grid grid-cols-2 gap-4">
            		<div class="col-span-6 lg:col-span-1">
		                <jet-label for="user_id" value="Cliente" />
		                <v-select 
				        label="name" 
				        :filterable="false" 
				        :options="clients" 
				        v-model="user_id"
				        :reduce= "clients => clients.id"
				        @search="onSearch"
				        @input="loadOrders">
						    <template slot="no-options">
						      Escribe el nombre de un cliente
						    </template>
						    <template slot="option" slot-scope="option">
						      <div class="d-center">
						        <p> Nombre: {{ option.name }}</p>
						        </div>
						    </template>
						    <template slot="selected-option" slot-scope="option">
						      <div class="selected d-center">
						      	 <p>{{ option.name }}</p>
						      </div>
						    </template>
						</v-select>
		                <jet-input-error :message="error_client" class="mt-2" />
		            </div>
		            <div class="col-span-6 lg:col-span-1" v-if="orders.length">
		                <jet-label for="order_id" value="Pedidos" />
		                <v-select 
				        label="id" 
				        :options="orders" 
				        v-model="order_id"
				        :reduce= "orders => orders.id"
				        @input="showDetailOrder">
						    <template slot="option" slot-scope="option">
						      <div class="d-center">
						        <p> Pedido #: {{ option.id }}</p>
						        <cite>Cliente: {{ user_name }}</cite>
						        </div>
						    </template>
						    <template slot="selected-option" slot-scope="option">
						      <div class="selected d-center">
						      	 <p>Pedido #: {{ option.id }}</p>
						      </div>
						    </template>
						</v-select>
		                <jet-input-error :message="error_client" class="mt-2" />
		            </div>
            	</div>
            </div>
            <!-- order details table -->
            <div v-if="details.length">
            	<div v-if="Object.keys(remi.errors).length">
            		<ul class="bg-red-500 mt-3 p-2 text-white">
            			<li v-for="error in remi.errors">
            				{{error}}
            			</li>
            		</ul>
            	</div>
            	<table-responsive-component>
	                <template #title>
	                    <tr>
	                        <th-responsive-component 
	                        v-for="(title, key) in titles"
	                        :key="key">{{title}}</th-responsive-component>
	                        <th-responsive-component></th-responsive-component>
	                    </tr>
	                </template>
	                <template #content>
	                    <tr v-for="(item, key) in details" :key="key">
	                        <td-responsive-component>
	                        	{{item.product.name}}
	                        </td-responsive-component>
	                        <td-responsive-component>
	                        	{{item.quantity}} 
	                        	<span class="text-xs">
	                        		m3
	                        	</span>
	                        </td-responsive-component>
	                        <td-responsive-component>
	                        	{{total_delivered(item.remissions)}}
	                        	<span class="text-xs">
	                        		m3
	                        	</span>
	                        </td-responsive-component>
	                        <td-responsive-component>
	                        	<jet-input type="number" class="mt-1 block w-full"
	                        	:max="getLimitUp(item.quantity,item.remissions)"
	                        	step="0.1"
	                        	min="0"
	                        	@change.native="validateQuantity(item)"
	                        	this.del
	                        	v-model.number="item.cantidad"/>
	                        </td-responsive-component>
	                        <td-responsive-component>
	                        	<v-select v-if="vehicles.length"
	                        	class="w-52"
						        label="license_plate" 
						        :options="vehicles" 
						        v-model="item.vehicle_user"
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
	                        </td-responsive-component>
	                        <td-responsive-component>
	                        	{{item.order.shipping_address}}
	                        </td-responsive-component>
	                        <td-responsive-component>
						      	<vs-tooltip>
						        	<vs-button flat>
						          	Consignaciones
						        	</vs-button>
						        	<template #tooltip>
						          		<ul>
						          			<li v-for="value in item.order.consignments">
						          				<span v-if="value.consignment_number">
						          					No. {{value.consignment_number}}.
						          				</span>
						          				<span v-else>
						          					No. consignación vacio para # {{value.id}}.
						          				</span>
						          			</li>
						          		</ul>
						        	</template>
						      	</vs-tooltip>
	                        </td-responsive-component>
	                        <td-responsive-component>
	                        	<jet-button v-if="fullyDispatched(item)" type="button" @click.native="storeRemission(item)">
	                        		Remisión
	                        	</jet-button>
	                        </td-responsive-component>
	                     
	                    </tr>
	                </template>
	            </table-responsive-component>
	            <div class="grid grid-flow-col gap-4 auto-cols-max">
	            	<div>
	            		<jet-button type="button" @click.native="openModalStoreVehicle">Agregar vehículo</jet-button>
	            	</div>
	            	<div>
	            		<a href="http://szimek.github.io/signature_pad/" title="Firmar" target="_blank" class="hover:text-blue-500">Ir a firmar</a>
	            	</div>
	            	<div>
			        	<label for="firm" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 p-1 ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
			        		<span>Subir firma</span>
			        		<input type="file"  id="firm"  ref="firm" @change="uploadImagen" class="w-px h-px opacity-0 overflow-hidden absolute" accept=".pdf, .jpg, .png" />
			        	</label>
			        	<span v-if="uploadedImagen" class="ml-4 text-green-500">¡Hecho!</span>
	            	</div>
	            </div>
	        </div>
            <!-- end table  -->
            <!-- modal vehicle -->
            <vs-dialog v-model="showModalFormVehicle">
            	<template #header>
            		<h4 class="not-margin">
            			Agregar <b>vechículo</b>
            		</h4>
            	</template>


            	<div class="con-form">
            		<form @submit.prevent="storeVehicle">
						<div class="grid grid-cols-6">
							<div class="col-span-6 sm:col-span-4">
				                <jet-label for="license_plate" value="Placa del vehículo" />
				                <jet-input id="license_plate" type="text" class="mt-1 block w-full" v-model="form.license_plate" autocomplete="license_plate" />
				                <jet-input-error :message="form.errors.license_plate" class="mt-2" />
				            </div>
				            <!-- Marca -->
				            <div class="col-span-6 sm:col-span-4">
				                <jet-label for="brand" value="Marca" />
				                <jet-input id="brand" type="text" class="mt-1 block w-full" v-model="form.brand" autocomplete="brand" />
				                <jet-input-error :message="form.errors.brand" class="mt-2" />
				            </div>
				            <!-- carrier -->
				             <div class="col-span-6 sm:col-span-4">
				                <jet-label for="carrier" value="Conductor" />
				                <jet-input id="carrier" type="text" class="mt-1 block w-full" v-model="form.carrier" autocomplete="carrier" />
				                <jet-input-error :message="form.errors.carrier" class="mt-2" />
				            </div>
			            	<div class="col-span-6 lg:col-span-4">
			            		<jet-label for="photo_plate" value="Subir imagen placa" />
					        	<label for="photo_plate" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 p-1 ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
					        		<span>Subir</span>
					        		<input type="file"  id="photo_plate"  ref="photo_plate" @change="uploadImagen" class="w-px h-px opacity-0 overflow-hidden absolute" accept=".pdf, .jpg, .png" />
					        	</label>
					        	<span v-if="uploadedImagen" class="ml-4 text-green-500">¡Hecho!</span>
					        </div>
				            	
				           <div class="col-span-6 sm:col-span-4">
					           	<jet-button class="mt-2" :disabled="form.processing">
					                Guardar
					            </jet-button>
				           </div>
						</div>
					</form>
            	</div>

            	<template #footer>
            		<div class="footer-dialog">
            			<vs-button block @click="closeModalFormVehicle">
            				Cerrar
            			</vs-button>
            		</div>
            	</template>
            </vs-dialog>
            <!-- end modal -->
        </div>
	</admin-layout>
</template>
<script>
	import AdminLayout from '@/Layouts/AdminLayout'
    import JetInput from '@/Jetstream/Input'
    import JetLabel from '@/Jetstream/Label'
    import JetInputError from '@/Jetstream/InputError'
    import JetActionMessage from '@/Jetstream/ActionMessage'
    import JetButton from '@/Jetstream/Button'
    import vSelect from "vue-select"
    import 'vue-select/dist/vue-select.css'
    import TableResponsiveComponent from '@/Components/TableResponsive'
    import ThResponsiveComponent from '@/Components/THResponsive'
    import TdResponsiveComponent from '@/Components/TDResponsive'
    import JetDialogModal from "@/Jetstream/DialogModal"

    export default {
    	components: {
            JetInput,
            JetLabel,
            JetInputError,
            JetActionMessage,
            JetButton,
            AdminLayout,
            vSelect,
            TableResponsiveComponent,
            ThResponsiveComponent,
            TdResponsiveComponent,
            JetDialogModal,
    	},
    	props: {
    		flash: {
    			type: Object
    		}
    	},
    	data(){
            return {
            	status:{},
                clients: [],
                vehicles: [],
                orders: [],
                details: [],
                titles: [
                	'Producto',
                	'Cantidad',
                	'Entregado',
                	'Remisionar',
                	'Vehículo',
                	'Dirección Entrega',
                	'Consignación'
                ],
                error_client: null,
                user_id: null,
                user_name: null,
                order_id: null,
                showModalFormVehicle: false,
                uploadedImagen: false,
                form: this.$inertia.form({
                    license_plate: '',
                    brand: '',
                    photo_plate: null,
                    user_id: null,
                    carrier: null,
                    state: 1
                }),
                remi: this.$inertia.form({
                    delivered: null,
            		order_details_id: null,
            		vehicle_users_id: null,
            		firm:null
                })
            }
        },
        mounted(){

        },
        methods: {
        	storeVehicle(){
        		if (this.$refs.photo_plate) {
                    this.form.photo_plate = this.$refs.photo_plate.files[0]
                }
                this.form.user_id =  this.user_id;

                const loading = this.$vs.loading({
            		type: 'circles'
            	});

                this.form.post(route('vehicle.store'), {
                    errorBag: 'storeVehicle',
                    preserveScroll: true,
                    onStart: () => { 
                    	this.showModalFormVehicle = false;
                    	loading.text = "Procesando..."
                    },
				  	onSuccess: () => {
				  		loading.text = "¡Hecho!";
				  		this.uploadedImagen = false;

				  		for (var val in this.flash){
				  			if (this.flash[val]) {
				  				this.status = {
				  					type: val,
				  					text: this.flash[val]
				  				}
				  			}
				  		}
				  	},
				  	onFinish: () => {
				  		loading.close()
				  	},
                });
        	},
            storeRemission(item){

            	this.remi.clearErrors();

        		this.remi.delivered = item.cantidad;
        		this.remi.order_details_id = item.id;
        		this.remi.vehicle_users_id = item.vehicle_user;

            	if (this.$refs.firm) {
                    this.remi.firm = this.$refs.firm.files[0]
                }

                const loading = this.$vs.loading({
            		type: 'circles'
            	});

                this.remi.post(route('remission.store'), {
                    preserveScroll: true,
                    onStart: () => { 
                    	loading.text = "Procesando..."
                    },
				  	onSuccess: () => {
				  		loading.text = "¡Hecho!";
				  		this.uploadedImagen = false;

				  		for (var val in this.flash){
				  			if (this.flash[val]) {
				  				this.status = {
				  					type: val,
				  					text: this.flash[val]
				  				}
				  			}
				  		}
				  	},
				  	onFinish: () => {
				  		loading.close()
				  	},
                });
            },
            onSearch(search, loading) {
		      if(search.length >= 3) {
		        loading(true);
		        this.search(loading, search, this);
		      }
		    },
		    search: _.debounce((loading, search, vm) => {
		      axios.get(
		        `/getClientWithOrders/client?q=${search}`
		      ).then(res => {
		      	vm.clients = res.data.clients;
		      	vm.status = {
		      		type: res.data.type,
		      		text: res.data.text,
		      	}
		        loading(false);
		      });
		    }, 350),
		    loadOrders(value){
		    	this.clients.map( item => {
		    		if (item.id == value) {
		    			this.vehicles = item.vehicles;
		    			this.user_name = item.name;
		    		}
		    	})
		    	axios.get(
		    		`/getOrdersByUserId/order?id=${value}`
		    	).then( res => {
		    		this.orders = res.data.orders;
		    		this.status = {
			      		type: res.data.type,
			      		text: res.data.text,
			      	}
		    	});
		    },
		    showDetailOrder(value){
		    	axios.get(
		    		`/getOrderDetailsByOrderId/orderDetail?id=${value}`
		    	).then( res => {
		    		this.details = res.data.details;

		    		this.status = {
			      		type: res.data.type,
			      		text: res.data.text,
			      	}
		    	});
		    },
		    validateQuantity(item){
		    	var deli = this.total_delivered(item.remissions);
		    	var total = item.quantity - deli;
		    	if (item.cantidad < 1 || item.cantidad > total) {
		    		item.cantidad = 1;
		    		this.status = {
		    			type: "warning",
		    			text: "La cantidad no puede ser menor a 1 o mayor a la cantidad del detalle",
		    		}
		    	}
		    },
		    openModalStoreVehicle(){
		    	this.showModalFormVehicle = true;
		    },
		    closeModalFormVehicle(){
		    	this.showModalFormVehicle = false;	
		    },
		    uploadImagen(){
		    	this.uploadedImagen = true;
		    },
		    total_delivered(remissions){
		    	var res = 0;
        		if (remissions.length) {
        			remissions.map(item => {
        				res += parseFloat(item.delivered)
        			});
        		}
        		return res;
        	},
        	getLimitUp(original,  remissions){
        		var deli = this.total_delivered(remissions)
        		return original - deli;
        	},
        	fullyDispatched(item){
        		var dispatched = this.total_delivered(item.remissions);
        		return item.quantity - dispatched;
        	}
        }

    }
</script>