<template>
    <admin-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Clientes
            </h2>
        </template>
        <div class="py-12">
            <jet-nav-link :href="route('client.create')">
                <jet-button type="button">
                    Crear Cliente
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
            <div class="mt-8">
                <div class="grid grid-flow-row lg:grid-flow-col gap-4 auto-cols-min items-end">
                    <div>
                        <label for="lenght">Paginar: </label>
                        <v-select
                        id="lenght"
                        class="w-20 bg-white"
                        v-model="lenght"
                        :options="pages"
                        @input="getPaginate"
                        :clearable="false"></v-select>
                    </div>
                    <div>
                        <label for="type_pay">Tipo: </label>
                        <v-select
                        id="type_pay"
                        class="w-36 bg-white"
                        v-model="valueParams.type_pay"
                        :options="params.type_pay"
                        :reduce="label => label.value"
                        @input="getPaginate"
                        :clearable="false"></v-select>
                    </div>
                    <div>
                        <label for="status">Estado: </label>
                        <v-select
                        id="status"
                        class="w-36 bg-white"
                        v-model="valueParams.status"
                        :options="params.status"
                        :reduce="label => label.value"
                        @input="getPaginate"
                        :clearable="false"></v-select>
                    </div>
                    <div>
                        <button type="button" class="bg-red-500 text-white py-1 px-2 rounded-md" @click="clean">
                            Limpiar
                        </button>
                    </div>
                </div>
                <table-responsive-component v-if="showTable && options.length">
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
                            <td-responsive-component 
                            :class="item.details.name_company ? '' : 'text-sm text-red-500'">
                                {{item.details.name_company 
                                    ? item.details.name_company 
                                    : '¡Importante! Edita la información de este cliente'}}
                            </td-responsive-component>
                            <td-responsive-component>{{item.name}}</td-responsive-component>
                            <td-responsive-component>{{item.details.type_pay}}</td-responsive-component>
                            <td-responsive-component>
                                {{item.details.street_address}}
                            </td-responsive-component>
                            <td-responsive-component>
                                {{item.details.city}}
                            </td-responsive-component>
                            <td-responsive-component>
                                {{item.email}}
                            </td-responsive-component>
                            <td-responsive-component>
                                <span class="text-white p-1 rounded-md" 
                                :class="item.status ? 'bg-green-500' :'bg-red-500'"
                                >
                                    {{item.status ? 'Activo' : 'Inactivo'}}
                                </span>
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
                                        :href="route(option.route, {client: item.id})">
                                            {{option.name}}
                                        </jet-dropdown-link>
                                        <button type="button"
                                        class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                                        @click="updateStatusUser(item)">
                                            {{item.status ? 'Inactivar' : 'Activar'}}
                                        </button>
                                    </template>
                                </jet-dropdown>
                            </td-responsive-component>
                        </tr>
                    </template>
                </table-responsive-component>
                <div v-else>No hay datos</div>
                <paginate-component
                v-if="options.length"
                :package="package"
                @updatingData="updateData"></paginate-component>
            </div>
           
        </div>
    </admin-layout>
</template>

<script>
   import { DataTableComponentMixin} from '@/Mixins/DataTableComponentMixin'

    export default {
        mixins: [DataTableComponentMixin],
        created() {
            this.url = '/getClientsPaginate/client';
        },
        beforeUpdate() {
            this.validateDataClients();
        },
        data() {
            return {
                titles: ['#','Empresa','Nombre','Tipo','Dirección','Ciudad','Correo','Estado','Opciones'],
                document_name: 'Listado pagina clientes',
                columns: ['#','Empresa','Nombre','Tipo','Dirección','Ciudad','Correo','Estado'],
                json_fields: {
                    '#' : 'users.id',
                    Nombre : 'users.name',
                    Tipo: 'users.details.type_pay',
                    Empresa: 'users.details.name_company',
                    'Dirección': 'users.details.street_address',
                    Ciudad: 'users.details.city',
                    Correo: 'users.email',
                    Estado: 'users.status'
                },
                showTable: false,
                actions: [
                    {name: 'Editar', route:'client.edit'},
                    {name: 'Ver', route:'client.show'},
                ],
                params: {
                    type_pay: [
                        {label:'Contado',value:'contado'},
                        {label:'Crédito',value:'crédito'}
                    ],
                    status: [
                        {label:'Activo',value:1},
                        {label:'Inactivo',value:0}
                    ]
                },
                valueParams: {}
            }
        },
        methods: {
            validateDataClients(){
                this.options.map( client => {
                    
                    if (client.details == null) {
                        client.details = {
                            name_company: 0,

                        }
                    }
                })
                this.showTable = true;
            },
            updateStatusUser(item){
                this.startLoading();
                axios.put(`/updateStatus/${item.id}/user`)
                .then(res => {
                    item.status = res.data.user.status ? 1 : 0;
                    this.setStatusFlash(res.data.type,res.data.text);
                })
                .finally( () =>  this.endLoading())
            },

        }
    }
</script>
