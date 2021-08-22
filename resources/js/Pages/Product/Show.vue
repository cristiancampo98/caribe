<template>
	<admin-layout :status="status">
		 <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
               Producto seleccionado
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            	<description-list-component>
            		<template #title>Producto</template>
            		<template #subtitle>Visualiza la información del producto</template>
            		<item-list-component>
            			<template #attribute>Nombre</template>
            			<template #description>{{product.name}}</template>
            		</item-list-component>
            		<item-list-component class="bg-gray-100">
            			<template #attribute>Referencia</template>
            			<template #description>{{product.reference}}</template>	
            		</item-list-component>
                   
                    <item-list-component >
            			<template #attribute>Descripción</template>
            			<template #description>{{product.description}}</template>	
            		</item-list-component>
                    <item-list-component class="bg-gray-100">
                        <template #attribute>Equivalencia en m3</template>
                        <template #description>{{product.cubic_meters | formatNumber}}</template> 
                    </item-list-component>
                   
                    <item-list-component >
                        <template #attribute>Equivalencia en ton</template>
                        <template #description>{{product.ton | formatNumber}}</template>   
                    </item-list-component>
                    <item-list-component class="bg-gray-100">
                        <template #attribute>Limite por día</template>
                        <template #description>{{product.limit_day | formatNumber}}</template> 
                    </item-list-component>
                    <item-list-component >
                        <template #attribute>Creador</template>
                        <template #description>{{product.creator.name}}</template> 
                    </item-list-component>
                     <item-list-component class="bg-gray-100">
                        <template #attribute>Estado</template>
                        <template #description>{{product.status ? 'Activo' : 'Inactivo'}}</template>   
                    </item-list-component>
                    <item-list-component >
                        <template #attribute>Fecha</template>
                        <template #description>{{moment(product.created_at).format('DD/MM/YYYY')}}</template> 
                    </item-list-component>
                    <item-list-download-component
                    v-if="multimedia.length"
                    title="Fotos productos"
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
            product: Object
        }, 
    	data(){
            return {
                status:{},
                multimedia: [],
                moment: moment,
            }
        },
        mounted(){
            this.getMultimediaFilesByProduct();
        },
        methods: {
            getMultimediaFilesByProduct(){
                axios.get(`/getMultimediaFilesByProduct/${this.product.id}/products`)
                .then( res => {
                    this.multimedia = res.data;
                })
                .finally( () => {

                });
            },
            updateNotifications(data){
                console.log(data);
                this.status = data;
            }
        }
    }
</script>