<template>
	<admin-layout>
		 <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Actualizar permiso
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

				
			       <jet-form-section @submitted="updateProduct">
			        <template #title>
			            Información de producto
			        </template>

			        <template #description>
			            Crea un producto con la información requerida.
			        </template>

			        <template #form v-if="showFormEdit">

			            <!-- Name -->
			            <div class="col-span-6 lg:col-span-3">
			                <jet-label for="name" value="Nombre" />
			                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" autocomplete="name" maxlength="100" />
			                <jet-input-error :message="form.errors.name" class="mt-2" />
			            </div>
			            <!-- Reference -->
			            <div class="col-span-6 lg:col-span-3">
			                <jet-label for="reference" value="Referencia" />
			                <jet-input id="reference" type="text" class="mt-1 block w-full" v-model="form.reference" autocomplete="reference" maxlength="50" />
			                <jet-input-error :message="form.errors.reference" class="mt-2" />
			            </div>
			            <!-- Unit measure -->
			            <div class="col-span-6 lg:col-span-3">
			                <jet-label for="unit_measure_id" value="Unidad medida" />
			                <select v-model="form.unit_measure_id" class="mt-1 block w-full rounded-lg" required>
			                	<option value="0" disabled> Seleccione una opción</option>
							  	<option v-for="option in units_measure" v-bind:value="option.id">
								    {{ option.name }}
							  	</option>
							</select>
			                <jet-input-error :message="form.errors.unit_measure_id" class="mt-2" />
			            </div>
			            <!-- Price -->
			            <div class="col-span-6 lg:col-span-3">
			                <jet-label for="price" value="Precio" />
			                <jet-input id="price" type="number" class="mt-1 block w-full" v-model.number="form.price" autocomplete="price" />
			                <jet-input-error :message="form.errors.price" class="mt-2" />
			            </div>
			            <!-- Description -->
			            <div class="col-span-6 lg:col-span-6">
			                <jet-label for="description" value="Descripción" />
			                <textarea id="description" class="mt-1 block w-full rounded-lg" v-model="form.description"></textarea>
			                <jet-input-error :message="form.errors.description" class="mt-2" />
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

    export default {
    	components: {
            JetFormSection,
            JetInput,
            JetLabel,
            JetInputError,
            JetActionMessage,
            JetButton,
            AdminLayout,
    	},
		/*,
		
    		
    	
        mounted(){
        	this.productHasDetail();
        },
        */
	   data(){
            return {
                form: this.$inertia.form({
                	_method: 'PUT',
                    name: this.product.name,
                    reference: this.product.reference,
                    unit_measure_id: this.product.unit_measure_id,
                    price: this.product.price,
                    description: this.product.description,
					photos: []
                }),
				showFormEdit: false
            }
        },
		props: {
            product: Object,
			units_measure: {
    			type: [Object,Array],
    			required: true
    		}
        }, 
	   
		 mounted(){
        	this.productHasDetail();
        },
	   methods: {
			
            updateProduct(){
				this.form.post(route('product.update', { id: this.product.id }), {
                    errorBag: 'updateProduct',
                    preserveScroll: true
                });
				
            },
            getFiles(files){
            	for (var i = 0; i < files.length; i++) {
            		if (files[i].type != "application/pdf") {
            			
            			this.form.photos.push(files[i]);
            		}
            	}
            	console.log(this.form.photos);	
            },
			productHasDetail(){
            	if (this.product.details) {
            		this.form.name = this.product.details.name;
                    this.form.reference = this.product.details.reference;
                    this.form.unit_measure_id = this.product.details.unit_measure_id;
                    this.form.price = this.product.details.price;
                    this.form.description = this.product.details.description;
                    this.form.photos = this.product.details.photos;

            	}
            	this.showFormEdit = true;
            }
            }
        }

</script>