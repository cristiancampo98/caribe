<template>
	<jet-form-section @submitted="storeProduct">
        <template #title>
            Información de producto
        </template>

        <template #description>
            Crea un producto con la información requerida.
        </template>

        <template #form>
            <!-- Profile Photo -->
            

            <!-- Name -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="name" value="Nombre" />
                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" autocomplete="name" />
                <jet-input-error :message="form.errors.name" class="mt-2" />
            </div>
            <!-- Reference -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="reference" value="Referencia" />
                <jet-input id="reference" type="text" class="mt-1 block w-full" v-model="form.reference" autocomplete="reference" />
                <jet-input-error :message="form.errors.reference" class="mt-2" />
            </div>
            <!-- Unit -->
             <div class="col-span-6 sm:col-span-4">
                <jet-label for="unit" value="Unidad" />
                <div class="grid grid-flow-col auto-cols-max md:auto-cols-min">
                	<div v-for="(item,index) in units" :key="index">
                		<label class="flex items-center">
		                   	<input  type="radio" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"  :value="item" v-model="form.unit">	
		                    <span class="ml-1 mr-3 text-sm text-gray-600"> {{item}}</span>
		                </label>
                	</div>


                </div>
                <jet-input-error :message="form.errors.unit" class="mt-2" />
            </div>

            <!-- Price -->
             <div class="col-span-6 sm:col-span-4">
                <jet-label for="price" value="Precio" />
                <jet-input id="price" type="number" class="mt-1 block w-full" v-model="form.price" autocomplete="price" />
                <jet-input-error :message="form.errors.price" class="mt-2" />
            </div>

            <!-- Description -->
             <div class="col-span-6 sm:col-span-4">
                <jet-label for="description" value="Descripción" />
                <jet-input id="description" type="text" class="mt-1 block w-full" v-model="form.description" autocomplete="description" />
                <jet-input-error :message="form.errors.description" class="mt-2" />
            </div>

            
        </template>

        <template #actions>
            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                Saved.
            </jet-action-message>

            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Save
            </jet-button>
        </template>
    </jet-form-section>
</template>
<script>
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
    	},
    	props: {
    		units: Array
    	},
    	data(){
            return {
                form: this.$inertia.form({
                    name: null,
                    reference: null,
                    unit: null,
                    price: null,
                    description: null,
                    image: [],
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