<template>
	<admin-layout>
		 <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Crear Pedido
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

				<jet-form-section @submitted="storeOrder">
			        <template #title>
			            Información de pedido
			        </template>

			        <template #description>
			            Crea un pedido con la información requerida.
			        </template>

			        <template #form>
			        	<ul class="col-span-6 bg-red-500 text-white py-2 px-8" v-if="Object.keys(form.errors).length">
			        		<li type="disc" v-for="error in form.errors">{{error}}</li>
			        	</ul>

			            <!-- user id or cliente -->
			            <div class="col-span-6 lg:col-span-3" v-if="$page.props.isAdmin">
			                <jet-label for="user_id" value="Cliente" />
			                <v-select 
					        label="name" 
					        :filterable="false" 
					        :options="clients" 
					        v-model="form.user_id"
					        :reduce= "clients => clients.id"
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
			           	<!--  consignment_number-->
			            <div class="col-span-6 lg:col-span-3">
			            	<jet-label for="consignment_number" value="Consignación" />
			            	<jet-input id="consignment_number" type="text" class="mt-1 block w-full" v-model="form.consignment.consignment_number" />
			            </div>
			            <!-- imagen -->
			            <div class="col-span-6 lg:col-span-3">
			            	<label for="imagen" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
			            		<span>Subir imagen</span>
			            		<input type="file"  id="imagen"  ref="imagen" @change="uploadImagen" class="w-px h-px opacity-0 overflow-hidden absolute" accept=".pdf, .jpg, .png" />
			            	</label>
			            	<span v-if="uploadedImagen" class="ml-4 text-green-500">¡Hecho!</span>
			            </div>
			            <!-- pse_urlpse_url -->
			            <div class="col-span-6 lg:col-span-3">
			            	<jet-label for="pse_url" value="Link PSE" />
			            	<jet-input id="pse_url" type="text" class="mt-1 block w-full" v-model="form.consignment.pse_url" />
			            </div>
			            <!-- pse_number -->
			            <div class="col-span-6 lg:col-span-3">
			            	<jet-label for="pse_number" value="PSE # radicado" />
			            	<jet-input id="pse_number" type="text" class="mt-1 block w-full" v-model="form.consignment.pse_number" />
			            </div>

			           <div class="col-span-6 lg:col-span-6">
			           	<h3>Pedido</h3>
			            <p class="text-sm">Selecciona un producto y su cantidad y presiona en <strong>el boton <u>Agregar</u></strong>  para agregarlo a la lista.</p>
			           	</div>
			            <!-- productos -->
			            <div class="col-span-6 lg:col-span-2">
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
			             <div class="col-span-6 lg:col-span-1">
			                <jet-label for="quantity" value="Cantidad" />
			               	<jet-input id="quantity" type="number" class="mt-1 block w-full" min="1" v-model.number="quantity" />
			            </div>
			            <!-- Discount -->
			             <div class="col-span-6 lg:col-span-1">
			                <jet-label for="discount" value="Descuento" />
			               	<jet-input id="discount" type="number" class="mt-1 block w-full" min="0" v-model.number="discount" />
			            </div>
			            <button type="button" @click="addToCar()" class="self-center inline-flex items-center px-4 py-2 mt-6 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-white hover:border-black active:bg-gray-900 focus:outline-none focus:border-black focus:shadow-outline-green transition ease-in-out duration-150">
			            	Agregar
			            </button>
			        </template>

			        <template #actions>
			            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
			                Guardado.
			            </jet-action-message>

			            <jet-button :class="{ 'opacity-25': form.processing }" >
			                Guardar
			            </jet-button>
			        </template>
			    </jet-form-section>

			    <div class="mt-8" v-if="Object.keys(form.order_details).length">
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
		            		<tr v-for="(item, key) in form.order_details" :key="key">
		            			<td-responsive-component>{{item.name}}</td-responsive-component>
		            			<td-responsive-component>{{item.quantity}}</td-responsive-component>
		            			<td-responsive-component>
		            				{{item.quantity * item.price}}
		            			</td-responsive-component>
		            			<td-responsive-component>{{item.discount}}</td-responsive-component>
		            			<td-responsive-component>
		            				{{item.quantity * item.price - item.discount}}
		            			</td-responsive-component>
		            			<td-responsive-component>
		            				<button type="button" @click="deleteToCar(key)" class="bg-red-500 hover:bg-red-700 rounded-lg border-2 border-white hover:border-black text-white py-1 px-2">
		            					Eliminar
		            				</button>
		            			</td-responsive-component>

		            		</tr>
		            	</template>
		            </table-responsive-component>
			    	
			    </div>

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
    		
    		products: {
    			type: [Object, Array],
    			required: true
    		},
    		user: {
    			type: Object,
    			required: true
    		}
    	},
    	data(){
            return {
                form: this.$inertia.form({
                    user_id: null,
                    shipping_address: null,
                    city: null,
                    note: null,
                    total: 0,
                    order_details: [],
                    consignment: {
                    	consignment_number: null,
	                    pse_url: null,
	                    pse_number: null,
	                    imagen: null
                    }
                }),
                product_detail: [],
                quantity: 1,
                discount: 0,
                error_product: false,
                titles: [
                	'Producto',
                	'Cantidad',
                	'Basico',
                	'Descuento',
                	'Neto'
                ],
                clients: [],
                deparments: [],
                citys: [],
                uploadedImagen: false

            }
        },
        mounted(){
        	this.loadFileColombiaJson()
        },
        methods: {
        	uploadImagen(){

        	},
            storeOrder(){
            	if (this.$refs.imagen) {
                    this.form.consignment.imagen = this.$refs.imagen.files[0]
                }
            	if (! this.$page.props.isAdmin) {
            		this.form.user_id = this.user.id
            	}
                this.form.post(route('order.store'), {
                    errorBag: 'storeOrder',
                    preserveScroll: true
                });
            },
            loadFileColombiaJson(){
            	axios.get('/default/colombia-json-master/colombia.json')
            	.then( res => {
            		this.deparments = res.data;
            	})
            },
            showCitys(value){
            	this.citys = value.ciudades
            },
            addToCar(){
            	if (this.quantity < 1 || this.discount < 0) {
            		this.quantity *= -1;
            		this.discount *= -1;
            	}
            	//Valida que se haya selecciona un producto
            	if (Object.keys(this.product_detail).length !== 0) {

            		this.error_product = false

            		var pedido = { 
						product_id: this.product_detail.id,
						name : this.product_detail.name, 
						quantity :this.quantity, 
						price: parseInt(this.product_detail.price),
						discount: parseInt(this.discount)
					}
	            	
	            	//Valida que el producto ya se haya agregado anteriormente
	            	const found = this.form.order_details.find(
	            		element => element.product_id == this.product_detail.id
	            	);

					if (found) {
						//Si lo encuentra modifica por los nuevos datos
						found.quantity = parseInt(this.quantity);
						found.discount = parseInt(this.discount);
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
		    }, 350)
        }

    }
</script>