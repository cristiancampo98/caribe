<template>
	<admin-layout>
		 <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Actualizar permiso
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

				<form action="#" method="PATCH" @submit="updatePermission">
			        <template >
			            Información del permiso
			        </template>

			        <template >
			            Crea un permiso con la información requerida.
			        </template>

			        <template >
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
			                	Nota: El identificador único debe corresponder siempre a el "name" de una ruta.
			                </p>
			                <jet-input-error :message="form.errors.slug" class="mt-2" />
			            </div>
			            

			            <!-- Controller -->
			             <div class="col-span-6 sm:col-span-4">
			                <jet-label for="controller" value="Controlador" />
			                <jet-input id="controller" type="text" class="mt-1 block w-full" v-model="form.controller" autocomplete="controller" />
			                <p class="text-sm text-blue-600">
			                	Nota: Digita el nombre del controlador <strong>Sí</strong> hay mas permisos para el mismo. Por ejemplo: Controlador => <u>permission</u>  Permisos => ['permission.index', 'permission.create', ...].
			                </p>
			                <jet-input-error :message="form.errors.controller" class="mt-2" />
			            </div>

			            <!-- Description -->
			             <div class="col-span-6 sm:col-span-4">
			                <jet-label for="description" value="Descripción" />
			                <textarea id="description" class="mt-1 block w-full rounded-md" v-model="form.description" autocomplete="description"></textarea>
			                <jet-input-error :message="form.errors.description" class="mt-2" />
			            </div>

			            
			        </template>

			        <template>
			            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
			                Guardado.
			            </jet-action-message>

			            <button type="submit">
			                Guardar
			            </button>
			        </template>
			   </form> 
            </div>
        </div>

	</admin-layout>

	
</template>
<script>

	import { FormComponentMixin} from '@/Mixins/FormComponentMixin'

    export default {
    	mixins: [FormComponentMixin],
    	props: ['permission', 'errors'],
    		
    	data(){
            return {
                form: this.$inertia.form({
                    name: this.permission.name,
                    slug: this.permission.slug,
                    controller: this.permission.controller,
                    description: this.permission.description,
                }),
            }
        },
        mounted(){
        	
        },
        methods: {
            updatePermission(){
				this.form.patch(`/permission/${this.permission.id}`, {
                    errorBag: 'storePermission',
                    preserveScroll: true
                })
				
                }
            }
        }

</script>