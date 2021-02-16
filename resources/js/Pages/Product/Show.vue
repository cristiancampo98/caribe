<template>
	<admin-layout>
		 <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
               Producto seleccionado
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            	<description-list-component>
            		<template #title>Producto</template>
            		<template #subtitle>Visualiza la información del producto</template>
            		<item-list-component>
            			<template #attribute>Nombre</template>
            			<template #description>{{product.name}}</template>
            		</item-list-component>
            		<item-list-component class="bg-gray-100">
            			<template #attribute>Correo</template>
            			<template #description>{{product.reference}}</template>	
            		</item-list-component>
                   <item-list-component class="bg-gray-100">
            			<template #attribute>Correo</template>
            			<template #description>{{product.unit_measure_id}}</template>	
            		</item-list-component>
                    <item-list-component class="bg-gray-100">
            			<template #attribute>Correo</template>
            			<template #description>{{product.price}}</template>	
            		</item-list-component>
                    <item-list-component class="bg-gray-100">
            			<template #attribute>Correo</template>
            			<template #description>{{product.description}}</template>	
            		</item-list-component>
            	</description-list-component>
            </div>
        </div>

	</admin-layout>

	
</template>
<script>
	import AdminLayout from '@/Layouts/AdminLayout'
	import DescriptionListComponent from '@/Components/DescriptionList'
	import ItemListComponent from '@/Components/ItemList'

    export default {
    	components: {
    		AdminLayout,
    		DescriptionListComponent,
    		ItemListComponent

    	},
    	props: {
            product: Object
        }, 
    	data(){
            return {
              
            }
        },
        mounted(){
        	
        },
        methods: {
        }

    }
</script>