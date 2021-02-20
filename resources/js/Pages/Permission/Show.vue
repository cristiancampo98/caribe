<template>
	<admin-layout>
		 <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
               Permiso seleccionado
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            	<description-list-component>
            		<template #title>Permiso</template>
            		<template #subtitle>Visualiza la información del permiso</template>
            		<item-list-component>
            			<template #attribute>Nombre</template>
            			<template #description>{{permissions.name}}</template>
            		</item-list-component>
            		<item-list-component class="bg-gray-10">
            			<template #attribute>Slug</template>
            			<template #description>{{permissions.slug}}</template>	
            		</item-list-component>
                   <item-list-component class="bg-gray-10">
            			<template #attribute>Controlador</template>
            			<template #description>{{permissions.controller}}</template>	
            		</item-list-component>
                    <item-list-component class="bg-gray-10">
            			<template #attribute>Descripción</template>
            			<template #description>{{permissions.description}}</template>	
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
        mounted(){
            console.log(this.permissions)
        },
        props: {
            permissions: Object
        },  
    

    }
</script>
