<template>
	<admin-layout>
		 <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
               Consultar usuario
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            	<description-list-component>
            		<template #title>Usuario</template>
            		<template #subtitle>Visualiza la información del usuario</template>
            		<item-list-component>
            			<template #attribute>Nombre</template>
            			<template #description>{{user.name}}</template>
            		</item-list-component>
            		<item-list-component class="bg-gray-100">
            			<template #attribute>Correo</template>
            			<template #description>{{user.email}}</template>	
            		</item-list-component>
            		<item-list-component>
            			<template #attribute>Estado</template>
            			<template #description>
            				<span class=" rounded-md text-white p-1" :class="getClassStatus">{{user.status ? 'Activo' : 'Inactivo'}}</span>
            			</template>
            		</item-list-component>
            		<div v-if="user.details">
	            		<item-list-component class="bg-gray-100">
	            			<template #attribute>Dirección</template>
	            			<template #description>{{user.details.street_address}}</template>
	            		</item-list-component>
	            		<item-list-component >
	            			<template #attribute >Ciudad</template>
	            			<template #description>{{user.details.city}}</template>
	            		</item-list-component>
	            		<item-list-component class="bg-gray-100">
	            			<template #attribute>Departamento</template>
	            			<template #description>{{user.details.deparment}}</template>
	            		</item-list-component>
	            		<item-list-component >
	            			<template #attribute >País</template>
	            			<template #description>{{user.details.country}}</template>
	            		</item-list-component>
	            		<item-list-component class="bg-gray-100">
	            			<template #attribute>Telefonos</template>
	            			<template #description>{{user.details.phones}}</template>
	            		</item-list-component>
	            		<item-list-component >
	            			<template #attribute>Correos</template>
	            			<template #description>{{user.details.others_email}}</template>
	            		</item-list-component>
	            		<item-list-component class="bg-gray-100">
	            			<template #attribute>Tipo identificación</template>
	            			<template #description>
	            				{{user.details.type_identification
	            					? user.details.type_identification.description
	            					: 'N/A'}}
	            			</template>
	            		</item-list-component>
	            		<item-list-component  >
	            			<template #attribute>Número de identificación</template>
	            			<template #description>{{user.details.number_identification}}</template>
	            		</item-list-component>
	            		<item-list-component class="bg-gray-100">
	            			<template #attribute>Sexo</template>
	            			<template #description>{{user.details.sex}}</template>
	            		</item-list-component>
	            		<item-list-component >
	            			<template #attribute >Tipo de sangre</template>
	            			<template #description>
	            				{{user.details.type_blood 
	            				? user.details.type_blood.description
	            				: 'N/A'}}</template>	
	            		</item-list-component>
            		</div>
            		<item-list-component class="bg-gray-100">
            			<template #attribute>
            				<ul >
            					<li>Roles</li>
            					<li class="text-blue-500">Pon el mouse sobre el rol para ver los permisos que tiene asignados.</li>
            				</ul>
            			</template>
            			<template #description>
            				<ul class="ml-4">
            					<li type="disc" v-for="(rol, key) in user.roles" class="w-40">
            						
								      <vs-tooltip>
								        <vs-button flat>
								          {{rol.name}}
								        </vs-button>
								        <template #tooltip>
								        	<div v-if="rol['full-access'] == 'yes'">
								        		<h3>Acceso total</h3>
								        	</div>
								        	<div v-else>
								        		<ul v-if="rol.permissions.length">
								        			<li type="circle" v-for="(per, clave) in rol.permissions">{{per.name}}</li>
								        		</ul>
								        		<ul v-else>
								        			<li type="circle">No se han asignado permisos</li>
								        		</ul>
								        	</div>
								        </template>
								      </vs-tooltip>
            					</li>
            				</ul>
            				
            			</template>
            		</item-list-component>
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
    		user: {
    			type: Object
    		},
    	},
    	data(){
            return {
              
            }
        },
        mounted(){
        	
        },
        computed: {
        	getClassStatus(){
        		return this.user.status ? 'bg-green-500' : 'bg-red-500'
        	}
        },
        methods: {
        }

    }
</script>