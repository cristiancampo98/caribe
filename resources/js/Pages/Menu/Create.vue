<template>
	<admin-layout>
		 <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Crear menú
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

				<jet-form-section @submitted="storeProduct">
			        <template #title>
			            Información del menú
			        </template>

			        <template #description>
			            Crea un menú con la información requerida.
			        </template>

			        <template #form>
			            <!-- Profile Photo -->
			            

			            <!-- Name -->
			            <div class="col-span-6 sm:col-span-4">
			                <jet-label for="name" value="Nombre" />
			                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" autocomplete="name" />
			                <jet-input-error :message="form.errors.name" class="mt-2" />
			            </div>
			            <!-- Slug -->
			            <div class="col-span-6 sm:col-span-4">
			                <jet-label for="slug" value="Identificador único" />
			                <jet-input id="slug" type="text" class="mt-1 block w-full" v-model="form.slug" autocomplete="slug" />
			                <p class="text-sm text-blue-600">
			                	Nota: Recuerda que este campo debe coincidir con el <strong>Identificador único de un permiso</strong>.
			                </p>
			                <jet-input-error :message="form.errors.slug" class="mt-2" />
			            </div>

			            <!-- Description -->
			             <div class="col-span-6 sm:col-span-4">
			                <jet-label for="description" value="Descripción" />
			                <textarea id="description"class="mt-1 block w-full rounded-md" v-model="form.description" autocomplete="description"></textarea>
			                <jet-input-error :message="form.errors.description" class="mt-2" />
			            </div>

			             <!-- Icon -->
			             <div class="col-span-6 sm:col-span-4">
			                <jet-label for="icon" value="Icono" />
			                <jet-input id="icon" type="text" class="mt-1 block w-full" v-model="form.icon" autocomplete="icon" />
			                <p class="text-sm text-blue-600">
			                	Nota: Aquí <strong><a href="https://heroicons.com" target="_blank">https://heroicons.com</a>/</strong> puedes buscar un icono que te agrade. Copias el nombre que aparece abajo de la cajita y lo pegas. Por ejemplo: ['menu','user-group',...].
			                </p>
			                <jet-input-error :message="form.errors.icon" class="mt-2" />
			            </div>
			            <!-- Available -->
			            <div class="col-span-6 sm:col-span-4">
			                <jet-label for="available" value="Disponible" />
			                <div class="grid grid-flow-col auto-cols-max md:auto-cols-min">
		                		<label class="flex items-center">
				                   	<input  type="radio" class="rounded border-gray-300 text-green-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-green-200 focus:ring-opacity-50"  value="1" v-model="form.available">	
				                    <span class="ml-1 mr-3 text-sm text-gray-600"> Si</span>
				                </label>
				                <label class="flex items-center">
				                   	<input  type="radio" class="rounded border-gray-300 text-red-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-red-200 focus:ring-opacity-50"  value="0" v-model="form.available">	
				                    <span class="ml-1 mr-3 text-sm text-gray-600"> No</span>
				                </label>
			                </div>
			                <jet-input-error :message="form.errors.available" class="mt-2" />
			            </div>

			            <!-- Is Direct -->
			            <div class="col-span-6 sm:col-span-4">
			                <jet-label for="isDirect" value="Enlace directo" />
			                <div class="grid grid-flow-col auto-cols-max md:auto-cols-min">
		                		<label class="flex items-center">
				                   	<input  type="radio" class="rounded border-gray-300 text-green-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-green-200 focus:ring-opacity-50"  value="1" v-model="form.isDirect">	
				                    <span class="ml-1 mr-3 text-sm text-gray-600"> Si</span>
				                </label>
				                <label class="flex items-center">
				                   	<input  type="radio" class="rounded border-gray-300 text-red-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-red-200 focus:ring-opacity-50"  value="0" v-model="form.isDirect">	
				                    <span class="ml-1 mr-3 text-sm text-gray-600"> No</span>
				                </label>
			                </div>
			                <p class="text-sm text-blue-600">
			                	Nota: Si marcas esta casilla querrá decir que el menu será un enlace directo a una ruta y por ende en <strong>Identificador único</strong> <u>deberás colocar el "name" de una ruta. Por ejemplo: <strong>menu.create</strong></u>. Si no lo haces, este menú será el padre de un submenú.
			                </p>
			                <jet-input-error :message="form.errors.isDirect" class="mt-2" />
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
    		units: Array
    	},
    	data(){
            return {
                form: this.$inertia.form({
                    name: null,
                    slug: null,
                    description: null,
                    icon: 'menu-alt-4',
                    available: 0,
                    isDirect: 0
                }),
            }
        },
        mounted(){
        	console.log(this.units)
        },
        methods: {
            storeProduct(){
                this.form.post(route('product.store'), {
                    errorBag: 'storeProduct',
                    preserveScroll: true
                });
            }
        }

    }
</script>