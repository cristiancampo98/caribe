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
            <div class="mt-8" v-if="options.length">
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
                <table-responsive-component v-if="showTable">
                    <template #title>
                        <tr>
                            <th-responsive-component 
                            v-for="(title, key) in titles"
                            :key="key">{{title}}</th-responsive-component>
                        </tr>
                    </template>
                    <template #content>
                        <tr v-for="(item, key) in options" :key="key">
                            <td-responsive-component>{{item.user_id}}</td-responsive-component>
                            <td-responsive-component>
                                {{item.users.details.name_company}}
                            </td-responsive-component>
                            <td-responsive-component>{{item.users.name}}</td-responsive-component>
                            <td-responsive-component>{{item.users.details.type_pay}}</td-responsive-component>
                            <td-responsive-component>
                                {{item.users.details.street_address}}
                            </td-responsive-component>
                            <td-responsive-component>
                                {{item.users.details.city}}
                            </td-responsive-component>
                            <td-responsive-component>
                                {{item.users.email}}
                            </td-responsive-component>
                            <td-responsive-component>
                                <span class="text-white p-1 rounded-md" :class="item.users.classStatus">{{item.users.status}}</span>
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
                                        :href="route(option.route, {client: item.user_id})">
                                            {{option.name}}
                                        </jet-dropdown-link>
                                        <button type="button"
                                        class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
                                        @click="updateStatusUser(item)">
                                            {{item.users.status == 'Activo' ? 'Inactivar' : 'Activar'}}
                                        </button>
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
        created() {
            this.url = '/getClientsPaginate/client';
        },
        updated() {
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
            }
        },
        methods: {
            validateDataClients(){

                for (var i = 0; i < this.options.length; i++) {

                    if (this.options[i].users.details) {
                       
                       for(var client in this.options[i].users.details){

                            this.options[i].users.details[client] = this.options[i].users.details[client] 
                            ? this.options[i].users.details[client]
                            : 'Sin datos'
                        }
                    }else{

                        this.options[i].users.details = {
                            name_company : 'N/A',
                            street_address : 'N/A',
                            city : 'N/A',
                            email : 'N/A',
                            type_pay: 'N/A'
                        }
                    }
                    this.options[i].users.status = this.options[i].users.status
                    ? 'Activo'
                    : 'Inactivo';

                    this.options[i].users.classStatus = this.options[i].users.status == 'Activo' 
                    ? 'bg-green-500'
                    : 'bg-red-500';
                }
                this.showTable = true;
            },
            updateStatusUser(item){
                this.startLoading();
                axios.put(`/updateStatus/${item.user_id}/user`)
                .then(res => {
                    item.users.status = res.data.user.status ? 'Activo' : 'Inactivo';
                    item.users.classStatus = res.data.user.status 
                    ? 'bg-green-500'
                    : 'bg-red-500';
                    this.setStatusFlash(res.data.type,res.data.text);
                })
                .finally( () =>  this.endLoading())
            },

        }
    }
</script>
