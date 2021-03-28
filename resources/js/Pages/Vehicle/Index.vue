<template>
    <admin-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Vehículos
            </h2>
        </template>
        <div class="py-12">
            <jet-nav-link :href="route('vehicle.create')">
                <jet-button type="button">
                    Crear vehículo
                </jet-button>
            </jet-nav-link>
            <jet-button type="button" @click.native="exportPDF">
                PDF
            </jet-button>
            <json-excel class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
            :data="options"
            :fields="json_fields"
            worksheet="Tabla"
            :name="`${document_name}.xls`">
                {{ btn_name_excel }}
            </json-excel>
            <div class="mt-8" v-if="Object.keys(options).length">
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-3">
                        <label for="lenght">Paginar: </label>
                        <v-select
                        id="lenght"
                        class="w-20 bg-white"
                        v-model="lenght"
                        :options="pages"
                        @input="getPaginate"
                        :clearable="false"></v-select>
                    </div>
                </div>
                <table-responsive-component>
                    <template #title>
                        <tr>
                            <th-responsive-component 
                            v-for="(title, key) in titles"
                            :key="key">{{title}}</th-responsive-component>
                        </tr>
                    </template>
                    <template #content>
                        <tr v-for="(item, key) in options" :key="key">
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

                                        <jet-dropdown-link v-for="(option,key) in actions"
                                        :key="key"
                                        :href="route(option.route, {id: item.id})" :as="option.as" method="option.method">
                                            {{option.name}}
                                        </jet-dropdown-link>

                                    </template>
                                </jet-dropdown>
                            </td-responsive-component>

                        </tr>
                    </template>
                </table-responsive-component>
                <paginate-component 
                :package="package"
                @updatingData="updateData"></paginate-component>
            </div>
            <div v-else>No hay datos</div>
        </div>
    </admin-layout>
</template>

<script>
    import { DataTableComponentMixin} from '@/Mixins/DataTableComponentMixin'

    export default {
        mixins: [DataTableComponentMixin],
        created(){
            this.url = '/getPaginateAllVehicles/vehicles';
        },
        data() {
            return {
            	titles: ['#','Placa','Marca','Estado','Opciones'],
                document_name: 'Listado pagina vehiculos',
                columns: ['#','Placa','Marca','Estado'],
                json_fields: {
                    '#' : 'id',
                    Placa : 'license_plate',
                    Marca: 'brand',
                    Estado: {
                        field: 'state',
                        callback: (value) => {
                            return value ? 'Activo' : 'Inactivo'
                        }
                    },
                },
            	actions: [
                    {name: 'Editar', route:'vehicle.edit'},
                    {name: 'Ver', route:'vehicle.show'},
                    {name: 'Actualizar estado', route:'editStatus.vehicle'},
                ],
            }
        },
        methods: {
            
        }
    }
</script>
