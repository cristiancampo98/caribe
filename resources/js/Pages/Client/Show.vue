<template>
	<admin-layout>
		 <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
               Consultar cliente
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            	<description-list-component>
            		<template #title>Cliente</template>
            		<template #subtitle>Visualiza la información del cliente</template>
            		<item-list-component>
            			<template #attribute>Nombre</template>
            			<template #description>{{client.name}}</template>
            		</item-list-component>
            		<item-list-component class="bg-gray-100">
            			<template #attribute>Correo</template>
            			<template #description>{{client.email}}</template>	
            		</item-list-component>
            		<item-list-component>
            			<template #attribute>Estado</template>
            			<template #description>{{client.status ? 'Activo' : 'Inactivo'}}</template>
            		</item-list-component>
            		<item-list-component class="bg-gray-100">
            			<template #attribute >Tipo de pago</template>
            			<template #description>{{client.details.type_pay}}</template>	
            		</item-list-component>
            		<item-list-component>
            			<template #attribute>Dirección</template>
            			<template #description>{{client.details.street_address}}</template>
            		</item-list-component>
            		<item-list-component class="bg-gray-100">
            			<template #attribute >Ciudad</template>
            			<template #description>{{client.details.city}}</template>
            		</item-list-component>
            		<item-list-component>
            			<template #attribute>Departamento</template>
            			<template #description>{{client.details.deparment}}</template>
            		</item-list-component>
            		<item-list-component class="bg-gray-100">
            			<template #attribute >País</template>
            			<template #description>{{client.details.country}}</template>
            		</item-list-component>
            		<item-list-component>
            			<template #attribute>Telefonos</template>
            			<template #description>{{client.details.phones}}</template>
            		</item-list-component>
            		<item-list-component class="bg-gray-100">
            			<template #attribute>Correos</template>
            			<template #description>{{client.details.others_email}}</template>
            		</item-list-component>
            		<item-list-component>
            			<template #attribute>Tipo identificación</template>
            			<template #description>{{client.details.type_identification.description}}</template>
            		</item-list-component>
            		<item-list-component  class="bg-gray-100">
            			<template #attribute>Número de identificación</template>
            			<template #description>{{client.details.number_identification}}</template>
            		</item-list-component>
            		<item-list-component>
            			<template #attribute>Sexo</template>
            			<template #description>{{client.details.sex}}</template>
            		</item-list-component>
            		<item-list-component class="bg-gray-100">
            			<template #attribute >Tipo de sangre</template>
            			<template #description>{{client.details.type_blood.description}}</template>	
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
    		client: {
    			type: Object
    		},
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