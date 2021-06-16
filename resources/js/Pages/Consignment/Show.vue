<template>
	<admin-layout :status="status">
		 <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
               Consulta de consignación
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            	<description-list-component>
            		<template #title>Consignación</template>
            		<template #subtitle>Visualiza la información de la consignación</template>
                    <item-list-component class="bg-gray-100">
                        <template #attribute>Cliente</template>
                        <template #description>{{consignment.order.client.name}}</template> 
                    </item-list-component>
                    <item-list-component>
                        <template #attribute>Correo cliente</template>
                        <template #description>{{consignment.order.client.email}}</template>    
                    </item-list-component>
                    <item-list-component class="bg-gray-100">
                        <template #attribute>No. pedido</template>
                        <template #description>{{consignment.order_id}}</template>
                    </item-list-component>
            		<item-list-component >
                        <template #attribute>No. consignación</template>
                        <template #description>{{consignment.consignment_number}}</template>    
                    </item-list-component>
                    <item-list-component class="bg-gray-100">
                        <template #attribute>Tipo de consignación</template>
                        <template #description>
                            <div v-if="consignment.fully_apply">
                                <p class="text-green-500">
                                    Consignación total
                                </p>
                            </div>
                            <div v-else>
                                <ul>
                                    <h4 class="text-green-500">Consignación parcial</h4>
                                    <li v-for="item in consignment.detail">
                                        Consignación aplicada al item <strong>{{item.product.name}}</strong>
                                    </li>
                                </ul>
                            </div>
                        </template>
                    </item-list-component>
                    <item-list-component>
                        <template #attribute>Creador</template>
                        <template #description>{{consignment.creator.name}}</template> 
                    </item-list-component>
                    <item-list-component class="bg-gray-100">
                        <template #attribute>Fecha consignación</template>
                        <template #description>{{moment(consignment.created_at).format('DD/MM/YYYY')}}</template>
                    </item-list-component>
                    <item-list-download-component
                    v-if="multimedia.length"
                    title="Foto consignación"
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
            consignment: Object
        }, 
    	data(){
            return {
                status:{},
                multimedia: [],
                moment: moment,
            }
        },
        mounted(){
            this.getMultimediaFilesByConsignment();
        },
        methods: {
            getMultimediaFilesByConsignment(){
                axios.get(`/getMultimediaFilesByConsignment/${this.consignment.id}/consignment`)
                .then( res => {
                    this.multimedia = res.data;
                })
                .finally( () => {

                });
            },
            updateNotifications(data){
                this.status = data;
            }
        }
    }
</script>