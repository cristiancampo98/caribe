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
            		<item-list-component>
            			<template #attribute>Pedido</template>
            			<template #description>No. {{consignment.order_id}}</template>
            		</item-list-component>
            		<item-list-component class="bg-gray-100">
            			<template #attribute>No. consignación</template>
            			<template #description>{{consignment.consignment_number}}</template>	
            		</item-list-component>
                   <item-list-component >
            			<template #attribute>Url PSE</template>
            			<template #description>
            				<a class="hover:text-blue-500" :href="consignment.pse_url" target="_blank">{{consignment.pse_url}}</a>
            			</template>	
            		</item-list-component>
                    <item-list-component class="bg-gray-100">
            			<template #attribute>Número PSE</template>
            			<template #description>{{consignment.pse_number}}</template>	
            		</item-list-component>
                    <item-list-component>
                        <template #attribute>Fecha consignación</template>
                        <template #description>{{consignment.created_at}}</template> 
                    </item-list-component>
                    <item-list-component class="bg-gray-100">
            			<template #attribute>Cliente</template>
            			<template #description>{{consignment.order.client.name}}</template>	
            		</item-list-component>
            		<item-list-component>
                        <template #attribute>Correo cliente</template>
                        <template #description>{{consignment.order.client.email}}</template>	
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