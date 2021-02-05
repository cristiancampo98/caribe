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

			            <!-- user id or cliente -->
			            <div class="col-span-6 lg:col-span-2" v-if="clients.length">
			                <jet-label for="user_id" value="Cliente" />
			                <select v-model="form.user_id" id="user_id" class="mt-1 block w-full rounded-lg" required>
			                	<option value="0" disabled> Seleccione una opción</option>
							  	<option v-for="option in clients" v-bind:value="option.user_id">
								    {{ option.users.name }}
							  	</option>
							</select>
			                <jet-input-error :message="form.errors.user_id" class="mt-2" />
			            </div>
			            <div class="col-span-6 lg:col-span-2" v-else>
			            	<jet-label for="user_id" value="Cliente" />
			            	<span class="border border-gray-300 rounded-md shadow-sm mt-1 block w-full my-2 py-2 pl-2 bg-gray-200">{{user.name}}</span>
			            </div>
			            <!-- city -->
			            <div class="col-span-6 lg:col-span-2">
			                <jet-label for="city" value="Ciudad" />
			               	<jet-input id="city" type="text" class="mt-1 block w-full" v-model="form.city" required />
			                <jet-input-error :message="form.errors.city" class="mt-2" />
			            </div>
			            <!-- shipping address -->
			            <div class="col-span-6 lg:col-span-2">
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

			            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
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
    		clients: {
    			type: [Object, Array, Boolean],
    			required: true
    		},
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
                    order_details: []
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
                ]

            }
        },
        mounted(){

        },
        methods: {
            storeOrder(){
            	if (! this.clients) {
            		this.form.user_id = this.user.id
            	}
                this.form.post(route('order.store'), {
                    errorBag: 'storeOrder',
                    preserveScroll: true
                });
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

            	
            	console.log(this.form.order_details)
            },
            deleteToCar(index){
            	//Elimina el producto de la tabla
            	this.form.order_details.splice(index,1)
            }
        }

    }
</script>