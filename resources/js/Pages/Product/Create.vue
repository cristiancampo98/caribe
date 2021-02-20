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
	import AdminLayout from '@/Layouts/AdminLayout'
	import JetFormSection from '@/Jetstream/FormSection'
    import JetInput from '@/Jetstream/Input'
    import JetLabel from '@/Jetstream/Label'
    import JetInputError from '@/Jetstream/InputError'
    import JetActionMessage from '@/Jetstream/ActionMessage'
    import JetButton from '@/Jetstream/Button'
    import DrapZoneComponent from '@/components/DrapZone'

    export default {
    	components: {
            JetFormSection,
            JetInput,
            JetLabel,
            JetInputError,
            JetActionMessage,
            JetButton,
            AdminLayout,
            DrapZoneComponent
    	},
    	props: {
    	},
    	data(){
            return {
                form: this.$inertia.form({
                    name: null,
                    reference: null,
                    description: null,
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
            	
            }
        }

    }
</script>