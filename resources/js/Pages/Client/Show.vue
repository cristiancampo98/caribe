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
            		<template #title>Cliente</template>
            		<template #subtitle>Visualiza la información del cliente</template>
            		<item-list-component>
            			<template #attribute>Nombre</template>
            			<template #description>{{client.name}}</template>
            		</item-list-component>
            		<item-list-component class="bg-gray-100">
            			<template #attribute>Correo</template>
            			<template #description>{{client.email}}</template>	
            		</item-list-component>
            		<item-list-component>
            			<template #attribute>Estado</template>
            			<template #description>{{client.status ? 'Activo' : 'Inactivo'}}</template>
            		</item-list-component>
                    <div v-if="client.details">
                        <item-list-component class="bg-gray-100">
                			<template #attribute >Tipo de pago</template>
                			<template #description>
                                {{client.details.type_pay 
                                    ? client.details.type_pay
                                    :'Sin seleccionar'}}
                            </template>	
                		</item-list-component>
                		<item-list-component>
                			<template #attribute>Dirección</template>
                			<template #description>
                                {{client.details.street_address
                                    ? client.details.street_address
                                    : 'N/A'}}
                            </template>
                		</item-list-component>
                		<item-list-component class="bg-gray-100">
                			<template #attribute >Ciudad</template>
                			<template #description>
                                {{client.details.city
                                    ? client.details.city
                                    : 'Sin seleccionar'}}
                            </template>
                		</item-list-component>
                		<item-list-component>
                			<template #attribute>Departamento</template>
                			<template #description>
                                {{client.details.deparment
                                    ? client.details.deparment
                                    : 'Sin seleccionar'}}
                            </template>
                		</item-list-component>
                		<item-list-component class="bg-gray-100">
                			<template #attribute >País</template>
                			<template #description>
                                {{client.details.country 
                                    ? lient.details.country
                                    : 'Sin seleccionar'}}
                            </template>
                		</item-list-component>
                		<item-list-component>
                			<template #attribute>Telefonos</template>
                			<template #description>
                                {{client.details.phones
                                    ? client.details.phones
                                    : 'N/A'}}
                            </template>
                		</item-list-component>
                		<item-list-component class="bg-gray-100">
                			<template #attribute>Correos</template>
                			<template #description>
                                {{client.details.others_email
                                    ? client.details.others_email
                                    : 'N/A'}}
                            </template>
                		</item-list-component>
                		<item-list-component>
                			<template #attribute>Tipo identificación</template>
                			<template #description>
                                {{client.details.type_identification
                                    ?client.details.type_identification.description 
                                    : 'N/A' }}
                            </template>
                		</item-list-component>
                		<item-list-component  class="bg-gray-100">
                			<template #attribute>Número de identificación</template>
                			<template #description>
                                {{client.details.number_identification
                                    ? client.details.number_identification
                                    : 'N/A'}}
                            </template>
                		</item-list-component>
                		<item-list-component>
                			<template #attribute>Sexo</template>
                			<template #description>
                                {{client.details.sex 
                                    ? client.details.sex
                                    : 'N/A'}}
                            </template>
                		</item-list-component>
                		<item-list-component class="bg-gray-100">
                			<template #attribute >Tipo de sangre</template>
                			<template #description>
                                {{client.details.type_blood
                                    ? client.details.type_blood.description
                                    : 'N/A'}}
                                </template>
                		</item-list-component>
					</div>
                    <item-list-download-component
                    v-if="multimedia.length"
                    title="Documentos"
                    :files="multimedia"
                    @updatingNotifications="updateNotifications"
                    />
                    <div v-if="client.orders">
                        <item-list-component class="bg-gray-100">
                            <template #attribute >Pedidos</template>
                            <template #description>
                                <ul>
                                    <li v-for="item in client.orders" class="mb-4">
                                        Pedido No. {{item.id}} <span class="self-auto border-2 border-blue-500 rounded-md p-1"> Estado: {{item.status}}</span>
                                    </li>
                                </ul>
                            </template>
                        </item-list-component>
                    </div>
                    <div v-if="client.orders">
                        <item-list-component>
                            <template #attribute >Vehículos</template>
                            <template #description>
                                <ul>
                                    <li v-for="item in client.vehicles" class="mb-4">
                                        Placa <b class="uppercase">{{item.license_plate}}</b> <span class="self-auto border-2 border-blue-500 rounded-md p-1"> Estado: {{item.state ? 'Activo' : 'Inactivo'}}</span>
                                    </li>
                                </ul>
                            </template>
                        </item-list-component>
                        
                    </div>
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
    		client: {
    			type: Object
    		},
    	},
    	data(){
            return {
                status:{},
                multimedia: [],
            }
        },
        mounted(){
        	this.getMultimediaFilesByClient();
        },
        methods: {
            getMultimediaFilesByClient(){
                axios.get(`/getMultimediaFilesByClient/${this.client.id}/client`)
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