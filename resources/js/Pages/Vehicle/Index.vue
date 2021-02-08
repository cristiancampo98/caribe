<template>
    <admin-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Vehículos
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <jet-nav-link :href="route('vehicle.create')" class="my-8">
                    <jet-button type="button">
                        Crear vehículo
                    </jet-button>
                </jet-nav-link>
                <div v-if="Object.keys(vehicles).length">
                    <table-responsive-component>
                        <template #title>
                            <tr>
                                <th-responsive-component 
                                v-for="(title, key) in titles"
                                :key="key">{{title}}</th-responsive-component>
                                <th-responsive-component></th-responsive-component>
                            </tr>
                        </template>
                        <template #content>
                            <tr v-for="(item, key) in vehicles" :key="key">
                                <td-responsive-component>{{item.id}}</td-responsive-component>
                                <td-responsive-component>{{item.license_plate}}</td-responsive-component>
                                <td-responsive-component>
                                    {{item.brand}}
                                </td-responsive-component>
                                <td-responsive-component>
                                    <span 
                                    :class="item.state 
                                    ? 'text-white bg-green-500 p-1 rounded-md' 
                                    : 'text-white bg-red-500 p-1 rounded-md'"
                                    >{{item.state ? 'Activo' : 'Inactivo'}}</span>
                                </td-responsive-component>
                                <td-responsive-component>
                                    <jet-dropdown align="right" width="48">
                                        <template #trigger>
                                            <span  class="inline-flex rounded-md">
                                                <button type="button" class="inline-flex items-center  text-gray-900 hover:text-blue-400 focus:outline-none transition ease-in-out duration-150">
                                                    <div class="bg-white border border-transparent hover:border-black shadow-sm p-2 rounded-lg">
                                                        <img src="/img/menu.svg">
                                                    </div>
                                                </button>
                                            </span>
                                        </template>

                                        <template #content>
                                            <!-- Account Management -->
                                            <div class="block px-4 py-2 text-xs text-gray-400">
                                                Opciones
                                            </div>

                                            <jet-dropdown-link v-for="(option,key) in options"
                                            :key="key"
                                            :href="route(option.route, {vehicle: item.id})" :as="option.as" method="option.method">
                                                {{option.name}}
                                            </jet-dropdown-link>

                                        </template>
                                    </jet-dropdown>
                                </td-responsive-component>

                            </tr>
                        </template>
                    </table-responsive-component>
                    
                </div>
            </div>
        </div>
    </admin-layout>
</template>

<script>
    import AdminLayout from '@/Layouts/AdminLayout'
    import JetNavLink from '@/Jetstream/NavLink'
    import JetButton from '@/Jetstream/Button'
    import TableResponsiveComponent from '@/Components/TableResponsive'
    import ThResponsiveComponent from '@/Components/THResponsive'
    import TdResponsiveComponent from '@/Components/TDResponsive'
    import JetDropdown from '@/Jetstream/Dropdown'
    import JetDropdownLink from '@/Jetstream/DropdownLink'

    export default {
        components: {
            AdminLayout,
            JetNavLink,
            JetButton,
            TableResponsiveComponent,
            ThResponsiveComponent,
            TdResponsiveComponent,
            JetDropdown,
            JetDropdownLink
        },
        props: {
            vehicles: {
                type: [Object, Array],
                required: true
            }

        },
        mounted(){
            
        },
        data() {
            return {
            	titles: ['#','Placa','Marca','Estado'],
            	options: [
                    {name: 'Editar', route:'vehicle.edit'},
                    {name: 'Ver', route:'vehicle.show'},
                    {name: 'Actualizar estado', route:'editStatus.vehicle'},
                ]
            }
        },
        methods: {
        }
    }
</script>
