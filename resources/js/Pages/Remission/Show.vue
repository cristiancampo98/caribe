<template>
	<admin-layout>
		 <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
               Consultar remisión
            </h2>
        </template>
        <div class="py-12">

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <a 
                :href="`/print/${remission.id}/remission`" 
                target="_blank"
                class="hover:text-blue-500 underline">
                 Imprimir
                </a>
            	<description-list-component>
            		<template #title>Remisión</template>
            		<template #subtitle>Visualiza la información de la remisión</template>
                    <item-list-component >
                        <template #attribute>Consecutivo Remisión </template>
                        <template #description>
                            {{remission.id}}
                        </template> 
                    </item-list-component>
                    <item-list-component class="bg-gray-100">
                        <template #attribute>Empresa </template>
                        <template #description>
                            {{remission.order_detail.order.client.details.name_company}}
                        </template> 
                    </item-list-component>
            		<item-list-component >
            			<template #attribute>Cliente </template>
            			<template #description>
            				{{remission.order_detail.order.client.name}}
            			</template>	
            		</item-list-component>
                    <item-list-component class="bg-gray-100">
                        <template #attribute>Correo</template>
                        <template #description>
                            {{remission.order_detail.order.client.email}}
                        </template> 
                    </item-list-component>
                    <item-list-component>
                        <template #attribute>Departamento</template>
                        <template #description>
                            {{remission.order_detail.order.client.details.deparment}}
                        </template> 
                    </item-list-component>
                    <item-list-component class="bg-gray-100">
                        <template #attribute>Ciudad</template>
                        <template #description>
                            {{remission.order_detail.order.client.details.city}}
                        </template> 
                    </item-list-component>
                    <item-list-component>
                        <template #attribute>Dirección</template>
                        <template #description>
                            {{remission.order_detail.order.client.details.street_address}}
                        </template> 
                    </item-list-component>
                     <item-list-component class="bg-gray-100">
                        <template #attribute>Telefono</template>
                        <template #description>
                            {{remission.order_detail.order.client.details.phones}}
                        </template> 
                    </item-list-component>
            		<item-list-component>
            			<template #attribute>Consecutivo Pedido</template>
            			<template #description>{{remission.order_detail.order_id}}</template>
            		</item-list-component>
            		<item-list-component class="bg-gray-100">
            			<template #attribute>Cantidad entregada</template>
            			<template #description>{{ remission.delivered | formatNumber}} m3</template>
            		</item-list-component>
            		<item-list-component>
            			<template #attribute>Cantidad del producto</template>
            			<template #description>{{remission.order_detail.quantity | formatNumber}} m3</template>
            		</item-list-component>
            		<item-list-component class="bg-gray-100">
            			<template #attribute>Producto</template>
            			<template #description>{{remission.order_detail.product.name}}</template>	
            		</item-list-component>
            		<item-list-component>
            			<template #attribute>Vehículo</template>
            			<template #description>
            				<ul>
            					<li class="capitalize">Conductor: {{remission.carrier.carrier}}</li>
                                <li class="capitalize">Identificación: {{remission.carrier.identification_number}}</li>
            					<li>Placa: <span class="uppercase">{{remission.carrier.vehicle.license_plate}}</span></li>
                                <li>Marca: <span class="uppercase">{{remission.carrier.vehicle.brand}}</span></li>
            				</ul>
            			</template>
            		</item-list-component>
            		<item-list-component class="bg-gray-100">
            			<template #attribute>Remitido por </template>
            			<template #description>{{remission.creator.name}}</template>	
            		</item-list-component>
                    <item-list-component >
                        <template #attribute>Fecha remisión </template>
                        <template #description>{{moment(remission.created_at).format('DD/MM/YYYY')}}</template>    
                    </item-list-component>            		
                    <item-list-download-component
                    v-if="multimedia.length"
                    title="Documentos"
                    :files="multimedia"
                    @updatingNotifications="updateNotifications"
                    />
                   
                   
            	</description-list-component>
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
    		remission: {
    			type: Object
    		},
    	},
    	data(){
            return {
                status:{},
                multimedia: [],
                loading: false,
                moment: moment,
            }
        },
        mounted(){
        	this.getMultimediaFilesByRemission();
        },
        methods: {
            getMultimediaFilesByRemission(){
            	this.startLoading();
                axios.get(`/getMultimediaFilesByRemission/${this.remission.id}/remission`)
                .then( res => {
                    this.multimedia = res.data;
                })
                .finally( () => {
                	this.endLoading();
                });
            },
            updateNotifications(data){
                this.status = data;
            },
            exportPDF(){
                window.print()
            }
        }

    }
</script>