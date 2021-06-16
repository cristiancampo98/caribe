<template>
	<admin-layout>
		 <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
               Editar Usuario
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

				<jet-form-section @submitted="updateUser">
			        <template #title>
			            Información de usuario
			        </template>

			        <template #description>
			            Edita un usuario con la información requerida
			        </template>

			        <template #form v-if="showFormEdit">

			            <!-- name -->
			            <div class="col-span-6 lg:col-span-2">
			                <jet-label for="name" value="Nombre Completo" />
			                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" autocomplete="name" />
			                <jet-input-error :message="form.errors.name" class="mt-2" />
			            </div>
			            <!-- email -->
			            <div class="col-span-6 lg:col-span-2">
			                <jet-label for="email" value="Correo principal" />
			                <jet-input id="email" type="text" class="mt-1 block w-full" v-model="form.email" autocomplete="email" />
			                <jet-input-error :message="form.errors.email" class="mt-2" />
			            </div>
			            <div class="col-span-6 lg:col-span-2">
			                <jet-label for="roles_id" value="Roles" />
			                <v-select 
			            	class="mt-1"
			            	id="roles_id"
			            	label="name"
			            	multiple
			            	v-model="form.roles_id"
			            	:reduce="roles => roles.id"
			            	:options="roles"
			            	:clearable="false"></v-select>
			                <jet-input-error :message="form.errors.roles_id" class="mt-2" />
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
			            <!-- street comune -->
			            <div class="col-span-6 lg:col-span-2">
			                <jet-label for="street_comune" value="Comuna" />
			                <jet-input id="street_comune" type="text" class="mt-1 block w-full" v-model="form.street_comune" autocomplete="street_comune" />
			                <jet-input-error :message="form.errors.street_comune" class="mt-2" />
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
			             
			            <!-- photo document -->
			            <div class="col-span-6 lg:col-span-2">
			            	<label for="photo" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
			            		<span>Subir Identificación</span>
			            		<input type="file" id="photo" ref="photo" @change="uploadDocument" class="w-px h-px opacity-0 overflow-hidden absolute" accept=".pdf" />
			            		<p class="text-xs text-gray-500">PDF</p>
			            	</label>
			            	<span v-if="uploadedDocument" class="ml-4 text-green-500">¡Hecho!</span>
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

    export default {
    	mixins: [FormComponentMixin],
    	props: {
    		user: {
    			type: Object
    		},
    		roles: {
    			type: Array
    		},
    		types_identification: {
    			type: Array
    		}
    	},
    	data(){
            return {
                form: this.$inertia.form({
                	_method: 'PUT',
                    name: this.user.name,
                    email: this.user.email,
                    roles_id: this.user.roles,
                    number_identification: null,
                    type_identification_id: null,
                    photo_document: null,
                    street_address: null,
                    street_details: null,
                    street_comune: null,
                    city: null,
                    deparment: null,
                    country: null,
                    others_email: null,
                    phones: null,
                    name_company: null,
                    type_pay: null
                    
                }),
                uploadedDocument: false,
                deparments: [],
                citys: [],
                showFormEdit: false
            }
        },
        mounted(){
        	this.userHasDetail();
        	this.loadFileColombiaJson();
        },
        methods: {
            updateUser(){
            	if (this.$refs.photo) {
                    this.form.photo_document = this.$refs.photo.files[0]
                }
               
                this.form.post(route('user.update', { user: this.user.id }), {
                    errorBag: 'updateUser',
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
            uploadDocument(){
            	this.uploadedDocument = true;
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
            userHasDetail(){
            	if (this.user.details) {
            		this.form.number_identification = this.user.details.number_identification;
                    this.form.type_identification_id = this.user.details.type_identification_id;
                    this.form.photo_document = this.user.details.photo_document;
                    this.form.street_address = this.user.details.street_address;
                    this.form.street_details = this.user.details.street_details;
                    this.form.street_comune = this.user.details.street_comune;
                    this.form.city = this.user.details.city;
                    this.form.deparment = this.user.details.deparment;
                    this.form.country = this.user.details.country;
                    this.form.others_email = this.user.details.others_email;
                    this.form.phones = this.user.details.phones;
            	}
            	this.showFormEdit = true;
            }
        }
    }
</script>