<template>
    <admin-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Crear vehiculo
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <jet-form-section >
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
                        <!-- Marca -->
                        <div class="col-span-6 sm:col-span-4">
			                <jet-label for="brand" value="Correo" />
			                <jet-input id="brand" type="text" class="mt-1 block w-full" v-model="form.brand" autocomplete="brand" />
			                <jet-input-error :message="form.errors.brand" class="mt-2" />
			            </div>
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
                form: this.$inertia.form({
                    license_plate: '',
                    brand: '',
                }),
            }
        },
        methods:{
            storeVehicle(){
                this.form.post(route('vehicle.store'), {
                    errorBag: 'storeVehicle',
                    preserveScroll: true
                });
            }
        }
    }
</script>