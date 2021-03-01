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
<<<<<<< HEAD
            		<item-list-component class="bg-gray-10">
            			<template #attribute>Refencia</template>
            			<template #description>{{product.reference}}</template>	
            		</item-list-component>
                   <item-list-component class="bg-gray-10">
            			<template #attribute>Unidad de medida</template>
            			<template #description>{{product.unit_measure_id}}</template>	
            		</item-list-component>
                    <item-list-component class="bg-gray-10">
            			<template #attribute>Precio</template>
            			<template #description>{{product.price}}</template>	
            		</item-list-component>
                    <item-list-component class="bg-gray-10">
=======
            		<item-list-component class="bg-gray-100">
            			<template #attribute>Referencia</template>
            			<template #description>{{product.reference}}</template>	
            		</item-list-component>
                   <item-list-component >
            			<template #attribute>Unidad</template>
            			<template #description>{{product.units_measure.name}}</template>	
            		</item-list-component>
                    <item-list-component class="bg-gray-100">
            			<template #attribute>Precio</template>
            			<template #description>{{product.price}}</template>	
            		</item-list-component>
                    <item-list-component >
>>>>>>> 703df894c0d9264b5b3a69caa246e3e1c1cf7ef7
            			<template #attribute>Descripción</template>
            			<template #description>{{product.description}}</template>	
            		</item-list-component>
                    <item-list-component class="bg-gray-100">
                        <template #attribute>Creador</template>
                        <template #description>{{product.creator.name}}</template> 
                    </item-list-component>
                     <item-list-component >
                        <template #attribute>Estado</template>
                        <template #description>{{product.status ? 'Activo' : 'Inactivo'}}</template>   
                    </item-list-component>
                    <item-list-component class="bg-gray-100">
                        <template #attribute>Fecha</template>
                        <template #description>{{product.created_at}}</template> 
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

    export default {
    	components: {
    		AdminLayout,
    		DescriptionListComponent,
    		ItemListComponent,
            ItemListDownloadComponent
    	},
    	props: {
            product: {}
        }, 
    	data(){
            return {
                status:{},
                multimedia: [],
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