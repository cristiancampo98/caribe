<template>
	<admin-layout>
		 <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
               Consultar vehículo
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            	<description-list-component>
            		<template #title>Vehículo</template>
            		<template #subtitle>Visualiza la información del vehículo</template>
            		<item-list-component>
            			<template #attribute>Placa</template>
            			<template #description :class="uppercase">
            				<p class="uppercase">{{vehicle.license_plate}}</p>
            			</template>
            		</item-list-component>
            		<item-list-component class="bg-gray-100">
            			<template #attribute>Marca</template>
            			<template #description>{{vehicle.brand}}</template>	
            		</item-list-component>
            		<item-list-component>
            			<template #attribute>Estado</template>
            			<template #description>
            				<span 
            				:class="vehicle.state 
            				? 'bg-green-500 rounded-md text-white p-1' 
            				: 'bg-red-500 rounded-md text-white p-1'">
            					{{vehicle.state ? 'Activo' : 'Inactivo'}}
            				</span>
            			</template>
            		</item-list-component>
            		<item-list-component class="bg-gray-100">
            			<template #attribute >Motivo</template>
            			<template #description>{{vehicle.reason}}</template>	
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
    		vehicle: {
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