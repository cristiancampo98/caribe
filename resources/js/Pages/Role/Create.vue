<template>
	<admin-layout>
		 <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Crear rol
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

				<jet-form-section @submitted="storeRol">
			        <template #title>
			            Información de role
			        </template>

			        <template #description>
			            Crea un rol con la información requerida.
			        </template>

			        <template #form>

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
			                <jet-input-error :message="form.errors.slug" class="mt-2" />
			            </div>
			            <!-- Description -->
			             <div class="col-span-6 sm:col-span-4">
			                <jet-label for="description" value="Descripción" />
			                <jet-input id="description" type="text" class="mt-1 block w-full" v-model="form.description" autocomplete="description" />
			                <jet-input-error :message="form.errors.description" class="mt-2" />
			            </div>

			            <!-- Description -->
			             <div class="col-span-6 sm:col-span-4">
			                <jet-label for="full_access" value="Acceso total" />
			                <jet-input id="full_access" type="text" class="mt-1 block w-full" v-model="form.full_access" autocomplete="full_access" />
			                <jet-input-error :message="form.errors.full_access" class="mt-2" />
			            </div>

			            <!-- Public -->
			             <div class="col-span-6 sm:col-span-4">
			                <jet-label for="public" value="Publico" />
			                <jet-input id="public" type="text" class="mt-1 block w-full" v-model="form.public" autocomplete="public" />
			                <jet-input-error :message="form.errors.public" class="mt-2" />
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
    	data(){
            return {
                form: this.$inertia.form({
                    name: null,
                    slug: null,
                    description: null,
                    full_access: null,
                    public: null,
                }),
            }
        },
        mounted(){

        },
        methods: {
            storeRol(){
                this.form.post(route('role.store'), {
                    errorBag: 'storeRol',
                    preserveScroll: true
                });
            }
        }

    }
</script>