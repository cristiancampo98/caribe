<template>
	<admin-layout>
		 <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
               Consultar pedido
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            	<description-list-component>
            		<template #title>Pedido</template>
            		<template #subtitle>Visualiza la información del pedido</template>
            		<item-list-component>
            			<template #attribute>Cliente</template>
            			<template #description>{{order.client.name}}</template>
            		</item-list-component>
            		<item-list-component class="bg-gray-100">
            			<template #attribute>Dirección de envío</template>
            			<template #description>{{order.shipping_address}}</template>	
            		</item-list-component>
            		<item-list-component>
            			<template #attribute>Ciudad</template>
            			<template #description>{{order.city}}</template>
            		</item-list-component>
                    <item-list-component class="bg-gray-100">
                        <template #attribute>Nota</template>
                        <template #description>{{order.note}}</template>
                    </item-list-component>
                    <item-list-component>
                        <template #attribute>Estado</template>
                        <template #description>{{order.status}}</template>
                    </item-list-component>
                    <item-list-component class="bg-gray-100">
                        <template #attribute>Valor</template>
                        <template #description>{{order.total}}</template>
                    </item-list-component>
                    <item-list-component>
                        <template #attribute>Fecha</template>
                        <template #description>{{order.created_at}}</template>
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
    		detail: {
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