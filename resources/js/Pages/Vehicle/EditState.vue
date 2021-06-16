<template>
	<admin-layout>
		 <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Actualizar estado
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

				<jet-form-section @submitted="updateStatus">
			        <template #title>
			            Actualizar estado del vehículo
			        </template>

			        <template #description>
			            Actualiza el estado del vehículo digitando la razón.
			        </template>

			        <template #form>

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
	
    import { FormComponentMixin} from '@/Mixins/FormComponentMixin'

    export default {
        mixins: [FormComponentMixin],
    	props: {
    		vehicle: {
    			type: Object
    		}
    	},
    	data(){
            return {
                form: this.$inertia.form({
                    state: this.vehicle.state,
                    reason: this.vehicle.reason,
                }),
            }
        },
        mounted(){

        },
        methods: {
            updateStatus(){
                this.form.put(route('updateStatus.vehicle',{vehicle: this.vehicle.id}), {
                    errorBag: 'updateStatus',
                    preserveScroll: true
                });
            }
        }

    }
</script>