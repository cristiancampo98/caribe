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
		                <jet-label for="user_id" value="Pedidos" />
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
             <table-responsive-component v-if="details.length">
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
                                		{{item.product.units_measure.name}}
                                	</span>
                                </td-responsive-component>
                                <td-responsive-component>
                                	0
                                </td-responsive-component>
                                <td-responsive-component>
                                	<jet-input type="number" class="mt-1 block w-full"
                                	:max="item.quantity"
                                	min="0"
                                	@change.native="validateQuantity(item)"
                                	v-model.number="item.cantidad"/>
                                </td-responsive-component>
                                <td-responsive-component>
                                	<jet-input type="date"  
                                	v-model="item.fecha"/>
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
	                            	<jet-button type="button" @click.native="storeRemission(item)">
	                            		Remisión
	                            	</jet-button>
	                            </td-responsive-component>
                             
                            </tr>
                        </template>
                    </table-responsive-component>
            <!-- end table  -->

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
            TdResponsiveComponent
    	},
    	props: {
    		
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
                	'Fecha entrega',
                	'Vehículo',
                	'Dirección Entrega',
                	'Consignación'
                ],
                error_client: null,
                user_id: null,
                user_name: null,
                order_id: null
            }
        },
        mounted(){

        },
        methods: {
            storeRemission(item){
                // this.form.post(route('product.store'), {
                //     errorBag: 'storeProduct',
                //     preserveScroll: true
                // });
                console.log(item)
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
		    	if (item.cantidad < 1 || item.cantidad > item.quantity) {
		    		item.cantidad = 1;
		    		this.status = {
		    			type: "warning",
		    			text: "La cantidad no puede ser menor a 1 o mayor a la cantidad del detalle",
		    		}
		    	}
		    }
        }

    }
</script>