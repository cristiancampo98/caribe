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
                    <template #title>Permisos</template>
                    <template #subtitle>Visualiza la información del permiso</template>
                    <item-list-component>
                        <template #attribute>Nombre</template>
                        <template #description>{{permissions.name}}</template>
                    </item-list-component>
                    <item-list-component class="bg-gray-100">
                        <template #attribute>Slug</template>
                        <template #description>{{permissions.slug}}</template>
                    </item-list-component>
                    <item-list-component>
                        <template #attribute>Controlador</template>
                        <template #description>{{permissions.controller}}</template>
                    </item-list-component>
                    <item-list-component class="bg-gray-100">
                        <template #attribute>Descripción</template>
                        <template #description>{{permissions.description}}</template>
                    </item-list-component>
                    <item-list-component>
                        <template #attribute>Fecha creación</template>
                        <template #description>{{moment(permissions.created_at).format('DD/MM/YYYY')}}</template>
                    </item-list-component>
                    <item-list-component class="bg-gray-100">
                        <template #attribute>Roles</template>
                        <template #description>
                            <ul v-if="permissions.roles.length">
                                <li v-for="rol in permissions.roles" type="disc">
                                    {{rol.name}}
                                </li>
                            </ul>
                            <div v-else>
                                <p>No existe relación</p>
                            </div>
                        </template>
                    </item-list-component>
                </description-list-component>
            </div>
        </div>
    </admin-layout>
</template>
<script>
    import { ShowViewComponentMixin} from '@/Mixins/ShowViewComponentMixin'

    export default {
        mixins: [ShowViewComponentMixin],
        props: {
            permissions: {
                type: Object
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