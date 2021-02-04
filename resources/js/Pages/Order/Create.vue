<template>
	<admin-layout>
		 <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Crear Pedido
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

				<jet-form-section @submitted="storeOrder">
			        <template #title>
			            Información de pedido
			        </template>

			        <template #description>
			            Crea un pedido con la información requerida.
			        </template>

			        <template #form>

			            <!-- user id or cliente -->
			            <div class="col-span-6 lg:col-span-2" v-if="clients.length">
			                <jet-label for="user_id" value="Cliente" />
			                <select v-model="form.user_id" id="user_id" class="mt-1 block w-full rounded-lg" required>
			                	<option value="0" disabled> Seleccione una opción</option>
							  	<option v-for="option in clients" v-bind:value="option.user_id">
								    {{ option.users.name }}
							  	</option>
							</select>
			                <jet-input-error :message="form.errors.user_id" class="mt-2" />
			            </div>
			            <div class="col-span-6 lg:col-span-2" v-else>
			            	<jet-label for="user_id" value="Cliente" />
			            	<jet-input id="user_id" type="hidden" class="mt-1 block w-full" v-model="form.user_id" v-bind="user.id" />
			            	<span>{{user.name}}</span>
			            </div>
			            <!-- city -->
			            <div class="col-span-6 lg:col-span-2">
			                <jet-label for="city" value="Ciudad" />
			               	<jet-input id="city" type="text" class="mt-1 block w-full" v-model="form.city" />
			                <jet-input-error :message="form.errors.city" class="mt-2" />
			            </div>
			            <!-- shipping address -->
			            <div class="col-span-6 lg:col-span-2">
			                <jet-label for="shipping_address" value="Dirección envío" />
			               	<jet-input id="shipping_address" type="text" class="mt-1 block w-full" v-model="form.shipping_address" />
			                <jet-input-error :message="form.errors.shipping_address" class="mt-2" />
			            </div>
			           <!-- note -->
			            <div class="col-span-6 lg:col-span-6">
			                <jet-label for="note" value="Nota" />
			               	<textarea id="note" class="mt-1 block w-full rounded-lg" v-model="form.note"></textarea>
			                <jet-input-error :message="form.errors.note" class="mt-2" />
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
    		clients: {
    			type: [Object, Array],
    			required: true
    		},
    		user: {
    			type: Object,
    			required: true
    		}
    	},
    	data(){
            return {
                form: this.$inertia.form({
                    user_id: null,
                    shipping_address: null,
                    city: null,
                    note: null,
                    total: 0,
                    order_details: []
                }),
            }
        },
        mounted(){

        },
        methods: {
            storeOrder(){
                this.form.post(route('role.store'), {
                    errorBag: 'storeOrder',
                    preserveScroll: true
                });
            }
        }

    }
</script>