<template>
    <admin-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Crear vehiculo
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <jet-form-section @submitted="storeVehicle">
                    <template #title>
                        Información de vehiculo
                    </template>

                    <template #description>
                        Crea un vehiculo con la información requerida.
                    </template>
                    
                    <template #form>
                        <!-- placa -->
                        <div class="col-span-6 sm:col-span-4">
			                <jet-label for="license_plate" value="Placa del vehículo" />
			                <jet-input id="license_plate" type="text" class="mt-1 block w-full" v-model="form.license_plate" autocomplete="license_plate" />
			                <jet-input-error :message="form.errors.license_plate" class="mt-2" />
			            </div>
                        <div class="col-span-6 lg:col-span-4">
                            <jet-label for="photo_plate" value="Subir imagen placa" />
                            <label for="photo_plate" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 p-1 ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                <span>Subir</span>
                                <input type="file"  id="photo_plate"  ref="photo_plate" @change="uploadImagen" class="w-px h-px opacity-0 overflow-hidden absolute" accept=".pdf, .jpg, .png" />
                            </label>
                            <span v-if="uploadedImagen" class="ml-4 text-green-500">¡Hecho!</span>
                        </div>
                        <!-- Marca -->
                        <div class="col-span-6 sm:col-span-4">
			                <jet-label for="brand" value="Marca" />
			                <jet-input id="brand" type="text" class="mt-1 block w-full" v-model="form.brand" autocomplete="brand" />
			                <jet-input-error :message="form.errors.brand" class="mt-2" />
			            </div>
                        <!-- user id or client -->
                        <div class="col-span-6 lg:col-span-4">
                            <jet-label for="user_id" value="Cliente" />
                            <v-select 
                            label="name"
                            id="user_id"
                            :options="users" 
                            :reduce="users =>users.id"
                            v-model="form.users_id"
                            multiple>
                                <template slot="no-options">
                                  Escribe el nombre de un cliente o empresa
                                </template>
                                <template slot="option" slot-scope="option">
                                  <div class="d-center">
                                    <p> Nombre: {{ option.name }}</p>
                                    <cite>Empresa: {{ option.details.name_company }}</cite>
                                    </div>
                                </template>
                                <template slot="selected-option" slot-scope="option">
                                  <div class="selected d-center">
                                     <p>{{ option.name }}</p>
                                  </div>
                                </template>
                            </v-select>
                            <jet-input-error :message="form.errors.users_id" class="mt-2" />
                        </div>
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
            </div>
        </div>
    </admin-layout>
</template>
<script>
   
    import { FormComponentMixin} from '@/Mixins/FormComponentMixin'

    export default {
       
        mixins: [FormComponentMixin],
        props: {
            users: {
                type: Array,
                required: true
            }
        },
        data(){
            return {
                uploadedImagen: false,
                form: this.$inertia.form({
                    license_plate: null,
                    brand: null,
                    users_id: [],
                    state: 1,
                    photo_plate: null,
                    index: true
                }),
            }
        },
        methods:{
            storeVehicle(){
                if (this.$refs.photo_plate) {
                    this.form.photo_plate = this.$refs.photo_plate.files[0]
                }
                this.form.post(route('vehicle.store'), {
                    errorBag: 'storeVehicle',
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
            uploadImagen(){
                this.uploadedImagen = true;
            },
        }
    }
</script>