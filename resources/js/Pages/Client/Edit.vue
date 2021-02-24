<template>
	<admin-layout>
		 <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Editar cliente
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

			            <div class="mt-8">
			            	<ul>
			            		<li></li>
			            	</ul>
			            	
			            </div>
			        </template>

			        <template #form v-if="showFormEdit">

			            <!-- name -->
			            <div class="col-span-6 lg:col-span-3">
			                <jet-label for="name" value="Nombre Completo" />
			                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" autocomplete="name" />
			                <jet-input-error :message="form.errors.name" class="mt-2" />
			            </div>
			            <!-- email -->
			            <div class="col-span-6 lg:col-span-3">
			                <jet-label for="email" value="Correo principal" />
			                <jet-input id="email" type="text" class="mt-1 block w-full" v-model="form.email" autocomplete="email" />
			                <jet-input-error :message="form.errors.email" class="mt-2" />
			            </div>
			            <!-- number identification -->
			            <div class="col-span-6 lg:col-span-2">
			                <jet-label for="number_identification" value="Número de identificación" />
			                <jet-input id="number_identification" type="number" class="mt-1 block w-full" v-model.number="form.number_identification" autocomplete="number_identification" />
			                <jet-input-error :message="form.errors.number_identification" class="mt-2" />
			            </div>
			             <!-- type identification -->
			            <div class="col-span-6 lg:col-span-2">
			                <jet-label for="type_identification_id" value="Tipo identificación" />
			                <v-select 
			            	class="mt-1"
			            	id="type_identification_id"
			            	label="description"
			            	:reduce="description => description.id"
			            	v-model="form.type_identification_id"
			            	:options="types_identification"
			            	:clearable="false"></v-select>
			                <jet-input-error :message="form.errors.type_identification_id" class="mt-2" />
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
			                <v-select 
			            	class="mt-1"
			            	id="type_pay"
			            	v-model="form.type_pay"
			            	:clearable="false"
			            	:options="['contado','crédito']"></v-select>
			                <jet-input-error :message="form.errors.type_pay" class="mt-2" />
			            </div>
			             <!-- department -->
			            <div class="col-span-6 lg:col-span-2">
			                <jet-label for="deparment" value="Departamento" />
			                <v-select 
			            	class="mt-1"
			            	id="deparment"
			            	label="departamento"
			            	:options="deparments"
			            	v-model="form.deparment"
			            	:clearable="false"
			            	@input="showCitys"></v-select>
			                <jet-input-error :message="form.errors.deparment" class="mt-2" />
			            </div>
			            <!-- city -->
			            <div class="col-span-6 lg:col-span-2" >
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
			            <!-- street comune -->
			            <div class="col-span-6 lg:col-span-2">
			                <jet-label for="street_comune" value="Comuna" />
			                <jet-input id="street_comune" type="text" class="mt-1 block w-full" v-model="form.street_comune" autocomplete="street_comune" />
			                <jet-input-error :message="form.errors.street_comune" class="mt-2" />
			            </div>
			            <!-- steet address -->
			            <div class="col-span-6 lg:col-span-2">
			                <jet-label for="street_address" value="Dirección" />
			                <jet-input id="street_address" type="text" class="mt-1 block w-full" v-model="form.street_address" autocomplete="street_address" />
			                <jet-input-error :message="form.errors.street_address" class="mt-2" />
			            </div>
			            <!-- street details -->
			            <div class="col-span-6 lg:col-span-2">
			                <jet-label for="street_details" value="Detalles de dirección" />
			                <textarea id="street_details" class="mt-1 block w-full rounded-md" v-model="form.street_details"></textarea>
			                <jet-input-error :message="form.errors.street_details" class="mt-2" />
			            </div>
			            
			           

			            <div class="col-span-6">
			            	<p class="text-sm text-blue-500">Nota: En los siguientes tres recuadros podrá ingresar varios datos en cada casilla con la única condición que al final de cada dato exista una coma. Ejemplo: Placa1,Placa2, ... / Email1,Email2, ...</p>
			            </div>
			            
			            <!-- others_email -->
			            <div class="col-span-6 lg:col-span-2">
			                <jet-label for="others_email" value="Otros correos" />
			                <textarea id="others_email" class="mt-1 block w-full rounded-md" v-model="form.others_email"></textarea>
			                <jet-input-error :message="form.errors.others_email" class="mt-2" />

			            </div>
			            <!-- phones -->
			            <div class="col-span-6 lg:col-span-2">
			                <jet-label for="phones" value="Teléfonos" />
			                <textarea id="phones"  class="mt-1 block w-full rounded-md" v-model="form.phones"></textarea>
			                <jet-input-error :message="form.errors.phones" class="mt-2" />
			            </div>
			             <!-- vehicles -->
			            <div class="col-span-6 lg:col-span-2">
			                <jet-label for="vehicles" value="Vehículos" />
			                <textarea id="vehicles"  class="uppercase mt-1 block w-full rounded-md" v-model="form.vehicles"></textarea>
			                <jet-input-error :message="form.errors.vehicles" class="mt-2" />
			            </div>
			            <!-- photo document -->
			            <div class="col-span-6 lg:col-span-2">
			            	<label for="photo" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
			            		<span>Subir Identificación</span>
			            		<input type="file" id="photo" ref="photo" @change="uploadDocument" class="w-px h-px opacity-0 overflow-hidden absolute" accept=".pdf" />
			            		<p class="text-xs text-gray-500">PDF</p>
			            	</label>
			            	<span v-if="uploadedDocument" class="ml-4 text-green-500">¡Hecho!</span>
			            </div>
			            <!-- rut document -->
			            <div class="col-span-6 lg:col-span-2">
			            	<label for="rut" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
			            		<span>Subir RUT</span>
			            		<input type="file"  id="rut"  ref="rut" @change="uploadRut" class="w-px h-px opacity-0 overflow-hidden absolute" accept=".pdf" />
			            		<p class="text-xs text-gray-500">PDF</p>
			            	</label>
			            	<span v-if="uploadedRut" class="ml-4 text-green-500">¡Hecho!</span>
			            </div>
			            <!-- logo -->
			            <div class="col-span-6 lg:col-span-2">
			            	<label for="logo" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
			            		<span>Subir Logo</span>
			            		<input type="file"  id="logo"  ref="logo" @change="uploadLogo" class="w-px h-px opacity-0 overflow-hidden absolute" accept=".jpg, .png" />
			            		<p class="text-xs text-gray-500">JPG, PNG</p>
			            	</label>
			            	<span v-if="uploadedLogo" class="ml-4 text-green-500">¡Hecho!</span>
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
            vSelect
    	},
    	props: {
    		client: {
    			type: Object
    		},
    		types_blood: {
    			type: Array
    		},
    		types_identification: {
    			type: Array
    		},
    		photo_document: {
    			type: Array
    		},
    		rut_document: {
    			type: Array
    		},
    		logo: {
    			type: Array
    		}
    	},
    	data(){
            return {
                form: this.$inertia.form({
                	_method: 'PUT',
                    name: this.client.name,
                    email: this.client.email,
                    number_identification: null,
                    type_identification_id: null,
                    photo_document: null,
                    rut_document: null,
                    logo: null,
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
                    vehicles: null

                }),
                uploadedDocument: false,
                uploadedRut: false,
                uploadedLogo: false,
                deparments: [],
                citys: [],
                showFormEdit: false
            }
        },
        mounted(){
        	this.clientHasDetail();
        	this.loadFileColombiaJson();
        },
        methods: {
            updateClient(){
            	if (this.$refs.photo) {
                    this.form.photo_document = this.$refs.photo.files[0]
                }
                if (this.$refs.rut) {
                    this.form.rut_document = this.$refs.rut.files[0]
                }
                if (this.$refs.logo) {
                    this.form.logo = this.$refs.logo.files[0]
                }
                this.form.post(route('client.update', { id: this.client.id }), {
                    errorBag: 'updateClient',
                    preserveScroll: true
                });
            },
            uploadDocument(){
            	this.uploadedDocument = true;
            },
            uploadRut(){
            	this.uploadedRut = true;
            },
            uploadLogo(){
            	this.uploadedLogo = true;
            },
            loadFileColombiaJson(){
            	axios.get('/default/colombia-json-master/colombia.json')
            	.then( res => {
            		this.deparments = res.data;
            	})
            },
            showCitys(value){
            	this.citys = value.ciudades
            	this.form.deparment = value.departamento
            },
            clientHasDetail(){
            	if (this.client.details) {
            		this.form.number_identification = this.client.details.number_identification;
                    this.form.type_identification_id = this.client.details.type_identification_id;
                    this.form.photo_document = this.client.details.photo_document;
                    this.form.rut_document = this.client.details.rut_document;
                    this.form.name_company = this.client.details.name_company;
                    this.form.type_pay = this.client.details.type_pay;
                    this.form.street_address = this.client.details.street_address;
                    this.form.street_details = this.client.details.street_details;
                    this.form.street_comune = this.client.details.street_comune;
                    this.form.city = this.client.details.city;
                    this.form.deparment = this.client.details.deparment;
                    this.form.country = this.client.details.country;
                    this.form.others_email = this.client.details.others_email;
                    this.form.phones = this.client.details.phones;
            	}
            	this.showFormEdit = true;
            }
        }

    }
</script>