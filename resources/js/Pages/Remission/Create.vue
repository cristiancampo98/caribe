<template>
	<admin-layout>
		 <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Crear remissión
            </h2>
        </template>
        <div class="py-12">
        	<div class="grid grid-flow-row lg:grid-flow-col gap-4 auto-rows-max lg:auto-cols-max">
        		<div >
	                <jet-label for="user_id" value="Cliente" />
	                <v-select 
	                class="w-72 min-w-full lg:min-w-max"
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
					        <cite>Empresa: {{ option.name_company }}</cite>
					        </div>
					    </template>
					    <template slot="selected-option" slot-scope="option">
					      <div class="selected d-center">
					      	 <p>{{ option.name }}</p>
					      	 <cite>Empresa: {{ option.name_company }}</cite>
					      </div>
					    </template>
					</v-select>
	                <jet-input-error :message="error_client" class="mt-2" />
	            </div>
	            <div v-if="orders.length">
	                <jet-label for="order_id" value="Pedidos" />
	                <v-select 
			        label="id" 
			        class="w-72 min-w-full lg:min-w-max"
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
	                        	<jet-input type="number" class="mt-4 block w-full"
	                        	:max="getLimitUp(item)"
	                        	step="0.1"
	                        	min="0"
	                        	@change.native="validateQuantity(item)"
	                        	v-model.number="item.cantidad"/>
	                        	<jet-label :value="`Limite por día ${item.product.limit_day}`"/>
	                        	<p class="text-sm text-red-500">
	                        		Limite disponible {{item.quantity - total_delivered(item.remissions)}}
	                        	</p>
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
	                        	<div v-if="item.consignment_id && item.order.client.details.type_pay== 'contado'">
	                        		<jet-button 
	                        		v-if="fullyDispatched(item)" 
	                        		type="button" 
	                        		@click.native="storeRemission(item)">
	                        			Remisión
	                        		</jet-button>
	                        	</div>
	                        	<div v-else-if="item.order.client.details.type_pay== 'crédito'">
	                        		<jet-button 
	                        		v-if="fullyDispatched(item)" 
	                        		type="button" 
	                        		@click.native="storeRemission(item)">
	                        			Remisión
	                        		</jet-button>
	                        	</div>
	                        	<div v-else>
	                        		<p class="text-red-500">Sin consignación</p>
	                        	</div>	
	                        </td-responsive-component>
	                        
	                     
	                    </tr>
	                </template>
	            </table-responsive-component>
	            <div class="grid grid-flow-row lg:grid-flow-col gap-4 auto-rows-max lg:auto-cols-max">
	            	<div>
	            		<jet-button type="button" @click.native="openModalStoreVehicle">Agregar vehículo</jet-button>
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
					        		<p class="mt-2 text-xs text-gray-500">PDF, JPG, PNG</p>
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
	
    import TableResponsiveComponent from '@/Components/TableResponsive'
    import ThResponsiveComponent from '@/Components/THResponsive'
    import TdResponsiveComponent from '@/Components/TDResponsive'
    import { FormComponentMixin} from '@/Mixins/FormComponentMixin'

    export default {
    	components: {
            TableResponsiveComponent,
            ThResponsiveComponent,
            TdResponsiveComponent,
    	},
    	mixins: [FormComponentMixin],
    	data(){
            return {
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
                })
            }
        },
        mounted(){

        },
        methods: {
        	storeVehicle(){
        		this.startLoading();

        		if (this.$refs.photo_plate) {
                    this.form.photo_plate = this.$refs.photo_plate.files[0]
                }
                this.form.user_id =  this.user_id;

                this.form.post(route('vehicle.store'), {
                    errorBag: 'storeVehicle',
                    preserveScroll: true,
                    onStart: () => { 
                    	this.showModalFormVehicle = false;
                    },
				  	onSuccess: () => {
				  		this.loader.text = "¡Hecho!";
				  		this.uploadedImagen = false;
				  		this.getVehiclesByUserId();
				  	},
				  	onFinish: () => {
				  		this.endLoading();
				  		this.form.reset()
				  	},
                });
        	},
        	getVehiclesByUserId(){
        		axios.get(`/getVehiclesByUserId/${this.user_id}/client`)
        		.then(res => {
        			this.vehicles = res.data.vehicles;
        		});
        	},
            storeRemission(item){
            	this.startLoading();
            	this.remi.clearErrors();
        		this.remi.delivered = item.cantidad;
        		this.remi.order_details_id = item.id;
        		this.remi.vehicle_users_id = item.vehicle_user;

                this.remi.post(route('remission.store'), {
                    preserveScroll: true,
                    onStart: () => { 
                    },
				  	onSuccess: () => {
				  		this.loader.text = "¡Hecho!";
				  		this.uploadedImagen = false;
				  	},
				  	onFinish: () => {
				  		this.getStatusFlash();
				  		this.endLoading();
				  		this.remi.reset()
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
		      	vm.setStatusFlash(res.data.type, res.data.text);
		        loading(false);
		      });
		    }, 350),
		    loadOrders(value){
		    	this.startLoading();
		    	this.clients.map( item => {
		    		if (item.id == value) {
		    			this.vehicles = item.vehicles;
		    			this.user_name = item.name;
		    		}
		    	})
		    	axios.get(
		    		`/getOrdersByUserIdToRemission/order?id=${value}`
		    	).then( res => {
		    		this.orders = res.data.orders;
		    		this.setStatusFlash(res.data.type, res.data.text);
		    	})
		    	.finally( () => this.endLoading());
		    },
		    showDetailOrder(value){
		    	this.startLoading();
		    	axios.get(
		    		`/getOrderDetailsByOrderId/orderDetail?id=${value}`
		    	).then( res => {
		    		this.details = res.data.details;
		    		this.setStatusFlash(res.data.type, res.data.text);
		    	})
		    	.finally( () => this.endLoading());;
		    },
		    validateQuantity(item){
		    	var deli = this.total_delivered(item.remissions);
		    	var total = item.quantity - deli;

		    	if (item.cantidad < 0 || item.cantidad > item.product.limit_day) {
		    		item.cantidad = item.product.limit_day;
	    			let type = "error";
	    			let text = `La cantidad no puede ser menor a 1 o mayor a ${item.product.limit_day}`;
		    		this.setStatusFlash(type, text);
		    	}
		    	if (total < item.product.limit_day) {
		    		if (item.cantidad < 0 || item.cantidad > total) {
		    			item.cantidad = total;
		    			let type = "warning";
		    			let text = `La cantidad no puede ser menor a 1 o mayor a ${total}`;
			    		this.setStatusFlash(type, text);
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
		   	/*
		   	 * @ Obtiene el total despachado de las remisiones de un producto
		   	 */
		    total_delivered(remissions){
		    	var res = 0;
        		if (remissions.length) {
        			remissions.map(item => {
        				res += parseFloat(item.delivered)
        			});
        		}
        		return res;
        	},
        	/*
		   	 * @ Obtiene el limite posible para despachar
		   	 */
        	getLimitUp(item){
        		var deli = this.total_delivered(item.remissions)
        		var total = item.quantity - deli;

        		if (total > item.product.limit_day) {
        			return item.product.limit_day;
        		}else {
        			return total;
        		}
        	},
        	fullyDispatched(item){
        		var dispatched = this.total_delivered(item.remissions);
        		return item.quantity - dispatched;
        	},
        }

    }
</script>