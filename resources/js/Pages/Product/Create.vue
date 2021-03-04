<template>
	<admin-layout>
		 <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Crear producto
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

				<jet-form-section @submitted="storeProduct">
			        <template #title>
			            Información de producto
			        </template>

			        <template #description>
			            Crea un producto con la información requerida.
			        </template>

			        <template #form>

			            <!-- Name -->
			            <div class="col-span-6 lg:col-span-2">
			                <jet-label for="name" value="Nombre" />
			                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" autocomplete="name" maxlength="100" />
			                <jet-input-error :message="form.errors.name" class="mt-2" />
			            </div>
			            <!-- Reference -->
			            <div class="col-span-6 lg:col-span-1">
			                <jet-label for="reference" value="Referencia" />
			                <jet-input id="reference" type="text" class="mt-1 block w-full" v-model="form.reference" autocomplete="reference" maxlength="50" />
			                <jet-input-error :message="form.errors.reference" class="mt-2" />
			            </div>
                        <!-- Cubic meters -->
                        <div class="col-span-6 lg:col-span-2">
                            <jet-label for="cubic_meters" value="Equivalencia en metros cúbicos" />
                            <jet-input type="number" class="mt-1 block w-full"
                            id="cubic_meters"
                            step="0.1"
                            min="0"
                            v-model.number="form.cubic_meters"/>
                            <jet-input-error :message="form.errors.cubic_meters" class="mt-2" />
                        </div>
                        <!-- Ton -->
                        <div class="col-span-6 lg:col-span-1">
                            <jet-label for="ton" value="Equivalencia en toneladas" />
                            <jet-input type="number" class="mt-1 block w-full"
                            id="ton"
                            step="0.1"
                            min="0"
                            v-model.number="form.ton"/>
                            <jet-input-error :message="form.errors.ton" class="mt-2" />
                        </div>
			            <!-- Description -->
			            <div class="col-span-6 lg:col-span-6">
			                <jet-label for="description" value="Descripción" />
			                <textarea id="description" class="mt-1 block w-full rounded-lg" v-model="form.description"></textarea>
			                <jet-input-error :message="form.errors.description" class="mt-2" />
			            </div>
			            <div class="col-span-6 lg:col-span-6">
			            	<drap-zone-component accept=".jpg,.jpeg,.png" types="JPG,GIF,PNG" title="Fotos producto" @setFiles="getFiles"/>
			            	 <p class="text-sm text-red-500">
			                	Nota: Cualquier archivo distinto a los indicados sera ignorado.</strong>.
			                </p>
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
	
    import DrapZoneComponent from '@/components/DrapZone'
    import { FormComponentMixin} from '@/Mixins/FormComponentMixin'

    export default {
    	components: {
            DrapZoneComponent
    	},
        mixins: [FormComponentMixin],
    	props: {
    	},
    	data(){
            return {
                form: this.$inertia.form({
                    name: null,
                    reference: null,
                    description: null,
                    cubic_meters: 0,
                    ton: 0,
                    photos: []
                }),
            }
        },
        mounted(){

        },
        methods: {
            storeProduct(){
                
                this.form.post(route('product.store'), {
                    errorBag: 'storeProduct',
                    preserveScroll: true,
                    onStart: () => { 
                        this.startLoading();
                    },
                    onSuccess: () => {
                        this.loader.text = "¡Hecho!";
                        this.uploadedImagen = false;
                    },
                    onFinish: () => {
                        this.endLoading();
                    },
                });
            },
            getFiles(files){

            	for (var i = 0; i < files.length; i++) {
            		if (files[i].type != "application/pdf") {
            			
            			this.form.photos.push(files[i]);
            		}
            	}
            },
        }

    }
</script>