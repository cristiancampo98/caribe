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
                        <template #attribute>Nota de pedido</template>
                        <template #description>{{order.note}}</template>
                    </item-list-component>
                    <item-list-component>
                        <template #attribute>Nota de eliminación</template>
                        <template #description>{{order.delete_note}}</template>
                    </item-list-component>
                    <item-list-component class="bg-gray-100">
                        <template #attribute>Estado</template>
                        <template #description>{{order.status}}</template>
                    </item-list-component>
                    <item-list-component >
                        <template #attribute>Url PSE</template>
                        <template #description>
                            <a class="hover:text-blue-500" :href="order.pse_url" target="_blank">{{order.pse_url}}</a>
                        </template> 
                    </item-list-component>
                    <item-list-component class="bg-gray-100">
                        <template #attribute>Número PSE</template>
                        <template #description>{{order.pse_number}}</template>    
                    </item-list-component>
                    <item-list-download-component
                    v-if="order_files.length"
                    title="Contrato/Orden de compra"
                    :files="order_files">
                    </item-list-download-component>
                    <item-list-component class="bg-gray-100">
                        <template #attribute>Fecha</template>
                        <template #description>{{order.created_at}}</template>
                    </item-list-component>
            	</description-list-component>
                <div class="py-4">
                    <hr class="my-8 border-2 border-gray">
                </div>
                <description-list-component>
                    <template #title>Detalle del pedido</template>
                    <template #subtitle>Visualiza la información del detalle del pedido</template>
                    <item-list-component 
                    v-for="(item, key) in order.order_details"
                    :key="key"
                    :class="getClass(key)"
                    >
                        <template #attribute>Producto # {{key+1}}</template>
                        <template #description>
                            <ul class="mx-auto">
                                <li>Nombre: {{item.product.name}}</li>
                                <li>Precio: {{item.product.price}}</li>
                                <li>Cantidad: {{item.quantity}}</li>
                                <li>Descuento: {{item.discount}}</li>
                            </ul>
                        </template>
                    </item-list-component>
                </description-list-component>
                <div class="py-4">
                    <hr class="my-8 border-2 border-gray">
                </div>
                <description-list-component>
                    <template #title>Consignaciones</template>
                    <template #subtitle>Visualiza las consignaciones del pedido</template>
                    <item-list-component 
                    v-for="(item, key) in order.consignments"
                    :key="key"
                    :class="getClass(key)"
                    >
                        <template #attribute>Consignación # {{item.id}}</template>
                        <template #description>
                            <ul class="mx-auto">
                                <li>No. consignación: {{item.consignment_number}}</li>
                                <li>
                                    Url: 
                                    <a :href="item.pse_url" 
                                    title="Enlace" 
                                    target="_blank"
                                    class="text-blue-500 hover:underline">
                                        {{item.pse_url}}
                                    </a>
                                </li>
                                <li>No. Pse: {{item.pse_number}}</li>
                                <li>Fecha: {{item.created_at}}</li>
                            </ul>
                        </template>
                    </item-list-component>
                </description-list-component>
                <div class="py-4">
                    <hr class="my-8 border-2 border-gray">
                </div>
                
                <div v-if="files_consignments.length">
                    <item-list-download-component
                    title="Imagenes consignación"
                    :files="files_consignments"
                    />
                    
                </div>
            </div>
        </div>
	</admin-layout>
	
</template>
<script>
	import AdminLayout from '@/Layouts/AdminLayout'
	import DescriptionListComponent from '@/Components/DescriptionList'
	import ItemListComponent from '@/Components/ItemList'
    import ItemListDownloadComponent from '@/Components/ItemListDownload'

    export default {
    	components: {
    		AdminLayout,
    		DescriptionListComponent,
    		ItemListComponent,
            ItemListDownloadComponent

    	},
    	props: {
    		order: {
    			type: Object
    		},
    	},
    	data(){
            return {
                files_consignments: [],
                order_files: []
            }
        },
        mounted(){
        	this.getMultimediaConsignmentsByOrder();
            this.getMultimediaOrdersById();
        },
        methods: {
            getClass(value){
                return value % 2 == 0 ? 'bg-gray-100' : '';
            },
            getMultimediaConsignmentsByOrder(){
                if (this.order.consignments) {
                    axios.get(`/getMultimediaConsignmentsByOrder/${this.order.id}/consignment`)
                    .then( res => {
                        this.files_consignments = res.data;
                    });
                }
            },
            getMultimediaOrdersById(){
                if (this.order.client.details.type_pay == 'crédito') {
                    axios.get(`/getMultimediaOrdersById/${this.order.id}/order`)
                    .then( res => {
                        this.order_files = res.data;
                    });
                }
            }
        }
    }
</script>