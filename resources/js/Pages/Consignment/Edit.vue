<template>
	<admin-layout>
		 <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Editar consignación
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

				<jet-form-section @submitted="updateConsignment">
			        <template #title>
			            Información de consignación
			        </template>
			        <template #description>
			            Edita una consignación con la información requerida.
			        </template>
			        <template #form>
			        	<!--  consignment_number-->
			            <div class="col-span-6 lg:col-span-2">
			            	<jet-label for="consignment_number" value="Consignación" />
			            	<jet-input id="consignment_number" type="text" class="mt-1 block w-full" v-model="form.consignment_number" />
			            	 <jet-input-error :message="form.errors.consignment_number" class="mt-2" />
			            </div>
			            <!-- imagen -->
			            <div class="col-span-6 lg:col-span-2">
			            	<label for="imagen" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150 cursor-pointer">
			            		<span>Subir imagen</span>
			            		<input type="file"  id="imagen"  ref="imagen" @change="uploadImagen" class="w-px h-px opacity-0 overflow-hidden absolute" accept=".pdf, .jpg, .png" />
			            	</label>
			            	<p class="text-xs text-gray-500">PDF JPG PNG</p>
			            	<span v-if="uploadedImagen" class="ml-4 text-green-500">¡Hecho!</span>
			            	<jet-input-error :message="form.errors.imagen" class="mt-2" />
			            </div>
			        	<div class="col-span-6 lg:col-span-4">
			        		<client-with-order-component
			        		:client="{ user_id: consignment.order.user_id, name: consignment.order.client.name}"
			        		:default_order_id="consignment.order_id"
			        		@getValueOrderId="setValueOrderId"
			        		@getDetailsOrder="setDetailsOrder">
			        		</client-with-order-component>
			        	</div>
			        	<div class="col-span-6 lg:col-span-6" v-if="form.order_id">
			        		<jet-label for="consignment_number">
		        			 	<div class="flex items-center">
		        			 		<jet-checkbox v-model="form.fully_apply"/>
		        			 		<div class="ml-2">
			                            ¿Esto es una consignación total?
			                        </div>
		        			 	</div>
			        		</jet-label>
			        		<p class="text-sm text-blue-500 m-1">Si es una consignación parcial, deberás de marcar en la tabla el item que acogido por la consignación. En caso de no ser parcial se vinculará esta consignación a todos los items del pedido.
			        		</p>
			        	</div>
			        	<div class="col-span-6 lg:col-span-6 self-center"
			        	v-if="details_order.length && !form.fully_apply">
				        	<div v-if="Object.keys(form.errors).length">
			            		<ul class="bg-red-500 mt-3 p-2 text-white">
			            			<li v-for="error in form.errors">
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
				                	 <tr v-for="(item, key) in details_order" :key="key">
				                	 	<td-responsive-component>
				                	 		<div v-if="item.consignment_id">
				                	 			<jet-label>
						                	 		<div class="flex items-center">
						                	 			<vs-checkbox danger @click="setStatus(item,'remove')">
						                	 				<template #icon>
													          <i class='bx bx-x'></i>
													        </template>
						                	 			</vs-checkbox>
						                	 			<div class="ml-2 text-red-500">
						                	 				Quitar consignación
						                	 			</div>
						                	 		</div>
						                	 	</jet-label>
						                	</div>
						                	<div v-else>
				                	 			<jet-label>
						                	 		<div class="flex items-center">
						                	 			<vs-checkbox success @click="setStatus(item,'apply')"></vs-checkbox>
						                	 			<div class="ml-2 text-green-500">
						                	 				Aplicar consignación
						                	 			</div>
						                	 		</div>
						                	 	</jet-label>
						                	</div>
				                	 	</td-responsive-component>
				                	 	<td-responsive-component>{{item.product.name}}</td-responsive-component>
				                	 </tr>
				                </template>
				            </table-responsive-component>
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

	import { FormComponentMixin} from '@/Mixins/FormComponentMixin'
	import ClientWithOrderComponent from '@/Components/Client/ClientWithOrderComponent'
    import TableResponsiveComponent from '@/Components/TableResponsive'
	import ThResponsiveComponent from '@/Components/THResponsive'
	import TdResponsiveComponent from '@/Components/TDResponsive'
	import JetCheckbox from '@/Jetstream/Checkbox'

    export default {
    	components: {
    		ClientWithOrderComponent,
    		TableResponsiveComponent,
		    ThResponsiveComponent,
		    TdResponsiveComponent,
		    JetCheckbox
    	},
    	mixins: [FormComponentMixin],
    	props: {
    		consignment: {
    			type: Object
    		}
    	},
    	data(){
            return {
            	prueba: [],
                form: this.$inertia.form({
                    consignment_number: this.consignment.consignment_number,
                    order_id: this.consignment.order_id,
                    details_order: [],
                    imagen: null,
                    fully_apply: this.consignment.fully_apply ? true : false,
                }),
                titles: ['Información','Producto'],
                details_order: [],
                uploadedImagen: false
            }
        },
        mounted(){

        },
        methods: {
        	uploadImagen(){

        	},
            async updateConsignment(){
            	if (this.$refs.imagen) {
                    this.form.imagen = this.$refs.imagen.files[0]
                }

                if (this.form.fully_apply) {
                	this.form.details_order = []
                } else {
                	this.form.details_order = await this.buildDataRemission()
                }

                this.form
                .transform((data) => ({
                	...data,
				    fully_apply: data.fully_apply ? 1 : 0,
				}))
                .put(route('consignment.update', {id: this.consignment.id}), {
                    errorBag: 'updateConsignment',
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
            setValueOrderId(value) {
		    	if (typeof value === 'number') {
		    		this.form.order_id = value	
		    	} else {
		    		this.form.order_id = null
		    	}
		    },
		    setDetailsOrder(value) {
		    	if (value.length) {
		    		this.details_order = value
		    	} else {
		    		this.details_order = []
		    	}
		    },
		    setStatus(item, key) {
		    	if (key === 'apply') {
		    		if (typeof(item.apply) == 'undefined') {
		    			item.apply = null
		    		}
		    		if (item.apply) {
		    			item.apply = false
		    		}else{
		    			item.apply = true
		    		}
		    	} else {
		    		if (typeof(item.remove) == 'undefined') {
		    			item.remove = null
		    		}
		    		if (item.remove) {
		    			item.remove = false
		    		}else{
		    			item.remove = true
		    		}
		    	}
		    },
		    buildDataRemission() {
		    	let data = []
		    	if (!this.form.fully_apply) {
		    		this.details_order.map(element => {
		    			const obj = {
			    			order_details_id: element.id,
			    			apply: element.apply,
			    			remove: element.remove
			    		}
			    		data.push(obj)
			    	})
		    	}
		    	return data
		    }
        }
    }
</script>