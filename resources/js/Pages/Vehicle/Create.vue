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
        data(){
            return {
                clients: [],
                uploadedImagen: false,
                loading: false,
                form: this.$inertia.form({
                    license_plate: null,
                    brand: null,
                    user_id: null,
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
                        this.loading.text = "¡Hecho!";
                        this.uploadedImagen = false;
                    },
                    onFinish: () => {
                        this.endLoading();
                    },
                });
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
            }, 350),
            uploadImagen(){
                this.uploadedImagen = true;
            },
            startLoading(){
                
                this.loading = this.$vs.loading({
                    type: 'circles'
                });
                this.loading.text = "Procesando...";
            },
            endLoading(){
                this.loading.close();
            }
        }
    }
</script>