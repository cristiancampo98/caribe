<template>
	<admin-layout>
		 <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Actualizar vehículo
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

				<jet-form-section @submitted="updateVehicle">
			        <template #title>
			            Actualizar vehículo
			        </template>

			        <template #description>
			            Actualiza vehículo digitando la razón.
			        </template>

			        <template #form>
			        	<!-- license plate -->
			        	<div class="col-span-6 sm:col-span-4">
				        	<jet-label for="license_plate" value="Placa" />
			                <jet-input id="license_plate" type="text" maxlength="15" class="mt-1 block w-full" v-model="form.license_plate" autocomplete="license_plate" />
			                <jet-input-error :message="form.errors.license_plate" class="mt-2" />
			            </div>

		                <!-- brand -->
		                <div class="col-span-6 sm:col-span-4">
				        	<jet-label for="brand" value="Marca" />
			                <jet-input id="brand" type="text" maxlength="20" class="mt-1 block w-full" v-model="form.brand" autocomplete="brand" />
			                <jet-input-error :message="form.errors.brand" class="mt-2" />
			            </div>

			            <!-- state -->
			            <div class="col-span-6 sm:col-span-4">
			                <jet-label for="name" value="Estado" />
			               	<v-select 
			            	class="mt-1"
			            	id="state"
			            	label="text"
			            	:reduce="text => text.id"
			            	v-model="form.state"
			            	:clearable="false"
			            	:options="[{id:0,text:'Inactivo'},{id:1,text:'Activo'}]"></v-select>
			                <jet-input-error :message="form.errors.state" class="mt-2" />
			            </div>
			            <!-- reason -->
			            <div class="col-span-6 sm:col-span-4">
			                <jet-label for="reason" value="Motivo" />
			                <textarea id="reason" v-model="form.reason" class="mt-1 block w-full rounded-md"></textarea>
			                <jet-input-error :message="form.errors.reason" class="mt-2" />
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
    		vehicle: {
    			type: Object
    		}
    	},
    	data(){
            return {
                form: this.$inertia.form({
                	license_plate: this.vehicle.license_plate,
                	brand: this.vehicle.brand,
                    state: this.vehicle.state,
                    reason: this.vehicle.reason,
                }),
            }
        },
        mounted(){

        },
        methods: {
            updateVehicle(){
                this.form.put(route('vehicle.update',{vehicle: this.vehicle.id}), {
                    errorBag: 'updateVehicle',
                    preserveScroll: true
                });
            }
        }

    }
</script>