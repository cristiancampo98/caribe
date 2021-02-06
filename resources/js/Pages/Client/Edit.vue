<template>
	<admin-layout>
		 <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Crear cliente
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

				<jet-form-section @submitted="updateClient">
			        <template #title>
			            Información de cliente
			        </template>

			        <template #description>
			            Crea un cliente con la información requerida.
			        </template>

			        <template #form>

			            <!-- name -->
			            <div class="col-span-6 lg:col-span-3">
			                <jet-label for="name" value="Nombre Completo" />
			                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" autocomplete="name" />
			                <jet-input-error :message="form.errors.name" class="mt-2" />
			            </div>
			            <!-- email -->
			            <div class="col-span-6 lg:col-span-3">
			                <jet-label for="email" value="Correo" />
			                <jet-input id="email" type="text" class="mt-1 block w-full" v-model="form.email" autocomplete="email" />
			                <jet-input-error :message="form.errors.email" class="mt-2" />
			            </div>
			            <!-- number identification -->
			            <div class="col-span-6 lg:col-span-2">
			                <jet-label for="number_identification" value="Número de identificación" />
			                <jet-input id="number_identification" type="text" class="mt-1 block w-full" v-model="form.number_identification" autocomplete="number_identification" />
			                <jet-input-error :message="form.errors.number_identification" class="mt-2" />
			            </div>
			             <!-- type identification -->
			            <div class="col-span-6 lg:col-span-2">
			                <jet-label for="type_identification" value="Tipo identificación" />
			                <jet-input id="type_identification" type="text" class="mt-1 block w-full" v-model="form.type_identification" autocomplete="type_identification" />
			                <jet-input-error :message="form.errors.type_identification" class="mt-2" />
			            </div>
			            <!-- sex -->
			            <div class="col-span-6 lg:col-span-1">
			                <jet-label for="sex" value="Sexo" />
			                <jet-input id="sex" type="text" class="mt-1 block w-full" v-model="form.sex" autocomplete="sex" />
			                <jet-input-error :message="form.errors.sex" class="mt-2" />
			            </div>
			            <!-- type blood -->
			            <div class="col-span-6 lg:col-span-1">
			                <jet-label for="type_blood" value="Tipo de sangre" />
			                <jet-input id="type_blood" type="text" class="mt-1 block w-full" v-model="form.type_blood" autocomplete="type_blood" />
			                <jet-input-error :message="form.errors.type_blood" class="mt-2" />
			            </div>
			            <!-- name company -->
			            <div class="col-span-6 lg:col-span-2">
			                <jet-label for="name_company" value="Empresa" />
			                <jet-input id="name_company" type="text" class="mt-1 block w-full" v-model="form.name_company" autocomplete="name_company" />
			                <jet-input-error :message="form.errors.name_company" class="mt-2" />
			            </div>
			            <!-- type pay -->
			            <div class="col-span-6 lg:col-span-2">
			                <jet-label for="type_pay" value="Tipo de pago" />
			                <jet-input id="type_pay" type="text" class="mt-1 block w-full" v-model="form.type_pay" autocomplete="type_pay" />
			                <jet-input-error :message="form.errors.type_pay" class="mt-2" />
			            </div>
			            <!-- steet address -->
			            <div class="col-span-6 lg:col-span-2">
			                <jet-label for="street_address" value="Dirección" />
			                <jet-input id="street_address" type="text" class="mt-1 block w-full" v-model="form.street_address" autocomplete="street_address" />
			                <jet-input-error :message="form.errors.street_address" class="mt-2" />
			            </div>
			            <!-- street details -->
			            <div class="col-span-6 lg:col-span-6">
			                <jet-label for="street_details" value="Detalles de dirección" />
			                <textarea id="street_details" class="mt-1 block w-full rounded-md" v-model="form.street_details"></textarea>
			                <jet-input-error :message="form.errors.street_details" class="mt-2" />
			            </div>
			            <!-- street comune -->
			            <div class="col-span-6 lg:col-span-2">
			                <jet-label for="street_comune" value="Comuna" />
			                <jet-input id="street_comune" type="text" class="mt-1 block w-full" v-model="form.street_comune" autocomplete="street_comune" />
			                <jet-input-error :message="form.errors.street_comune" class="mt-2" />
			            </div>
			            <!-- department -->
			            <div class="col-span-6 lg:col-span-2">
			                <jet-label for="deparment" value="Departamento" />
			                <jet-input id="deparment" type="text" class="mt-1 block w-full" v-model="form.deparment" autocomplete="deparment" />
			                <jet-input-error :message="form.errors.deparment" class="mt-2" />
			            </div>
			            <!-- city -->
			            <div class="col-span-6 lg:col-span-2">
			                <jet-label for="city" value="Ciudad" />
			                <jet-input id="city" type="text" class="mt-1 block w-full" v-model="form.city" autocomplete="city" />
			                <jet-input-error :message="form.errors.city" class="mt-2" />
			            </div>
			            
			            <!-- others_email -->
			            <div class="col-span-6 lg:col-span-3">
			                <jet-label for="others_email" value="Otros correos" />
			                <textarea id="others_email" class="mt-1 block w-full rounded-md" v-model="form.others_email"></textarea>
			                <jet-input-error :message="form.errors.others_email" class="mt-2" />
			            </div>
			            <!-- phones -->
			            <div class="col-span-6 lg:col-span-3">
			                <jet-label for="phones" value="Otros telefonos" />
			                <textarea id="phones"  class="mt-1 block w-full rounded-md" v-model="form.phones"></textarea>
			                <jet-input-error :message="form.errors.phones" class="mt-2" />
			            </div>
			            <!-- photo document -->
			            <div class="col-span-6 lg:col-span-2">
			            	<label for="photo" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
			            		<span>Subir Identificación</span>
			            		<input type="file" id="photo" ref="photo" @change="uploadDocument" class="w-px h-px opacity-0 overflow-hidden absolute" accept=".pdf" />
			            	</label>
			            	<span v-if="uploadedDocument" class="ml-4 text-green-500">¡Hecho!</span>
			            </div>
			            <!-- rut document -->
			            <div class="col-span-6 lg:col-span-2">
			            	<label for="rut" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
			            		<span>Subir RUT</span>
			            		<input type="file"  id="rut"  ref="rut" @change="uploadRut" class="w-px h-px opacity-0 overflow-hidden absolute" accept=".pdf" />
			            	</label>
			            	<span v-if="uploadedRut" class="ml-4 text-green-500">¡Hecho!</span>
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
    	props: {
    		client: {
    			type: Object
    		}
    	},
    	data(){
            return {
                form: this.$inertia.form({
                	_method: 'PUT',
                    name: this.client.name,
                    email: this.client.email,
                    number_identification: null,
                    type_identification: null,
                    sex: null,
                    photo_document: null,
                    rut_document: null,
                    type_blood: null,
                    name_company: null,
                    type_pay: null,
                    street_address: null,
                    street_details: null,
                    street_comune: null,
                    city: null,
                    deparment: null,
                    country: null,
                    others_email: null,
                    phones: null,

                }),
                uploadedDocument: false,
                uploadedRut: false
            }
        },
        mounted(){

        },
        methods: {
            updateClient(){
            	if (this.$refs.photo) {
                    this.form.photo_document = this.$refs.photo.files[0]
                }
                if (this.$refs.rut) {
                    this.form.rut_document = this.$refs.rut.files[0]
                }
                console.log(this.form);
                this.form.post(route('client.update', { id: this.client.id }), {
                    errorBag: 'updateClient',
                    preserveScroll: true
                });
            },
            uploadDocument(){
            	this.uploadedDocument = true
            },
            uploadRut(){
            	this.uploadedRut = true
            }
        }

    }
</script>