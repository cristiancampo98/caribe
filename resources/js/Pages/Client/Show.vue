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
						{{logo[0].path}}
						<item-list-component>
							<template #attribute>logo</template>
							<template #description>
								<img :src="`/${logo[0].path}`" alt="" class="w-40 rounded-md">
							</template>
						</item-list-component>
						<div class="bg-gray-100 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
        <dt class="text-sm font-medium text-gray-500">
          Attachments
        </dt>
        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
          <ul class="border border-gray-200 rounded-md divide-y divide-gray-200">
            <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
              <div class="w-0 flex-1 flex items-center">
                <!-- Heroicon name: solid/paper-clip -->
                <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd" />
                </svg>
                <span class="ml-2 flex-1 w-0 truncate">
                  resume_back_end_developer.pdf
                </span>
              </div>
              <div class="ml-4 flex-shrink-0">
                <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">
                  Download
                </a>
              </div>
            </li>
            <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
              <div class="w-0 flex-1 flex items-center">
                <!-- Heroicon name: solid/paper-clip -->
                <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd" />
                </svg>
                <span class="ml-2 flex-1 w-0 truncate">
                  coverletter_back_end_developer.pdf
                </span>
              </div>
              <div class="ml-4 flex-shrink-0">
                <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">
                  Download
                </a>
              </div>
            </li>
          </ul>
        </dd>
      </div>
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

    export default {
    	components: {
    		AdminLayout,
    		DescriptionListComponent,
    		ItemListComponent

    	},
    	props: {
    		client: {
    			type: Object
    		},
			photo_document:{
				type: [Object,Array]
			},
			rut_document:{
				type: [Object,Array]
			},
			logo:{
				type: [Object,Array]
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