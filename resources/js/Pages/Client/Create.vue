<template>
	<admin-layout>
		 <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Crear cliente
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

				<jet-form-section @submitted="storeClient">
			        <template #title>
			            Información de cliente
			        </template>

			        <template #description>
			            Crea un cliente con la información requerida.
			        </template>

			        <template #form>

                        <!-- name company -->
                        <div class="col-span-6 lg:col-span-4">
                            <jet-label for="name_company" value="Empresa" />
                            <jet-input id="name_company" type="text" class="mt-1 block w-full" v-model="form.name_company" autocomplete="name_company" />
                            <jet-input-error :message="form.errors.name_company" class="mt-2" />
                        </div>
			            <!-- Name -->
			            <div class="col-span-6 sm:col-span-4">
			                <jet-label for="name" value="Nombre Completo" />
			                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" autocomplete="name" />
			                <jet-input-error :message="form.errors.name" class="mt-2" />
			            </div>
			            <!-- email -->
			            <div class="col-span-6 sm:col-span-4">
			                <jet-label for="email" value="Correo" />
			                <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" autocomplete="email" />
			                <jet-input-error :message="form.errors.email" class="mt-2" />
                            <p class="text-sm text-blue-500">Nota: La contraseña por defecto de los clientes es : 12345678 </p>
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
    	data(){
            return {
                form: this.$inertia.form({
                    name_company: '',
                    name: '',
                    email: '',
                }),
            }
        },
        mounted(){

        },
        methods: {
            storeClient(){
                this.form.post(route('client.store'), {
                    errorBag: 'storeClient',
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
            }
        }

    }
</script>