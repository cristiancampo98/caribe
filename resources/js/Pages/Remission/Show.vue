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
            		<template #title>Remission</template>
            		<template #subtitle>Visualiza la información de la remisión</template>
            		<item-list-component >
            			<template #attribute>Cliente </template>
            			<template #description>
            				{{remission.order_detail.order.client.name}}
            				<br>
            				{{remission.order_detail.order.client.email}}
            			</template>	
            		</item-list-component>
            		<item-list-component class="bg-gray-100">
            			<template #attribute>No. Pedido</template>
            			<template #description>{{remission.order_detail.order_id}}</template>
            		</item-list-component>
            		<item-list-component>
            			<template #attribute>Cantidad entregada</template>
            			<template #description>{{remission.delivered}} m3</template>
            		</item-list-component>
            		<item-list-component class="bg-gray-100">
            			<template #attribute>Cantidad del producto</template>
            			<template #description>{{remission.order_detail.quantity}} m3</template>
            		</item-list-component>
            		<item-list-component >
            			<template #attribute>Producto</template>
            			<template #description>{{remission.order_detail.product.name}}</template>	
            		</item-list-component>
            		<item-list-component class="bg-gray-100">
            			<template #attribute>Vehículo</template>
            			<template #description>
            				<ul>
            					<li class="capitalize">Conductor: {{remission.carrier.carrier}}</li>
            					<li>Placa: <span class="uppercase">{{remission.carrier.vehicle.license_plate}}</span></li>
            				</ul>
            			</template>
            		</item-list-component>
            		<item-list-component >
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
            startLoading(){
                
                this.loading = this.$vs.loading({
                    type: 'circles'
                });
                this.loading.text = "Procesando...";
            },
            endLoading(){
                this.loading.close();
            }

        }

    }
</script>