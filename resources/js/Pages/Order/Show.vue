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
                    <item-list-component class="bg-gray-100">
                        <template #attribute>Empresa</template>
                        <template #description>{{order.client.details.name_company}}</template>    
                    </item-list-component>
            		<item-list-component>
            			<template #attribute>Cliente</template>
            			<template #description>{{order.client.name}}</template>
            		</item-list-component>
                    <item-list-component class="bg-gray-100">
            			<template #attribute>Lugar de cargue</template>
            			<template #description>{{order.place_loading}}</template>	
            		</item-list-component>
            		<item-list-component >
            			<template #attribute>Dirección de envío</template>
            			<template #description>{{order.shipping_address}}</template>	
            		</item-list-component>
            		<item-list-component class="bg-gray-100">
            			<template #attribute>Ubicación de envío</template>
            			<template #description>{{order.department}} | {{order.city}}</template>
            		</item-list-component>
                    <item-list-component>
                        <template #attribute>Nota de pedido</template>
                        <template #description>{{order.note}}</template>
                    </item-list-component>
                    <item-list-component class="bg-gray-100">
                        <template #attribute>Nota de eliminación</template>
                        <template #description>{{order.delete_note}}</template>
                    </item-list-component>
                    <item-list-component>
                        <template #attribute>Estado</template>
                        <template #description>{{order.status}}</template>
                    </item-list-component>
                    <item-list-download-component 
                    class="bg-gray-100"
                    v-if="order_files.length"
                    title="Contrato/Orden de compra"
                    :files="order_files">
                    </item-list-download-component>
                    <item-list-component >
                        <template #attribute>Fecha</template>
                        <template #description>{{moment(order.created_at).format('DD/MM/YYYY')}}</template>
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
                                <li>Cantidad: {{item.quantity | formatNumber}} m3</li>
                                <li>Equivalencia: {{(item.quantity / item.product.cubic_meters).toFixed(3)}} ton</li>
                            </ul>
                            <div v-if="item.remissions.length" class="bg-white p-3">
                                <strong>Remisiones</strong>
                                <ul v-for="(remi) in item.remissions">
                                    <h3>Remisión # {{remi.id}}</h3>
                                    <li class="ml-5" type="disc">Entregado {{remi.delivered | formatNumber}} m3 de {{item.quantity | formatNumber }} m3</li>
                                    <li class="ml-5" type="disc">Placa de vehículo 
                                        <span class="uppercase">
                                            {{remi.carrier.vehicle.license_plate}}
                                        </span>
                                    </li>
                                    <li class="ml-5" type="disc">Remitido el  {{moment(remi.created_at).format('DD/MM/YYYY')}}</li>
                                </ul>
                            </div>
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
                                <li>Tipo: {{item.fully_apply ? 'Total' : 'Parcial'}}</li>
                                <li>Fecha: {{moment(item.created_at).format('DD/MM/YYYY')}}</li>
                                <li class="grid gap-4 grid-flow-col auto-cols-max">
                                    <span class="border-2 border-green-500 p-1"v-for="detail in item.detail">Producto: {{detail.product.name}}</span>
                                </li>
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
    import moment from 'moment';
    moment.locale('es')

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
                order_files: [],
                moment: moment,
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