<template>
	<admin-layout :status="status">
		 <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Editar Pedido
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

				<jet-form-section @submitted="updateOrder">
			        <template #title>
			            Información de pedido
			        </template>

			        <template #description>
			            Edita un pedido con la información requerida.
			        </template>

			        <template #form>

			            <!-- user id or cliente -->
			            <div class="col-span-6 lg:col-span-3" v-if="$page.props.isAdmin">
			                <jet-label for="user_id" 
			                :value="`Cliente: ${order.client.name}`" />
			                <v-select 
					        label="name" 
					        :filterable="false" 
					        :options="clients" 
					        v-model="form.user_id"
					        :reduce= "clients => clients.id"
					        @input="getTypePay"
					        @search="onSearch">
							    <template slot="no-options">
							      Escribe el nombre de un cliente o empresa
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
							      </div>
							    </template>
							</v-select>
			                <jet-input-error :message="form.errors.user_id" class="mt-2" />
			            </div>
			            <div class="col-span-6 lg:col-span-3" v-else>
			            	<jet-label for="user_id" value="Cliente" />
			            	<span class="border border-gray-300 rounded-md shadow-sm mt-1 block w-full my-2 py-2 pl-2 bg-gray-200">{{user.name}}</span>
			            </div>
			             <div class="col-span-6 lg:col-span-3">
			                <jet-label for="deparment" value="Departamento" />
			                <v-select 
			            	class="mt-1"
			            	id="deparment"
			            	label="departamento"
			            	:options="deparments"
			            	:clearable="false"
			            	:value="form.department"
			            	@input="showCitys"></v-select>
			            </div>
			            <!-- city -->
			            <div class="col-span-6 lg:col-span-3" >
			                <jet-label for="city" value="Ciudad" />
			               	<v-select 
			               	v-if="form.city || citys.length"
			            	class="mt-1"
			            	id="city"
			            	label="ciudades"
			            	v-model="form.city"
			            	:options="citys"></v-select>
			                <jet-input-error :message="form.errors.city" class="mt-2" />
			            </div>
			            <!-- shipping address -->
			            <div class="col-span-6 lg:col-span-3">
			                <jet-label for="shipping_address" value="Dirección envío" />
			               	<jet-input id="shipping_address" type="text" class="mt-1 block w-full" v-model="form.shipping_address" required/>
			                <jet-input-error :message="form.errors.shipping_address" class="mt-2" />
			            </div>
			           <!-- note -->
			            <div class="col-span-6 lg:col-span-6">
			                <jet-label for="note" value="Nota" />
			               	<textarea id="note" class="mt-1 block w-full rounded-lg" v-model="form.note"></textarea>
			                <jet-input-error :message="form.errors.note" class="mt-2" />
			            </div>
			             <!-- pse_url -->
				        <div class="col-span-6 lg:col-span-3">
				        	<jet-label for="pse_url" value="Link PSE" />
				        	<jet-input id="pse_url" type="text" class="mt-1 block w-full" v-model="form.pse_url" />
				            <jet-input-error :message="form.errors.pse_url" class="mt-2" />
				        </div>
				        <!-- pse_number -->
				        <div class="col-span-6 lg:col-span-3">
				        	<jet-label for="pse_number" value="PSE # radicado" />
				        	<jet-input id="pse_number" type="text" class="mt-1 block w-full" v-model="form.pse_number" />
				            <jet-input-error :message="form.errors.pse_number" class="mt-2" />
				        </div>
			             <!-- contrato -->
			            <div class="col-span-6 lg:col-span-3" v-if="type_pay == 'crédito'">
			            	<label for="contract" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
			            		<span>Subir contrato</span>
			            		<input type="file"  id="contract"  ref="contract" @change="uploadContract" class="w-px h-px opacity-0 overflow-hidden absolute" accept=".pdf, .jpg, .png" />
			            		<p class="text-xs text-gray-500">PDF, JPG, PNG</p>
			            	</label>
			            	<span v-if="uploadedContract" class="ml-4 text-green-500">¡Hecho!</span>
			            	<jet-input-error :message="form.errors.contract" class="mt-2" />
			            </div>
			             <!-- orden de compra -->
			            <div class="col-span-6 lg:col-span-3" v-if="type_pay == 'crédito'">
			            	<label for="purchaseOrder" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
			            		<span>Subir orden de compra</span>
			            		<input type="file"  id="purchaseOrder"  ref="purchaseOrder" @change="uploadPurchaseOrder" class="w-px h-px opacity-0 overflow-hidden absolute" accept=".pdf, .jpg, .png" />
			            		<p class="text-xs text-gray-500">PDF, JPG, PNG</p>
			            	</label>
			            	<span v-if="uploadedPurchaseOrder" class="ml-4 text-green-500">¡Hecho!</span>
			            	<jet-input-error :message="form.errors.purchaseOrder" class="mt-2" />
			            </div>
			            
			            <div class="col-span-6 lg:col-span-6" v-if="order.order_details[0].remissions.length">
			            	<p class="text-sm">Este pedido ya tiene remisiones por lo tanto  <strong>no será posible editar el detalle del pedido</strong>.</p>
			            </div>
			           	<div class="col-span-6 lg:col-span-6" v-if="!order.order_details[0].remissions.length">
			           		<h3>Pedido</h3>
			            	<p class="text-sm">Selecciona un producto y su cantidad y presiona en <strong>el boton <u>Agregar</u></strong>  para agregarlo a la lista.</p>
			           	</div>
			            <!-- productos -->
			            <div class="col-span-6 lg:col-span-2" v-if="!order.order_details[0].remissions.length">
			            	<jet-label for="product_id" value="Producto" />
			            	<v-select 
			            	class="mt-1"
			            	id="product_id"
			            	label="name"
			            	v-model="product_detail"
			            	:options="products"></v-select>
			            	<p class="text-sm text-red-500" v-if="error_product">Debes seleccionar un producto</p>
			            	<jet-input-error :message="form.errors.order_details" class="mt-2" />
			            </div>
			            <!-- quantity -->
			             <div class="col-span-6 lg:col-span-1" v-if="!order.order_details[0].remissions.length">
			                <jet-label for="quantity" value="Cantidad en m3" />
			               	<jet-input id="quantity" type="number" class="mt-1 block w-full" min="1" v-model.number="quantity" />
			            </div>
			            <div class="col-span-6 lg:col-span-1" v-if="!order.order_details[0].remissions.length">
			            	<button type="button" @click="addToCar()" class="self-center inline-flex items-center px-4 py-2 mt-6 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-white hover:border-black active:bg-gray-900 focus:outline-none focus:border-black focus:shadow-outline-green transition ease-in-out duration-150">
				            	Agregar
				            </button>
			            </div>
			            <div class="col-span-6 lg:col-span-6" v-if="!order.order_details[0].remissions.length">
			            	<table-responsive-component v-if="Object.keys(form.order_details).length">
				            	<template #title>
				            		<tr>
				            			<th-responsive-component 
				            			v-for="(title, key) in titles"
				            			:key="key">{{title}}</th-responsive-component>
				            			<th-responsive-component></th-responsive-component>
				            		</tr>
				            	</template>
				            	<template #content>
				            		<tr v-for="(item, key) in form.order_details" :key="key">
				            			<td-responsive-component>{{item.name}}</td-responsive-component>
				            			<td-responsive-component>{{item.quantity}}</td-responsive-component>
				            			<td-responsive-component>
				            				<button type="button" @click="deleteToCar(key)" class="bg-red-500 hover:bg-red-700 rounded-lg border-2 border-white hover:border-black text-white py-1 px-2">
				            					Eliminar
				            				</button>
				            			</td-responsive-component>

				            		</tr>
				            	</template>
				            </table-responsive-component>
			            </div>
			           
			        </template>

			        <template #actions>
			            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
			                Guardado.
			            </jet-action-message>

			            <jet-button type="button" @click.native="sendEmail" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
			                Guardar
			            </jet-button>
			        </template>
			    </jet-form-section>
			    <vs-dialog width="550px" not-center v-model="confirm">
			        <template #header>
			          <h4 class="not-margin">
			            Enviar notificación por correo a <b>{{order.client.name}}</b>
			          </h4>
			        </template>


			        <div class="con-content">
			          <p>
			            ¿Quieres enviar una notificación al usuario informandole que su pedido ha sido actualizado?. <br>
			            Enviar una notificación al usuario podrá causar que la operación tarde mas ¿Quieres enviarla?
			          </p>
			        </div>

			        <template #footer>
			          <div class="con-footer">
			            <vs-button @click="updateOrder(true)" transparent>
			              Si, enviar notificación
			            </vs-button>
			            <vs-button @click="updateOrder(false)" dark transparent>
			              No enviar notificación
			            </vs-button>
			          </div>
			        </template>
			    </vs-dialog>

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
    import TableResponsiveComponent from '@/Components/TableResponsive'
    import ThResponsiveComponent from '@/Components/THResponsive'
    import TdResponsiveComponent from '@/Components/TDResponsive'
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
            TableResponsiveComponent,
            ThResponsiveComponent,
            TdResponsiveComponent,
            vSelect

    	},
    	props: {
    		order: {
    			type: Object
    		},
    		products: {
    			type: [Object, Array],
    			required: true
    		},
    		user: {
    			type: Object,
    			required: true
    		},
    		contract_old: {
    			type: Array,
    			required: true
    		},
    		purchase_order_old: {
    			type: Array,
    			required: true
    		}
    	},
    	data(){
            return {
            	status:{},
            	confirm: false,
                form: this.$inertia.form({
                	_method: 'put',
                    user_id: this.order.user_id,
                    shipping_address: this.order.shipping_address,
                    department: this.order.department,
                    city: this.order.city,
                    note: this.order.note,
                    pse_url: this.order.pse_url,
                    pse_number: this.order.pse_number,
                    contract: null,
                    purchaseOrder: null,
                    order_details: [],
                    send_email:false,
                    type_pay: false,
                    credit_documents: null
                }),
                product_detail: [],
                quantity: 1,
                error_product: false,
                titles: [
                	'Producto',
                	'Cantidad en metros cúbicos',
                ],
                clients: [],
                deparments: [],
                citys: [],
                uploadedContract: false,
                uploadedPurchaseOrder: false,
                type_pay: null,
                loading: false

            }
        },
        mounted(){
        	this.loadFileColombiaJson();
        	this.setProductStorageToFormOrderDetails()
        	this.type_pay = this.order.client.details.type_pay;
        },
        methods: {
        	setProductStorageToFormOrderDetails(){
        		this.order.order_details.map(item => {
        			var detail = {
        				product_id : item.product_id,
						name  : item.product.name,
						quantity  : item.quantity,
        			}
        			this.form.order_details.push(detail);
        		});
        	},
        	uploadContract(){
        		this.uploadedContract = true
        	},
        	uploadPurchaseOrder(){
        		this.uploadedPurchaseOrder = true
        	},
            updateOrder(email){

                if (this.$refs.contract) {
                    this.form.contract = this.$refs.contract.files[0]
                    this.form.credit_documents = false;
                }
                if (this.$refs.purchaseOrder) {
                    this.form.purchaseOrder = this.$refs.purchaseOrder.files[0]
                    this.form.credit_documents = false;
                }

                if (this.contract_old.length || this.purchase_order_old.length) {
            		this.form.credit_documents = true;
            	}

            	if (this.type_pay == 'crédito') {
            		this.form.type_pay = true;
            	}else{
            		this.form.type_pay = false;
            	}
            	if (! this.$page.props.isAdmin) {
            		this.form.user_id = this.user.id
            	}
            	this.form.send_email = email;
            	
                this.form.post(route('order.update',{id : this.order.id}), {
                    errorBag: 'updateOrder',
                    preserveScroll: true,
                    onStart: (visit) => { 
                    	this.confirm = false;
                    	this.startLoading();
                    },
				  	onSuccess: () => { 
				  		this.loading.text = "¡Hecho!"
				  	},
				  	onFinish: () => {
				  		this.endLoading();
				  	},
                });
            },
            sendEmail(){
            	this.confirm = true;
            },
            loadFileColombiaJson(){
            	axios.get('/default/colombia-json-master/colombia.json')
            	.then( res => {
            		this.deparments = res.data;
            	})
            },
            showCitys(value){
            	this.citys = value.ciudades;
            	this.form.department = value.departamento;
            },
            addToCar(){
            	if (this.quantity < 1) {
            		this.quantity *= -1;
            	}
            	//Valida que se haya selecciona un producto
            	if (Object.keys(this.product_detail).length !== 0) {

            		this.error_product = false

            		var pedido = { 
						product_id: this.product_detail.id,
						name : this.product_detail.name, 
						quantity :this.quantity,
					}
	            	
	            	//Valida que el producto ya se haya agregado anteriormente
	            	const found = this.form.order_details.find(
	            		element => element.product_id == this.product_detail.id
	            	);

					if (found) {
						//Si lo encuentra modifica por los nuevos datos
						found.quantity = parseInt(this.quantity);
					}else{
						//Si no lo encuentra agrega el nuevo producto
						this.form.order_details.push(pedido);
					}
            	}else{
            		this.error_product = true
            	}
            },
            deleteToCar(index){
            	//Elimina el producto de la tabla
            	this.form.order_details.splice(index,1)
            },
            onSearch(search, loading) {
		      if(search.length >= 3) {
		        loading(true);
		        this.search(loading, search, this);
		      }
		    },
		    search: _.debounce((loading, search, vm) => {
		      axios.get(
		        `/getClients/client?q=${search}`
		      ).then(res => {
		      	vm.clients = res.data;
		        loading(false);
		      });
		    }, 350),
		    getTypePay(value){
		    	const found = this.clients.find( item => item.id == value);
		    	if (found) {
		    		this.type_pay = found.type_pay;
		    	}
		    },
		    startLoading(){
                
                this.loading = this.$vs.loading({
                    type: 'circles'
                });
                this.loading.text = "Procesando...";
            },
            endLoading(){
                this.loading.close();
            },
        }

    }
</script>